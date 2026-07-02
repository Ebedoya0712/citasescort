<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\Users\Pages\CreateUser;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                TextInput::make('password')
                    ->password()
                    ->required(fn ($livewire) => $livewire instanceof CreateUser)
                    ->visible(fn ($livewire) => $livewire instanceof CreateUser)
                    ->maxLength(255)
                    ->dehydrated(fn ($state) => filled($state)),
                Select::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'escort' => 'Escort',
                        'user' => 'User',
                        'casa de masajes' => 'Casa de Masajes',
                    ])
                    ->required(),
            ]);
    }
}
