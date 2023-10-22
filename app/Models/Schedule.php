<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'product_id',
        'customer_id',
        'company_id',
    ];

    public function products(){

        return $this->hasMany(Product::class, 'id','product_id');

    }
}
