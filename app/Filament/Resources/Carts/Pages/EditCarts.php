<?php

namespace App\Filament\Resources\Carts\Pages;

use App\Filament\Resources\Carts\CartsResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCarts extends EditRecord
{
    protected static string $resource = CartsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
