<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class CspReportController extends Controller
{
    public function report(): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|Response
    {
        logger()->info(request()->getContent());
        return response('ok', 201);
    }
}
