<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;

class AddressRelationManager extends RelationManager
{
    protected static string $relationship = 'address';
    protected static ?string $recordTitleAttribute = 'street_address';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('first_name')->required(),
            Forms\Components\TextInput::make('last_name')->required(),
            Forms\Components\TextInput::make('phone')->required(),
            Forms\Components\TextInput::make('street_address')->label('Alamat Lengkap')->required(),
            Forms\Components\TextInput::make('city')->required(),
            Forms\Components\TextInput::make('state')->label('Provinsi'),
            Forms\Components\TextInput::make('zip_code')->label('Kode Pos'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('first_name'),
            Tables\Columns\TextColumn::make('last_name'),
            Tables\Columns\TextColumn::make('phone'),
            Tables\Columns\TextColumn::make('street_address')->label('Alamat Lengkap'),
            Tables\Columns\TextColumn::make('city'),
            Tables\Columns\TextColumn::make('state'),
            Tables\Columns\TextColumn::make('zip_code'),
        ]);
    }
}
