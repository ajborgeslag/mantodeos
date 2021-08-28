<?php


namespace App\Services;


use App\Models\Categoria;

class CategoriaService
{
    public function list()
    {
        try {
            return Categoria::all()->where("activo", 1)->sortBy("popular");
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function popular()
    {
        try {
            return Categoria::all()->where("activo", 1)->where("popular", 1)->sortBy("popular");
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
