<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'permission_id',
        'label',
        'icon',
        'position'
    ];

    public function permission()
    {
        return $this->belongsTo(\Spatie\Permission\Models\Permission::class);
    }
}
