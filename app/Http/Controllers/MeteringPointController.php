<?php

namespace App\Http\Controllers;

use App\Models\MeteringPoint;

class MeteringPointController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function index() {
        return view('meteringpoint');
    }
}
