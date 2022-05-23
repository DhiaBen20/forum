<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageThreadsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guests_users_cannot_create_threads()
    {
        $this->get('threads/create')->assertRedirect('login');
        $this->post('threads')->assertRedirect('login');
    }

    /** @test */
    public function only_authenticated_users_can_create_threads()
    {
        $this->signIn();

        $channel = $this->create(Channel::class);

        $attributes = [
            'title' => $this->faker->sentence(),
            'body' => $this->faker->paragraph(),
            'channel_id' => $channel->id
        ];

        $this->post('threads', $attributes);

        $this->assertDatabaseHas('threads', $attributes);
    }

    /** @test */
    public function a_thread_title_is_required()
    {
        $this->signIn();

        $this->post('threads')->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_body_is_required()
    {
        $this->signIn();

        $this->post('threads')->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_a_valid_channel()
    {
        $this->signIn();

        $this->post('threads')->assertSessionHasErrors('channel_id');
        $this->post('threads', ['channel_id' => 1])->assertSessionHasErrors('channel_id');
    }

    /** @test */
    public function unauthenticated_users_cannot_delete_threads()
    {

        $thread = $this->create(Thread::class);

        $this->delete("threads/{$thread->channel->slug}/$thread->id")->assertRedirect('login');

        $this->signIn();

        $this->delete("threads/{$thread->channel->slug}/$thread->id")->assertStatus(403);
    }

    /** @test */
    public function only_authenticated_users_can_delete_threads()
    {
        $this->signIn();

        $thread = $this->create(Thread::class, ['author_id' => auth()->id()]);
        $reply = $this->create(Reply::class, ['thread_id' => $thread]);

        $this->delete("threads/{$thread->channel->slug}/{$thread->id}");

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertDatabaseMissing('activities', ['subject_id' => $thread->id, 'type' => 'created_thread']);
        $this->assertDatabaseMissing('activities', ['subject_id' => $reply->id, 'type' => 'created_reply']);
    }
}
