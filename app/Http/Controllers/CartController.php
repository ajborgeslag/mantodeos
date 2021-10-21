<?php

namespace App\Http\Controllers;

use App\Http\Requests\Producto\ProductCartUpdateRequest;
use App\Http\Requests\Producto\ProductRequest;
use App\Services\ProductoService;
use App\Utils\UtilFunctions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Cart;

class CartController extends Controller
{
    public $productoService;
    public function __construct()
    {
        $this->productoService = new ProductoService();
    }
    public function cartList()
    {
        try{
            $cartItems = session()->get('cart');
            $data = $cartItems;
            return response(["success"=>!!$data, "data" => $data, "message" => trans('messages.success')], JsonResponse::HTTP_CREATED);
        }
        catch (\Exception $e) {
            return response(["success"=>false, "message" => trans('messages.internal_server_error')], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function addToCart(ProductRequest $request)
    {
        try{
            $idProducto = $request->id;
            $product = $this->productoService->getProducto($idProducto);
//            $userID = 2; // the user ID to bind the cart contents

            if(!$product) {
                return response(["success"=>false, "message" => trans('messages.product_not_exist')], JsonResponse::HTTP_NOT_FOUND);
            }

            $cart = session()->get('cart');
           // return response(["success"=>false, "message" => $cart, JsonResponse::HTTP_NOT_FOUND]);
            if(!$cart) {// if cart is empty then this is the first product
                $orderId = UtilFunctions::getRandomString(); // generate a unique() row ID
                $cart = [
                    'orderId' => $orderId,
                    $idProducto => [
                        "name" => $product->nombre,
                        "quantity" => 1,
                        "product" => $product,
                    ]
                ];
                session()->put('cart', $cart);
                return response(["success"=>!!$cart, "data" => $cart, "message" => trans('messages.product_added_to_cart')], JsonResponse::HTTP_OK);
            }
            // if cart not empty then check if this product exist then increment quantity
            if(isset($cart[$idProducto])) {
                $cart[$idProducto]['quantity']++;
                session()->put('cart', $cart);
                return response(["success"=>!!$cart, "data" => $cart, "message" => trans('messages.product_added_to_cart')], JsonResponse::HTTP_OK);
            }
            // if item not exist in cart then add to cart with quantity = 1
            $cart[$idProducto] = [
                "name" => $product->nombre,
                "quantity" => 1,
                "product" => $product,
//                "price" => $product->price,
//                "photo" => $product->photo
            ];
            session()->put('cart', $cart);
            return response(["success"=>!!$cart, "data" => $cart, "message" => trans('messages.product_added_to_cart')], JsonResponse::HTTP_OK);
        }
        catch (\Exception $e) {
            return response(["success"=>false,"error"=>$e->getMessage(), "message" => trans('messages.internal_server_error')], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function emptyCart(Request $request){
        try {
            session()->forget('cart');
            return response(["success" => true, "data"=> null , "message" => trans('messages.success')], JsonResponse::HTTP_OK);
        }
        catch (\Exception $e) {
            return response(["success"=>false, "message" => trans('messages.internal_server_error')], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateCart(ProductCartUpdateRequest $request)
    {
        try{
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            return response(["success" => true, "data"=> $cart[$request->id] , "message" => trans('messages.product_updated_in_cart')], JsonResponse::HTTP_OK);
        }
        catch (\Exception $e) {
            return response(["success"=>false, "message" => trans('messages.internal_server_error')], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function removeProduct(ProductRequest $request)
    {
        try{
            if($request->id) {
                $cart = session()->get('cart');
                if(isset($cart[$request->id])) {
                    unset($cart[$request->id]);
                    session()->put('cart', $cart);
                    return response(["success" => true, "data"=> $cart , "message" => trans('messages.product_deleted_from_cart')], JsonResponse::HTTP_OK);
                }
                return response(["success" => true, "data"=> $cart , "message" => trans('messages.product_not_exist_in_cart')], JsonResponse::HTTP_NOT_FOUND);
            }
        }
        catch (\Exception $e) {
            return response(["success"=>false, "message" => trans('messages.internal_server_error')], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

}
