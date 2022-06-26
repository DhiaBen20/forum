<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Testing\Fluent\AssertableJson as Assert;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_notifications_is_prepared_when_a_subscribed_thread_receives_new_reply_that_is_not_created_by_us()
    {
        $this->signIn();

        $thread = $this->create(Thread::class);
        $thread->subscribe();

        $thread->addReply([
            'owner_id' => auth()->id(),
            'body' => 'this is reply body'
        ]);

        $this->assertCount(0, auth()->user()->notifications);

        $thread->addReply([
            'owner_id' => $this->create(User::class)->id,
            'body' => 'this is reply body'
        ]);

        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    /** @test */
    public function a_user_can_fetch_their_unread_notifications()
    {
        $this->signIn();

        $this->create(DatabaseNotification::class);

        $this->get("threads")->assertInertia(fn (Assert $page) => $page->has('notifications', 1));
    }

    /** @test */
    public function a_user_can_mark_a_notification_as_as_read()
    {
        $this->signIn();

        $notification = $this->create(DatabaseNotification::class);

        $userName = auth()->user()->name;
        $this->delete("profiles/{$userName}/notifications/{$notification->id}");

        $this->assertCount(0, auth()->user()->fresh()->unreadNotifications);
    }
}
