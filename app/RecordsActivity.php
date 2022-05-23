<?php

namespace App;

use App\Models\Activity;

trait RecordsActivity
{
    protected static function bootRecordsActivity()
    {
        static::created(function ($model) {
            // for test purposes only
            if (auth()->guest()) {
                return;
            }

            $model->recordActivity();
        });

        static::deleting(function ($model) {
            $model->activities()->delete();
        });
    }

    protected function recordActivity()
    {
        $arr = explode('\\', __CLASS__);

        $this->activities()->create([
            'type' => 'created_' . strtolower(end($arr)),
            'user_id' => auth()->id()
        ]);
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'subject');
    }
}
