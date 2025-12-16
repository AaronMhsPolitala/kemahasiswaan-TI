<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'no_wa',
        'role', // Tambahkan 'role' ke fillable
        'avatar',
        'google_id',
    ];

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
            'password' => 'string', // Pastikan password tidak di-hash otomatis
        ];
    }

    protected $appends = ['photo_url'];

    public function getPhotoUrlAttribute()
    {
        // If there's a locally stored avatar (not null and not an external URL)
        // We can assume local avatars will always be file names
        // If there's a local upload process, it will usually be stored as a string without 'http' or 'https'
        if ($this->avatar && !str_starts_with($this->avatar, 'http://') && !str_starts_with($this->avatar, 'https://')) {
            return asset('storage/' . $this->avatar);
        }

        // If there is no local avatar, or the existing avatar is from an external source (Google, etc.),
        // then use the default image
        return asset('assets/image/profil.png');
    }
}
