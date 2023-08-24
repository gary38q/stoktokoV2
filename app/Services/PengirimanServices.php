<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Pengiriman;
use App\Models\Produk;
use Auth;
use Illuminate\Http\Request;

class PengirimanServices
{
    public function index()
    {
        $pengiriman = Pengiriman::where('user_id','=',Auth::user()->id)->get();

        setmodulnav('pengiriman');
        return view('pages.menu_now.pengiriman',compact('pengiriman'));
    }

    public function create(Request $request){
        dd($request->all());
    }

}
