<?php

namespace App\Models;

use App\Notifications\ThreadWasUpdated;
use App\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory, RecordsActivity;

    protected $appends = ['isSubscribedTo'];

    function scopeFilter($query, $filters)
    {
        $filters->apply($query);
    }

    protected static function booted()
    {
        static::deleting(function ($thread) {
            Activity::whereHasMorph(
                'subject',
                Reply::class,
                fn ($query) => $query->whereBelongsTo($thread)
            )
                ->delete();

            $thread->replies()->delete();
        });
    }

    public function replies()
    {
        return $this->hasMany(Reply::class)
            ->with('owner');
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?? auth()->id()
        ]);
    }

    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
            ->where('user_id', $userId ?? auth()->id())
            ->delete();
    }

    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    public function getIsSubscribedToAttribute()
    {
        return !!$this->subscriptions()->where('user_id', auth()->id())->count();
    }

    public function addReply($attributes)
    {
        $reply = $this->replies()->create($attributes);

        $this->subscriptions()
            ->where('user_id', '!=', $reply->owner_id)
            ->with('user')
            ->get()
            ->each
            ->notify($this, $reply);

        return $reply;
    }

    public function visits()
    {
        return $this->hasMany(ThreadVisit::class);
    }
}
