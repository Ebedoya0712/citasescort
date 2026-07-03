<?php

namespace App\Filament\Escort\Pages;

use Filament\Pages\Page;
use App\Models\Plan;
use App\Models\Payment;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ViewField;
use Filament\Notifications\Notification;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Illuminate\Support\HtmlString;

class UpgradePlan extends Page implements HasActions
{
    use InteractsWithActions;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-star';
    
    protected static ?string $navigationLabel = 'Mejorar mis Anuncios';
    
    protected static ?string $title = 'Mejorar mis Anuncios';

    protected string $view = 'filament.escort.pages.upgrade-plan';

    public $plans;

    public function mount()
    {
        $this->plans = Plan::all();
    }

    public function payWithYapeAction(): Action
    {
        return Action::make('payWithYape')
            ->label('Pagar con Yape')
            ->modalHeading('Datos de Yape / Transferencia')
            ->modalDescription(function(array $arguments) {
                $number = '+51 921 519 687';
                
                $priceSoles = '';
                if (isset($arguments['amount'])) {
                    $converted = number_format($arguments['amount'], 2);
                    $priceSoles = "<br><br>Monto a pagar: <strong>S/. {$converted}</strong>";
                }

                return new HtmlString("Transfiere al número <strong>{$number}</strong>. Luego sube tu comprobante aquí.{$priceSoles}");
            })
            ->form([
                // ViewField::make('qr')
                //     ->view('filament.forms.components.yape-qr'),
                FileUpload::make('receipt_image')
                    ->label('Sube tu captura de pantalla o comprobante')
                    ->image()
                    ->required()
                    ->directory('payments/receipts')
            ])
            ->action(function (array $data, array $arguments) {
                Payment::create([
                    'user_id' => auth()->id(),
                    'plan_id' => $arguments['plan_id'],
                    'amount' => $arguments['amount'],
                    'status' => 'pending',
                    'gateway' => 'yape',
                    'receipt_image' => $data['receipt_image'],
                ]);
                
                Notification::make()
                    ->title('Comprobante enviado')
                    ->body('El administrador revisará tu pago en breve y activará tu plan.')
                    ->success()
                    ->send();
            })
            ->modalSubmitActionLabel('Enviar Comprobante')
            ->color('success');
    }
}
