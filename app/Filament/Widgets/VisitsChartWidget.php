<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\VisitLog;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class VisitsChartWidget extends ChartWidget
{
    protected ?string $heading = 'Páginas Vistas Diarias (Últimos 15 Días)';
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 'full';
    protected ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $startDate = Carbon::now()->subDays(15)->startOfDay();

        // Obtener los logs de visitas agrupados por fecha
        $logs = VisitLog::query()
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();

        // Generar labels (e.g. "29/06") y rellenar dÃ­as sin visitas con 0
        $labels = [];
        $data = [];
        for ($i = 15; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dateStr = $date->format('Y-m-d');
            $labels[] = $date->format('d/m');
            $data[] = $logs[$dateStr] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Vistas',
                    'data' => $data,
                    'borderColor' => '#f72585', // Rosa Citasescort
                    'backgroundColor' => 'rgba(247, 37, 133, 0.1)',
                    'fill' => true,
                    'tension' => 0.3,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'x' => [
                    'ticks' => [
                        'autoSkip' => true,
                        'maxTicksLimit' => 7,
                    ],
                ],
            ],
        ];
    }
}

