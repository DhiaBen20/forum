<?php

namespace App\Http\Controllers;

use App\Models\Thread;

class ThreadSubscriptionController extends Controller
{
    public function store(Thread $thread)
    {
        $thread->subscribe(auth()->id());

        return back();
    }

    public function destroy(Thread $thread)
    {
        $thread->unsubscribe();

        return back();
    }
}
