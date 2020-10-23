<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\NotificationReaded;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public  $configurations = [
        ['name' => 'Permitir contactarme',      'icon' => 'fas fa-id-card-alt',  'field' => 'contact' ],
        ['name' => 'Mostrar mi foto',           'icon' => 'fas fa-camera',  'field' => 'show_photo' ],
        ['name' => 'Mostrar mi nombre',         'icon' => 'far fa-credit-card',  'field' => 'show_name' ],
        ['name' => 'Mostrar mi teléfono',       'icon' => 'fas fa-phone',  'field' => 'show_phone' ],
        ['name' => 'Mostrar mi ubicación',      'icon' => 'fas fa-map-marked-alt',  'field' => 'show_location' ],
        ['name' => 'Mostrar mi edad',           'icon' => 'fas fa-birthday-cake',  'field' => 'show_age' ],
        ['name' => 'Mostrar mi género',         'icon' => 'fas fa-venus-mars',  'field' => 'show_gender' ],
        ['name' => 'Mostrar mi identificación', 'icon' => 'fas fa-id-badge',  'field' => 'show_identification' ],
        ['name' => 'Mostrar mi estado civil',   'icon' => 'fas fa-ring',  'field' => 'show_civil_state' ],
    ];

    public function profile(){
        $user = Auth::user();
        $phone_codes = Country::select(DB::raw("CONCAT(nicename,' ',phonecode) AS code"),'id')->pluck('code', 'id');
        $activities = [
            ['name' => 'Mensajes enviados', 'count' => 0],
            ['name' => 'Mensajes recibidos', 'count' => 0],
            ['name' => 'Notificaciones recibidas', 'count' => NotificationReaded::where('reader', Auth::id())->count()],
        ];
        $countries = Country::all();
        return view('pages.profile.index')
            ->with('user', $user)
            ->with('configurations', $this->configurations)
            ->with('activities', $activities)
            ->with('phone_codes', $phone_codes)
            ->with('countries', $countries);
    }
}
