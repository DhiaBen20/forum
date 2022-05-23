<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_browse_threads()
    {
        $thread = Thread::factory()->create();

        $this->get('threads')
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Threads/Index')
                    ->has(
                        'threads',
                        fn (Assert $page) => $page
                            ->where('0.title', $thread->title)
                            ->where('0.body', $thread->body)
                    )
            );
    }

    /** @test */
    public function a_user_can_see_a_single_thread()
    {
        $thread = Thread::factory()->create();

        $this->get("threads/{$thread->channel->slug}/{$thread->id}")->assertInertia(
            fn (Assert $page) => $page
                ->component('Threads/Show')
                ->where('thread.title', $thread->title)
                ->where('thread.body', $thread->body)
        );
    }

    /** @test */
    public function a_user_can_see_the_associated_replies_with_a_thread()
    {
        $thread = Thread::factory()->create();
        $reply = Reply::factory()->create(['thread_id' => $thread]);

        $this->get("threads/{$thread->channel->slug}/{$thread->id}")->assertInertia(
            fn (Assert $page) => $page
                ->where('replies.data.0.body', $reply->body)
        );
    }

    /** @test */
    public function a_user_can_filter_threads_by_a_channel()
    {
        $channel = $this->create(Channel::class);
        $thread = $this->create(Thread::class, ['channel_id' => $channel]);

        $this->create(Thread::class);

        $this->get("threads/{$channel->slug}/")->assertInertia(
            fn (Assert $page) => $page
                ->has('threads', 1)
                ->where('threads.0.title', $thread->title)
                ->where('threads.0.body', $thread->body)
        );
    }

    /** @test */
    public function a_user_can_filter_threads_by_any_username()
    {
        $thread = $this->create(Thread::class);
        $this->create(Thread::class);

        $this->get("threads?by={$thread->author->name}")
            ->assertInertia(
                fn (Assert $page) => $page
                    ->has('threads', 1)
                    ->where('threads.0.title', $thread->title)
                    ->where('threads.0.body', $thread->body)
            );
    }

    /** @test */
    public function a_user_can_filter_threads_by_popularity()
    {
        $threadWithThreeReplies = $this->create(Thread::class);
        $this->create(Reply::class, ['thread_id' => $threadWithThreeReplies], 3);

        $threadWithNoReplies = $this->create(Thread::class);

        $threadWithTwoReplies = $this->create(Thread::class);
        $this->create(Reply::class, ['thread_id' => $threadWithTwoReplies], 2);

        $this->get('threads?popularity=1')->assertInertia(
            fn (Assert $page) => $page
                ->where('threads.0.title', $threadWithThreeReplies->title)
                ->where('threads.1.title', $threadWithTwoReplies->title)
                ->where('threads.2.title', $threadWithNoReplies->title)
        );
    }

    /** @test */
    public function a_user_can_filter_threads_by_those_that_are_unanswered()
    {
        $threadWithoutReply = $this->create(Thread::class);

        $this->create(Reply::class);

        // $this->get('threads?unanswered=1')->assertInertia(
        //     fn (Assert $page) => $page->has(
        //         'threads',
        //         1,
        //         fn (Assert $page) => $page->where('title', $threadWithoutReply->title)
        //     )
        // );
    }
}
