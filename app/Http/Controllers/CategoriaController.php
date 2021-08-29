<?php

namespace App\Http\Controllers;

use App\Services\CategoriaService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CategoriaController extends Controller
{
    public $categoriaService;
    public function __construct()
    {
        $this->categoriaService = new CategoriaService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data = $this->categoriaService->list();
            return response(["success"=>!!$data, "data" => $data, "message" => trans('messages.success')], JsonResponse::HTTP_CREATED);
        }
        catch (\Exception $e) {
            return response(["success"=>false, "message" => trans('messages.internal_server_error')], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function popular()
    {
        try{
            $data = $this->categoriaService->popular();
            return response(["success"=>!!$data, "data" => $data, "message" => trans('messages.success')], JsonResponse::HTTP_CREATED);
        }
        catch (\Exception $e) {
            return response(["success"=>false, "message" => trans('messages.internal_server_error')], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
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
        //
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
}
