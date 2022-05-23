<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_has_a_profile()
    {
        $this->withoutExceptionHandling();

        $user = $this->create(User::class);

        $this->get("profiles/{$user->name}")
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Profiles/Show')
                    ->has(
                        'profile',
                        fn (Assert $page) => $page
                            ->where('name', $user->name)
                            ->etc()
                    )
            );
    }
}
