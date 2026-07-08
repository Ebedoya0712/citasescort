<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class RevenueChart extends ChartWidget
{
    protected ?string $pollingInterval = null;
    protected static ?int $sort = 1;
    protected int|string|array $columnSpan = 'full';
    protected ?string $maxHeight = '300px';
    
    protected ?string $heading = 'Ingresos Mensuales';

    protected function getData(): array
    {
        // Ideally use Flowframe\Trend if installed, or raw query. 
        // For simplicity and no extra dependencies errors, raw query to get last 6 months.
        
        $data = Payment::selectRaw('SUM(amount) as aggregate, DATE_FORMAT(created_at, "%Y-%m") as month')
            ->whereIn('status', ['completed', 'approved'])
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $labels = $data->pluck('month')->map(fn($date) => \Carbon\Carbon::parse($date)->format('M'))->toArray();
        $values = $data->pluck('aggregate')->toArray();

        // Fallback for empty data so chart renders something
        if (empty($values)) {
            $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
            $values = [0, 0, 0, 0, 0, 0];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Ingresos (S/)',
                    'data' => $values,
                    'fill' => 'start',
                    'borderColor' => '#dc2626', // Pink-600ish
                    'backgroundColor' => 'rgba(219, 39, 119, 0.1)',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
