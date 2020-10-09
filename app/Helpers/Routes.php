<?php

use App\Models\GroupRole;

function get_route($route){
    try {
        return route($route);
    }catch (\Throwable $e){
        return '#';
    }
}

function exists_group_rol($group, $rol){
    try {
        $group_rol = GroupRole::query()->where('role', $rol)->where('group', $group)->first();
        return !empty($group_rol);
    }catch (\Throwable $e){
        return false;
    }
}
