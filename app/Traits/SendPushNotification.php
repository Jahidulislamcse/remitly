<?php

namespace App\Traits;

use App\Notifications\PushNotification;
use App\Models\User;

trait SendPushNotification
{

    public function sendPush(string $title, string $body, $users = null) 
    {
        if (!$users) {
            $users = User::where('role', 'super admin')->get();
        }

        if (is_numeric($users)) {
            $users = User::find($users);
        }

        if (!is_array($users) && !$users instanceof \Illuminate\Support\Collection) {
            $users = [$users];
        }

        foreach ($users as $user) {
            if ($user) {
                $user->notify(new PushNotification($title, $body));
            }
        }
    }
}