<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\RelationManagers\RelationManager;

class ProductVariantRelationManager extends RelationManager
{
    protected static string $relationship = 'variants';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $title = 'Varian Produk';

    public static function parseRupiah($value): int
    {
        $str = str_replace(['Rp', 'Rp ', ' '], '', (string) $value);
        if (preg_match('/^\d{1,3}(\.\d{3})+$/', $str)) {
            return (int) str_replace('.', '', $str);
        }
        return (int) round((float) $str);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Varian')->schema([
                    TextInput::make('name')
                        ->label('Nama Varian')
                        ->required()
                        ->maxLength(100)
                        ->placeholder('Contoh: Merah, XL, 128GB'),

                    TextInput::make('sku')
                        ->label('SKU Varian')
                        ->maxLength(50)
                        ->placeholder('Opsional'),

                    TextInput::make('stock')
                        ->label('Stok')
                        ->required()
                        ->numeric()
                        ->minValue(0)
                        ->default(0),

                    TextInput::make('price')
                        ->label('Harga (kosongkan = harga produk utama)')
                        ->prefix('Rp')
                        ->extraAttributes(['inputmode' => 'numeric'])
                        ->mask(RawJs::make(<<<'JS'
                            $input => {
                                const digits = $input.replace(/[^\d]/g, '');
                                return digits.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                            }
                        JS))
                        ->dehydrateStateUsing(fn ($state) => $state ? self::parseRupiah($state) : null)
                        ->formatStateUsing(fn ($state) => $state ? number_format((float) $state, 0, ',', '.') : null),

                    Toggle::make('is_active')
                        ->label('Aktif')
                        ->default(true),
                ])->columns(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nama Varian')->searchable(),
                TextColumn::make('sku')->label('SKU')->placeholder('-'),
                TextColumn::make('stock')->label('Stok')
                    ->badge()
                    ->color(fn (int $state): string => match (true) {
                        $state === 0      => 'danger',
                        $state <= 5       => 'warning',
                        default           => 'success',
                    }),
                TextColumn::make('price')->label('Harga')
                    ->formatStateUsing(fn ($state) => $state ? 'Rp ' . number_format((float) $state, 0, ',', '.') : '(harga utama)')
                    ->alignRight(),
                ToggleColumn::make('is_active')->label('Aktif'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Tambah Varian'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum ada varian')
            ->emptyStateDescription('Klik "Tambah Varian" untuk membuat varian produk.');
    }
}
