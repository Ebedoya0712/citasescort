<?php

namespace App\Filament\Pages;

use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class MyProfile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | \UnitEnum | null $navigationGroup = 'Configuración';
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'Mi Perfil';
    protected static ?string $title = 'Mi Perfil';
    protected string $view = 'filament.pages.my-profile';

    public ?array $data = [];

    public function mount(): void
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $this->form->fill([
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Información Personal')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre Completo')
                            ->required(),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(table: 'users', ignorable: fn () => auth()->user()),
                    ])->columns(2),
                
                Section::make('Cambia tu contraseña si es necesario (opcional)')
                    ->description('Dejar en blanco para mantener la actual')
                    ->schema([
                        TextInput::make('new_password')
                            ->label('Nueva Contraseña')
                            ->password()
                            ->confirmed()
                            ->rule(Password::default())
                            ->autocomplete('new-password')
                            ->revealable(),
                        TextInput::make('new_password_confirmation')
                            ->label('Confirmar Nueva Contraseña')
                            ->password()
                            ->revealable(),
                    ])->columns(2),
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        $this->validate(); // Validates the form state

        $data = $this->form->getState();
        $user = auth()->user();

        // Check if email is unique manually if the unique rule above is tricky in Page context without a record
        // But usually unique(ignorable: ...) works if passed correctly
        
        $user->name = $data['name'];
        $user->email = $data['email'];

        if (!empty($data['new_password'])) {
            $user->password = Hash::make($data['new_password']);
        }

        $user->save();

        Notification::make()
            ->success()
            ->title('Perfil actualizado correctamente')
            ->send();
        
        // Reset password fields
        $this->form->fill([
            'name' => $user->name,
            'email' => $user->email,
            'new_password' => '',
            'new_password_confirmation' => '',
        ]);
    }
}
