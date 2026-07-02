<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Visitor;
use Illuminate\Support\Carbon;

class VisitorStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Visitantes Activos', Visitor::where('last_visit_at', '>=', Carbon::now()->subMinutes(5))->count())
                ->description('Activos en tiempo real (5 min)')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
                
            Stat::make('Visitantes Recurrentes', Visitor::where('total_visits', '>', 1)->count())
                ->description('Usuarios con más de 1 visita')
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color('info'),
                
            Stat::make('Recurrentes sin WhatsApp', Visitor::where('total_visits', '>', 1)->whereNull('whatsapp_number')->where('whatsapp_clicks', 0)->count())
                ->description('Prospectos sin contacto')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color('warning'),
        ];
    }
}
