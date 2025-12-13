<?php

namespace App\Filament\Resources\Attributes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AttributesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('stock')
                    ->required()
                    ->numeric(),
                TextInput::make('discount_number')
                    ->numeric(),
                TextInput::make('discount_percentage')
                    ->numeric(),
                Select::make('galleries_id')
                    ->relationship('galleries', 'name'),
                Select::make('variants_id')
                    ->relationship('variants', 'name')
                    ->required(),
            ]);
    }
}
