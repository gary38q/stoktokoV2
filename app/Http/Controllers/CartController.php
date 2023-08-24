<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Services\CartServices;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public CartServices $cartservice;

    public function __construct(
        CartServices $cartservice
    ) {

        $this->cartservice = $cartservice;
    }
    
    public function AddToCart(Request $request){
        return $this->cartservice->AddToCart($request);
    }

    public function DeleteCart(Request $request){
        return $this->cartservice->DeleteCart($request);
    }

    public function DeleteAllCart(Request $request){
        return $this->cartservice->DeleteAllCart($request);
    }
}
