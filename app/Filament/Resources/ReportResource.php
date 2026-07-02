<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Models\Report;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-exclamation-triangle';
    protected static string | \UnitEnum | null $navigationGroup = 'Mensajes y Reportes';
    protected static ?string $navigationLabel = 'Reportes de Usuarios';
    protected static bool $shouldRegisterNavigation = false;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Select::make('reporter_id')
                    ->relationship('reporter', 'name')
                    ->required()
                    ->label('Reportado por'),
                Forms\Components\Select::make('reported_user_id')
                    ->relationship('reportedUser', 'name')
                    ->label('Usuario Reportado'),
                Forms\Components\TextInput::make('reason')
                    ->required()
                    ->maxLength(255)
                    ->label('Motivo'),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull()
                    ->label('Descripción'),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pendiente',
                        'resolved' => 'Resuelto',
                        'dismissed' => 'Descartado',
                    ])
                    ->required()
                    ->default('pending')
                    ->label('Estado'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('reporter.name')
                    ->label('Reportado por')
                    ->sortable(),
                Tables\Columns\TextColumn::make('reportedUser.name')
                    ->label('Reportado')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('reason')
                    ->label('Motivo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'resolved' => 'success',
                        'dismissed' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Fecha'),
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

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('reporter', function ($query) {
                $query->where('role', 'user');
            });
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReports::route('/'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }
}
