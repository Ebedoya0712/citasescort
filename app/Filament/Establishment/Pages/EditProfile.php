<?php

namespace App\Filament\Establishment\Pages;

use App\Models\Establishment;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Schemas\Schema;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class EditProfile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?string $navigationLabel = 'Mi Perfil';
    protected static ?string $title = 'Editar Perfil del Establecimiento';
    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.establishment.pages.edit-profile';

    public ?array $data = [];

    public function mount(): void
    {
        $establishment = Auth::user()->establishment;

        if ($establishment) {
            $this->form->fill($establishment->attributesToArray());
        } else {
            $this->form->fill();
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('view_public')
                ->label('Ver Perfil Público')
                ->color('gray')
                ->icon('heroicon-o-eye')
                ->url(fn () => auth()->user()->establishment ? route('establishments.show', auth()->user()->establishment->id) : '#')
                ->openUrlInNewTab()
                ->visible(fn () => auth()->user()->establishment !== null),
        ];
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->components([
                \Filament\Schemas\Components\Section::make('Información General')
                    ->description('Detalles básicos de tu establecimiento.')
                    ->schema([
                        \Filament\Forms\Components\Toggle::make('is_active')
                            ->label('Perfil Público Activo')
                            ->helperText('Activa esta opción para que tu establecimiento sea visible en la plataforma.')
                            ->default(true)
                            ->columnSpanFull(),
                        TextInput::make('name')
                            ->label('Nombre del Establecimiento')
                            ->required()
                            ->maxLength(255),
                        Select::make('type')
                            ->label('Tipo de Establecimiento')
                            ->options([
                                'whiskeria' => 'Whiskería',
                                'massage' => 'Casa de Masajes',
                                'motel' => 'Motel / Hotel',
                            ])
                            ->required(),
                        Textarea::make('description')
                            ->label('Descripción')
                            ->placeholder('Describe los servicios y ambiente de tu lugar...')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ])->columns(2),

                \Filament\Schemas\Components\Section::make('Ubicación y Contacto')
                    ->description('Cómo pueden encontrarte los clientes.')
                    ->schema([
                        Select::make('city')
                            ->label('Ubicación / Departamento')
                            ->searchable()
                            ->options(\App\Models\City::getDepartments())
                            ->required(),
                        TextInput::make('address')
                            ->label('Dirección')
                            ->placeholder('Ej: Av. Principal 123, Montevideo')
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label('Teléfono Fijo / Móvil')
                            ->tel()
                            ->maxLength(255)
                            ->columnSpan(1),

                        TextInput::make('whatsapp')
                            ->label('WhatsApp')
                            ->tel()
                            ->maxLength(255)
                            ->prefix(new \Illuminate\Support\HtmlString('<img src="https://flagcdn.com/w20/pe.png" width="20" height="15" alt="PE" class="inline" style="margin-right:4px;"> +51'))
                            ->dehydrateStateUsing(function ($state) {
                                return $state ? '+51' . $state : null;
                            })
                            ->afterStateHydrated(function (\Filament\Forms\Components\TextInput $component, $state) {
                                if ($state) {
                                    foreach (['+598', '+595', '+591', '+593', '+54', '+56', '+57', '+51', '+58', '+55'] as $prefix) {
                                        if (str_starts_with($state, $prefix)) {
                                            $component->state(substr($state, strlen($prefix)));
                                            return;
                                        }
                                    }
                                }
                            })
                            ->columnSpan(1),

                        TextInput::make('website')
                            ->label('Sitio Web')
                            ->url()
                            ->placeholder('https://tusitio.com')
                            ->maxLength(255),
                    ])->columns(2),

                \Filament\Schemas\Components\Section::make('Imagen de Marca')
                    ->description('Esta imagen aparecerá en tu perfil público.')
                    ->schema([
                        FileUpload::make('banner_image')
                            ->label('Imagen de Banner (Fondo)')
                            ->image()
                            ->imageEditor()
                            ->directory('establishments/banners')
                            ->columnSpanFull()
                            ->helperText('Se mostrará como la imagen ancha de fondo en la parte superior de tu perfil.'),
                        FileUpload::make('cover_image')
                            ->label('Imagen de Logo')
                            ->image()
                            ->imageEditor()
                            ->circleCropper()
                            ->directory('establishments')
                            ->columnSpanFull(),
                        FileUpload::make('gallery')
                            ->label('Fotos Adicionales (Galería)')
                            ->image()
                            ->multiple()
                            ->reorderable()
                            ->appendFiles()
                            ->directory('establishments/gallery')
                            ->columnSpanFull(),
                    ]),

                \Filament\Schemas\Components\Section::make('Horarios')
                    ->description('Define los horarios de apertura y cierre de tu establecimiento.')
                    ->schema([
                        \Filament\Forms\Components\Repeater::make('schedule')
                            ->label('Configurar Horarios')
                            ->schema([
                                \Filament\Forms\Components\Select::make('day')
                                    ->label('Día o Rango de Días')
                                    ->options([
                                        'Lunes' => 'Lunes',
                                        'Martes' => 'Martes',
                                        'Miércoles' => 'Miércoles',
                                        'Jueves' => 'Jueves',
                                        'Viernes' => 'Viernes',
                                        'Sábado' => 'Sábado',
                                        'Domingo' => 'Domingo',
                                        'Lunes a Viernes' => 'Lunes a Viernes',
                                        'Lunes a Sábado' => 'Lunes a Sábado',
                                        'Fines de Semana' => 'Fines de Semana',
                                        'Todos los días' => 'Todos los días',
                                    ])
                                    ->required(),
                                \Filament\Forms\Components\TimePicker::make('open')
                                    ->label('Apertura')
                                    ->required(),
                                \Filament\Forms\Components\TimePicker::make('close')
                                    ->label('Cierre')
                                    ->required(),
                            ])
                            ->columns(3)
                            ->defaultItems(1)
                            ->addActionLabel('Agregar otro horario')
                            ->columnSpanFull(),
                    ]),
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        $establishment = Auth::user()->establishment;

        if ($establishment) {
             $establishment->update($this->form->getState());
        } else {
            Auth::user()->establishment()->create($this->form->getState());
        }

        Notification::make()
            ->title('Perfil actualizado correctamente')
            ->success()
            ->send();
    }
}
