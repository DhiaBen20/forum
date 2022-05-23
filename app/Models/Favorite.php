<?php

namespace App\Models;

use App\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory, RecordsActivity;

    public function favorited()
    {
        return $this->morphTo()->morphWith([
            Thread::class => 'channel',
            Reply::class => 'thread.channel',
        ]);
    }
}
