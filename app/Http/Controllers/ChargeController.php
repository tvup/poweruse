<?php

namespace App\Http\Controllers;


use Illuminate\View\View;

class ChargeController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->make();
    }

    public function index() : View {
        return view('charges')->with('data', session('data'));
    }
}
