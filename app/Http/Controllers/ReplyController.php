<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Thread;

class ReplyController extends Controller
{
    public function store(Thread $thread)
    {
        request()->validate(['body' => 'required|min:3']);

        $thread->replies()->create([
            'body' => request('body'),
            'owner_id' => auth()->id()
        ]);

        return back()->with('flash', 'Your reply has been posted');
    }

    public function update(Reply $reply)
    {
        $this->authorize('update-reply', $reply);

        $reply->update(['body' => request('body')]);

        return back();
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update-reply', $reply);

        $reply->delete();

        return back()->with('flash', 'Your reply has been deleted');
    }
}
