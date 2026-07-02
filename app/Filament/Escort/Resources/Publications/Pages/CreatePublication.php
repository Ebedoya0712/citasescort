<?php

namespace App\Filament\Escort\Resources\Publications\Pages;

use App\Filament\Escort\Resources\Publications\PublicationResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePublication extends CreateRecord
{
    protected static string $resource = 'App\Filament\Escort\Resources\Publications\PublicationResource';

    protected static bool $canCreateAnother = false;

    public function mount(): void
    {
        parent::mount();

        $escort = \Illuminate\Support\Facades\Auth::user()->escort;
        if ($escort && $escort->publications()->count() === 0 && !$escort->isVerified()) {
            \Filament\Notifications\Notification::make()
                ->title('Aviso Importante')
                ->body('Ya que no has verificado tu perfil, solo podrás subir un anuncio por ahora. Cuando el administrador apruebe tu verificación, podrás crear más anuncios y hacerlos públicos.')
                ->warning()
                ->persistent()
                ->send();
        }
    }

    public function getTitle(): string 
    {
        return 'Publicar Anuncio';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $escort = \Illuminate\Support\Facades\Auth::user()->escort;
        $data['escort_id'] = $escort->id;
        $data['title'] = 'Perfil de ' . $escort->name;
        return $data;
    }

    protected function afterCreate(): void 
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
