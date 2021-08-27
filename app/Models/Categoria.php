<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Categoria extends Model
{
    public function scopeActive($query)
    {
        return $query->where('activo', 1);
    }
}
