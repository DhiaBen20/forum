<?php

namespace App\Http\Controllers;

use App\Filters\ThreadFilters;
use App\Http\Requests\StoreThreadRequest;
use App\Models\Channel;
use App\Models\Thread;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class ThreadController extends Controller
{
    public function index(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::filter($filters)
            ->latest()
            ->with('channel')
            ->withCount('replies');

        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }

        return Inertia::render('Threads/Index', ['threads' => $threads->latest()->get()]);
    }

    public function show(Channel $channel, Thread $thread)
    {
        return Inertia::render('Threads/Show', [
            'thread' => $thread->load('author'),
            'channel' => $channel,
            'can' => [
                'delete_thread' => Gate::check('delete-thread', $thread),
            ],
            'replies' => $thread->replies()
                ->paginate(10)
                ->through(fn ($reply) => [
                    'id' => $reply->id,
                    'owner' => $reply->owner,
                    'created_id' => $reply->created_id,
                    'body' => $reply->body,
                    'favorites' => $reply->favorites,
                    'favoritesCount' => $reply->favoritesCount,
                    'canUpdateReply' => Gate::check('update-reply', $reply),
                    'isFavorited' => $reply->isFavorited,
                ])
        ]);
    }

    public function create()
    {
        return Inertia::render('Threads/Create');
    }

    public function store(StoreThreadRequest $request)
    {
        $thread = Thread::create([
            'title' => $request->title,
            'body' => $request->body,
            'channel_id' => $request->channel_id,
            'author_id' => auth()->id()
        ]);

        return redirect("threads/{$thread->channel->slug}/$thread->id")
            ->with('flash', 'Your thread has been published!');
    }

    public function destroy(Channel $channel, Thread $thread)
    {
        Gate::authorize('update-thread', $thread);

        $thread->delete();

        return redirect('/');
    }
}
