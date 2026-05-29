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
                            ->directory('products')
                            ->maxFiles(5)
                            ->reorderable(),
                    ]),
                ])->columnSpan(2),

                Group::make()->schema([
                    Section::make('Price')->schema([
                        // === CHANGED: input harga bertopeng (mask) ribuan ".", prefix "Rp", simpan bersih ===
                        TextInput::make('price')
                            ->label('Harga')
                            ->required()
                            ->prefix('Rp') // ganti IDR -> Rp
                            ->extraAttributes(['inputmode' => 'numeric'])
                            ->mask(RawJs::make(<<<'JS'
                                $input => {
                                    // Hanya angka lalu format ribuan titik
                                    const digits = $input.replace(/[^\d]/g, '');
                                    return digits.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                                }
                            JS))
                            // Saat menyimpan ke DB, hapus semua titik/Rp/spasi
                            ->dehydrateStateUsing(fn ($state) => (int) str_replace(['.', 'Rp', ' '], '', (string) $state))
                            // Saat edit (load dari DB), tampilkan dalam format ribuan titik (tanpa desimal)
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
                        Toggle::make('in_stock')->label('Stok Tersedia')->required()->default(true),
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
                    ->label('Harga')
                    ->alignRight()
                    ->sortable()
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format((float) $state, 0, ',', '.')),

                IconColumn::make('is_featured')->label('Unggulan')->boolean(),
                IconColumn::make('on_sale')->label('Diskon')->boolean(),
                IconColumn::make('in_stock')->label('Stok Tersedia')->boolean(),
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
        return [];
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
