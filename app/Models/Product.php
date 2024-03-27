<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "description",
        "price",
        "discount"
    ];

    public static function boot(){

        parent::boot();

        self::creating(function($model){

            $price = str_replace('.', '', $model->price);
            $price = str_replace(',', '.', $price);
            
            $price = (float) $price;

            $model->price = $price;

            if(!$model->discount){
                $model->discount = 0;

            }

        });

    }
}
