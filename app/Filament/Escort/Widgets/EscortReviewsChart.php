<?php

namespace App\Filament\Escort\Widgets;

use App\Models\Review;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Facades\Auth;

class EscortReviewsChart extends ChartWidget
{
    protected ?string $heading = 'Reseñas en el tiempo';
    
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $escort = Auth::user()->escort;
        
        if (!$escort) {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }

        $data = Trend::query(
                Review::query()->where('escort_id', $escort->id)
            )
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Reseñas recibidas',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#ec4899', // Pink-500
                    'backgroundColor' => 'rgba(236, 72, 153, 0.1)',
                    'fill' => true,
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
