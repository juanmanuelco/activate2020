<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\NotificationReaded;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Image;

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
            ['name' => 'Mis puntos', 'count' => 0],
            ['name' => 'Mi ahorro', 'count' => "$ 0.00"],
            ['name' => 'Mi ganancia', 'count'=> "$ 0.00"],
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
    public function profile_image(Request $request){
        DB::beginTransaction();
        try {
            $image = $request->file('files');
            $extension = $image->getClientOriginalExtension();
            $imageBinary = Image::make($image);
            Response::make($imageBinary->encode($extension));
            $image = base64_encode($imageBinary);
            $image = 'data:image/png;base64,' . $image;
            $user = Auth::user();
            $user->photo = $image;
            $user->save();
            DB::commit();
        }catch (\Throwable $e){
            DB::rollBack();
            return abort(500, $e->getMessage());
        }
    }

    public function profile_configuration(Request $request){
        $accepted = [
            'contact' ,
            'show_photo' ,
            'show_name' ,
            'show_phone' ,
            'show_location' ,
            'show_age' ,
            'show_gender' ,
            'show_identification' ,
            'show_civil_state' ,
        ];
        if(in_array($request['field'], $accepted)){
            try {
                DB::beginTransaction();
                $user = Auth::user();
                $user[$request['field']] = ($request['status'] == 'true');
                $user->save();
                DB::commit();
            }catch (\Throwable $e){
                DB::rollBack();
                abort(500, $e->getMessage());
            }
        }else{
            return abort(403);
        }
    }

    public function profile_direction(Request $request){
        try {
            DB::beginTransaction();
            $user = Auth::user();
            $user->country = $request['country'];
            $user->state = $request['state'];
            $user->city =  $request['city'];
            $user->address1 = $request['address1'];
            $user->address2 = $request['address2'];
            $user->postcode = $request['postcode'];
            $user->save();
            DB::commit();
        }catch (\Throwable $e){
            DB::rollBack();
            return abort(500, $e->getMessage());
        }
    }

    public function profile_password(Request $request){
        if (!(Hash::check($request->get('password'), Auth::user()->password))) return abort(403);
        if($request['new_password'] != $request['confirm_password']) return abort(500);
        try {
            DB::beginTransaction();
            $user =Auth::user();
            $user->password = bcrypt($request['new_password']);
            $user->save();
            DB::commit();
        }catch (\Throwable $e){
            DB::rollBack();
            return abort(500, $e->getMessage());
        }
    }

    public function profile_post(Request $request){
        $input = $request->all();
        unset($input['show_photo']);
        unset($input['show_name']);
        unset($input['show_phone']);
        unset($input['show_location']);
        unset($input['show_age']);
        unset($input['show_gender']);
        unset($input['show_identification']);
        unset($input['show_civil_state']);
        unset($input['email']);
        unset($input['contact']);
        unset($input['phone']);
        unset($input['password']);
        unset($input['_token']);
        try {
            DB::beginTransaction();
            User::where('id', Auth::user()->id)->update($input);
            DB::commit();
            return redirect()->back()->with('status', 'Cambios guardados con éxito');
        }catch (\Throwable $e){
            DB::rollBack();
            return  abort(500, $e->getMessage());
        }
    }
}