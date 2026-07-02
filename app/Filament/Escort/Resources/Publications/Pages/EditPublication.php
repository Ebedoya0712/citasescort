<?php

namespace App\Filament\Escort\Resources\Publications\Pages;

use App\Filament\Escort\Resources\Publications\PublicationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPublication extends EditRecord
{
    protected static string $resource = 'App\Filament\Escort\Resources\Publications\PublicationResource';

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void 
    {
        $publication = $this->record;
        $escort = $publication->escort;

        if ($escort && $publication->is_active) {
            $escort->update([
                 // Sync data from Publication to Escort
                'title' => $publication->title ?? $escort->title,
                'description' => $publication->description ?? $escort->description,
                'photos' => $publication->photos ?? $escort->photos,
                'price' => $publication->price ?? $escort->price,
                'city' => $publication->city ?? $escort->city,
                'oral_sex' => $publication->oral_sex ?? $escort->oral_sex,
                'fantasies' => $publication->fantasies ?? $escort->fantasies,
                'virtual_services' => $publication->virtual_services ?? $escort->virtual_services,
                'age' => $publication->age ?? $escort->age,
                'gender' => $publication->gender ?? $escort->gender,
                'height' => $publication->height ?? $escort->height,
                'hair_color' => $publication->hair_color ?? $escort->hair_color,
                'phone' => $publication->phone ?? $escort->phone,
                'whatsapp' => $publication->whatsapp ?? $escort->whatsapp,
                'instagram' => $publication->instagram ?? $escort->instagram,
                'twitter' => $publication->twitter ?? $escort->twitter,
                'onlyfans' => $publication->onlyfans ?? $escort->onlyfans,
                'attends_in' => $publication->attends_in ?? $escort->attends_in,
                'attends_to' => $publication->attends_to ?? $escort->attends_to,
                'services' => $publication->services ?? $escort->services,
                'schedule' => $publication->schedule ?? $escort->schedule,
                'currency' => $publication->currency ?? $escort->currency,
            ]);
        }
    }
}
