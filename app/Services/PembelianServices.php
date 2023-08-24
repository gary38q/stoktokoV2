<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\history;
use App\Models\historyid;
use App\Models\Produk;
use Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class PembelianServices
{
    public function index()
    {
        $product = Produk::all();
        $cart = Cart::join('produks','carts.cart_SKU','=','produks.produk_SKU')
        ->where('carts.user_id',Auth::user()->id)
        ->get();

        setmodulnav('pembelian');
        return view('pages.menu_now.pembelian',compact('product','cart'));
    }

    public function transaction(Request $request)
    {
        $cart = Cart::where('user_id',Auth::user()->id)->get();
        $dt = Carbon::now();
        $this->print_receipt($cart,$request->total_qty,$request->total_harga);

        //Create History
        $history = historyid::create([
            'id'            => $dt->format('YmdHis').rand(100,999),
            'user_id'       => Auth::user()->id,
            'total_qty'     => $request->total_qty,
            'total_harga'   => $request->total_harga
        ]);
        

        foreach($cart as $cart)
        {
            $product = Produk::where('produk_SKU',$cart->cart_SKU)->first();

            $qtyakhir = $product->jumlah_stock - $cart->Jumlah;

            history::create([
                'user_id'       => Auth::user()->id,
                'history_id'    => $history->id,
                'nama_produk'   => $product->nama_produk,
                'jumlah'        => $cart->Jumlah,
                'harga'         => ($cart->Jumlah * $product->harga)
            ]);
            
            //Update Stock
            Produk::where('produk_SKU',$cart->cart_SKU)
            ->update([
                'jumlah_stock' => $qtyakhir
            ]);

            Cart::where('id',$cart->id)->delete();
        }

        if($request->kirim == 1){
            return redirect()->route('create_pengiriman',$request->all());
        }

        return 1;
    }

    public function print_receipt($barang,$total_qty,$total_harga){
        try {
            // Enter the share name for your USB printer here
            // $connector = null;
            $connector = new WindowsPrintConnector("Receipt Printer");
        
            /* Print a "Hello world" receipt" */
            $printer = new Printer($connector);
            $printer -> text("Hello World!\n");
            $printer -> cut();
            
            /* Close printer */
            $printer -> close();
        } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
        }
    }
}
