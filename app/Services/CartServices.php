<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Produk;
use Illuminate\Http\Request;

class CartServices
{
    public function AddToCart(Request $request){
        
        $checkcart = Cart::where('cart_SKU','=',$request->cart_SKU)->first();
        $checkproduct = Produk::where('produk_SKU','=',$request->cart_SKU)->first();

        if(!empty($checkcart)){


            $totalqty = $checkcart->Jumlah + $request->Jumlah;

            if($totalqty > $checkproduct->jumlah_stock){
                return redirect()->back()->with('error','Jumlah barang melebihi stok yang ada');
            }
            else{
                    Cart::where('cart_SKU','=',$request->cart_SKU)->update([
                    'Jumlah' => $totalqty
                ]);
            }
        }
        else{ 
            
            if($request->Jumlah > $checkproduct->jumlah_stock){
                return redirect()->back()->with('error','Jumlah barang melebihi stok yang ada');
            }
            else{
                Cart::create($request->all());
            }
        }

        return redirect()->back()->with('success','Berhasil ditambahkan');

    }

    public function DeleteCart(Request $request){

        try {
            Cart::where('cart_SKU','=',$request->id)->delete();
            return redirect()->back()->with('success','Produk terhapus!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error','Produk tidak dapat dihapus!');
        }

    }
}
