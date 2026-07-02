<?php

namespace App\Filament\Widgets;

use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use App\Models\VisitLog;
use Illuminate\Support\Facades\DB;

class MostVisitedPagesWidget extends BaseWidget
{
    protected static ?string $heading = 'Ranking de Páginas y Secciones más Visitadas';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                VisitLog::query()
                    ->select('url as id', 'url', DB::raw('count(*) as views_count'), DB::raw('ROUND(AVG(duration)) as avg_duration'))
                    ->groupBy('url')
                    ->orderByDesc('views_count')
            )
            ->columns([
                TextColumn::make('url')
                    ->label('Ruta / URL')
                    ->formatStateUsing(fn (string $state): string => parse_url($state, PHP_URL_PATH) ?: $state)
                    ->searchable()
                    ->wrap(),
                TextColumn::make('views_count')
                    ->label('Visitas Totales')
                    ->sortable(),
                TextColumn::make('avg_duration')
                    ->label('Permanencia Promedio')
                    ->suffix(' seg.')
                    ->sortable(),
            ]);
    }

    public function getTableRecordKey($record): string
    {
        return (string) $record->url;
    }
}
