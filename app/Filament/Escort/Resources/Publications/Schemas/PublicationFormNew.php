<?php

namespace App\Filament\Escort\Resources\Publications\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Grid;

class PublicationFormNew
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Información del Perfil')
                    ->schema([
                         \Filament\Forms\Components\Placeholder::make('profile_photo')
                            ->label('Mi Foto de Perfil')
                            ->content(fn () => view('filament.escort.components.profile-photo-preview', ['escort' => \Illuminate\Support\Facades\Auth::user()->escort]))
                            ->columnSpanFull(),

                        TextInput::make('title')
                            ->label('Título del Anuncio')
                            ->placeholder('Ej. Perfil de marit o un título atractivo')
                            ->required()
                            ->columnSpanFull(),

                        Textarea::make('description')
                            ->label('Descripción')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),

                \Filament\Schemas\Components\Section::make('Detalles Generales')
                    ->schema([
                        \Filament\Schemas\Components\Grid::make(2)
                            ->schema([
                                \Filament\Forms\Components\Select::make('attends_in')
                                    ->label('¿Dónde Atiende?')
                                    ->multiple()
                                    ->options([
                                        'Hoteles' => 'Hoteles',
                                        'Apartamento Propio' => 'Apartamento Propio',
                                        'Domicilio' => 'Domicilio',
                                        'Casa de Masajes' => 'Casa de Masajes',
                                        'Club' => 'Club',
                                    ]),
                                \Filament\Forms\Components\Select::make('attends_to')
                                    ->label('¿A quién Atiende?')
                                    ->multiple()
                                    ->options([
                                        'Hombres' => 'Hombres',
                                        'Mujeres' => 'Mujeres',
                                        'Parejas' => 'Parejas',
                                        'Trans' => 'Trans',
                                    ]),
                            ]),
                        \Filament\Forms\Components\Textarea::make('schedule')
                            ->label('Horarios de Atención')
                            ->rows(2)
                            ->columnSpanFull(),
                    ]),

                \Filament\Schemas\Components\Section::make('Servicios Ofrecidos')
                    ->schema([
                        \Filament\Schemas\Components\Tabs::make('Servicios')
                            ->tabs([
                                \Filament\Schemas\Components\Tabs\Tab::make('Servicios Presenciales')
                                    ->schema([
                                        \Filament\Forms\Components\TagsInput::make('services')
                                            ->label('Lista de Servicios')
                                            ->placeholder('Ej: Masajes, Baile, etc.')
                                            ->suggestions([
                                                'Besos', 'Masaje Erótico', 'Baile', 'GFE', 'Lluvia Dorada', 
                                                'Juguetes', 'Disfraces', 'Saso', 'Dúplex',
                                            ])
                                            ->columnSpanFull(),
                                        \Filament\Schemas\Components\Grid::make(2)
                                            ->schema([
                                                \Filament\Forms\Components\Select::make('oral_sex')
                                                    ->label('Sexo Oral')
                                                    ->options([
                                                        'Realiza con preservativo' => 'Realiza con preservativo',
                                                        'Realiza sin preservativo' => 'Realiza sin preservativo',
                                                        'No realiza' => 'No realiza',
                                                    ]),
                                            ]),
                                        \Filament\Forms\Components\TagsInput::make('fantasies')
                                            ->label('Fantasías')
                                            ->placeholder('Agregar fantasía')
                                            ->columnSpanFull(),
                                    ]),
                                \Filament\Schemas\Components\Tabs\Tab::make('Servicios Virtuales')
                                    ->schema([
                                        \Filament\Forms\Components\TagsInput::make('virtual_services')
                                            ->label('Servicios Virtuales')
                                            ->placeholder('Agregar servicio virtual')
                                            ->columnSpanFull(),
                                    ]),
                            ])
                            ->columnSpanFull(),
                    ]),

                \Filament\Schemas\Components\Section::make('Detalles Personales')
                    ->schema([

                        \Filament\Schemas\Components\Grid::make(3)
                            ->schema([
                                TextInput::make('height')
                                    ->label('Estatura')
                                    ->placeholder('Ej: 1.60m'),
                                TextInput::make('hair_color')
                                    ->label('Color de Pelo'),
                                TextInput::make('price')
                                    ->label('Tarifa')
                                    ->numeric()
                                    ->prefix('$'),
                                TextInput::make('waist')
                                    ->label('Cintura')
                                    ->placeholder('Ej: 60cm'),
                                TextInput::make('hips')
                                    ->label('Caderas')
                                    ->placeholder('Ej: 90cm'),
                                TextInput::make('bust')
                                    ->label('Busto')
                                    ->placeholder('Ej: 36 B'),
                            ]),
                        \Filament\Forms\Components\Radio::make('currency')
                            ->label('Moneda')
                            ->options([
                                'PEN' => 'PEN',
                                'USD' => 'USD',
                            ])
                            ->default('PEN')
                            ->inline()
                            ->inlineLabel(false)
                            ->columnSpanFull(),
                    ]),

                \Filament\Schemas\Components\Section::make('Contacto')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('phone')
                            ->label('Teléfono')
                            ->tel()
                            ->columnSpanFull(),

                        \Filament\Forms\Components\TextInput::make('whatsapp')
                            ->label('WhatsApp')
                            ->tel()
                            ->prefix(new \Illuminate\Support\HtmlString('<div class="flex items-center gap-1.5"><img src="https://flagcdn.com/w20/pe.png" width="18" height="13" class="rounded-sm" alt="PE"> <span class="text-gray-300 font-medium text-sm">+51</span></div>'))
                            ->dehydrateStateUsing(function ($state) {
                                return $state ? '+51' . ltrim($state, '+51 ') : null;
                            })
                            ->afterStateHydrated(function (\Filament\Forms\Components\TextInput $component, $state) {
                                if ($state && str_starts_with($state, '+51')) {
                                    $component->state(substr($state, 3));
                                }
                            })
                            ->columnSpanFull(),

                        \Filament\Forms\Components\Toggle::make('has_telegram')
                            ->label('¿Tiene Telegram?')
                            ->live()
                            ->dehydrated(false)
                            ->afterStateHydrated(function ($component, $record) {
                                if ($record && $record->telegram) {
                                    $component->state(true);
                                }
                            })
                            ->columnSpanFull(),

                        \Filament\Forms\Components\TextInput::make('telegram')
                            ->label('Usuario de Telegram')
                            ->placeholder('Ej: nombre_usuario')
                            ->prefix('@')
                            ->visible(fn ($get) => $get('has_telegram'))
                            ->columnSpanFull(),
                    ]),

                \Filament\Schemas\Components\Section::make('Redes Sociales')
                    ->schema([
                        \Filament\Schemas\Components\Grid::make(3)
                            ->schema([
                                TextInput::make('instagram')
                                    ->label('Instagram')
                                    ->prefix('instagram.com/'),
                                TextInput::make('twitter')
                                    ->label('Twitter / X')
                                    ->prefix('x.com/'),
                                TextInput::make('onlyfans')
                                    ->label('OnlyFans')
                                    ->prefix('onlyfans.com/'),
                            ]),
                    ]),

                \Filament\Schemas\Components\Section::make('Fotos')
                    ->schema([
                        \Filament\Forms\Components\FileUpload::make('photos')
                            ->label('Galería de Fotos y Videos')
                            ->multiple()
                            ->reorderable()
                            ->maxSize(102400) // 100MB
                            ->directory('publication-photos')
                            ->downloadable()
                            ->openable()
                            ->columnSpanFull(),
                    ]),

                Toggle::make('is_active')
                    ->label('Publicación Visible')
                    ->default(false)
                    ->disabled(fn () => \Illuminate\Support\Facades\Auth::user()->escort?->verification_status !== 'approved')
                    ->helperText(fn () => \Illuminate\Support\Facades\Auth::user()->escort?->verification_status !== 'approved' ? 'Tu perfil debe ser verificado por un administrador para poder hacerlo público.' : ''),
            ]);
    }
}
