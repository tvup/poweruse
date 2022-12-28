<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class TotalPricesController extends Controller
{


    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return View
     */
    public function __invoke(Request $request) : View
    {
        $data = session('data');
        $chart = session('chart');
        $companies = Operator::$operatorName;

        return view('totalprices')->with('data', $data ? : null)->with('chart', $chart ? : null)->with('companies', $companies);
    }
}
