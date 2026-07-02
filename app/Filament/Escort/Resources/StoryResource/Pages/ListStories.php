<?php

namespace App\Filament\Escort\Resources\StoryResource\Pages;


use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStories extends ListRecords
{
    protected static string $resource = 'App\Filament\Escort\Resources\StoryResource';

    protected function getHeaderActions(): array
    {
        return [
            // Action 1: Access allowed directly for verified escorts or those with 0 stories
            \Filament\Actions\Action::make('create_story')
                ->label('Subir Historia')
                ->icon('heroicon-m-plus')
                ->visible(fn () => 
                    ($escort = \Illuminate\Support\Facades\Auth::user()->escort) &&
                    ($escort->isVerified() || $escort->stories()->count() === 0)
                )
                ->url(fn () => \App\Filament\Escort\Resources\StoryResource::getUrl('create')),

            // Action 2: Access blocked for unverified escorts with 1 or more stories (triggers modal)
            \Filament\Actions\Action::make('create_story_restricted')
                ->label('Subir Historia')
                ->icon('heroicon-m-plus')
                ->visible(fn () => 
                    ($escort = \Illuminate\Support\Facades\Auth::user()->escort) &&
                    !$escort->isVerified() &&
                    $escort->stories()->count() >= 1
                )
                ->requiresConfirmation()
                ->modalHeading('Verificación Requerida')
                ->modalDescription('Para subir más historias verifica tu perfil de escort.')
                ->modalSubmitActionLabel('Ir a Verificar mi Perfil')
                ->action(fn () => redirect(\App\Filament\Escort\Pages\VerifyProfile::getUrl())),
        ];
    }
}
