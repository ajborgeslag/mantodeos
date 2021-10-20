<?php

namespace App\Http\Controllers;

use App\Http\Requests\Producto\SearchCatRequest;
use App\Services\ProductoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\SearchRequest;

class ProductoController extends Controller
{
    public $productoService;
    public function __construct()
    {
        $this->productoService = new ProductoService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $data = $this->productoService->getProducto($id);
            if($data)
                return response(["success"=>!!$data, "data" => $data, "message" => trans('messages.success')], JsonResponse::HTTP_OK);
            else return response(["success"=>!!$data, "data" => $data, "message" => trans('messages.entity_not_found')], JsonResponse::HTTP_NOT_FOUND);
        }
        catch (\Exception $e) {
            return response(["success"=>false, "message" => trans('messages.internal_server_error')], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function search(SearchRequest $searchRequest)
    {
        try{
            $data = $this->productoService->search(json_decode($searchRequest->getContent()));
            return response(["success"=>!!$data, "data" => $data, "message" => trans('messages.success')], JsonResponse::HTTP_CREATED);
        }
        catch (\Exception $e) {
            return response(["success"=>false, "message" => trans('messages.internal_server_error')], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function searchCategoria(SearchCatRequest $searchRequest)
    {
        try{
            $data = $this->productoService->searchCat(json_decode($searchRequest->getContent()));
            return response(["success"=>!!$data, "data" => $data, "message" => trans('messages.success')], JsonResponse::HTTP_CREATED);
        }
        catch (\Exception $e) {
            return response(["success"=>false, "message" => trans('messages.internal_server_error')], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function popular()
    {
        try{
            $data = $this->productoService->popular();
            return response(["success"=>!!$data, "data" => $data, "message" => trans('messages.success')], JsonResponse::HTTP_CREATED);
        }
        catch (\Exception $e) {
            return response(["success"=>false, "message" => trans('messages.internal_server_error')], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function listByIds(Request $request)
    {
        try{
            $idlists = json_decode($request->getContent());
            $data = $this->productoService->getListProducts($idlists);
            return response(["success"=>!!$data, "data" => $data, "message" => trans('messages.success')], JsonResponse::HTTP_OK);
        }
        catch (\Exception $e) {
            return response(["success"=>false, "message" => trans('messages.internal_server_error')], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
