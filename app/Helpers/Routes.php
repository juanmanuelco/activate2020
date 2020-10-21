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

function getConfiguration($type, $configuration){
    $response = "";
    $configuration = \App\Models\Configuration::where('name', $configuration)->first();
    if(empty($configuration)) return '';
    switch ($type){
        case 'text' :
            $response =  $configuration->text;
            break;
        case 'number':
            $response = $configuration->number;
            break;
        case 'date':
            $response = $configuration->date;
            break;
        case 'time':
            $response = $configuration->time;
            break;
        case 'datetime':
            $response =  $configuration->datetime;
            break;
        case 'boolean':
            $response = $configuration->boolean ? 'true' : 'false';
            break;
        case 'image':
            $image =  $configuration->image;
            if(empty($image)) $response = "";
            else{
                $image = \App\Models\ImageFile::find($configuration->image);
                $response = url('/') . '/images/system/' . $image->id . '.' . $image->extension;
            }
            break;
        case 'color':
            $response = !empty($configuration->text) ? $configuration->text  : '#000000';
            break;
    }
    return $response;
}
