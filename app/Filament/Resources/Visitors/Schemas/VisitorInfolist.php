<?php

namespace App\Filament\Resources\Visitors\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class VisitorInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Información General del Visitante')
                    ->schema([
                        TextEntry::make('id')
                            ->label('UUID del Visitante')
                            ->copyable(),
                        TextEntry::make('name')
                            ->label('Nombre registrado')
                            ->placeholder('No proporcionado'),
                        TextEntry::make('whatsapp_number')
                            ->label('Número de WhatsApp')
                            ->placeholder('No registrado')
                            ->copyable(),
                        TextEntry::make('total_visits')
                            ->label('Visitas Totales')
                            ->numeric(),
                        TextEntry::make('whatsapp_clicks')
                            ->label('Clics en WhatsApp')
                            ->numeric(),
                        TextEntry::make('first_visit_at')
                            ->label('Primera Visita')
                            ->dateTime(),
                        TextEntry::make('last_visit_at')
                            ->label('Última Visita')
                            ->dateTime(),
                    ])->columns(3),

                \Filament\Schemas\Components\Section::make('Campaña y Origen (UTM / Ad)')
                    ->schema([
                        TextEntry::make('utm_source')
                            ->label('UTM Source')
                            ->placeholder('-'),
                        TextEntry::make('utm_medium')
                            ->label('UTM Medium')
                            ->placeholder('-'),
                        TextEntry::make('utm_campaign')
                            ->label('UTM Campaign')
                            ->placeholder('-'),
                        TextEntry::make('utm_content')
                            ->label('UTM Content')
                            ->placeholder('-'),
                        TextEntry::make('utm_term')
                            ->label('UTM Term')
                            ->placeholder('-'),
                        TextEntry::make('gclid')
                            ->label('Google Click ID (GCLID)')
                            ->placeholder('-')
                            ->copyable(),
                        TextEntry::make('fbclid')
                            ->label('Facebook Click ID (FBCLID)')
                            ->placeholder('-')
                            ->copyable(),
                    ])->columns(4),

                \Filament\Schemas\Components\Section::make('Dispositivo y Ubicación')
                    ->schema([
                        TextEntry::make('ip_address')
                            ->label('Dirección IP')
                            ->placeholder('-')
                            ->copyable(),
                        TextEntry::make('device')
                            ->label('Dispositivo')
                            ->placeholder('-'),
                        TextEntry::make('browser')
                            ->label('Navegador')
                            ->placeholder('-'),
                        TextEntry::make('city')
                            ->label('Ciudad')
                            ->placeholder('-'),
                        TextEntry::make('country')
                            ->label('País')
                            ->placeholder('-'),
                        TextEntry::make('user_agent')
                            ->label('User Agent')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ])->columns(3),
            ]);
    }
}
