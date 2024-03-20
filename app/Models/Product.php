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

            // ! CORRIGIR FORMATAÇÃO DE NÚMEROS 

            $model->price = floatval($model->price);

            if(!$model->discount){
                $model->discount = 0;

            }

        });

    }
}
