<?php

namespace App\Models;

use App\Favorited;
use App\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory, Favorited, RecordsActivity;

    protected $appends = ['isFavorited', 'favoritesCount'];

    protected $touches = ['thread'];

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }
}
