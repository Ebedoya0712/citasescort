<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Models\Payment;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;
use App\Models\Post;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionInvoice;
use Illuminate\Support\Str;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-currency-dollar';

    protected static string | \UnitEnum | null $navigationGroup = 'Finanzas';
    protected static ?string $navigationLabel = 'Pagos y Transacciones';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\Select::make('plan_id')
                    ->relationship('plan', 'name')
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pendiente',
                        'approved' => 'Aprobado',
                        'failed' => 'Fallido',
                        'refunded' => 'Reembolsado',
                    ])
                    ->required(),
                Forms\Components\Select::make('gateway')
                    ->options([
                        'manual' => 'Manual / Transferencia',
                        'yape' => 'Yape',
                        'stripe' => 'Stripe',
                        'paypal' => 'PayPal',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('transaction_id')
                    ->label('ID Transacción'),
                Forms\Components\FileUpload::make('receipt_image')
                    ->label('Comprobante de Pago')
                    ->image()
                    ->directory('payments/receipts')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuario')
                    ->searchable(),
                Tables\Columns\TextColumn::make('plan.name')
                    ->label('Plan'),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->prefix('$')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'approved' => 'success',
                        'completed' => 'success',
                        'pending' => 'warning',
                        'failed' => 'danger',
                        'refunded' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('gateway')
                    ->label('Pasarela'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('receipt_image')
                    ->label('Comprobante'),
            ])
            ->actions([
                \Filament\Actions\Action::make('approve')
                    ->label('Aprobar')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Payment $record): bool => $record->status === 'pending' && in_array($record->gateway, ['yape', 'manual']))
                    ->action(function (Payment $record) {
                        $record->update(['status' => 'approved']);
                        
                        // Update user's escort plan if user is an escort
                        if ($record->user && $record->user->escort && $record->plan) {
                            $expiresAt = now()->addDays($record->plan->duration_days);
                            $record->user->escort->update([
                                'level' => strtolower($record->plan->name),
                                'plan_id' => $record->plan_id,
                                'plan_expires_at' => $expiresAt,
                            ]);
                            
                            // Send Invoice Email
                            Mail::to($record->user->email)->send(new SubscriptionInvoice($record, $record->plan, $record->user->escort, $expiresAt->format('d/m/Y')));
                            
                            // Create News Post
                            $photo = null;
                            if (!empty($record->user->escort->photos) && is_array($record->user->escort->photos)) {
                                $photo = $record->user->escort->photos[0];
                            } elseif ($record->user->escort->profile_photo) {
                                $photo = $record->user->escort->profile_photo;
                            }
                            
                            Post::create([
                                'user_id' => $record->user_id,
                                'title' => $record->user->escort->name . ' - Escort Destacada',
                                'slug' => Str::slug($record->user->escort->name . '-' . uniqid()),
                                'content' => '<p>¡Destacamos a <strong>' . $record->user->escort->name . '</strong>! No te pierdas su increíble perfil y descubre todos los servicios que tiene para ofrecer.</p>',
                                'image' => $photo,
                                'is_published' => true,
                                'published_at' => now(),
                            ]);
                        }
                    }),
                \Filament\Actions\ViewAction::make(),
                \Filament\Actions\EditAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
