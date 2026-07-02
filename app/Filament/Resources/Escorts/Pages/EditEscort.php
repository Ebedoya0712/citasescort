<?php

namespace App\Filament\Resources\Escorts\Pages;

use App\Filament\Resources\Escorts\EscortResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditEscort extends EditRecord
{
    protected static string $resource = EscortResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
