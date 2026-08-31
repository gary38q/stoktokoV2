<?php

namespace App\Http\Controllers;

use App\Services\ConvertServices;
use App\Services\ProductServices;
use Illuminate\Http\Request;

class ConvertController extends Controller
{
    public ConvertServices $convertService;
    public ProductServices $productServices;

    public function __construct(
        ConvertServices $convertService,
        ProductServices $productServices
    ) {

        $this->convertService = $convertService;
        $this->productServices = $productServices;
    }

    public function index()
    {
        $convert = $this->convertService->Convert();
        $product = $this->productServices->all();

        setmodulnav('convert');
        return view('pages.menu_now.convert', compact('convert','product'));
    }

    public function create(Request $request)
    {
        return $this->convertService->create($request);
    }

    public function edit(Request $request)
    {
        return $this->convertService->edit($request);
    }

    public function delete(Request $request)
    {
        return $this->convertService->delete($request);
    }

    public function tambah_stock(Request $request)
    {
        return $this->convertService->tambah_stock($request);
    }
}
