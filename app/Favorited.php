<?php

namespace App;

use App\Models\Favorite;

trait Favorited
{
    protected static function bootFavorited()
    {
        static::deleting(function ($model) {
            $model->Favorites->each->delete();
        });
    }

    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];

        if (!$this->favorites()->where($attributes)->exists()) {
            $this->favorites()->create($attributes);
        }
    }

    public function unfavorite()
    {
        $attributes = ['user_id' => auth()->id()];
        // $this->favorites()->delete();
        $this->favorites()->where($attributes)->first()->delete();
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function getIsFavoritedAttribute()
    {
        return !!$this->Favorites()->where('user_id', auth()->id())->count();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->Favorites()->count();
    }
}
