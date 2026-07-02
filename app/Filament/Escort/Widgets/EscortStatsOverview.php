<?php

namespace App\Filament\Escort\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class EscortStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $user = Auth::user();
        $escort = $user->escort;

        if (!$escort) {
            return [
                Stat::make('Perfil incompleto', 'Sin Datos')
                    ->description('Por favor completa tu perfil de escort')
                    ->color('danger'),
            ];
        }

        $activeStories = $escort->stories()
            ->where('is_active', true)
            ->where('expires_at', '>', now())
            ->count();
            
        $reviewCount = $escort->reviews()->count();
        $averageRating = $reviewCount > 0 ? round($escort->reviews()->avg('rating'), 1) : 0;

        $stats = [
            Stat::make('Valoración Promedio', number_format($averageRating, 1))
                ->description('Basado en tus reseñas')
                ->descriptionIcon('heroicon-m-star')
                ->color('warning'),

            Stat::make('Total de Reseñas', $reviewCount)
                ->description('Comentarios recibidos')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color('primary'),

            Stat::make('Historias Activas', $activeStories)
                ->description('Visibles por los usuarios')
                ->descriptionIcon('heroicon-m-camera')
                ->color('success'),
        ];

        if ($escort->hasActivePlan()) {
            $stats[] = Stat::make('Suscripción Activa', 'Plan ' . ucfirst($escort->plan->name))
                ->description('Vence el: ' . $escort->plan_expires_at->format('d/m/Y'))
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success');
        } else {
            $stats[] = Stat::make('Suscripción', 'Sin Plan Activo')
                ->description('Mejora tu perfil para destacar')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger');
        }

        return $stats;
    }
}
