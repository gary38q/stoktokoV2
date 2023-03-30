<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Produk;
use App\Services\PembelianServices;

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
}
