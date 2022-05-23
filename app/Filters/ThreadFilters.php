<?php

namespace App\Filters;

use App\Models\User;

class ThreadFilters extends Filters
{
    protected $filters = ['by', 'popularity', 'unanswered'];

    protected function by($value)
    {
        $user = User::where('name', $value)->firstOrFail();

        $this->query->whereBelongsTo($user, 'author');
    }

    protected function popularity()
    {
        // $this->query->getQuery()->orders = null;

        $this->query->orderBy('replies_count', 'desc');
    }

    protected function unanswered() {
        $this->query->having('replies_count', 0);
    }
}
