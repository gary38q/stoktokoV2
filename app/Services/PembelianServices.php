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
use Mike42\Escpos\CapabilityProfile;
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

    public function transaction(Request $request,$print)
    {
        $cart = Cart::where('user_id',Auth::user()->id)->get();
        $dt = Carbon::now();

        //Create History
        $history = historyid::create([
            'id'            => $dt->format('YmdHis').rand(100,999),
            'user_id'       => Auth::user()->id,
            'total_qty'     => $request->total_qty,
            'total_harga'   => $request->total_harga
        ]);

        if($print == 1)
        {
            $this->print_receipt($cart, $history->id);
        }
        

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

    public function print_receipt($cart, $transactionID){
        try {
            // Enter the share name for your USB printer here
            // $connector = null;
            $profile = CapabilityProfile::load('simple');
            $connector = new WindowsPrintConnector("printer_struk");
        
            /* Print a "Hello world" receipt" */
            $printer = new Printer($connector,$profile);
            // $printer -> initialize();
            $this -> header($printer,$transactionID);

            $total = 0;
            foreach($cart as $barang)
            {
                $printer -> setTextSize(1, 1);

                $product = Produk::where('produk_SKU',$barang->cart_SKU)->first();
                $total = $total + $product->harga*$barang->Jumlah;

                $printer -> text($product->nama_produk."\n");

                $qty = str_split($barang->Jumlah, 8);
                foreach ($qty as $k => $l) {
                    $l = trim($l);
                    $qty[$k] = $this->addSpaces($l, 8);
                }

                $satuan = str_split($product->satuan_barang, 5);
                foreach ($satuan as $k => $l) {
                    $l = trim($l);
                    $satuan[$k] = $this->addEndSpaces($l, 6);
                }

                $xprice = str_split("X ".number_format( $product->harga, 0,',','.'), 15);
                foreach ($xprice as $k => $l) {
                    $l = trim($l);
                    $xprice[$k] = $this->addEndSpaces($l, 17);
                }

                $total_price = str_split(number_format( $product->harga*$barang->Jumlah, 0,',','.'), 15);
                foreach ($total_price as $k => $l) {
                    $l = trim($l);
                    $total_price[$k] = $this->addEndSpaces($l, 17);
                }
                
                $counter = 0;
                $temp = [];
                $temp[] = count($qty);
                $temp[] = count($satuan);
                $temp[] = count($xprice);
                $temp[] = count($total_price);
                $counter = max($temp);

                for ($i = 0; $i < $counter; $i++) {
                    $line = '';
                    if (isset($qty[$i])) {
                        $line .= ($qty[$i]);
                    }
                    if (isset($satuan[$i])) {
                        $line .= ($satuan[$i]);
                    }
                    if (isset($xprice[$i])) {
                        $line .= ($xprice[$i]);
                    }
                    if (isset($total_price[$i])) {
                        $line .= ($total_price[$i]);
                    }
                    $printer->text($line . "\n\n");
                }

                // $printer -> setJustification(Printer::JUSTIFY_LEFT);
                // $printer -> text(number_format( $product->harga, 0,',','.') ." X ". $barang->Jumlah."\n");

                // $printer -> setJustification(Printer::JUSTIFY_RIGHT);
                // $printer -> text(number_format( $product->harga*$barang->Jumlah, 0,',','.')."\n");
                
                $printer -> setJustification();
            }
            $printer->textRaw(str_repeat(chr(196), 48).PHP_EOL); 

            $this -> total($printer,$total);
            
            /* Close printer */
            $printer -> close();
        } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
        }

    }

    public function header(Printer $printer, $transactionID)
    {
        $dt = Carbon::now();
        
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> setTextSize(2, 2);
        $printer -> text("TB EDEN JAYA\n");
        $printer -> setTextSize(1, 1);
        $printer -> text("Jalan Pejuangan Raya No 14 D\n");
        $printer -> text("Kebon Jeruk, Jakarta Barat\n");
        $printer -> text("Telp: 021-5326391\n");
        $printer->setPrintLeftMargin(0);
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer -> text("\n");
        $printer -> text("ID     : ".$transactionID."\n");   
        $printer -> text("Tanggal: ".$dt->format('d-m-Y')."\n\n");
        $printer->textRaw(str_repeat(chr(196), 48).PHP_EOL); 
        $printer -> text("\n");
        $printer -> setJustification();// Reset
    }

    public function total(Printer $printer , $total)
    {
        // $printer -> text("\n");
        $qty = str_split('Total', 8);
        foreach ($qty as $k => $l) {
            $l = trim($l);
            $qty[$k] = $this->addSpaces($l, 8);
        }

        $xprice = str_split("=", 18);
        foreach ($xprice as $k => $l) {
            $l = trim($l);
            $xprice[$k] = $this->addEndSpaces($l, 20);
        }

        $total_price = str_split(number_format( $total, 0,',','.'), 18);
        foreach ($total_price as $k => $l) {
            $l = trim($l);
            $total_price[$k] = $this->addEndSpaces($l, 20);
        }
        
        $counter = 0;
        $temp = [];
        $temp[] = count($qty);
        $temp[] = count($xprice);
        $temp[] = count($total_price);
        $counter = max($temp);

        for ($i = 0; $i < $counter; $i++) {
            $line = '';
            if (isset($qty[$i])) {
                $line .= ($qty[$i]);
            }
            if (isset($xprice[$i])) {
                $line .= ($xprice[$i]);
            }
            if (isset($total_price[$i])) {
                $line .= ($total_price[$i]);
            }
            $printer->text($line . "\n\n");
        }
        // $printer -> setJustification(Printer::JUSTIFY_RIGHT);
        // $printer -> text('Total = '.number_format( $total, 0,',','.')."\n");
        // $printer -> text("\n"); 

        $printer -> setTextSize(1, 1);
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> text("TERIMA KASIH\n");
        $printer -> text("BARANG YANG SUDAH DI BELI TIDAK DAPAT DITUKAR\n");
        $printer -> text("ATAU DIKEMBALIKAN\n");
        $printer -> cut();
    }

    public function addSpaces($string = '', $valid_string_length = 0) {
        if (strlen($string) < $valid_string_length) {
            $spaces = $valid_string_length - strlen($string);
            for ($index1 = 1; $index1 <= $spaces; $index1++) {
                $string = $string . ' ';
            }
        }
    
        return $string;
    }

    public function addEndSpaces($string = '', $valid_string_length = 0)
    {        
        if (strlen($string) < $valid_string_length) {
            $spaces = $valid_string_length - strlen($string);
            for ($index1 = 1; $index1 <= $spaces; $index1++) {
                $string = ' '. $string;
            }
        }
    
        return $string;
    }
    
}
