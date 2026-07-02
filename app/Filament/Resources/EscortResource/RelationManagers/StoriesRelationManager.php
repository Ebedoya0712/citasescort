<?php

namespace App\Filament\Resources\EscortResource\RelationManagers;

use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'stories';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Select::make('media_type')
                    ->options([
                        'image' => 'Imagen',
                        'video' => 'Video',
                    ])
                    ->required()
                    ->default('image')
                    ->reactive(),
                Forms\Components\FileUpload::make('media_path')
                    ->label('Media')
                    ->disk('public')
                    ->directory('stories')
                    ->required()
                    ->image()
                    ->hidden(fn (Forms\Get $get) => $get('media_type') === 'video'),
                Forms\Components\FileUpload::make('media_path')
                    ->label('Media (Video)')
                    ->disk('public')
                    ->directory('stories')
                    ->required()
                    ->acceptedFileTypes(['video/mp4', 'video/quicktime', 'video/x-m4v'])
                    ->hidden(fn (Forms\Get $get) => $get('media_type') !== 'video'),
                Forms\Components\Toggle::make('is_active')
                    ->label('Activo')
                    ->default(true),
            ]);

    }

    public function table(Table $table): Table
    {
        return $table
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->recordTitleAttribute('id')
            ->columns([
                \Filament\Tables\Columns\Layout\Stack::make([
                    \Filament\Tables\Columns\ImageColumn::make('media_path')
                        ->height('200px')
                        ->width('100%')
                        ->extraImgAttributes([
                            'class' => 'object-cover rounded-t-xl',
                        ]),
                    \Filament\Tables\Columns\TextColumn::make('caption')
                        ->limit(30)
                        ->weight('bold'),
                    \Filament\Tables\Columns\TextColumn::make('media_type')
                        ->badge()
                        ->colors([
                            'primary' => 'image',
                            'success' => 'video',
                        ]),
                    \Filament\Tables\Columns\IconColumn::make('is_active')
                        ->boolean()
                        ->label('Activo'),
                ]),
            ])
            ->filters([
                //
            ])
            ->defaultSort('created_at', 'desc')
            ->headerActions([
                //
            ])
            ->actions([
                \Filament\Actions\Action::make('view_story')
                    ->label('Ver Historia')
                    ->icon('heroicon-o-eye')
                    ->url(fn ($record) => asset('storage/' . (is_array($record->media_path) ? $record->media_path[0] : $record->media_path)))
                    ->openUrlInNewTab(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
