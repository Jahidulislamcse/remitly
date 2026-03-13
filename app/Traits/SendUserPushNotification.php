<?php

namespace App\Traits;

use App\Models\User;
use App\Notifications\PushNotification;
use Illuminate\Support\Collection;

trait SendUserPushNotification
{
    public function dispatchUserPush(string $title, string $body, $users)
    {
        if (is_numeric($users)) {
            $users = User::find($users);
        }

        if ($users instanceof User) {
            $users = collect([$users]);
        }

        foreach ($users as $user) {
            if ($user) {
                $user->notify(new PushNotification($title, $body));
            }
        }
    }
}