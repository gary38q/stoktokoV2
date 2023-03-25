<?php

namespace App\Http\Controllers;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        setmodulnav('pembelian');
        return view('pages.menu_now.pembelian');
    }
}
