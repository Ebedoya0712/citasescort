<?php

namespace App\Filament\Escort\Resources\StoryResource\Pages;


use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateStory extends CreateRecord      
{
    protected static string $resource = 'App\Filament\Escort\Resources\StoryResource';

    public function mount(): void
    {
        parent::mount();

        $escort = \Illuminate\Support\Facades\Auth::user()->escort;
        if ($escort && !$escort->isVerified()) {
            \Filament\Notifications\Notification::make()
                ->title('Verificación Requerida')
                ->body('Debes verificar tu identidad antes de poder subir historias. Una vez que el administrador apruebe tu perfil, podrás publicar historias libremente.')
                ->warning()
                ->persistent()
                ->send();
            
            $this->redirect(\App\Filament\Escort\Pages\VerifyProfile::getUrl());
        }
    }
    
    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        $escortId = Auth::user()->escort->id;
        $mediaPaths = $data['media_path'];
        $caption = $data['caption'] ?? null;
        $expiresAt = $data['expires_at'] ?? now()->addDays(2);
        $isActive = $data['is_active'] ?? true;

        // Ensure mediaPaths is an array (it should be from FileUpload multiple)
        if (!is_array($mediaPaths)) {
            $mediaPaths = [$mediaPaths];
        }

        $createdModels = [];

        foreach ($mediaPaths as $path) {
            $story = new \App\Models\Story();
            $story->escort_id = $escortId;
            // Store as array of 1 item for consistency with existing structure
            $story->media_path = [$path]; 
            $story->caption = $caption;
            $story->expires_at = $expiresAt;
            $story->is_active = $isActive;
            $story->save();
            
            $createdModels[] = $story;
        }

        // Return the first one created so Filament has something to redirect to/show
        return $createdModels[0];
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
