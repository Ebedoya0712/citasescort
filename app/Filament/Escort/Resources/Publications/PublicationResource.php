<?php

namespace App\Filament\Escort\Resources\Publications;

use App\Filament\Escort\Resources\Publications\Pages\CreatePublication;
use App\Filament\Escort\Resources\Publications\Pages\EditPublication;
use App\Filament\Escort\Resources\Publications\Pages\ListPublications;
use App\Filament\Escort\Resources\Publications\Schemas\PublicationFormNew;
use App\Filament\Escort\Resources\Publications\Tables\PublicationsTable;
use App\Models\Publication;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PublicationResource extends Resource
{
    protected static ?string $model = Publication::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMegaphone;

    protected static ?string $navigationLabel = 'Publicar Anuncio';
    protected static ?string $modelLabel = 'Anuncio';

    public static function canCreate(): bool
    {
        $escort = \Illuminate\Support\Facades\Auth::user()->escort;
        if (!$escort) {
            return false;
        }
        
        // Can create if they have 0 publications, OR if their verification is approved
        return $escort->publications()->count() === 0 || $escort->verification_status === 'approved';
    }

    protected static ?string $recordTitleAttribute = null;
    
    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->where('escort_id', \Illuminate\Support\Facades\Auth::user()->escort->id);
    }

    public static function form(Schema $schema): Schema
    {
        return PublicationFormNew::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PublicationsTable::configure($table);
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
            'index' => ListPublications::route('/'),
            'create' => CreatePublication::route('/create'),
            'edit' => EditPublication::route('/{record}/edit'),
        ];
    }
}
