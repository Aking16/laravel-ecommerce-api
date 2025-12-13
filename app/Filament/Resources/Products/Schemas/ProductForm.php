<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('meta_description'),
                TextInput::make('meta_keywords'),
                TextInput::make('meta_title'),
                Select::make('categories_id')
                    ->relationship('categories', 'name')
                    ->required(),
                Select::make('galleries_id')
                    ->relationship('galleries', 'name'),
            ]);
    }
}
