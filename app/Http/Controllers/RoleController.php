<?php

namespace App\Http\Controllers;

use App\Models\GroupRole;
use App\Models\User;
use App\Repositories\NotificationReceiverRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * @var RoleRepository
     */
    private $roleRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;

    private $notificationRepository;

    private $notificationReceiverRepository;

    /**
     * RoleController constructor.
     * @param RoleRepository $roleRepo
     * @param UserRepository $userRepo
     * @param NotificationRepository $notificationRepo
     */
    public function __construct(RoleRepository $roleRepo, UserRepository $userRepo, NotificationRepository $notificationRepo, NotificationReceiverRepository $notificationReceiverRepo)
    {
        $this->roleRepository = $roleRepo;
        $this->userRepository = $userRepo;
        $this->notificationRepository = $notificationRepo;
        $this->notificationReceiverRepository = $notificationReceiverRepo;
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $roles = $this->roleRepository;
        $roles = $roles->search(isset($request['search'])? $request['search'] : '');
        $roles = $roles->paginate(15);
        return view('pages.roles.index')->with('roles', $roles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('pages.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request['public'] = $request['public'] == 'on';
        $request['is_admin'] = $request['is_admin'] == 'on';
        $input = $request->all();
        try {
            DB::beginTransaction();
           $this->roleRepository->create($input);
            DB::commit();
            return redirect(route('role.create'))->with('status', __('saved_success'));
        }catch (\Throwable $e){
            DB::rollBack();
            abort(403, $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $role = Role::findById($id);
        if(!empty($role)){
            return view('pages.roles.show')->with('role', $role);
        }else{
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $role = Role::findById($id);
        if(!empty($role)){
            return view('pages.roles.edit')->with('role', $role);
        }else{
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request['public'] = $request['public'] == 'on';
        $request['is_admin'] = $request['is_admin'] == 'on';
        $input = $request->all();
        $role = Role::findById($id);
        try {
            DB::beginTransaction();
            $role->update($input);
            DB::commit();
            return redirect()->back()->with('status', __('updated_success'));
        }catch (\Throwable $e){
            DB::rollBack();
            abort(403, $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $role = Role::findById($id);
        try {
            DB::beginTransaction();
            $users = User::all();
            foreach($users as $user){
               if( $user->hasRole($role->name))  $user->removeRole($role->name);
            }
            DB::table('role_has_permissions')->where('role_id', $id)->delete();
            GroupRole::where('role', $id)->delete();
            $role->delete();
            DB::commit();
            return response()->json(['delete' => 'success']);
        }catch (\Throwable $e){
            DB::rollBack();
            abort(403, $e->getMessage());
        }
    }

    public function  assign(Request $request){
        $users = $this->userRepository;
        $users = $users->search(isset($request['search'])? $request['search'] : '');
        $users =$users->paginate(8);
        return view('pages.roles.assign')->with('users', $users);
    }

    public function assign_role_post(Request $request){
        try {
            DB::beginTransaction();
            $input = $request->all();
            $role = $this->roleRepository->find($input['role']);
            $user = $this->userRepository->find($input['user']);

            if($input['active'] === 'true')  {
                $notification = $this->notificationRepository->create([
                    'detail' => "Felicidades, se te ha asignado el rol de $role->name, Por favor actualiza tu información para poder activar tus servicios",
                    'icon'   => 'fas fa-glass-cheers',
                    'emisor'    =>  Auth::user()->id
                ]);
                $destiny = [
                    ['receiver' => $user->id , 'type' => 'user', 'notification' => $notification->id]
                ];
                //setReceiver($destiny, $this->notificationReceiverRepository, $notification);

                $user->assignRole($role->name);
            } else{
                $notification = $this->notificationRepository->create([
                    'detail' => "Lo sentimos, tu rol de $role->name ha sido removido por el administrador",
                    'icon'   => 'fas fa-heart-broken',
                    'emisor'    =>  Auth::user()->id
                ]);
                $destiny = [
                    ['receiver' => $user->id , 'type' => 'user', 'notification' => $notification->id]
                ];
                //setReceiver($destiny, $this->notificationReceiverRepository, $notification);

                $user->removeRole($role->name);
            }
            DB::commit();
            return response()->json(['success' => 'true']);
        }catch (\Throwable $e){
            DB::rollBack();
            abort(500, $e->getMessage());
        }
    }

    public function apply($role){
        try {
            DB::beginTransaction();
            $role = $this->roleRepository->find($role);
            if(empty($role)) abort(404);
            if($role->public)  Auth::user()->assignRole($role->name);
            else               abort(401);

            $notification = $this->notificationRepository->create([
                'detail' => "El usuario con ID :" . Auth::id() .", con nombre: " . Auth::user()->name ." y con email: " . Auth::user()->email . " ha adquirido el rol de " . $role->name,
                'icon'   => 'fas fa-user-tag',
                'emisor'    =>  Auth::user()->id
            ]);
            $destiny = [
                ['receiver' => 1 , 'type' => 'role', 'notification' => $notification->id]
            ];
            //setReceiver($destiny, $this->notificationReceiverRepository, $notification);

            DB::commit();
            return redirect('home')->with('status', __('apply_in_process', ['type' => $role->name]));
        }catch (\Throwable $e){
            DB::rollBack();
            return redirect('home')->with('error', $e->getMessage());
        }
    }
}
