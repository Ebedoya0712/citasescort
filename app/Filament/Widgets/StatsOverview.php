<?php

namespace App\Filament\Widgets;

use App\Models\Escort;
use App\Models\Payment;
use App\Models\Report;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Escorts', Escort::where('is_active', true)->count())
                ->description('Escorts activas en la plataforma')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17]) // Dummy trend data for visual appeal
                ->color('success'),

            Stat::make('Reportes Pendientes', Report::where('status', 'pending')->count())
                ->description('Requieren atención')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->chart([1, 0, 2, 0, 1, 5, 0])
                ->color('warning'),

            Stat::make('Ingresos Totales', '$' . number_format(Payment::where('status', 'completed')->sum('amount'), 2))
                ->description('Pagos completados')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->chart([15, 4, 10, 2, 12, 4, 12])
                ->color('success'),
        ];
    }
}
