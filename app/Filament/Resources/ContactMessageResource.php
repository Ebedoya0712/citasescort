<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Models\ContactMessage;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-inbox';
    protected static string | \UnitEnum | null $navigationGroup = 'Mensajes y Reportes';
    protected static ?string $navigationLabel = 'Bandeja de Entrada';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nombre'),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('subject')
                    ->maxLength(255)
                    ->label('Asunto'),
                Forms\Components\Textarea::make('message')
                    ->required()
                    ->columnSpanFull()
                    ->label('Mensaje'),
                Forms\Components\Toggle::make('is_read')
                    ->label('LeÃ­do')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Nombre'),
                Tables\Columns\TextColumn::make('subject')
                    ->searchable()
                    ->label('Asunto'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_read')
                    ->boolean()
                    ->label('LeÃ­do'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Fecha'),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                \Filament\Actions\ViewAction::make()
                    ->label('Ver')
                    ->modalHeading('Mensaje de Contacto'),
                \Filament\Actions\Action::make('responder')
                    ->label('Responder')
                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                    ->color('success')
                    ->modalHeading(fn ($record) => "Responder a {$record->name}")
                    ->modalDescription(fn ($record) => "Escribe tu respuesta a continuaciÃ³n. Se enviarÃ¡ un correo electrÃ³nico a {$record->email}.")
                    ->form([
                        Forms\Components\Textarea::make('respuesta')
                            ->label('Tu Respuesta')
                            ->placeholder('Escribe aquÃ­ el mensaje que le llegarÃ¡ por correo...')
                            ->rows(5)
                            ->required(),
                    ])
                    ->action(function ($record, array $data): void {
                        try {
                            // Marcar como leÃ­do
                            $record->update(['is_read' => true]);

                            // Enviar correo (usando Mail::raw para simplicidad)
                            \Illuminate\Support\Facades\Mail::raw($data['respuesta'], function ($message) use ($record) {
                                $message->to($record->email)
                                    ->subject('Respuesta a tu contacto en Citasescort - ' . $record->subject);
                            });

                            \Filament\Notifications\Notification::make()
                                ->title('Respuesta enviada')
                                ->body('El mensaje ha sido enviado por correo y el estado marcado como leÃ­do.')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            \Filament\Notifications\Notification::make()
                                ->title('Error al enviar')
                                ->body('No se pudo enviar el correo: ' . $e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
                \Filament\Actions\DeleteAction::make()
                    ->label('Borrar'),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactMessages::route('/'),
        ];
    }
}

