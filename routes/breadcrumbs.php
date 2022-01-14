<?php
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Support\Facades\Route;


Breadcrumbs::for('notification.mail', function ($trail) {
    $trail->parent('home.index');
    $trail->push('Send mails', route('notification.mail'));
});




foreach(Route::getRoutes() as $route){
    try {
        $route = $route->action['as'];
        $explode = explode('.', $route);
        if(count($explode) > 1){
            if($explode[1] == 'index'){
                Breadcrumbs::for($route, function ($trail) use ($route, $explode){
                    if($explode[0] != 'home'){
                        $trail->parent('home.index');
                    }
                    $trail->push(mb_strtoupper($explode[0]), route($route));
                });
            }
            if($explode[1] == 'create' || $explode[1] == 'assign' ||  $explode[1] == 'insert' ||  $explode[1] == 'my_notifications' ){
                Breadcrumbs::for($route, function ($trail) use ($route, $explode){
                    $trail->parent($explode[0] . '.index');
                    $trail->push(mb_strtoupper($explode[1]), route($route));
                });
            }
            if($explode[1] == 'show' || $explode[1] == 'edit'){
                Breadcrumbs::for($route, function ($trail, $object) use ($route, $explode){
                    $trail->parent($explode[0] . '.index');
                    $trail->push(mb_strtoupper(isset($object->name) ? $object->name : $object->id), route($route, [$explode[0] => $object]));
                });
            }
        }
    }catch (\Throwable $e){
        $ee = $e;
    }

}
