<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        return Inertia::render('Profiles/Show', [
            'profile' => $user,
            'activities' => Activity::feed($user->id),
        ]);
    }
}
