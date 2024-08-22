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

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    } 
}
