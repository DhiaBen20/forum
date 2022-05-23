<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guest_users_cannot_participate_in_threads()
    {
        $this->post("threads/1/replies")->assertRedirect('login');
    }

    /** @test */
    public function an_athenticated_user_can_participate_in_forum_threads()
    {
        $thread = $this->create(Thread::class);

        $this->signIn();

        $body = $this->faker->paragraph();
        $this->post("threads/{$thread->id}/replies", ['body' => $body]);

        $this->assertDatabaseHas('replies', ['body' => $body]);
    }

    /** @test */
    public function a_reply_requires_a_body()
    {
        $thread = $this->create(Thread::class);

        $this->signIn();

        $this->post("threads/{$thread->id}/replies")->assertSessionHasErrors('body');
    }

    /** @test */
    public function unauthorized_users_cannot_delete_replies()
    {
        $this->create(Reply::class);

        $this->delete('replies/1')->assertRedirect('login');

        $this->signIn();

        $this->delete('replies/1')->assertStatus(403);
    }

    /** @test */
    public function authorized_users_can_delete_replies()
    {
        $this->signIn();

        $reply = $this->create(Reply::class, ['owner_id' => auth()->id()]);

        $this->delete('replies/1');

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    /** @test */
    public function unauthorized_user_can_update_replies()
    {
        $this->create(Reply::class);
        
        $this->patch('replies/1')->assertRedirect('login');
        
        $this->signIn();
        
        $this->patch('replies/1')->assertStatus(403);
    }
    
    /** @test */
    public function authorized_user_can_update_replies()
    {
        $this->signIn();

        $reply = $this->create(Reply::class, ['owner_id' => auth()->id()]);

        $this->patch('replies/1', ['body' => 'Reply updated']);

        $this->assertEquals('Reply updated', $reply->fresh()->body);
    }
}
