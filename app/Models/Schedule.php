<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'customer_id',
        'user_id',
        'notify',
        'start',
        'locale',
        'end',
        'confirmation',
        'status', // 1 - pendding, 2 - running, 3 - finished, 4 - canceled
        'products',
        'notification_submitted'
    ];

    // protected static function boot()
    // {
    //     parent::boot();
    //     User::saving(function ($model) {
    //         if(!User::where("role","=", "admin")->exists())
    //         {
    //             $model->role = 'admin';
    //         } 

    //     });
    // }
    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    } 

    public function transaction(){
        return $this->asOne(Transaction::class, 'id', 'shchedule');

    }
}
