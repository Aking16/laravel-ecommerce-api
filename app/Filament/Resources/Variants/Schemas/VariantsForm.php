<?php

namespace App\Filament\Resources\Variants\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VariantsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Select::make('variant_categories_id')
                    ->relationship('variant_categories', 'name')
                    ->required(),
                TextInput::make('color')
                    ->required(),
            ]);
    }
}
