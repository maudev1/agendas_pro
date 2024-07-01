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
        'products'
    ];

}
