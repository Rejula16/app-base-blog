<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Ynotz\AccessControl\Traits\WithRoles;
use Modules\Ynotz\MediaManager\Traits\OwnsMedia;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, WithRoles, OwnsMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getMediaStorage(): array
    {
        return [
            'profile_picture' => $this->storageLocation(
                disk: 'local',
                folder: 'public/images/profile_pictures'
            ),
        ];
    }

      public function articles()
    {
        return $this->hasMany(Article::class);
    }

}
