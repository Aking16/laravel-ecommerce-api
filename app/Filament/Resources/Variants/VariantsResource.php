<?php

namespace App\Filament\Resources\Variants;

use App\Filament\Resources\Variants\Pages\CreateVariants;
use App\Filament\Resources\Variants\Pages\EditVariants;
use App\Filament\Resources\Variants\Pages\ListVariants;
use App\Filament\Resources\Variants\Schemas\VariantsForm;
use App\Filament\Resources\Variants\Tables\VariantsTable;
use App\Models\Variants;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VariantsResource extends Resource
{
    protected static ?string $model = Variants::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return VariantsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VariantsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVariants::route('/'),
            'create' => CreateVariants::route('/create'),
            'edit' => EditVariants::route('/{record}/edit'),
        ];
    }
}
