<?php

namespace App\Http\Controllers;

use App\Services\ProductServices;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public ProductServices $productservice;

    public function __construct(
        ProductServices $productservice
    ) {

        $this->productservice = $productservice;
    }

    public function index()
    {
        return $this->productservice->index();
    }

    public function create(Request $request)
    {
        return $this->productservice->create($request);
    }

    public function edit(Request $request)
    {
        return $this->productservice->edit($request);
    }

    public function delete(Request $request)
    {
        return $this->productservice->delete($request);
    }

    public function tambah_stock(Request $request)
    {
        return $this->productservice->tambah_stock($request);
    }
}
