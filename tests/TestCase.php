<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function create($className, $overrides = [], $nb = null)
    {
        return $className::factory($nb)->create($overrides);
    }

    public function signIn($user = null)
    {
        $user = $user ?? $this->create(User::class);

        $this->be($user);

        return $user;
    }
}
