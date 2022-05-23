<?php

namespace Tests\Feature;

use App\Models\Reply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_favorite_anything()
    {
        $this->post("replies/1/favorites")->assertRedirect('login');
    }

    /** @test */
    public function an_authenticated_user_can_favorite_any_reply()
    {
        $this->signIn();

        $reply = $this->create(Reply::class);

        $this->post("replies/{$reply->id}/favorites");

        $this->assertDatabaseCount('favorites', 1);
    }

    /** @test */
    public function an_authenticated_user_can_unfavorite_any_reply()
    {
        $this->signIn();

        $reply = $this->create(Reply::class);

        $this->post("replies/{$reply->id}/favorites");
        $this->delete("replies/{$reply->id}/favorites");

        $this->assertDatabaseCount('favorites', 0);
    }


    /** @test */
    public function an_authenticated_user_may_only_favorite_a_reply_once()
    {
        $this->signIn();

        $reply = $this->create(Reply::class);

        $this->post("replies/{$reply->id}/favorites");
        $this->post("replies/{$reply->id}/favorites");

        $this->assertDatabaseCount('favorites', 1);
    }
}
