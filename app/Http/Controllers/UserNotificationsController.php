<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserNotificationsController extends Controller
{
    public function destroy(User $user, $notificationId)
    {
        $user->unreadNotifications()
            ->find($notificationId)
            ->markAsRead();

        return back();
    }
}
