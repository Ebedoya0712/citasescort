<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements JWTSubject, FilamentUser, HasAvatar
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'role' => $this->role,
        ];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function escort()
    {
        return $this->hasOne(Escort::class);
    }

    public function establishment()
    {
        return $this->hasOne(Establishment::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isEstablishment(): bool
    {
        return $this->role === 'establishment';
    }

    public function isEscort(): bool
    {
        return $this->role === 'escort';
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return $this->role === 'admin';
        }

        if ($panel->getId() === 'escort') {
            return $this->role === 'escort';
        }

        if ($panel->getId() === 'establishment') {
            return $this->role === 'establishment';
        }

        return false;
    }

    public function getFilamentAvatarUrl(): ?string
    {
        if ($this->isEscort() && $this->escort && $this->escort->profile_photo) {
            return Storage::url($this->escort->profile_photo);
        }

        if ($this->isEstablishment() && $this->establishment && $this->establishment->cover_image) {
            return Storage::url($this->establishment->cover_image);
        }

        return null;
    }

    public function favorites()
    {
        return $this->belongsToMany(Escort::class, 'favorites', 'user_id', 'escort_id')->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Send the password reset notification with Citasescort branding.
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new \App\Notifications\ResetPasswordNotification($token));
    }
}

