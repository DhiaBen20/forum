<?php

namespace Tests\Feature;

use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscribeToThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unauthenticated_users_cannot_subscribe_to_thread()
    {
        $this->post("threads/1/subscriptions")->assertRedirect('login');
    }

    /** @test */
    public function an_authenticated_user_can_subscribe_to_a_thread()
    {
        $this->signIn();

        $thread = $this->create(Thread::class);

        $this->post("threads/{$thread->id}/subscriptions");

        $this->assertCount(1, $thread->subscriptions);
    }

    /** @test */
    public function an_authenticated_user_can_unsubscribe_from_a_thread()
    {
        $this->signIn();

        $thread = $this->create(Thread::class);

        $this->post("threads/{$thread->id}/subscriptions");
        $this->assertCount(1, $thread->subscriptions);

        $this->delete("threads/{$thread->id}/subscriptions");
        $this->assertCount(0, $thread->fresh()->subscriptions);
    }
}
