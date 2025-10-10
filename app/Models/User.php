<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{

    use HasFactory, Notifiable,  HasRoles {
        // Alias the original trait methods
        HasRoles::hasRole as traitHasRole;
        HasRoles::hasAnyRole as traitHasAnyRole;
    }

    protected static function booted()
    {
        static::created(function ($user) {
            $user->profile()->create([
                'user_id' => $user->id
            ]);
        });
    }
    

    public function hasRole($roles, $guard = null): bool
    {
        if ($this->traitHasRole('super_admin')) {
            return true;
        }

        return $this->traitHasRole($roles, $guard);
    }

    public function hasAnyRole($roles, $guard = null): bool
    {
        if ($this->traitHasRole('super_admin')) {
            return true;
        }

        return $this->traitHasAnyRole($roles, $guard);
    }

    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
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

    public function isSuperAdmin(): bool{
        return $this->hasRole('super_admin');
    }

    public function profile(){
        return $this->hasOne(Profile::class);
    }
}
