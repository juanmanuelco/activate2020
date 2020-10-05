<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Repositories\PermissionRepository;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    private $permissionRepository;

    /**
     * PermissionController constructor.
     * @param PermissionRepository $permissionRepo
     */
    public function __construct(PermissionRepository $permissionRepo)
    {
        $this->permissionRepository = $permissionRepo;
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $permissions = $this->permissionRepository;
        $permissions = $permissions->search(isset($request['search'])? $request['search'] : '');
        $permissions = $permissions->orderBy('name')->paginate(15);
        return view('pages.permissions.index')->with('permissions', $permissions);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function create()
    {
        $groups = Group::query()->orderBy('name')->pluck('name', 'id');
        return view('pages.permissions.create')->with('groups', $groups);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $this->validate($request, [
            'name' => 'required|max:255|unique:permissions',
            'guard_name' => 'required',
        ]);

        try {
            DB::beginTransaction();
            route($input['name']);
            $this->permissionRepository->create($input);
            DB::commit();
            return redirect(route('permission.create'))->with('status', __('saved_success'));
        }catch (\Throwable $e){
            DB::rollBack();
            return redirect(route('permission.create'))->with('error', $e->getMessage());
        }
    }


    /**
     * @param Permission $permission
     */
    public function show(Permission $permission)
    {
        return view('pages.permissions.show')->with('permission', $permission);
    }


    /**
     * @param Permission $permission
     */
    public function edit(Permission $permission)
    {
        $groups = Group::query()->orderBy('name')->pluck('name', 'id');
        return view('pages.permissions.edit')->with('permission', $permission)->with('groups', $groups);
    }


    /**
     * @param Request $request
     * @param Permission $permission
     */
    public function update(Request $request, Permission $permission)
    {
        $input = $request->all();
        try {
            DB::beginTransaction();
            route($input['name']);
            $permission->update($input);
            DB::commit();
            return redirect()->back()->with('status', __('updated_success'));
        }catch (\Throwable $e){
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    /**
     * @param Permission $permission
     */
    public function destroy(Permission $permission)
    {
        try {
            DB::beginTransaction();
            $permission->delete();
            DB::commit();
            return response()->json(['delete' => 'success']);
        }catch (\Throwable $e){
            DB::rollBack();
            abort(403, $e->getMessage());
        }
    }

    public function  assign(Request $request){
        $permissions =  $this->permissionRepository;
        $permissions =  $permissions->search(isset($request['search'])? $request['search'] : '');
        $permissions =  $permissions->paginate(8);
        return view('pages.permissions.assign')->with('permissions', $permissions);
    }

    public function assign_post(){

    }
}
