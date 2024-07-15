<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Traits\HasRoles;
use NotificationChannels\WebPush\HasPushSubscriptions; //import the trait
class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasPushSubscriptions;


    protected $fillable = [
        "name",
        "phone",
        "email",
        "password",
        "cpf",
        "user_id"
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    public static function boot()
    {
        parent::boot();


        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }
}
