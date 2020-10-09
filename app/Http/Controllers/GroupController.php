<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupRole;
use App\Repositories\GroupRepository;
use App\Repositories\GroupRoleRepository;
use App\Repositories\RoleRepository;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    /**
     * @var GroupRepository
     */
    private $groupRepository;

    /**
     * @var RoleRepository
     */
    private $roleRepository;

    private $groupRolRepository;

    /**
     * GroupController constructor.
     * @param GroupRepository $groupRepo
     * @param RoleRepository $roleRepo
     * @param GroupRoleRepository $groupRoleRepo
     */
    public function __construct(GroupRepository $groupRepo, RoleRepository $roleRepo, GroupRoleRepository $groupRoleRepo)
    {
        $this->groupRepository = $groupRepo;
        $this->roleRepository = $roleRepo;
        $this->groupRolRepository = $groupRoleRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $group = $this->groupRepository;
        $group = $group->search(isset($request['search'])? $request['search'] : '');
        $group = $group->paginate(15);
        return view('pages.groups.index')->with('groups', $group);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('pages.groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'icon' => 'required',
        ]);
        try {
            DB::beginTransaction();
            $input = $request->all();
            $this->groupRepository->create($input);
            DB::commit();
            return redirect(route('group.create'))->with('status', __('saved_success'));
        }catch (\Throwable $e){
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage() . ' in line '. $e->getLine());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Group $group)
    {
        return view('pages.groups.show')->with('group', $group);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Group $group){
        return view('pages.groups.edit')->with('group', $group);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Group $group)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'icon' => 'required',
        ]);
        try {
            DB::beginTransaction();
            $input = $request->all();
            $group->update($input);
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
    public function destroy(Group $group)
    {
        try {
            DB::beginTransaction();
            $group->delete();
            DB::commit();
            return response()->json(['delete' => 'success']);
        }catch (\Throwable $e){
            DB::rollBack();
            abort(403, $e->getMessage());
        }
    }

    public function  assign(Request $request){
        $groups =   $this->groupRepository;
        $groups =   $groups->search(isset($request['search'])? $request['search'] : '');
        $groups =   $groups->paginate(10);
        return view('pages.groups.assign')->with('groups', $groups);
    }

    public function assign_post(Request $request){
        try {
            DB::beginTransaction();
            $input = $request->all();
            $role = $this->roleRepository->find($input['role']);
            $group = $this->groupRepository->find($input['group']);

            if($input['active'] === 'true') {
                GroupRole::firstOrCreate([
                    'role' => $role->id,
                    'group' =>  $group->id
                ]);
            } else {
                GroupRole::query()->where('role' , $role->id,)->where('group' ,  $group->id)->delete();
            }
            DB::commit();
        }catch (\Throwable $e){
            DB::rollBack();
            abort(500, $e->getMessage());
        }
    }


}
