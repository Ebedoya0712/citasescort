<?php

namespace App\Filament\Establishment\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EstablishmentStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $establishment = $user->establishment;

        return [
            Stat::make('Puntuación', ($establishment->rating ?? '0.0') . ' / 5.0')
                ->description('Basado en reviews de clientes')
                ->descriptionIcon('heroicon-m-star')
                ->color('warning'),
            Stat::make('Tipo de Local', ucfirst($establishment->type ?? 'No definido'))
                ->description('Categoría actual')
                ->descriptionIcon('heroicon-m-building-storefront')
                ->color('primary'),
            Stat::make('Estado del Perfil', $establishment->status === 'approved' ? 'Aprobado' : ucfirst($establishment->status))
                ->description($establishment->status === 'approved' && $establishment->is_active ? 'Visible al público' : 'No visible')
                ->descriptionIcon($establishment->status === 'approved' && $establishment->is_active ? 'heroicon-m-check-circle' : 'heroicon-m-clock')
                ->color($establishment->status === 'approved' && $establishment->is_active ? 'success' : 'gray'),
        ];
    }
}
