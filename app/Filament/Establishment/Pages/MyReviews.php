<?php

namespace App\Filament\Establishment\Pages;

use Filament\Pages\Page;
use App\Models\EstablishmentReview;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Auth;

class MyReviews extends Page implements HasTable
{
    use InteractsWithTable;

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-star';
    }

    public static function getNavigationLabel(): string
    {
        return 'Mis Reseñas';
    }

    public function getTitle(): string
    {
        return 'Mis Reseñas';
    }

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

    protected string $view = 'filament.establishment.pages.my-reviews';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                EstablishmentReview::query()
                    ->where('establishment_id', Auth::user()->establishment?->id)
                    ->latest()
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Usuario')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn ($record) => $record->user ? $record->user->name : ($record->name ?: 'Anónimo')),
                TextColumn::make('rating')
                    ->label('Calificación')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => str_repeat('⭐', $state)),
                TextColumn::make('content')
                    ->label('Comentario')
                    ->searchable()
                    ->wrap(),
                TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->emptyStateHeading('No tienes reseñas aún');
    }
}
