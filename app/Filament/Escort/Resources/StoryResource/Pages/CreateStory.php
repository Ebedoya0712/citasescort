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
        if ($escort && $escort->stories()->count() === 0 && !$escort->isVerified()) {
            \Filament\Notifications\Notification::make()
                ->title('Aviso Importante')
                ->body('Ya que no has verificado tu perfil, solo podrás subir una historia por ahora. Cuando el administrador apruebe tu verificación, podrás subir más historias libremente.')
                ->warning()
                ->persistent()
                ->send();
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
