<?php

namespace App\Filament\Escort\Resources\Publications\Pages;

use App\Filament\Escort\Resources\Publications\PublicationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPublications extends ListRecords
{
    protected static string $resource = 'App\Filament\Escort\Resources\Publications\PublicationResource';

    protected function getHeaderActions(): array
    {
        return [
            // Action 1: Access allowed directly for verified escorts or those with 0 publications
            \Filament\Actions\Action::make('create_publication')
                ->label('Crear Anuncio')
                ->icon('heroicon-m-plus')
                ->visible(fn () => 
                    ($escort = \Illuminate\Support\Facades\Auth::user()->escort) &&
                    ($escort->isVerified() || $escort->publications()->count() === 0)
                )
                ->url(fn () => \App\Filament\Escort\Resources\Publications\PublicationResource::getUrl('create')),

            // Action 2: Access blocked for unverified escorts with 1 or more publications (triggers modal)
            \Filament\Actions\Action::make('create_publication_restricted')
                ->label('Crear Anuncio')
                ->icon('heroicon-m-plus')
                ->visible(fn () => 
                    ($escort = \Illuminate\Support\Facades\Auth::user()->escort) &&
                    !$escort->isVerified() &&
                    $escort->publications()->count() >= 1
                )
                ->requiresConfirmation()
                ->modalHeading('Verificación Requerida')
                ->modalDescription('Para publicar más anuncios verifica tu perfil de escort.')
                ->modalSubmitActionLabel('Ir a Verificar mi Perfil')
                ->action(fn () => redirect(\App\Filament\Escort\Pages\VerifyProfile::getUrl())),
        ];
    }
}
