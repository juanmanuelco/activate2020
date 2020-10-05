<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' =>  ['required', 'min:10'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'permission' => ['exists:roles,id', 'not_in:1,2'],
            'country'    =>['exists:countries,id']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Models\User
     * @throws \Exception
     */
    protected function create(array $data)
    {
        try {
            DB::beginTransaction();
            $country = Country::find($data['country']);
            $permissions = Role::whereIn('id', $data['permission'])->where('public', true)->pluck('name');
            $new_user = User::create([
                'name'          => $data['name'],
                'email'         => $data['email'],
                'phone'         => $data['phone'],
                'code_phone'    => '+' . $country->phonecode,
                'birthday'      =>  $data['birth'],
                'password'      => Hash::make($data['password']),
                'user_token'    => mb_strtoupper(bin2hex(random_bytes(25)))
            ]);
            $new_user->syncRoles($permissions);
            DB::commit();
            return $new_user;
        }catch (\Throwable $e){
            DB::rollBack();
            abort(403);
        }
    }
}
