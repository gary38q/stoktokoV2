<?php

namespace App\Http\Controllers;

use App\Models\Pengiriman;
use App\Http\Requests\StorePengirimanRequest;
use App\Http\Requests\UpdatePengirimanRequest;
use App\Services\PengirimanServices;
use Illuminate\Http\Request;

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

    public function create(Request $request){
        return $this->pengirimanservice->create($request);
    }
}
