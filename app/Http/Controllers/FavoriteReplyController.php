<?php

namespace App\Http\Controllers;

use App\Models\Reply;

class FavoriteReplyController extends Controller
{
    public function store(Reply $reply)
    {
        $reply->favorite();

        return back();
    }

    public function destroy(Reply $reply)
    {
        $reply->unfavorite();

        return back();
    }
}
