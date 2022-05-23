<?php

namespace Tests\Unit;

use App\Models\Activity;
use App\Models\Reply;
use App\Models\Thread;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_records_activity_when_a_thread_is_create()
    {
        $this->signIn();

        $thread = $this->create(Thread::class, ['author_id' => auth()->id()]);

        $this->assertDatabaseHas('activities', [
            'subject_id' => $thread->id,
            'subject_type' => Thread::class,
            'type' => 'created_thread',
            'user_id' => auth()->id()
        ]);
    }

    /** @test */
    public function it_records_activity_when_a_reply_is_create()
    {
        $this->signIn();

        $thread = $this->create(Thread::class, ['author_id' => auth()->id()]);

        $reply = $this->create(Reply::class, ['thread_id' => $thread->id, 'owner_id' => auth()->id()]);

        $this->assertDatabaseHas('activities', [
            'subject_id' => $reply->id,
            'subject_type' => Reply::class,
            'type' => 'created_reply',
            'user_id' => auth()->id()
        ]);
    }

    /** @test */
    public function it_fetches_activity_feed_for_any_user()
    {
        $this->signIn();

        $userId = auth()->id();

        $this->create(Thread::class, ['author_id' => $userId]);
        $this->create(Thread::class, ['author_id' => $userId, 'created_at' => Carbon::now()->subWeek()]);

        auth()->user()->activity()->first()->update(['created_at' => Carbon::now()->subWeek()]);

        $feed = Activity::feed($userId);

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('M d, Y')
        ));

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->subWeek()->format('M d, Y')
        ));
    }
}
