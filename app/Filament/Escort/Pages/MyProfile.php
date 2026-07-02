<?php

namespace App\Filament\Escort\Pages;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Forms;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\View;

class MyProfile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string | \UnitEnum | null $navigationGroup = 'Mi Cuenta';
    protected static ?string $navigationLabel = 'Configurar mi perfil';

    protected string $view = 'filament.escort.pages.my-profile';
    
    protected static ?string $title = 'Configurar mi perfil';

    public ?array $data = [];

    public function mount(): void
    {
        $user = Auth::user();
        $escort = $user->escort;
        
        $data = $escort ? $escort->toArray() : [];
        $data['email'] = $user->email;

        $this->form->fill($data);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Configuración de Cuenta')
                    ->schema([
                        View::make('filament.escort.components.profile-photo-css'),

                        Group::make()
                            ->schema([
                                Forms\Components\FileUpload::make('profile_photo')
                                    ->hiddenLabel()
                                    ->avatar()
                                    ->imageEditor()
                                    ->directory('escort-avatars')
                                    ->imagePreviewHeight('250')
                                    ->extraAttributes([
                                        'class' => 'profile-photo-centered',
                                        'style' => 'width: 250px; height: 250px;'
                                    ]),
                            ])
                            ->columnSpanFull()
                            ->extraAttributes(['class' => 'flex justify-center items-center w-full']),

                        Forms\Components\TextInput::make('name')
                            ->label('Nombre Artístico')
                            ->required(),

                        \Filament\Schemas\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('age')
                                    ->label('Edad')
                                    ->numeric(),
                                Forms\Components\Select::make('city')
                                    ->label('Ubicación / Departamento')
                                    ->searchable()
                                    ->options([
                                        'Amazonas' => 'Amazonas',
                                        'Ancash' => 'Ancash',
                                        'Apurímac' => 'Apurímac',
                                        'Arequipa' => 'Arequipa',
                                        'Ayacucho' => 'Ayacucho',
                                        'Cajamarca' => 'Cajamarca',
                                        'Callao' => 'Callao',
                                        'Cusco' => 'Cusco',
                                        'Huancavelica' => 'Huancavelica',
                                        'Huánuco' => 'Huánuco',
                                        'Ica' => 'Ica',
                                        'Junín' => 'Junín',
                                        'La Libertad' => 'La Libertad',
                                        'Lambayeque' => 'Lambayeque',
                                        'Lima' => 'Lima',
                                        'Loreto' => 'Loreto',
                                        'Madre de Dios' => 'Madre de Dios',
                                        'Moquegua' => 'Moquegua',
                                        'Pasco' => 'Pasco',
                                        'Piura' => 'Piura',
                                        'Puno' => 'Puno',
                                        'San Martín' => 'San Martín',
                                        'Tacna' => 'Tacna',
                                        'Tumbes' => 'Tumbes',
                                        'Ucayali' => 'Ucayali',
                                    ]),
                            ]),

                        Forms\Components\TextInput::make('email')
                            ->label('Correo Electrónico')
                            ->email()
                            ->disabled()
                            ->dehydrated(false),

                        Forms\Components\TextInput::make('password')
                            ->label('Nueva Contraseña (Opcional)')
                            ->password()
                            ->confirmed()
                            ->dehydrated(fn ($state) => filled($state)),
                            
                        Forms\Components\TextInput::make('password_confirmation')
                            ->label('Confirmar Contraseña')
                            ->password()
                            ->dehydrated(false),
                    ])->columns(1),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $user = Auth::user();

        // Update User Account
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        if ($user->isDirty()) {
            $user->save();
        }
        
        // Update Escort Profile
        $escort = $user->escort()->firstOrCreate([
            'user_id' => $user->id
        ]);
        
        $escort->update([
            'name' => $data['name'] ?? null,
            'gender' => 'Mujer',
            'age' => $data['age'] ?? null,
            'city' => $data['city'] ?? null,
            'profile_photo' => $data['profile_photo'] ?? $escort->profile_photo,
        ]);
        
        Notification::make()
            ->success()
            ->title('Perfil actualizado correctamente')
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('deleteAccount')
                ->label('Eliminar Mi Cuenta')
                ->color('danger')
                ->icon('heroicon-o-trash')
                ->requiresConfirmation()
                ->modalHeading('¿Eliminar tu cuenta?')
                ->modalDescription('Esta acción es irreversible. Se eliminarán permanentemente tu cuenta, perfil de escort, publicaciones, fotos e historias.')
                ->modalSubmitActionLabel('Sí, eliminar mi cuenta')
                ->form([
                    Forms\Components\TextInput::make('current_password')
                        ->label('Confirmá tu contraseña actual')
                        ->password()
                        ->required(),
                ])
                ->action(function (array $data) {
                    $user = Auth::user();

                    if (!Hash::check($data['current_password'], $user->password)) {
                        Notification::make()
                            ->danger()
                            ->title('Contraseña incorrecta')
                            ->body('La contraseña ingresada no es correcta.')
                            ->send();
                        return;
                    }

                    // Log out and delete
                    Auth::logout();
                    $user->delete();

                    session()->invalidate();
                    session()->regenerateToken();

                    redirect('/');
                }),
        ];
    }
}
