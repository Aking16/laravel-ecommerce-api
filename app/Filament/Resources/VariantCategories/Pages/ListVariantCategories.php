<?php

namespace App\Filament\Resources\VariantCategories\Pages;

use App\Filament\Resources\VariantCategories\VariantCategoriesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVariantCategories extends ListRecords
{
    protected static string $resource = VariantCategoriesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
