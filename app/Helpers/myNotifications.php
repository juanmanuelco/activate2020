<?php


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
        $repository->create($destiny);
        event(new \App\Events\Notificacion($notification));
    }
}
