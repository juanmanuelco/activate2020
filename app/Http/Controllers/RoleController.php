<?php

namespace App\Http\Controllers;

use App\Models\GroupRol;
use App\Models\User;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
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

    /**
     * RoleController constructor.
     * @param RoleRepository $roleRepo
     * @param UserRepository $userRepo
     */
    public function __construct(RoleRepository $roleRepo, UserRepository $userRepo)
    {
        $this->roleRepository = $roleRepo;
        $this->userRepository = $userRepo;
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
            GroupRol::where('role', $id)->delete();
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

    public function assign_post(){

    }
}
