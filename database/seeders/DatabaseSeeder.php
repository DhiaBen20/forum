<?php

namespace Database\Seeders;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $thread = Thread::factory()->create();
        Reply::factory(5)->create(['thread_id' => $thread->id]);

        User::factory()->create([
            'email' => 'dhia.eddine97@gmail.com',
            'name' => 'Dhia Bendjedia',
            'password' => Hash::make('aze-123456')
        ]);
    }
}
