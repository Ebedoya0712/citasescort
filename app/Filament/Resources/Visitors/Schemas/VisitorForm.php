<?php

namespace App\Filament\Resources\Visitors\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class VisitorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->default(null),
                TextInput::make('whatsapp_number')
                    ->default(null),
                DateTimePicker::make('first_visit_at')
                    ->required(),
                DateTimePicker::make('last_visit_at')
                    ->required(),
                TextInput::make('total_visits')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('whatsapp_clicks')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('utm_source')
                    ->default(null),
                TextInput::make('utm_medium')
                    ->default(null),
                TextInput::make('utm_campaign')
                    ->default(null),
                TextInput::make('utm_content')
                    ->default(null),
                TextInput::make('utm_term')
                    ->default(null),
                TextInput::make('gclid')
                    ->default(null),
                TextInput::make('fbclid')
                    ->default(null),
                TextInput::make('ip_address')
                    ->default(null),
                Textarea::make('user_agent')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('browser')
                    ->default(null),
                TextInput::make('device')
                    ->default(null),
                TextInput::make('city')
                    ->default(null),
                TextInput::make('country')
                    ->default(null),
            ]);
    }
}
