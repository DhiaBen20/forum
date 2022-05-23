<?php

namespace Tests\Unit;

use App\Models\Favorite;
use App\Models\Reply;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReplyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_an_owner()
    {
        $reply = Reply::factory()->create();

        $this->assertInstanceOf(User::class, $reply->owner);
    }

    /** @test */
    public function it_has_favorites()
    {
        $reply = Reply::factory()->create();

        $favorite = $this->create(Favorite::class, [
            'favorited_type' => Reply::class,
            'favorited_id' => $reply->id,
        ]);

        $this->assertTrue($reply->favorites->contains($favorite));
    }
}
