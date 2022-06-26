<?php

namespace Database\Factories;

use App\Models\User;
use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Notifications\DatabaseNotification;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class DatabaseNotificationFactory extends Factory
{
    protected $model = DatabaseNotification::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid(),
            'type' => ThreadWasUpdated::class,
            'notifiable_type' => User::class,
            'notifiable_id' => auth()->id() ?? User::factory(),
            'data' => [],
        ];
    }
}
