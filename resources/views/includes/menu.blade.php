<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class=" align-items-center justify-content-center" href="{{route('home')}}" >
        <div class="sidebar-brand-icon" style="padding:30px 0px 30px 0px; text-align: center">
            <img src="{{asset('images/brand.png')}}" width="80%" alt="{{env('APP_NAME')}}">
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Pages Collapse Menu -->

    @php
        use Illuminate\Support\Facades\Auth;
        use Illuminate\Support\Facades\DB;
        use \Spatie\Permission\Models\Role;
        use App\Models\Group;
        $roles  = Auth::user()->getRoleNames();
        $roles  = Role::whereIn('name', $roles)->pluck('id');
        $groups = DB::table('groups_roles')->whereIn('role',$roles)->leftJoin('groups', 'groups.id', '=', 'groups_roles.group')->distinct('groups.name')->orderBy('groups.name')->get();
    @endphp

    @foreach($groups as $group)
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse_{{$group->id}}" aria-expanded="true" aria-controls="collapseTwo">
                <i class="{{$group->icon}} text-white"></i>
                <span>{{$group->name}}</span>
            </a>
            <div id="collapse_{{$group->id}}" class="collapse" aria-labelledby="" data-parent="#accordionSidebar">
                @php
                   $permissions = Group::find($group->id)->permissions()->get();
                @endphp
                @foreach($permissions as $permission)
                    <div class="bg-warning py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{route($permission->name)}}">{{$permission->detail}}</a>
                    </div>
                @endforeach
            </div>
        </li>
    @endforeach




    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
