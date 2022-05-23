<?php

namespace Tests\Unit;

use App\Models\Channel;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChannelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_channel_has_a_threads()
    {
        $channel = $this->create(Channel::class);
        $thread = $this->create(Thread::class, ['channel_id' => $channel]);

        $this->assertTrue($channel->threads->contains($thread));
    }
}
