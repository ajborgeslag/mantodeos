<?php


namespace App\Services;


use App\Models\Producto;

class ProductoService
{
    public function search($search)
    {
        try {
            /*--------------- Search Productos --------------------*/
            $limit = property_exists($search, 'limit') ? $search->limit : 20;
            $page = property_exists($search, 'page') && $search->page > 0 ? $search->page : 1;
            $skip = ($page - 1) * $limit;

            $productos = null;
            if(property_exists($search, 'search'))
                $productos = Producto::where('nombre', 'LIKE', '%' . $search->search . '%')->skip($skip)->take($limit)->get();
            else
                $productos = Producto::skip($skip)->take($limit)->get();

            return $productos;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function searchCat($search)
    {
        try {
            /*--------------- Search Productos --------------------*/
            $limit = property_exists($search, 'limit') ? $search->limit : 20;
            $page = property_exists($search, 'page') && $search->page > 0 ? $search->page : 1;
            $skip = ($page - 1) * $limit;

            $productos = null;
            if(property_exists($search, 'search'))
                $productos = Producto::where('nombre', 'LIKE', '%' . $search->search . '%')->where('id_categoria', $search->categoria)->skip($skip)->take($limit)->get();
            else
                $productos = Producto::skip($skip)->where('id_categoria', $search->categoria)->take($limit)->get();

            return $productos;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function popular()
    {
        try {
            return Producto::all()->where("popular", 1)->sortBy("popular");
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getProducto($id){
        return Producto::find($id);
    }

    public function getListProducts($idsList){
        try{
            $collection = Producto::find($idsList); // returns a collection of models
            return $collection;
        }catch (\Exception $e){
        }
        throw new \Exception(($e->getMessage()));
    }
}
