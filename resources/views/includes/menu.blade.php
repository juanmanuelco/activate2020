<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" style="z-index: 0">

    <!-- Sidebar - Brand -->
    <a class=" align-items-center justify-content-center" href="{{route('home')}}" >
        <div class="sidebar-brand-icon" style="padding:30px 0px 30px 0px; text-align: center">
            <img src="{{getConfiguration('image', 'LOGOTIPO')}}" width="80%" alt="{{env('APP_NAME')}}">
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
        if(Auth::check()){
            $roles  = Auth::user()->getRoleNames();
            $roles  = Role::whereIn('name', $roles)->pluck('id');
            $groups = DB::table('groups_roles')->whereIn('role',$roles)->leftJoin('groups', 'groups.id', '=', 'groups_roles.group')->pluck('groups.id');
            $groups = Group::query()->whereIn('id', $groups)->orderBy('name', 'asc')->get();
        }else{
            $groups = [];
        }
        $links = \App\Models\Link::get();
    @endphp
    @if(count($links) > 0)
        <p class="text-center text-white">{{__('interesting_links')}}</p>

        <div class="text-center menu-up">
            <i class="fa fa-caret-up"></i>
        </div>
        <div class="menu-system" style="height: 300px">

            @foreach($links as $link)
                <li class="nav-item">
                    <a class="nav-link" href="{{$link->link}}" target="_blank">
                        <i class="{{$link->icon}} text-white"></i>
                        <span>{{$link->name}}</span>
                    </a>
                </li>
            @endforeach
        </div>

        <div class="text-center menu-down">
            <i class="fa fa-caret-down"></i>
        </div>
    @endif

    <div class="text-center menu-up">
        <i class="fa fa-caret-up"></i>
    </div>
    <div class="menu-system">
        @foreach($groups as $group)
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse_{{$group->id}}" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="{{$group->icon}} text-white"></i>
                    <span>{{$group->name}}</span>
                </a>
                <div id="collapse_{{$group->id}}" class="collapse" aria-labelledby="" data-parent="#accordionSidebar">
                    @php
                        $permissions = Group::find($group->id)->permissions()->orderBy('permissions.detail')->get();
                    @endphp
                    @foreach($permissions as $permission)
                        @can($permission->name)
                            <?php try{
                                route($permission->name);
                                ?>
                                <div class="collapse-inner rounded" style="background-color: var(--background, #000000)">
                                    <a class="collapse-item" href="{{get_route($permission->name)}}">{{$permission->detail}}</a>
                                </div>
                                <?php
                            }catch (\Throwable $e){

                            } ?>

                        @endcan
                    @endforeach
                </div>
            </li>
        @endforeach
    </div>
    <div class="text-center menu-down">
        <i class="fa fa-caret-down"></i>
    </div>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
