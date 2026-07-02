<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use Filament\Resources\Pages\EditRecord;

class EditSetting extends EditRecord
{
    protected static string $resource = SettingResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $record = $this->getRecord();
        
        switch ($record->type) {
            case 'text':
                $data['value'] = $data['value_text'] ?? null;
                break;
            case 'textarea':
                $data['value'] = $data['value_textarea'] ?? null;
                break;
            case 'image':
                $data['value'] = $data['value_image'] ?? null;
                break;
            case 'boolean':
                $data['value'] = isset($data['value_boolean']) ? (bool) $data['value_boolean'] : null;
                break;
        }

        // Clean up temporary keys
        unset($data['value_text'], $data['value_textarea'], $data['value_image'], $data['value_boolean']);

        return $data;
    }
}
