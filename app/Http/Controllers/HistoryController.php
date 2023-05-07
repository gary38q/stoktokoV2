<?php

namespace App\Http\Controllers;

use App\Services\HistoryServices;

class HistoryController extends Controller
{
    public HistoryServices $historyservice;

    public function __construct(
        HistoryServices $historyservice
    ) {

        $this->historyservice = $historyservice;
    }

    public function index()
    {
        return $this->historyservice->index();
    }
}
