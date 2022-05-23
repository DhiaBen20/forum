<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    public function subject()
    {
        return $this->morphTo()->morphWith([
            Thread::class => 'channel',
            Reply::class => 'thread.channel',
            Favorite::class => 'favorited'
        ]);
    }

    public static function feed($userId)
    {
        return Activity::where('user_id', $userId)
            ->with('subject')
            ->latest()
            ->get()
            ->groupBy(fn ($activity) => $activity->created_at->format('M d, Y'));
    }
}
