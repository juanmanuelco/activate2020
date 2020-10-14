<?php

use Illuminate\Support\Facades\Broadcast;
use Spatie\Permission\Models\Role;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('user_channel.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('role_channel.{id}', function ($user, $id) {
    try {
        $role = Role::findById($id)->name;
        return $user->hasRole($role);
    }catch (\Throwable $e){
        return false;
    }

});
