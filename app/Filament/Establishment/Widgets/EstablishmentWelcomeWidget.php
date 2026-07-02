<?php

namespace App\Filament\Establishment\Widgets;

use Filament\Widgets\Widget;

class EstablishmentWelcomeWidget extends Widget
{
    protected string $view = 'filament.establishment.widgets.establishment-welcome-widget';
    protected int | string | array $columnSpan = 'full';
}
