<?php

use App\Events\NotificationRole;
use App\Events\NotificationUser;
use Spatie\Permission\Models\Role;
use App\Models\User;


/**
 * @param string $type
 * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|int
 */
function getNotifications($type = ""){
    $roles = \Illuminate\Support\Facades\Auth::user()->getRoleNames();
    $roles = \Spatie\Permission\Models\Role::query()->whereIn('name', $roles)->pluck('id');
    $receivers = \App\Models\NotificationReceiver::query()->where(function ($q) use ($roles){
        $q->where('type', 'role');
        $q->whereIn('receiver', $roles);
    })->orWhere(function ($q) {
        $q->where('type', 'user');
        $q->where('receiver', Illuminate\Support\Facades\Auth::user()->id);
    })->distinct('notification')->pluck('notification');

    $notifications =  \App\Models\Notification::query()->whereIn('notifications.id', $receivers);
    $readed  = \App\Models\NotificationReaded::whereIn('notification', $receivers)->where('reader', Illuminate\Support\Facades\Auth::user()->id)->pluck('notification');
    if($type == 'readed'){
        $notifications = $notifications->whereNotIn('notifications.id', $readed)->count();
    }else{
        $notifications = $notifications->whereNotIn('notifications.id', $readed)->orderBy('id', 'desc')->limit(50)->get();
        foreach ($notifications as $notification){
            $notification->{'created'} = $notification->created_at . "  ";
        }
    }

    return $notifications;
}

function setReceiver($destinies, $repository, $notification){
    foreach ($destinies as $destiny ){
        $create_dest =  $repository->create($destiny);
        if($destiny['type'] == 'role'){
            $role = Role::findById($destiny['receiver']);
            event(new NotificationRole($role, $notification));
        }else{
            $user = User::query()->find($destiny['receiver']);
            event(new NotificationUser($user, $notification));
        }
    }
}
