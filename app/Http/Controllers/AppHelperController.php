<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class AppHelperController extends Controller
{
    public function api_countries_index(){
        $countries = DB::table('countries')->get();
        //return response()->json($countries);
        return response()->json(['countries' => $countries]);
    }

    public function api_roles(){
        $roles = Role::query()->where('public', true)->get();
        return response()->json(['roles' => $roles]);
    }
}
