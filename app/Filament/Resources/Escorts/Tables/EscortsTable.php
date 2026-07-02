<?php

namespace App\Filament\Resources\Escorts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EscortsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('age')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('city')
                    ->searchable(),

                TextColumn::make('level')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'standard', 'general' => 'gray',
                        'silver', 'plata' => 'info',
                        'diamond', 'diamante' => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),
                IconColumn::make('verified')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-circle')
                    ->color(fn (bool $state): string => $state ? 'success' : 'danger'),
                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Activo')
                    ->action('toggle_active'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('level')
                    ->options([
                        'standard' => 'Standard',
                        'silver' => 'Silver',
                        'diamond' => 'Diamond',
                    ]),
                \Filament\Tables\Filters\Filter::make('pending_verification')
                    ->query(fn (\Illuminate\Database\Eloquent\Builder $query) => $query->where('verified', false))
                    ->label('Pendientes de Verificación')
                    ->default(false),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                ViewAction::make(),
                EditAction::make()
                    ->hidden(fn (\App\Models\Escort $record) => !$record->verified),
                \Filament\Actions\Action::make('toggle_active')
                    ->label(fn (\App\Models\Escort $record) => $record->is_active ? 'Desactivar' : 'Activar')
                    ->icon(fn (\App\Models\Escort $record) => $record->is_active ? 'heroicon-o-eye-slash' : 'heroicon-o-eye')
                    ->color(fn (\App\Models\Escort $record) => $record->is_active ? 'danger' : 'success')
                    ->visible(fn (\App\Models\Escort $record) => $record->verified)
                    ->requiresConfirmation()
                    ->modalHeading(fn (\App\Models\Escort $record) => $record->is_active ? 'Desactivar Usuario' : 'Activar Usuario')
                    ->modalDescription(fn (\App\Models\Escort $record) => '¿Estás seguro de ' . ($record->is_active ? 'desactivar' : 'activar') . ' al usuario: ' . $record->name . '?')
                    ->modalSubmitActionLabel('Sí, confirmar')
                    ->action(function (\App\Models\Escort $record) {
                        $record->update(['is_active' => !$record->is_active]);
                    }),
                \Filament\Actions\Action::make('aceptar')
                    ->label('Aceptar')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (\App\Models\Escort $record) => !$record->verified)
                    ->requiresConfirmation()
                    ->modalHeading('Aceptar Verificación')
                    ->modalDescription('¿Estás seguro de que deseas aceptar esta verificación? El perfil quedará verificado.')
                    ->modalSubmitActionLabel('Sí, aceptar')
                    ->action(function (\App\Models\Escort $record) {
                        $record->update([
                            'verification_status' => 'approved',
                            'verified' => true,
                            'is_active' => true,
                        ]);
                    }),
                \Filament\Actions\Action::make('rechazar')
                    ->label('Rechazar')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (\App\Models\Escort $record) => !$record->verified)
                    ->requiresConfirmation()
                    ->modalHeading('Rechazar Verificación')
                    ->modalDescription('¿Estás seguro de que deseas rechazar esta verificación? El usuario tendrá que volver a enviarla.')
                    ->modalSubmitActionLabel('Sí, rechazar')
                    ->action(function (\App\Models\Escort $record) {
                        $record->update([
                            'verification_status' => 'rejected',
                            'verified' => false,
                        ]);
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
