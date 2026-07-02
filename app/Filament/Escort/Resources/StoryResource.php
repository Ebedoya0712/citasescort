<?php

namespace App\Filament\Escort\Resources;

use App\Filament\Escort\Resources\StoryResource\Pages;
use App\Models\Story;
use Filament\Forms;
use Filament\Schemas\Schema;

use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class StoryResource extends Resource
{
    protected static ?string $model = Story::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-camera';
    
    protected static ?string $navigationLabel = 'Mis Historias';
    
    protected static ?string $modelLabel = 'Historia';

    public static function canCreate(): bool
    {
        $escort = \Illuminate\Support\Facades\Auth::user()->escort;
        if (!$escort) {
            return false;
        }
        
        // Can create if they have 0 stories, OR if their verification is approved
        return $escort->stories()->count() === 0 || $escort->verification_status === 'approved';
    }

    public static function getEloquentQuery(): Builder
    {
        // Scope to authenticated escort's stories
        return parent::getEloquentQuery()->where('escort_id', Auth::user()->escort?->id);
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\FileUpload::make('media_path')
                    ->label('Imagen o Video')
                    ->multiple()
                    ->reorderable()
                    ->appendFiles()
                    ->panelLayout('grid')
                    ->imagePreviewHeight('500')
                    ->acceptedFileTypes(['image/*', 'video/mp4', 'video/quicktime', 'video/x-msvideo'])
                    ->maxSize(102400) // 100MB limit
                    ->directory('stories')
                    ->required()
                    ->helperText('¡Sube todo lo que quieras! Si seleccionas 10 fotos, se crearán 10 historias separadas automáticamente.')
                    ->columnSpanFull(),
                
                Forms\Components\Textarea::make('caption')
                    ->label('Leyenda (Opcional)')
                    ->rows(2)
                    ->helperText('Esta leyenda se pondrá en todas las fotos. Si quieres leyendas diferentes, crea las historias y luego edítalas una por una.')
                    ->columnSpanFull(),
                    
                Forms\Components\Hidden::make('expires_at')
                    ->default(fn () => now()->addHours(24))
                    ->required(),
                    
                Forms\Components\Toggle::make('is_active')
                    ->label('Activo')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ViewColumn::make('media_path')
                    ->label('Vista Previa')
                    ->view('filament.tables.columns.story-media'),
                
                Tables\Columns\TextColumn::make('caption')
                    ->label('Leyenda')
                    ->limit(30),
                    
                Tables\Columns\TextColumn::make('expires_at')
                    ->label('Expira')
                    ->dateTime()
                    ->sortable(),
                    
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Activa')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListStories::route('/'),
            'create' => Pages\CreateStory::route('/create'),
            'edit' => Pages\EditStory::route('/{record}/edit'),
        ];
    }
}
