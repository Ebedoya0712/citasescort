<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Components\Utilities\Get;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-cog-6-tooth';
    
    protected static string | \UnitEnum | null $navigationGroup = 'Configuración';
    protected static ?string $navigationLabel = 'Ajustes del Sistema';
    protected static ?string $modelLabel = 'Configuración';
    protected static ?string $pluralModelLabel = 'Configuraciones';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('label')
                    ->label('Etiqueta')
                    ->disabled()
                    ->dehydrated(false) // Don't save label changes
                    ->columnSpanFull(),
                
                Forms\Components\TextInput::make('key')
                    ->disabled()
                    ->dehydrated(false)
                    ->hidden(),

                // Dynamic Value Fields based on 'type' using unique names to prevent hydration conflicts
                Forms\Components\TextInput::make('value_text')
                    ->label('Valor')
                    ->visible(fn (Get $get, ?Setting $record) => $record?->type === 'text' || $record === null)
                    ->formatStateUsing(fn ($state, ?Setting $record) => $record?->type === 'text' ? $record->value : null)
                    ->required()
                    ->dehydrated(false),

                Forms\Components\Textarea::make('value_textarea')
                    ->label('Valor')
                    ->visible(fn (Get $get, ?Setting $record) => $record?->type === 'textarea')
                    ->formatStateUsing(fn ($state, ?Setting $record) => $record?->type === 'textarea' ? $record->value : null)
                    ->required()
                    ->dehydrated(false),

                Forms\Components\FileUpload::make('value_image')
                    ->label('Imagen')
                    ->visible(fn (Get $get, ?Setting $record) => $record?->type === 'image')
                    ->image()
                    ->directory('settings')
                    ->formatStateUsing(fn ($state, ?Setting $record) => $record?->type === 'image' ? $record->value : null)
                    ->dehydrated(false),
                
                Forms\Components\Toggle::make('value_boolean')
                    ->label('Activo')
                    ->visible(fn (Get $get, ?Setting $record) => $record?->type === 'boolean')
                    ->formatStateUsing(fn ($state, ?Setting $record) => $record?->type === 'boolean' ? (bool) $record->value : false)
                    ->dehydrated(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->searchPlaceholder('Buscar')
            ->columns([
                Tables\Columns\TextColumn::make('label')
                    ->label('Configuración')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('value')
                    ->label('Valor Actual')
                    ->limit(50),
                Tables\Columns\TextColumn::make('group')
                    ->label('Grupo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'payment' => 'success',
                        'general' => 'info',
                        'social' => 'warning',
                        'seo' => 'gray',
                        default => 'primary',
                    })
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('group')
                    ->label('Grupo')
                    ->options([
                        'general' => 'General',
                        'payment' => 'Pagos',
                        'social' => 'Redes Sociales',
                        'seo' => 'SEO',
                    ])
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                \Filament\Actions\EditAction::make(),
            ])
            ->bulkActions([]); // Disable bulk actions to prevent accidental deletions
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
    
    public static function canCreate(): bool
    {
        return false; // Disable creation, only edit seeded values
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return false; // Disable deletion
    }
}
