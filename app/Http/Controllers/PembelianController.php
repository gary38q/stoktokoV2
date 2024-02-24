<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Produk;
use App\Services\PembelianServices;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    public PembelianServices $pembelianservice;

    public function __construct(
        PembelianServices $pembelianservice
    ) {

        $this->pembelianservice = $pembelianservice;
    }

    public function index()
    {
        return $this->pembelianservice->index();
    }

    public function transaction(Request $request)
    {
        return $this->pembelianservice->transaction($request,1);
    }

    public function transaction_no_print(Request $request)
    {
        return $this->pembelianservice->transaction($request,0);        
    }
}
