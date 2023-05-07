<?php

namespace App\Services;

use App\Models\history;
use App\Models\historybarang;
use App\Models\historyid;
use App\Models\Produk;
use Illuminate\Http\Request;

use function GuzzleHttp\Promise\all;

class HistoryServices
{
    public function index(){

        $data_history           = historyid::orderBy('created_at','desc')->get();
        $data_history_barang    = historybarang::orderBy('created_at','desc')->get();

        setmodulnav('history');
        return view('pages.menu_now.history', compact('data_history','data_history_barang'));

    }
}
