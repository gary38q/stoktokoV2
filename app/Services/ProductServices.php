<?php

namespace App\Services;

use App\Models\historybarang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductServices
{
    public function index(){

        $data_product = Produk::all();

        setmodulnav('produk');
        return view('pages.menu_now.product', compact('data_product'));

    }

    public function create(Request $request){

        $request->session()->put('modalid','CreateModalCenter'); 

        $validate = $request->validate([
            'nama_barang'   => 'required',
            'harga_barang'  => 'required'
        ]);

        $product = new Produk;
        $product->nama_produk = $validate['nama_barang'];
        $product->harga = $validate['harga_barang'];
        $product->save();
        
        return redirect('product')->with('success','Product Created Successfully');
    }

    public function edit(Request $request){

        $request->session()->put('modalid','CreateModalCenter'); 

        $validate = $request->validate([
            'nama_barang'   => 'required',
            'harga_barang'  => 'required',
            'cart_SKU'      => 'required'
        ]);


        Produk::where('produk_SKU','=',$validate['cart_SKU'])->update([
            'nama_produk' => $validate['nama_barang'],
            'harga'       => $validate['harga_barang']
        ]);


        return redirect('product')->with('success','Product Updated Successfully');
    }
    
    public function delete(Request $request)
    {
        Produk::where('produk_SKU','=',$request->id)->delete();

        Session::flash('success', 'Product Deleted Successfully');

        return response([
            'status' => true
        ]);
    }

    public function tambah_stock(Request $request){

        $request->session()->put('modalid','stockmodalcenter'); 

        $validate = $request->validate([
            'Jumlah'    => 'required','numeric','min_digits:1',
            'pengirim'  => 'required',
            'cart_SKUl' => 'required'
        ]);

        $produk_info = Produk::where('produk_SKU','=',$validate['cart_SKUl'])->first();

        $history_barang = new historybarang();
        $history_barang->SKU_produk     = $produk_info->produk_SKU;
        $history_barang->nama_produk    = $produk_info->nama_produk;
        $history_barang->Pengirim       = $validate['pengirim'];
        $history_barang->Jumlah         = $validate['Jumlah'];
        $history_barang->save();

        $updatejumlah = $produk_info->jumlah_stock + $validate['Jumlah'];

        Produk::where('produk_SKU','=',$validate['cart_SKUl'])->update([
            'jumlah_stock' => $updatejumlah
        ]);

        return redirect('product')->with('success','Stock Added Successfully');
    }
}
