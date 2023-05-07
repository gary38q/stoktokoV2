<?php

namespace App\Http\Controllers;

use App\Models\Pengiriman;
use App\Http\Requests\StorePengirimanRequest;
use App\Http\Requests\UpdatePengirimanRequest;
use App\Services\PengirimanServices;

class PengirimanController extends Controller
{
    public PengirimanServices $pengirimanservice;

    public function __construct(
        PengirimanServices $pengirimanservice
    ) {

        $this->pengirimanservice = $pengirimanservice;
    }

    public function index()
    {
        return $this->pengirimanservice->index();
    }
}
