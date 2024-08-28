<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'schedule',
        'products',
        'total_price',
        'payment_method'

    ];

    public function schedule(){
        return $this->belongsTo(Schedule::class, 'schedule');
    }

}
