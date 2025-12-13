<?php

namespace App\Filament\Resources\VariantCategories\Pages;

use App\Filament\Resources\VariantCategories\VariantCategoriesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVariantCategories extends EditRecord
{
    protected static string $resource = VariantCategoriesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
