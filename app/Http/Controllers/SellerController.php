<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Country;
use App\Models\Seller;
use App\Models\User;
use App\Repositories\SellerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Spatie\Permission\Models\Role;

class SellerController extends Controller
{
    private $sellerRepository;

    /**
     * @param SellerRepository $sellerRepository
     */
    public function __construct(SellerRepository $sellerRepository ) {
        $this->sellerRepository = $sellerRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $sellers= $this->sellerRepository;
        $sellers = $sellers->search(isset($request['search'])? $request['search'] : '');

        $roles = auth()->user()->getRoleNames()->toArray();
        $roles = Role::query()->whereIn('name', $roles)->where('is_admin', true)->first();

        if(empty($roles)){
            $sellers->where('superior', auth()->user()->id);
        }
        $sellers = $sellers->paginate(15);
        return view('pages.sellers.index')->with('sellers', $sellers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::whereHas("roles", function($q){
                    $q->where("name", "Vendedor");
                })->doesntHave('seller')->where('id', '!=', auth()->user()->id)->pluck('name', 'id');

        $roles = auth()->user()->getRoleNames()->toArray();
        $roles = Role::query()->whereIn('name', $roles)->where('is_admin', true)->first();

        if(!empty($roles)){
           $sellers = User::whereHas("roles", function($q){
                           $q->where("name", "Vendedor");
                       })->has('seller')->pluck('name', 'id');
        }else{
            $sellers = User::whereHas("roles", function($q){
                $q->where("name", "Vendedor");
            })->whereHas('seller', function ($q){
                $q->where('user', auth()->user()->id );
            })->pluck('name', 'id');
        }
        return view('pages.sellers.create', ['users'=> $users, 'superiors' => $sellers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $roles = auth()->user()->getRoleNames()->toArray();
        $roles = Role::query()->whereIn('name', $roles)->where('is_admin', true)->first();

        if(empty($roles)){
            $request['superior'] = auth()->user()->id;
        }

        try {
            DB::beginTransaction();
            $input = $request->all();
            $this->sellerRepository->create($input);
            DB::commit();
            return redirect(route('seller.create'))->with('status', __('saved_success'));
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
    public function show(Seller $seller)
    {
        return view('pages.sellers.show')->with('seller', $seller);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Seller  $seller
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Seller $seller)
    {
        return view('pages.sellers.edit', ['seller' => $seller]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Seller  $seller
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(Request $request, Seller $seller)
    {
        $roles = auth()->user()->getRoleNames()->toArray();
        $roles = Role::query()->whereIn('name', $roles)->where('is_admin', true)->first();

        if(empty($roles)){
            $request['superior'] = auth()->user()->id;
        }

        try {
            DB::beginTransaction();
            $input = $request->all();
            $seller->update($input);
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
     * @param  \App\Models\Seller  $seller
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function destroy(Seller $seller)
    {
        try {
            DB::beginTransaction();
            $seller->getUser()->assignRole('Cliente');
            $seller->getUser()->removeRole('Vendedor');
            Seller::query()->where('superior', $seller->getUser()->id)->update([
                'superior'=> null
            ]);
            $seller->delete();
            DB::commit();
            return response()->json(['delete' => 'success']);
        }catch (\Throwable $e){
            DB::rollBack();
            abort(403, $e->getMessage());
        }
    }

    public function api_create(Request $request){
        try {
            $current_user = User::query()->where('user_token', $request['user_token'])->with('roles')->first();
            if($current_user == null) abort(403);

            DB::beginTransaction();
            $country = Country::find($request['code_phone']);

            $user = User::query()->where('email', $request['email'])->first();
            if($user != null) abort(403);


            $new_user = User::create([
                'name'          => $request['name'],
                'email'         => $request['email'],
                'phone'         => $request['phone'],
                'code_phone'    => '+' . $country->phonecode,
                'password'      => Hash::make(mb_strtoupper(bin2hex(random_bytes(25)))),
                'user_token'    => mb_strtoupper(bin2hex(random_bytes(25))),
                'gains'         => 0
            ]);

            $new_user->syncRoles(['Vendedor', 'Cliente']);
            $this->sellerRepository->create([
                'name' => $request['name'],
                'user' => $new_user->id,
                'superior' => $current_user->id,
                'commission' => $request['commission']
            ]);

            Password::sendResetLink(
                $request->only('email')
            );


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
            DB::commit();
            return response()->json(['success' => 'true']);
        }catch (\Throwable $e){
            DB::rollBack();
            abort(403, $e->getMessage());
        }
    }
}
