<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $guarded = [];

    public function scopeName($builder, $name)
    {
        return $builder->where('name', $name);
    }

    public function scopeCode($builder, $name)
    {
        return $builder->where('code', $name);
    }
}
