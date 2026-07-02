<?php

namespace App\Filament\Resources\Escorts\Pages;

use App\Filament\Resources\Escorts\EscortResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewEscort extends ViewRecord
{
    protected static string $resource = EscortResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    public function getRelationManagers(): array
    {
        return [];
    }
}
