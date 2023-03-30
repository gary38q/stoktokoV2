<?php

namespace App\Services;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartServices
{
    public function AddToCart(Request $request){
        
        $checkcart = Cart::where('cart_SKU','=',$request->cart_SKU)->first();

        if(!empty($checkcart)){

            $totalqty = $checkcart->Jumlah + $request->Jumlah;

            Cart::where('cart_SKU','=',$request->cart_SKU)->update([
                'Jumlah' => $totalqty
            ]);
        }
        else{
            Cart::create($request->all());
        }

        return redirect()->back();

    }
}
