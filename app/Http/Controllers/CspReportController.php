<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class CspReportController extends Controller
{
    public function report(): int
    {
        logger()->info(request()->getContent());
        return response()->status(204);
    }
}
