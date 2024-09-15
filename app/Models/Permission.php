<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    public function attributes()
    {
        return $this->hasOne(PermissionAttribute::class, 'permission_id', 'id');
    }
}
