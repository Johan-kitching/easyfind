<?php

namespace App\Http\Livewire\Profile;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserProfileController extends Controller
{
    /**
     * Show the user profile screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function show(Request $request, User $user)
    {
        return view('profile.show', [
            'request' => $request,
            'user' => $user,
        ]);
    }
}
