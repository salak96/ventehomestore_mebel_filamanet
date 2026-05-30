<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?int $navigationSort = 4;

    public static function parseRupiah($value): int
    {
        $str = str_replace(['Rp', 'Rp ', ' '], '', (string) $value);
        if (preg_match('/^\d{1,3}(\.\d{3})+$/', $str)) {
            return (int) str_replace('.', '', $str);
        }
        return (int) round((float) $str);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Product Information')->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxlength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Set $set) {
                                if ($operation !== 'create') return;
                                $set('slug', Str::slug($state));
                            }),

                        TextInput::make('slug')
                            ->required()
                            ->maxlength(255)
                            ->disabled()
                            ->dehydrated()
                            ->unique(Product::class, 'slug', ignoreRecord: true),

                        MarkdownEditor::make('description')
                            ->columnSpanFull()
                            ->fileAttachmentsDirectory('products'),
                    ])->columns(2),

                    Section::make('Images')->schema([
                        FileUpload::make('images')
                            ->multiple()
                            ->disk('public')
                            ->directory('products')
                            ->maxFiles(4)
                            ->maxSize(5120)
                            ->image()
                            ->imageEditor()
                            ->reorderable()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->helperText('Maksimal 4 gambar, masing-masing max 5 MB. Otomatis di-compress ke WebP.')
                            ->saveUploadedFileUsing(function ($file) {
                                return \App\Helpers\ImageOptimizer::handleUploadedFile($file, 'products', 'webp');
                            }),
                    ]),
                ])->columnSpan(2),

                Group::make()->schema([
                    Section::make('Price')->schema([
                        TextInput::make('price')
                            ->label('Harga Jual')
                            ->required()
                            ->suffix('/pcs')
                            ->prefix('Rp')
                            ->extraAttributes(['inputmode' => 'numeric'])
                            ->mask(RawJs::make(<<<'JS'
                                $input => {
                                    const digits = $input.replace(/[^\d]/g, '');
                                    return digits.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                                }
                            JS))
                            ->dehydrateStateUsing(fn ($state) => self::parseRupiah($state))
                            ->formatStateUsing(fn ($state) => $state !== null ? number_format((float) $state, 0, ',', '.') : null),

                        TextInput::make('compare_at_price')
                            ->label('Harga Sebelum Diskon')
                            ->helperText('Isi harga asli sebelum diskon (harga ini akan dicoret di frontend). Kosongkan jika tidak ada diskon.')
                            ->suffix('/pcs')
                            ->prefix('Rp')
                            ->extraAttributes(['inputmode' => 'numeric'])
                            ->mask(RawJs::make(<<<'JS'
                                $input => {
                                    const digits = $input.replace(/[^\d]/g, '');
                                    return digits.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                                }
                            JS))
                            ->dehydrateStateUsing(fn ($state) => $state ? self::parseRupiah($state) : null)
                            ->formatStateUsing(fn ($state) => $state !== null ? number_format((float) $state, 0, ',', '.') : null),
                    ]),

                    Section::make('Associations')->schema([
                        Select::make('category_id')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->relationship('category', 'name'),

                        Select::make('brand_id')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->relationship('brand', 'name'),
                    ]),

                    Section::make('Status')->schema([
                        TextInput::make('stock')
                            ->label('Stok')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->helperText('Jumlah stok produk utama. Varian punya stok sendiri.'),
                        Toggle::make('is_active')->label('Aktif')->required()->default(true),
                        Toggle::make('is_featured')->label('Unggulan')->required(),
                        Toggle::make('on_sale')->label('Diskon')->required(),
                    ]),

                    Section::make('Digital Access')->schema([
                        Forms\Components\TextInput::make('access_link')
                            ->label('Link Akses / Download')
                            ->url()
                            ->placeholder('https://...'),
                        Forms\Components\TextInput::make('access_username')
                            ->label('Username'),
                        Forms\Components\TextInput::make('access_password')
                            ->label('Password'),
                    ]),
                ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('index')
                    ->label('No')
                    ->rowIndex(),

                TextColumn::make('name')->searchable(),
                TextColumn::make('category.name')->sortable(),
                TextColumn::make('brand.name')->sortable(),

                // === CHANGED: tampilkan harga sebagai "Rp 1.234.567" (tanpa desimal) ===
                TextColumn::make('price')
                    ->label('Harga Jual')
                    ->alignRight()
                    ->sortable()
                    ->suffix('/pcs')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format((float) $state, 0, ',', '.')),

                TextColumn::make('compare_at_price')
                    ->label('Harga Sebelum Diskon')
                    ->alignRight()
                    ->sortable()
                    ->suffix('/pcs')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->formatStateUsing(fn ($state) => $state ? 'Rp ' . number_format((float) $state, 0, ',', '.') : '-'),

                IconColumn::make('is_featured')->label('Unggulan')->boolean(),
                IconColumn::make('on_sale')->label('Diskon')->boolean(),
                \Filament\Tables\Columns\TextColumn::make('stock')
                    ->label('Stok')
                    ->badge()
                    ->sortable()
                    ->color(fn (int $state): string => match (true) {
                        $state === 0      => 'danger',
                        $state <= 5       => 'warning',
                        default           => 'success',
                    }),
                IconColumn::make('is_active')->label('Aktif')->boolean(),

                TextColumn::make('access_link')
                    ->label('Link')
                    ->limit(20)
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('access_username')
                    ->label('User')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->datetime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('Category')->relationship('category', 'name'),
                SelectFilter::make('Brand')->relationship('brand', 'name'),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ProductVariantRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit'   => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
