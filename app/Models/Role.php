<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Role extends \Spatie\Permission\Models\Role
{
    public function scopeWithoutSuperAdmin(Builder $builder)
    {
        return $builder->where('name', '!=', 'superadmin');
    }

    public function scopeWithoutAdmin(Builder $builder)
    {
        return $builder->where('name', '!=', 'administrator');
    }
}
