<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Produk;
use Illuminate\Http\Request;

class PembelianServices
{
    public function index(){
        $product = Produk::all();
        $cart = Cart::join('produks','carts.cart_SKU','=','produks.produk_SKU')->get();

        setmodulnav('pembelian');
        return view('pages.menu_now.pembelian',compact('product','cart'));
    }
}
