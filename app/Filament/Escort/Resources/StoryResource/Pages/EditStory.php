<?php

namespace App\Filament\Escort\Resources\StoryResource\Pages;


use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStory extends EditRecord
{
    protected static string $resource = 'App\Filament\Escort\Resources\StoryResource';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
