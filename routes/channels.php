<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('chat.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('group.{id}', function ($user, $id) {
    return \DB::table('group_user')
        ->where('group_id', $id)
        ->where('user_id', $user->id)
        ->exists();
});