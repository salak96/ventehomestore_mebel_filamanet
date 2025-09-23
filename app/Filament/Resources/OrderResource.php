<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use App\Models\Product;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\ToggleButtons;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers\AddressRelationManager;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Order Information')->schema([
                        Select::make('user_id')
                            ->label('Customer')
                            ->relationship('user', 'name')
                            ->preload()
                            ->searchable()
                            ->required(),

                        Select::make('payment_method')
                            ->options([
                                'stripe' => 'Stripe',
                                'cod'    => 'Cash On Delivery',
                            ])
                            ->required(),

                        Select::make('payment_status')
                            ->options([
                                'pending' => 'Pending',
                                'paid'    => 'Paid',
                                'failled' => 'Failled', // kalau mau, ganti ke 'failed'
                            ])
                            ->default('pending')
                            ->required(),

                        ToggleButtons::make('status')
                            ->inline()
                            ->default('new')
                            ->options([
                                'new'        => 'New',
                                'processing' => 'Processing',
                                'shipped'    => 'Shipped',
                                'delivered'  => 'Delivered',
                                'cancelled'  => 'Cancelled',
                            ])
                            ->colors([
                                'new'        => 'info',
                                'processing' => 'warning',
                                'shipped'    => 'success',
                                'delivered'  => 'success',
                                'cancelled'  => 'danger',
                            ])
                            ->icons([
                                'new'        => 'heroicon-m-sparkles',
                                'processing' => 'heroicon-m-arrow-path',
                                'shipped'    => 'heroicon-m-truck',
                                'delivered'  => 'heroicon-m-check-badge',
                                'cancelled'  => 'heroicon-m-x-circle',
                            ]),

                        Select::make('currency')
                            ->options([
                                'usd' => 'USD',
                                'eur' => 'EUR',
                                'idr' => 'IDR',
                            ])
                            ->default('idr') // selaras lowercase
                            ->required(),

                        Select::make('shipping_method')
                            ->options([
                                'fedex' => 'FedEx',
                                'ups'   => 'UPS',
                                'dhl'   => 'DHL',
                                'usps'  => 'USPS',
                            ]),

                        Textarea::make('notes')
                            ->columnSpanFull(),
                    ])->columns(2),

                    Section::make('Order Items')->schema([
                        Repeater::make('items')
                            ->relationship()
                            ->schema([
                                Select::make('product_id')
                                    ->relationship('product', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->distinct()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->columnSpan(4)
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                        $price = (int) (Product::find($state)?->price ?? 0);
                                        $set('unit_amount', $price);
                                        $qty = (int) ($get('quantity') ?: 1);
                                        $set('total_amount', $price * $qty);
                                    }),

                                TextInput::make('quantity')
                                    ->numeric()
                                    ->required()
                                    ->default(1)
                                    ->minValue(1)
                                    ->columnSpan(2)
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                        $qty   = (int) ($state ?: 1);
                                        $price = (int) str_replace(['.', 'Rp', ' '], '', (string) $get('unit_amount'));
                                        $set('total_amount', $qty * $price);
                                    }),

                                // Harga Satuan (editable, mask Rp & titik ribuan, simpan angka bersih)
                                TextInput::make('unit_amount')
                                    ->label('Harga Satuan')
                                    ->prefix('Rp')
                                    ->extraAttributes(['inputmode' => 'numeric'])
                                    ->mask(RawJs::make(<<<'JS'
                                        $input => {
                                            const digits = $input.replace(/[^\d]/g, '');
                                            return digits.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                                        }
                                    JS))
                                    ->dehydrateStateUsing(fn ($state) => (int) str_replace(['.', 'Rp', ' '], '', (string) $state))
                                    ->formatStateUsing(fn ($state) => $state !== null ? number_format((float) $state, 0, ',', '.') : null)
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                        $price = (int) str_replace(['.', 'Rp', ' '], '', (string) $state);
                                        $qty   = (int) ($get('quantity') ?: 1);
                                        $set('total_amount', $price * $qty);
                                    })
                                    ->columnSpan(3),

                                // Total (readonly, mask Rp, simpan angka bersih)
                                TextInput::make('total_amount')
                                    ->label('Total')
                                    ->prefix('Rp')
                                    ->extraAttributes(['inputmode' => 'numeric'])
                                    ->readOnly()
                                    ->mask(RawJs::make(<<<'JS'
                                        $input => {
                                            const digits = $input.replace(/[^\d]/g, '');
                                            return digits.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                                        }
                                    JS))
                                    ->dehydrateStateUsing(fn ($state) => (int) str_replace(['.', 'Rp', ' '], '', (string) $state))
                                    ->formatStateUsing(fn ($state) => $state !== null ? number_format((float) $state, 0, ',', '.') : null)
                                    ->columnSpan(3),
                            ])->columns(12),

                        // Grand total placeholder (tampil Rp 1.234.567) + set hidden grand_total
                        Placeholder::make('grand_total_placeholder')
                            ->label('Grand Total')
                            ->content(function (Get $get, Set $set) {
                                $sum = 0;
                                foreach ((array) $get('items') as $idx => $row) {
                                    // Bisa berupa angka atau string bermask
                                    $val = $row['total_amount'] ?? 0;
                                    $sum += (int) (is_numeric($val) ? $val : str_replace(['.', 'Rp', ' '], '', (string) $val));
                                }
                                $set('grand_total', $sum);
                                return 'Rp ' . number_format($sum, 0, ',', '.');
                            }),

                        Hidden::make('grand_total')->default(0),
                    ]),
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Order ID')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('user.name')
                    ->label('Customer')
                    ->sortable()
                    ->searchable(),

                // Grand total: tampil Rp tanpa desimal
                TextColumn::make('grand_total')
                    ->label('Grand Total')
                    ->alignRight()
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format((float) $state, 0, ',', '.')),

                TextColumn::make('payment_method')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('payment_status')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('shipping_method')
                    ->searchable()
                    ->sortable(),

                SelectColumn::make('status')
                    ->options([
                        'new'        => 'New',
                        'processing' => 'Processing',
                        'shipped'    => 'Shipped',
                        'delivered'  => 'Delivered',
                        'cancelled'  => 'Cancelled',
                    ])
                    ->searchable()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
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
            AddressRelationManager::class,
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getModel()::count() > 10 ? 'success' : 'danger';
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view'   => Pages\ViewOrder::route('/{record}'),
            'edit'   => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
