<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StockController extends Controller
{
    function index(){
        
        return view('stocks.index');
    }

    function stockCountKenya(){

        return view('stocks.kenya');
    }

    function stockCountTanzania(){

        return view('stocks.tanzania');
    }

    function stockCountUganda(){

        return view('stocks.uganda');
    }
}
