<?php

namespace App\Filament\Resources\VariantCategories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VariantCategoriesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
            ]);
    }
}
