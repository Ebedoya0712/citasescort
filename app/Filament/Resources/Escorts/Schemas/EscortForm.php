<?php

namespace App\Filament\Resources\Escorts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;

class EscortForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                \Filament\Forms\Components\Placeholder::make('profile_photo_view')
                    ->label('Foto de Perfil')
                    ->content(function ($record) {
                        if (!$record || !$record->profile_photo) {
                            return 'Sin foto';
                        }
                        $url = asset('storage/' . $record->profile_photo);
                        return new \Illuminate\Support\HtmlString("
                            <a href='{$url}' target='_blank' title='Clic para ver más grande' style='display: inline-block; transition: transform 0.2s;' onmouseover=\"this.style.transform='scale(1.05)'\" onmouseout=\"this.style.transform='scale(1)'\">
                                <img src='{$url}' style='width: 120px; height: 120px; border-radius: 50%; object-fit: cover; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);' alt='Foto de perfil' />
                            </a>
                        ");
                    })
                    ->columnSpanFull(),
                TextInput::make('age')
                    ->label('Edad')
                    ->numeric(),
                Select::make('gender')
                    ->label('Género')
                    ->options([
                        'female' => 'Femenino',
                        'male' => 'Masculino',
                        'trans' => 'Trans',
                    ]),
                Select::make('city')
                    ->label('Ubicación (Ciudad)')
                    ->searchable()
                    ->options(\App\Models\City::getDepartments()),

                \Filament\Schemas\Components\Section::make('Verificación de Identidad')
                    ->columnSpanFull()
                    ->schema([
                        Select::make('verification_status')
                            ->label('Estado de Verificación')
                            ->options([
                                'unverified' => 'No verificado',
                                'pending' => 'Pendiente de Revisión',
                                'approved' => 'Aprobado',
                                'rejected' => 'Rechazado',
                            ])
                            ->default('unverified')
                            ->required()
                            ->columnSpanFull(),
                        
                        FileUpload::make('id_front')
                            ->label('Frente del Documento')
                            ->image()
                            ->directory('escort-verifications')
                            ->downloadable()
                            ->openable()
                            ->disabled()
                            ->columnSpan(1),

                        FileUpload::make('id_back')
                            ->label('Dorso del Documento')
                            ->image()
                            ->directory('escort-verifications')
                            ->downloadable()
                            ->openable()
                            ->disabled()
                            ->columnSpan(1),

                        FileUpload::make('verification_video')
                            ->label('Video de Verificación')
                            ->directory('escort-verifications')
                            ->downloadable()
                            ->openable()
                            ->disabled()
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }
}
