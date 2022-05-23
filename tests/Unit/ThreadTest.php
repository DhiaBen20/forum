<?php

namespace Tests\Unit;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use App\Models\Channel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_thread_has_a_replies()
    {
        $thread = Thread::factory()->create();
        $reply = Reply::factory()->create(['thread_id' => $thread]);

        $replies = $thread->replies()->without('owner')->get();

        $this->assertCount(1, $replies);
        $this->assertEquals($reply->toArray(), $replies->first()->toArray());
    }

    /** @test */
    public function a_thread_has_an_author()
    {
        $thread = Thread::factory()->create();

        $this->assertInstanceOf(User::class, $thread->author);
    }

    /** @test */
    public function a_thread_has_a_channel()
    {
        $thread = $this->create(Thread::class);

        $this->assertInstanceOf(Channel::class, $thread->channel);
    }

    /** @test */
    public function it_can_be_subscribed_to()
    {
        $thread = $this->create(Thread::class);
        $user = $this->create(User::class);

        $thread->subscribe($user->id);

        $this->assertCount(1, $thread->subscriptions()->where('user_id', $user->id)->get());
    }

    /** @test */
    public function it_can_be_unsubscribed_to()
    {
        $thread = $this->create(Thread::class);
        $user = $this->create(User::class);
        $anotherUser = $this->create(User::class);


        $thread->subscribe($user->id);
        $thread->subscribe($anotherUser->id);

        $this->assertCount(2, $thread->subscriptions);

        $thread->unsubscribe($user->id);

        $this->assertCount(
            0,
            $thread->subscriptions()->where('user_id', auth()->id())->get()
        );
    }
}
