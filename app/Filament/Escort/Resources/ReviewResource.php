<?php

namespace App\Filament\Escort\Resources;

use App\Filament\Escort\Resources\ReviewResource\Pages;
use App\Models\Review;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

use Filament\Schemas\Schema;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    
    protected static ?string $navigationLabel = 'Mis Reseñas';

    protected static ?string $pluralModelLabel = 'Reseñas';
    
    protected static ?string $modelLabel = 'Reseña';
    
    protected static ?int $navigationSort = 3;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereHas('escort', function ($query) {
            $query->where('user_id', Auth::id());
        });
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                // Read-only view
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre del Usuario')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rating')
                    ->label('Valoración')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        '5', '4' => 'success',
                        '3' => 'warning',
                        '2', '1' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => $state . ' ★')
                    ->sortable(),
                Tables\Columns\TextColumn::make('content')
                     ->label('Comentario')
                     ->limit(50)
                     ->tooltip(fn (Review $record): string => $record->content),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_public')
                    ->label('Visible en Perfil')
                    ->onColor('success')
                    ->offColor('danger'),
            ])
            ->filters([
                //
            ])
            ->actions([
                // No edit action as reviews are user content
                // Maybe a View action if we implement a View page, but minimal needed
            ])
            ->bulkActions([
                // No bulk delete allowed for safety unless requested
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReviews::route('/'),
        ];
    }
    
    public static function canCreate(): bool
    {
        return false;
    }
}
