<?php

namespace App\Filament\Resources\Escorts\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class EscortInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Información General y Fotos Públicas')
                    ->schema([
                        TextEntry::make('name')->label('Nombre'),
                        TextEntry::make('description')->placeholder('-')->columnSpanFull()->label('Descripción'),
                        TextEntry::make('age')->numeric()->placeholder('-')->label('Edad'),
                        TextEntry::make('city')->placeholder('-')->label('Ciudad'),
                        TextEntry::make('price')->numeric()->prefix('$')->placeholder('-')->label('Precio'),
                        IconEntry::make('is_active')->boolean()->label('Activo'),
                        \Filament\Infolists\Components\ViewEntry::make('profile_photo')
                            ->label('Foto de Perfil')
                            ->view('filament.infolists.components.image-modal'),
                        \Filament\Infolists\Components\ViewEntry::make('photos')
                            ->label('Fotos de Galería')
                            ->view('filament.infolists.components.image-modal')
                            ->columnSpanFull(),
                    ])->columns(2),

                \Filament\Schemas\Components\Section::make('Verificación de Identidad')
                    ->schema([
                        TextEntry::make('verification_status')
                            ->label('Estado de Verificación')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'pending' => 'warning',
                                'approved' => 'success',
                                'rejected' => 'danger',
                                default => 'gray',
                            }),
                        \Filament\Infolists\Components\ViewEntry::make('id_front')
                            ->label('Frente del Documento')
                            ->view('filament.infolists.components.image-modal'),
                        \Filament\Infolists\Components\ViewEntry::make('id_back')
                            ->label('Dorso del Documento')
                            ->view('filament.infolists.components.image-modal'),
                        \Filament\Infolists\Components\ViewEntry::make('verification_video')
                            ->label('Video de Verificación')
                            ->view('filament.infolists.components.video-player')
                            ->columnSpanFull(),
                    ])->columns(3),
            ]);
    }
}
