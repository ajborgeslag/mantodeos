<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Categoria extends Model
{
    public function scopeActive($query)
    {
        return $query->where('activo', 1);
    }

    protected $fillable = [
        'nombre',
        'descripcion',
        'imagen'
    ];

    protected $hidden = [
        'activo',
        'deleted_at',
        'created_at',
        'updated_at'
    ];
}
