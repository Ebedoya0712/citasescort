<?php

namespace App\Filament\Escort\Resources\Publications\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PublicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\ImageColumn::make('photos')
                    ->label('Fotos/Videos')
                    ->circular()
                    ->stacked()
                    ->limit(3),
                TextColumn::make('title')
                    ->label('Título')
                    ->sortable(),

                TextColumn::make('price')
                    ->label('Tarifa')
                    ->formatStateUsing(function ($state, $record) {
                        if (is_null($state)) {
                            return '---';
                        }
                        $currency = $record->currency ?? 'PEN';
                        if ($currency === 'USD') {
                            return '$ ' . number_format($state, 2);
                        }
                        return 'S/. ' . number_format($state, 2);
                    })
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Visible')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->paginated(false);
    }
}
