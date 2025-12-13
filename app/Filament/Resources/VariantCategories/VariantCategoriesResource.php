<?php

namespace App\Filament\Resources\VariantCategories;

use App\Filament\Resources\VariantCategories\Pages\CreateVariantCategories;
use App\Filament\Resources\VariantCategories\Pages\EditVariantCategories;
use App\Filament\Resources\VariantCategories\Pages\ListVariantCategories;
use App\Filament\Resources\VariantCategories\Schemas\VariantCategoriesForm;
use App\Filament\Resources\VariantCategories\Tables\VariantCategoriesTable;
use App\Models\VariantCategories;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VariantCategoriesResource extends Resource
{
    protected static ?string $model = VariantCategories::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Variant Categories';

    public static function form(Schema $schema): Schema
    {
        return VariantCategoriesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VariantCategoriesTable::configure($table);
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
            'index' => ListVariantCategories::route('/'),
            'create' => CreateVariantCategories::route('/create'),
            'edit' => EditVariantCategories::route('/{record}/edit'),
        ];
    }
}
