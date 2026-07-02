<?php

namespace App\Filament\Resources\Escorts\Pages;

use App\Filament\Resources\Escorts\EscortResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEscorts extends ListRecords
{
    protected static string $resource = EscortResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => \Filament\Schemas\Components\Tabs\Tab::make('Todos'),
            'diamond' => \Filament\Schemas\Components\Tabs\Tab::make('Diamante')
                ->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) => $query->where('level', 'diamond')),
            'silver' => \Filament\Schemas\Components\Tabs\Tab::make('Plata')
                ->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) => $query->where('level', 'silver')),
            'pending' => \Filament\Schemas\Components\Tabs\Tab::make('Pendientes')
                ->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) => $query->where('verified', false))
                ->badge(\App\Models\Escort::where('verified', false)->count()),
        ];
    }
}
