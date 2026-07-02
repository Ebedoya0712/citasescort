<?php

namespace App\Filament\Escort\Pages;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Forms;
use Filament\Schemas\Components\Section;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;

class VerifyProfile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-shield-check';

    protected string $view = 'filament.escort.pages.verify-profile';
    
    protected static ?string $title = 'Verificar mi Perfil';

    protected ?string $maxWidth = '3xl';

    public ?array $data = [];

    public function mount(): void
    {
        $user = Auth::user();
        $escort = $user->escort;

        if ($escort) {
            $this->form->fill([
                'id_front' => $escort->id_front,
                'id_back' => $escort->id_back,
                'verification_video' => $escort->verification_video,
            ]);
        }
    }

    public function form(Schema $schema): Schema
    {
        $user = Auth::user();
        $escort = $user->escort;
        $status = $escort ? $escort->verification_status : 'unverified';

        // Only show form if unverified or rejected
        if (in_array($status, ['pending', 'approved'])) {
            return $schema->schema([]);
        }

        return $schema
            ->schema([
                \Filament\Schemas\Components\Wizard::make([
                    // Step 1: Frente del Documento
                    \Filament\Schemas\Components\Wizard\Step::make('Frente del Documento')
                        ->icon('heroicon-o-identification')
                        ->description('Subí una foto clara del frente de tu CI')
                        ->schema([
                            Forms\Components\Placeholder::make('instrucciones_frente')
                                ->hiddenLabel()
                                ->content(new HtmlString('
                                    <div class="flex items-center gap-4 bg-gray-900/50 p-6 rounded-xl border border-gray-800">
                                        <div class="p-3 bg-brand-pink/20 rounded-full text-brand-pink">
                                            <svg xmlns="http://www.w3.org/2000/svg" style="width: 80px; height: 80px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-bold text-white leading-tight">Foto Frontal de la Cédula</h3>
                                            <p class="text-sm text-gray-400 mt-1">Asegurate de que haya buena iluminación y que todos los datos sean legibles. No cortes los bordes de la tarjeta.</p>
                                        </div>
                                    </div>
                                ')),
                            Forms\Components\FileUpload::make('id_front')
                                ->label('')
                                ->image()
                                ->directory('escort-verifications')
                                ->required()
                                ->maxSize(10240) // 10MB
                        ]),

                    // Step 2: Dorso del Documento
                    \Filament\Schemas\Components\Wizard\Step::make('Dorso del Documento')
                        ->icon('heroicon-o-credit-card')
                        ->description('Subí una foto del reverso de tu CI')
                        ->schema([
                            Forms\Components\Placeholder::make('instrucciones_dorso')
                                ->hiddenLabel()
                                ->content(new HtmlString('
                                    <div class="flex items-center gap-4 bg-gray-900/50 p-6 rounded-xl border border-gray-800">
                                        <div class="p-3 bg-brand-pink/20 rounded-full text-brand-pink">
                                            <svg xmlns="http://www.w3.org/2000/svg" style="width: 80px; height: 80px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h14.25c.621 0 1.125.504 1.125 1.125v14.25c0 .621-.504 1.125-1.125 1.125H4.875A1.125 1.125 0 013.75 19.125V4.875z" />
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6h16.5" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-bold text-white leading-tight">Foto Trasera de la Cédula</h3>
                                            <p class="text-sm text-gray-400 mt-1">Acordate de enfocar bien para que podamos ver claramente el reverso de tu documento de identidad.</p>
                                        </div>
                                    </div>
                                ')),
                            Forms\Components\FileUpload::make('id_back')
                                ->label('')
                                ->image()
                                ->directory('escort-verifications')
                                ->required()
                                ->maxSize(10240) // 10MB
                        ]),

                    // Step 3: Video de Verificación
                    \Filament\Schemas\Components\Wizard\Step::make('Prueba de Vida')
                        ->icon('heroicon-o-video-camera')
                        ->description('Grabá un video corto')
                        ->schema([
                            Forms\Components\Placeholder::make('instrucciones_video')
                                ->hiddenLabel()
                                ->content(new HtmlString('
                                    <style>
                                        /* Head and eye animations */
                                        @keyframes head-turn {
                                            0%   { transform: rotate(0deg); }
                                            15%  { transform: rotate(-18deg); }  /* Look left */
                                            30%  { transform: rotate(0deg); }
                                            45%  { transform: rotate(18deg); }   /* Look right */
                                            60%  { transform: rotate(0deg); }
                                            100% { transform: rotate(0deg); }
                                        }
                                        @keyframes head-nod {
                                            0%   { transform: rotate(0deg); }
                                            15%  { transform: rotate(-15deg); }  /* Look up */
                                            30%  { transform: rotate(0deg); }
                                            45%  { transform: rotate(12deg); }   /* Look down */
                                            60%  { transform: rotate(0deg); }
                                            100% { transform: rotate(0deg); }
                                        }
                                        @keyframes eye-look-lr {
                                            0%   { cx: 50%; }
                                            15%  { cx: 38%; }
                                            30%  { cx: 50%; }
                                            45%  { cx: 62%; }
                                            60%  { cx: 50%; }
                                            100% { cx: 50%; }
                                        }
                                        @keyframes eye-look-ud {
                                            0%   { cy: 38%; }
                                            15%  { cy: 28%; }
                                            30%  { cy: 38%; }
                                            45%  { cy: 48%; }
                                            60%  { cy: 38%; }
                                            100% { cy: 38%; }
                                        }
                                        @keyframes label-fade {
                                            0%, 10%  { opacity: 0; transform: translateY(4px); }
                                            20%, 40% { opacity: 1; transform: translateY(0); }
                                            50%, 100%{ opacity: 0; transform: translateY(-4px); }
                                        }
                                        @keyframes label-fade2 {
                                            0%, 50%  { opacity: 0; transform: translateY(4px); }
                                            60%, 80% { opacity: 1; transform: translateY(0); }
                                            90%, 100%{ opacity: 0; transform: translateY(-4px); }
                                        }
                                        .head-lr { transform-origin: center center; animation: head-turn 4s ease-in-out infinite; }
                                        .head-ud { transform-origin: center center; animation: head-nod 4s ease-in-out infinite; }
                                        .eye-pupil-lr { animation: eye-look-lr 4s ease-in-out infinite; }
                                        .eye-pupil-ud { animation: eye-look-ud 4s ease-in-out infinite; }
                                        .label-lr { animation: label-fade 4s ease-in-out infinite; }
                                        .label-ud { animation: label-fade2 4s ease-in-out infinite; }
                                        .fi-verify-card {
                                            background: rgba(0,0,0,0.3);
                                            border: 1px solid rgba(255,255,255,0.06);
                                            border-radius: 12px;
                                            padding: 20px 16px;
                                            display: flex;
                                            flex-direction: column;
                                            align-items: center;
                                            gap: 12px;
                                        }
                                    </style>
                                    <div style="background:rgba(17,17,27,0.5); padding:24px; border-radius:16px; border:1px solid rgba(255,255,255,0.08);">
                                        <h3 style="font-size:1rem; font-weight:700; color:#fff; text-align:center; margin:0 0 6px;">Instrucciones del Video</h3>
                                        <p style="font-size:0.75rem; color:#9ca3af; text-align:center; margin:0 0 20px;">Sostenés tu documento cerca de tu cara y hacés estos movimientos:</p>
                                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">

                                            <!-- Card Izquierda/Derecha -->
                                            <div class="fi-verify-card">
                                                <svg viewBox="0 0 100 120" style="width:90px; height:108px; overflow:visible;">
                                                  <g class="head-lr">
                                                    <!-- Neck -->
                                                    <rect x="40" y="85" width="20" height="18" rx="5" fill="#374151"/>
                                                    <!-- Head -->
                                                    <ellipse cx="50" cy="55" rx="34" ry="38" fill="#4b5563"/>
                                                    <!-- Hair -->
                                                    <ellipse cx="50" cy="26" rx="32" ry="14" fill="#1f2937"/>
                                                    <!-- Left eye white -->
                                                    <ellipse cx="35" cy="55" rx="9" ry="9" fill="white"/>
                                                    <!-- Right eye white -->
                                                    <ellipse cx="65" cy="55" rx="9" ry="9" fill="white"/>
                                                    <!-- Left pupil -->
                                                    <circle r="4.5" fill="#1d4ed8">
                                                      <animate attributeName="cx" values="35;26;35;44;35" dur="4s" keyTimes="0;0.15;0.3;0.45;1" calcMode="spline" keySplines=".4 0 .6 1;.4 0 .6 1;.4 0 .6 1;.4 0 .6 1" repeatCount="indefinite"/>
                                                      <animate attributeName="cy" values="55;55;55;55;55" dur="4s" repeatCount="indefinite"/>
                                                    </circle>
                                                    <!-- Right pupil -->
                                                    <circle r="4.5" fill="#1d4ed8">
                                                      <animate attributeName="cx" values="65;56;65;74;65" dur="4s" keyTimes="0;0.15;0.3;0.45;1" calcMode="spline" keySplines=".4 0 .6 1;.4 0 .6 1;.4 0 .6 1;.4 0 .6 1" repeatCount="indefinite"/>
                                                      <animate attributeName="cy" values="55;55;55;55;55" dur="4s" repeatCount="indefinite"/>
                                                    </circle>
                                                    <!-- Mouth -->
                                                    <path d="M40 75 Q50 81 60 75" stroke="#9ca3af" stroke-width="2.5" fill="none" stroke-linecap="round"/>
                                                  </g>
                                                  <!-- Arrows left/right -->
                                                  <text x="8" y="60" font-size="16" fill="#ec4899" opacity="0.9" style="animation: label-fade 4s ease-in-out infinite;">←</text>
                                                  <text x="78" y="60" font-size="16" fill="#ec4899" opacity="0.9" style="animation: label-fade 4s ease-in-out infinite;">→</text>
                                                </svg>
                                                <span style="font-size:14px; font-weight:700; color:#fff; text-align:center;">1. Negá con la cabeza</span>
                                                <span style="font-size:12px; color:#6b7280; text-align:center; line-height:1.4;">Girá lentamente hacia la izquierda y luego hacia la derecha</span>
                                            </div>

                                            <!-- Card Arriba/Abajo -->
                                            <div class="fi-verify-card">
                                                <svg viewBox="0 0 100 120" style="width:90px; height:108px; overflow:visible;">
                                                  <g class="head-ud">
                                                    <!-- Neck -->
                                                    <rect x="40" y="85" width="20" height="18" rx="5" fill="#374151"/>
                                                    <!-- Head -->
                                                    <ellipse cx="50" cy="55" rx="34" ry="38" fill="#4b5563"/>
                                                    <!-- Hair -->
                                                    <ellipse cx="50" cy="26" rx="32" ry="14" fill="#1f2937"/>
                                                    <!-- Left eye white -->
                                                    <ellipse cx="35" cy="55" rx="9" ry="9" fill="white"/>
                                                    <!-- Right eye white -->
                                                    <ellipse cx="65" cy="55" rx="9" ry="9" fill="white"/>
                                                    <!-- Left pupil -->
                                                    <circle cx="35" r="4.5" fill="#1d4ed8">
                                                      <animate attributeName="cy" values="55;46;55;62;55" dur="4s" keyTimes="0;0.15;0.3;0.45;1" calcMode="spline" keySplines=".4 0 .6 1;.4 0 .6 1;.4 0 .6 1;.4 0 .6 1" repeatCount="indefinite"/>
                                                    </circle>
                                                    <!-- Right pupil -->
                                                    <circle cx="65" r="4.5" fill="#1d4ed8">
                                                      <animate attributeName="cy" values="55;46;55;62;55" dur="4s" keyTimes="0;0.15;0.3;0.45;1" calcMode="spline" keySplines=".4 0 .6 1;.4 0 .6 1;.4 0 .6 1;.4 0 .6 1" repeatCount="indefinite"/>
                                                    </circle>
                                                    <!-- Mouth -->
                                                    <path d="M40 75 Q50 81 60 75" stroke="#9ca3af" stroke-width="2.5" fill="none" stroke-linecap="round"/>
                                                  </g>
                                                  <!-- Arrows up/down -->
                                                  <text x="44" y="12" font-size="16" fill="#ec4899" opacity="0.9" style="animation: label-fade 4s ease-in-out infinite;">↑</text>
                                                  <text x="44" y="116" font-size="16" fill="#ec4899" opacity="0.9" style="animation: label-fade 4s ease-in-out infinite;">↓</text>
                                                </svg>
                                                <span style="font-size:14px; font-weight:700; color:#fff; text-align:center;">2. Asentí con la cabeza</span>
                                                <span style="font-size:12px; color:#6b7280; text-align:center; line-height:1.4;">Mové lentamente hacia arriba y luego hacia abajo</span>
                                            </div>

                                        </div>
                                    </div>
                                ')),
                            Forms\Components\FileUpload::make('verification_video')
                                ->label('')
                                ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/quicktime'])
                                ->directory('escort-verifications')
                                ->required()
                                ->maxSize(51200) // 50MB
                                ->helperText('Subí tu video en formato MP4, WebM o MOV. Máximo 50MB.')
                        ]),
                ])
                ->submitAction(new HtmlString('<button type="submit" class="fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg fi-color-primary fi-btn-color-primary bg-primary-600 text-white hover:bg-primary-500 dark:bg-primary-500 dark:hover:bg-primary-400 fi-size-md px-3 py-2 text-sm inline-grid shadow-sm gap-1.5 mt-4"><span class="fi-btn-label">Enviar para Revisión</span></button>'))
            ])
            ->statePath('data');
    }

    public function getEscortStatus(): string
    {
        $user = Auth::user();
        $escort = $user->escort;
        return $escort ? $escort->verification_status : 'unverified';
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $user = Auth::user();
        $escort = $user->escort;

        if (!$escort) {
            Notification::make()
                ->danger()
                ->title('Error')
                ->body('Debe crear su perfil primero en "Mi Cuenta".')
                ->send();
            return;
        }

        $escort->update([
            'id_front' => $data['id_front'],
            'id_back' => $data['id_back'],
            'verification_video' => $data['verification_video'],
            'verification_status' => 'pending',
        ]);

        Notification::make()
            ->success()
            ->title('Verificación enviada')
            ->body('Tus documentos han sido enviados y están en revisión por un administrador.')
            ->send();
    }
}
