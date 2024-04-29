<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Laravel\Passport\ClientRepository;

class ApiAccessController extends Controller
{
    public function create(Request $request, ClientRepository $clients): \Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
    {
        $user = auth()->user();
        $user->api_access_token = auth()->user()->createToken('Laravel Password Grant Client')->accessToken;
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'api-token-created');
    }
}
