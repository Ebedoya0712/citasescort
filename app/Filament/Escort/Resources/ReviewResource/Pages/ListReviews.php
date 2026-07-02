<?php

namespace App\Filament\Escort\Resources\ReviewResource\Pages;

use App\Filament\Escort\Resources\ReviewResource;
use Filament\Resources\Pages\ListRecords;

class ListReviews extends ListRecords
{
    protected static string $resource = ReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No create action
        ];
    }
}
