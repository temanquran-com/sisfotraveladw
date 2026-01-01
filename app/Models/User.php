<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Filament\Panel;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
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

    protected $guard_name = 'web'; // penting


    // protected static function booted(): void
    // {
    //     static::created(function (User $user) {
    //         if (! $user->roles()->exists()) {
    //             $user->assignRole('customer');
    //         }
    //     });
    // }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // RELATIONS
    public function bookingsCreated()
    {
        return $this->hasMany(Booking::class, 'created_by');
    }

    public function paymentsVerified()
    {
        return $this->hasMany(Payment::class, 'verified_by');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    // HELPERS
    public function isAdmin()
    {
        return $this->role === 'administrator';
    }

    public function isStaff()
    {
        return $this->role === 'staff';
    }

    public function isCustomer()
    {
        return $this->role === 'customer';
    }

    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id', 'role_id');
    // }

    // protected static function booted(): void
    // {
    //     static::creating(function (User $user) {
    //         $user->role = 'customer';
    //     });
    // }


    /**
     * Determine if the user can access the given panel.
     *
     * @param \Filament\Panel $panel
     *
     * @return bool
     */
    // public function canAccessPanel(Panel $panel): bool
    // {
    //     $role = auth()->user()->role->name;

    //     return match ($panel->getId()) {
    //         'administrator' => $role === 'administrator',
    //         'staff'         => $role === 'staff',
    //         'customer'      => $role === 'customer',
    //         default         => false,
    //     };
    // }

    public function canAccessPanel(Panel $panel): bool
    {
        return match ($panel->getId()) {
            'administrator' => $this->hasRole('administrator'),
            'staff' => $this->hasRole('staff'),
            'customer' => $this->hasRole('customer'),
            default => false,
        };
    }

    // protected static function booted(): void
    // {
    //     static::created(function (User $user) {
    //         if (! $user->roles()->exists()) {
    //             $user->assignRole('customer');
    //         }
    //     });
    // }

}
