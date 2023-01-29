<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class WebManifestController extends Controller
{
    public function manifest(): Response {
        return response(File::get(public_path('manifest.webmanifest')))
            ->header('Content-Type', 'application/json');
    }
}
