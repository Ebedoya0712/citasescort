<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PublicationResource\Pages;
use App\Models\Publication;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Schemas\Components\Section as SchemaSection;
use Filament\Schemas\Components\Grid as SchemaGrid;
use Filament\Schemas\Components\Group as SchemaGroup;
use Illuminate\Database\Eloquent\Builder;

class PublicationResource extends Resource
{
    protected static ?string $model = Publication::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-megaphone';
    protected static string | \UnitEnum | null $navigationGroup = 'Perfiles Publicados';
    protected static ?string $navigationLabel = 'Ver Perfiles';

    protected static ?string $modelLabel = 'Perfil Publicado';
    protected static ?string $pluralModelLabel = 'Perfiles Publicados';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Escort')
                    ->schema([
                        Forms\Components\Select::make('escort_id')
                            ->relationship('escort', 'name')
                            ->required()
                            ->searchable()
                            ->label('Escort'),
                    ]),
                \Filament\Schemas\Components\Section::make('Información del Perfil')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->label('Título'),
                        Forms\Components\Textarea::make('description')
                            ->label('Descripción')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
                \Filament\Schemas\Components\Section::make('Detalles Generales')
                    ->schema([
                        Forms\Components\Select::make('city')
                            ->label('Departamento -> Distrito')
                            ->options(\App\Models\City::getGroupedOptions())
                            ->required(),
                        Forms\Components\TextInput::make('price')
                            ->label('Tarifa')
                            ->numeric()
                            ->prefix('$'),
                        Forms\Components\Select::make('currency')
                            ->label('Moneda')
                            ->options([
                                'UYU' => 'UYU',
                                'USD' => 'USD',
                                'EUR' => 'EUR',
                                'ARS' => 'ARS',
                                'BRL' => 'BRL',
                            ])
                            ->default('UYU'),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Visible')
                            ->default(true),
                    ])->columns(2),
                \Filament\Schemas\Components\Section::make('Fotos')
                    ->schema([
                        Forms\Components\FileUpload::make('photos')
                            ->label('Galería de Fotos y Videos')
                            ->multiple()
                            ->reorderable()
                            ->directory('publication-photos')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                // ─── CABECERA ─────────────────────────────────────────────
                SchemaSection::make()
                    ->schema([
                        SchemaGrid::make(2)
                            ->schema([
                                // Izquierda: Nombre + Título
                                SchemaGrid::make(1)->schema([
                                    \Filament\Infolists\Components\ImageEntry::make('escort.profile_photo')
                                        ->hiddenLabel()
                                        ->circular()
                                        ->size(80),
                                    TextEntry::make('escort.name')
                                        ->hiddenLabel()
                                        ->extraAttributes([
                                            'style' => 'font-size: 1.875rem; font-weight: 900; line-height: 1.1; color: rgb(239, 68, 68); letter-spacing: -0.02em;'
                                        ]),
                                    TextEntry::make('title')
                                        ->hiddenLabel()
                                        ->extraAttributes([
                                            'style' => 'font-size: 1.125rem; font-weight: 500; opacity: 0.7;'
                                        ]),
                                ]),
                                // Derecha: Precio + Ciudad
                                SchemaGrid::make(1)->schema([
                                    TextEntry::make('price')
                                        ->hiddenLabel()
                                        ->money(fn ($record) => $record->currency ?? 'UYU')
                                        ->alignEnd()
                                        ->extraAttributes([
                                            'style' => 'font-size: 1.5rem; font-weight: 900; line-height: 1.1; color: rgb(34, 197, 94);'
                                        ]),
                                    TextEntry::make('city')
                                        ->hiddenLabel()
                                        ->icon('heroicon-m-map-pin')
                                        ->alignEnd()
                                        ->extraAttributes([
                                            'style' => 'font-size: 0.875rem; font-weight: 600; opacity: 0.8;'
                                        ]),
                                ]),
                            ]),
                    ])
                    ->extraAttributes(['style' => 'min-height: 6rem;']),

                // ─── DESCRIPCIÓN ───────────────────────────────────────────────
                SchemaSection::make('Descripción')
                    ->schema([
                        TextEntry::make('description')
                            ->hiddenLabel()
                            ->markdown()
                            ->prose()
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                // ─── SERVICIOS ────────────────────────────────────────────────
                SchemaSection::make('Servicios')
                    ->schema([
                        TextEntry::make('services')
                            ->label('Ofrece')
                            ->badge()
                            ->separator(',')
                            ->color('danger')
                            ->extraAttributes(['class' => '[&>div>ul]:flex-col [&>div>ul]:items-start [&_ul]:flex-col [&_ul]:items-start gap-y-1']),
                        TextEntry::make('attends_in')
                            ->label('Atiende en')
                            ->badge()
                            ->color('warning')
                            ->extraAttributes(['class' => '[&>div>ul]:flex-col [&>div>ul]:items-start [&_ul]:flex-col [&_ul]:items-start gap-y-1']),
                        TextEntry::make('attends_to')
                            ->label('Atiende a')
                            ->badge()
                            ->color('success')
                            ->extraAttributes(['class' => '[&>div>ul]:flex-col [&>div>ul]:items-start [&_ul]:flex-col [&_ul]:items-start gap-y-1']),
                    ])
                    ->columns(3)
                    ->collapsible(),

                // ─── ESTADO DEL ANUNCIO ───────────────────────────────────────
                SchemaSection::make('Estado del Anuncio')
                    ->schema([
                        IconEntry::make('is_active')
                            ->boolean()
                            ->label('Visible en el sitio'),
                        TextEntry::make('created_at')
                            ->label('Publicado el')
                            ->dateTime('d/m/Y - H:i')
                            ->icon('heroicon-m-calendar-days'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                // ─── CUENTA ───────────────────────────────────────────────────
                SchemaSection::make('Cuenta')
                    ->schema([
                        TextEntry::make('escort.user.name')
                            ->label('Titular')
                            ->weight('bold'),
                        TextEntry::make('escort.user.email')
                            ->label('Email')
                            ->icon('heroicon-m-envelope')
                            ->copyable()
                            ->size('sm'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                // ─── GALERÍA ───────────────────────────────────────────────
                SchemaSection::make('Galería de Medios')
                    ->schema([
                        ViewEntry::make('photos')
                            ->label(null)
                            ->columnSpanFull()
                            ->view('filament.infolists.components.image-modal'),
                        ViewEntry::make('videos')
                            ->label(null)
                            ->state(fn ($record) => $record->photos)
                            ->columnSpanFull()
                            ->view('filament.infolists.components.video-player'),
                    ])
                    ->collapsible(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photos')
                    ->label('Foto')
                    ->circular()
                    ->stacked()
                    ->limit(3),
                Tables\Columns\TextColumn::make('escort.name')
                    ->label('Escort')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->label('Ubicación')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Tarifa')
                    ->money(fn ($record) => $record->currency ?? 'UYU')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Visible')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('city')
                    ->label('Departamento -> Distrito')
                    ->options(\App\Models\City::getGroupedOptions()),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Visible'),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                \Filament\Actions\ViewAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
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
            'index' => Pages\ListPublications::route('/'),
            'view' => Pages\ViewPublication::route('/{record}'),
        ];
    }
}
