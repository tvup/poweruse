<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

class ServiceWorkerController extends Controller
{
    public function index() {
        return response(File::get('/build/sw.js'))
            ->header('Service-Worker-Allowed', '/')
            ->header('Content-Type', 'application/javascript');
    }
}
