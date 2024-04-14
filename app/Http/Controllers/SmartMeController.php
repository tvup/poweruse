<?php

namespace App\Http\Controllers;

use App\Http\Requests\SmartMeUpdateRequest;
use Illuminate\Support\Facades\Redirect;

class SmartMeController extends Controller
{
    /**
     * Update the user's smartme information.
     *
     * @param  SmartMeUpdateRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SmartMeUpdateRequest $request)
    {
        $user = $request->user();
        $user->smartme_username = $request->username;
        $user->smartme_password = $request->password;
        $user->smartme_directory_id = $request->directory_id;

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'smartme-updated');
    }
}
