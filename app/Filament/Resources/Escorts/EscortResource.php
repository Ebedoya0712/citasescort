<?php

namespace App\Filament\Resources\Escorts;

use App\Filament\Resources\Escorts\Pages\CreateEscort;
use App\Filament\Resources\Escorts\Pages\EditEscort;
use App\Filament\Resources\Escorts\Pages\ListEscorts;
use App\Filament\Resources\Escorts\Pages\ViewEscort;
use App\Filament\Resources\Escorts\Schemas\EscortForm;
use App\Filament\Resources\Escorts\Schemas\EscortInfolist;
use App\Filament\Resources\Escorts\Tables\EscortsTable;
use App\Models\Escort;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EscortResource extends Resource
{
    protected static ?string $model = Escort::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $navigationColor = 'danger';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return EscortForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EscortInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EscortsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            \App\Filament\Resources\Escorts\RelationManagers\PublicationsRelationManager::class,
            \App\Filament\Resources\EscortResource\RelationManagers\StoriesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEscorts::route('/'),
            'create' => CreateEscort::route('/create'),
            'view' => ViewEscort::route('/{record}'),
            'edit' => EditEscort::route('/{record}/edit'),
        ];
    }

    public static function getNavigationItems(): array
    {
        return [
            \Filament\Navigation\NavigationItem::make('Lista de Escorts')
                ->url(static::getUrl())
                ->icon('heroicon-o-users')
                ->group('Escorts')
                ->sort(1),
        ];
    }
}
