<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Profile;
use Illuminate\Console\Scheduling\Schedule;
use Spatie\Permission\Traits\HasRoles;
use NotificationChannels\WebPush\HasPushSubscriptions;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasPushSubscriptions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'document',
        'phone',
        'password'
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
    ];


    public function profile(){

        return $this->has_one(Profile::class, "profile", "id"); 

    }

    public function schedules(){

        return $this->has_many(Schedule::class, "user", "id"); 

    }

    public static function boot()
    {

        parent::boot();

        
        self::created(function($model){
            




        });


        self::updated(function($model){



        });



    }

    // public function roles()
    // {

    //     return $this->belongsToMany(Role::class);

    // }

    // public function permissions()
    // {
    //     return $this->belongsToMany(Permission::class);
    // }
}
