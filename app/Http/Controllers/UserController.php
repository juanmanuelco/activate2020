<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Country;
use App\Models\NotificationReaded;
use App\Models\User;
use App\Repositories\UserRepository;
use Carbon\CarbonImmutable;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Response;

use Image;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    private UserRepository $userRepository;



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

    /**
     * @param UserRepository $userRepository
     */
    public function __construct( UserRepository $userRepo ) {
        $this->userRepository = $userRepo;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('pages.users.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);
        try {
            DB::beginTransaction();
            $input = $request->all();
            $input['password']= Hash::make($input['password']);
            $this->userRepository->create($input);
            DB::commit();
            return redirect(route('user.create'))->with('status', __('saved_success'));
        }catch (\Throwable $e){
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage() . ' in line '. $e->getLine());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Seller  $seller
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('pages.users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user){
        return view('pages.users.edit')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {

        $this->validate($request, [
            'name' => 'required|max:255',
            'password' => 'confirmed',
        ]);
        try {
            DB::beginTransaction();
            $input = $request->all();

            if($user->email != $input['email']){
                throw new Exception(__("Can not change the email"));
            }

            if(!empty($input['password'])){
                $input['password']= Hash::make($input['password']);
            }else{
                unset($input['password']);
            }


            $user->update($input);
            DB::commit();
            return redirect()->back()->with('status', __('updated_success'));
        }catch (\Throwable $e){
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage() . ' in line '. $e->getLine());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        try {
            DB::beginTransaction();
            $user->delete();
            DB::commit();
            return response()->json(['delete' => 'success']);
        }catch (\Throwable $e){
            DB::rollBack();
            abort(403, $e->getMessage());
        }
    }

    public function profile(){
        $user = Auth::user();
        $phone_codes = Country::select(DB::raw("CONCAT(nicename,' ',phonecode) AS code"),'id')->pluck('code', 'id');
        $activities = [
            ['name' => 'Mis puntos', 'count' => $user->points],
            ['name' => 'Mi ahorro', 'count' => "$ 0.00"],
            ['name' => 'Mi ganancia', 'count'=> "$ " . number_format($user->gains,2,'.', ',')],
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
             return response()->json(['error' => $e->getFile() . $e->getLine() . $e->getTraceAsString()]);
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
                return response()->json(['error' => $e->getFile() . $e->getLine() . $e->getTraceAsString()]);
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
             return response()->json(['error' => $e->getFile() . $e->getLine() . $e->getTraceAsString()]);
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
             return response()->json(['error' => $e->getFile() . $e->getLine() . $e->getTraceAsString()]);
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
        }catch (\Throwable $e){dd($e);
            DB::rollBack();
            return response()->json(['error' => $e->getFile() . $e->getLine() . $e->getTraceAsString()]);
        }
    }

    public function location(Request $request){
        try {
            DB::beginTransaction();
            $input = $request->all();
            $user = \auth()->user();
            $user->latitude = $input['latitude'];
            $user->longitude = $input['longitude'];
            $user->location_updated = CarbonImmutable::parse( date('Y-m-d h:i:sa'));
            $user->save();
            DB::commit();
            return response()->json(['save' => 'success']);
        }catch (\Throwable $e){
            DB::rollBack();
            return  response()->json(['error' => $e->getMessage()]);
        }
    }

    public function api_login(Request $request){
        $current_user = User::query()->where('email', $request['email'])->first();
        if ($current_user && Hash::check($request['password'], $current_user->password)) {
            $new_user = User::query()->where('id', $current_user->id)->with('roles')->first();
            return response()->json($new_user);
        }else{
            abort(403);
        }
    }

    public function api_register(Request $request){

        try {
            DB::beginTransaction();
            $country = Country::find($request['code_phone']);
            if(isset($request['roles'])){
                $permissions = Role::whereIn('name', $request['roles'])->where('public', true)->pluck('name');
            }else{
                $permissions = Role::where('name', "Cliente")->where('public', true)->pluck('name');
            }

            $user = User::query()->where('email', $request['email'])->first();
            if($user != null) abort(403);


            $new_user = User::create([
                'name'          => $request['name'],
                'email'         => $request['email'],
                'phone'         => $request['phone'],
                'code_phone'    => '+' . $country->phonecode,
                'password'      => Hash::make($request['password']),
                'user_token'    => mb_strtoupper(bin2hex(random_bytes(25))),
                'gains'         => 0
            ]);

            $new_user->syncRoles($permissions);

            DB::commit();
            $new_user = User::query()->where('id', $new_user->id)->with('roles')->first();
            $ch = curl_init();

            $application_api = getConfiguration('text', 'SendBirdAppId' );
            $api_token = getConfiguration('text', 'SenBird_token' );
            $user_profile = getConfiguration('text', 'SENDBIRD-PROFILE-URL');

            curl_setopt($ch, CURLOPT_URL, "https://api-$application_api.sendbird.com/v3/users");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

            $post = array(
                'user_id' => $new_user->id,
                'nickname' => $new_user->name,
                'profile_url' => $user_profile.'/' . $new_user->user_token,
                "is_active" => true,
                "is_online" => true,
            );
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

            $headers = array();
            $headers[] = "Api-Token: $api_token";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_exec($ch);
            if (curl_errno($ch)) {
                throw new \Exception(curl_error($ch));
            }
            curl_close($ch);

            return response()->json($new_user);
        }catch (\Throwable $e){
            DB::rollBack();
            abort(403, $e->getMessage());
        }
    }

    public function api_recovery (request $request){
        $user = User::query()->where('email', $request['email'])->first();
        if($user == null) abort(403);

        Password::broker()->sendResetLink(['email' => $request['email']]);
        flash('Reset password link sent', 'success');
        return response()->json(['success', true]);
    }

    public function current_user(Request $request){
        $user = User::query()->where('user_token', $request['user_token'])
                             ->with(['roles', 'stores', 'stores.image', 'stores.benefits', 'stores.benefits.image'])
                             ->first();
        if($user == null) abort(403);
        if(isset($request['latitude'])){
            $user->latitude = doubleval($request['latitude']);
        }
        if(isset($request['longitude'])){
            $user->longitude = doubleval($request['longitude']);
        }
        $user->location_updated = CarbonImmutable::parse( date('Y-m-d h:i:sa'));
        $user->save();
        return response()->json($user);
    }

    public function api_my_applied_benefits(Request $request){
        $user = User::query()->where('user_token', $request['user_token'])->with('roles')->first();
        if($user == null) abort(403);
        $applications = Application::query()->whereHas('assignment', function ($q) use($user){
            $q->where('email', $user->email);
        })->with([
            'assignment',
            'benefit',
            'assignment.card',
            'assignment.card.image',
            'benefit.image',
            'benefit.store',
            'benefit.store.image'
        ])
          ->orderBy('created_at', 'desc')->get();

        return response()->json(['applications' => $applications]);
    }

    public function api_profile_update(Request $request){
        try {
            DB::beginTransaction();
            $country = Country::find($request['code_phone']);
            $user = User::query()->where('user_token', $request['user_token'])->first();
            if($user == null) abort(403);
            Auth::login($user);
            $user->birthday = CarbonImmutable::parse( date( $request['birthday']));
            $user->identification = $request['identification'];
            $user->code_phone = "+" .$country->phonecode;
            $user->show_location = $request['show_location'];
            $user->show_age = $request['show_age'];
            $user->show_gender = $request['show_gender'];
            $user->gender = $request['gender'];
            $user->phone = $request['phone'];
            $user->save();
            DB::commit();
            $user = User::query()->where('id', $user->id)->with('roles')->first();
            return response()->json($user);
        }catch (\Throwable $e){
            DB::rollBack();
            abort(403, $e->getMessage());
        }
    }

    public function api_change_password(Request $request){
        try {
            DB::beginTransaction();
            $user = User::query()->where('user_token', $request['user_token'])->first();
            if($user == null) abort(403);
            Auth::login($user);
            if (!Hash::check($request['password'], $user->password)) abort(403);
            $user->password = Hash::make($request['new_password']);
            $user->save();
            DB::commit();
            $user = User::query()->where('id', $user->id)->with('roles')->first();
            return response()->json($user);
        }catch (\Throwable $e){
            DB::rollBack();
            abort(403, $e->getMessage());
        }
    }

    public function  api_change_roles(Request $request){
        try {
            DB::beginTransaction();
            $user = User::query()->where( 'user_token', $request['user_token'] )->first();
            if ( $user == null ) {
                abort( 403 );
            }
            Auth::login($user);
            $roles_assign = ['Cliente'];
            foreach ( $request['roles'] as $role ) {
                $role_obj = Role::query()->where('name', $role)->first();
                if($role_obj == null) abort(403);
                if($role_obj->public){
                    array_push($roles_assign,$role);
                }
            }
            $user->syncRoles($roles_assign);
            DB::commit();
            $user = User::query()->where('id', $user->id)->with('roles')->first();
            return response()->json($user);
        }catch (\Throwable $e){
            DB::rollBack();
            abort(403, $e->getMessage());
        }
    }

    public function get_users(Request $request){
        $users = $this->userRepository;
        $users = $users->search(isset($request['search'])? $request['search'] : '');
        $users = $users->paginate(20);
        return view('pages.users.index')->with('users', $users);
    }

    public function index(Request $request){
        return $this->get_users($request);
    }

}
