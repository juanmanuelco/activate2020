<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\NotificationReaded;
use App\Models\NotificationReceiver;
use App\Models\User;
use App\Repositories\NotificationReadedRepository;
use App\Repositories\NotificationReceiverRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class NotificationController extends Controller
{
    private NotificationRepository $notificationRepository;
    private NotificationReadedRepository $notificationReadedRepository;

    private RoleRepository $roleRepository;
    private UserRepository $userRepository;
    private $notificationReceiverRepository;

    /**
     * NotificationController constructor.
     * @param NotificationRepository $notificationRepo
     * @param NotificationReadedRepository $notificationReadedRepo
     * @param RoleRepository $roleRepo
     * @param UserRepository $userRepo
     * @param NotificationReceiverRepository $notificationReceiverRepo
     */
    public function __construct(
        NotificationRepository $notificationRepo,
        NotificationReadedRepository $notificationReadedRepo,
        RoleRepository $roleRepo,
        UserRepository $userRepo,
        NotificationReceiverRepository $notificationReceiverRepo
    )
    {
        $this->notificationRepository = $notificationRepo;
        $this->notificationReadedRepository = $notificationReadedRepo;

        $this->roleRepository = $roleRepo;
        $this->userRepository = $userRepo;
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
        $notifications= $this->notificationRepository;
        $notifications = $notifications->search(isset($request['search'])? $request['search'] : '');
        $notifications = $notifications->where('emisor', Auth::user()->id)->orderBY('id', 'desc')->paginate(15);
        return view('pages.notifications.index')->with('notifications', $notifications);
    }

    public function roles_users(){
        $roles = $this->roleRepository->all();
        foreach($roles as $role){
            $role->{'users'} = $this->userRepository->makeModel()->whereHas("roles", function($q) use($role){ $q->where("name", $role->name); })->orderBy('name', 'asc')->get();
        }
        return $roles;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('pages.notifications.create')->with('roles', $this->roles_users());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $notification = $request->all();
            $users = isset($notification['users']) ? $notification['users'] : [] ;
            unset($notification['users']);
            $notification['emisor'] = Auth::id();
            $notification = $this->notificationRepository->create($notification);
            $users = array_unique($users);
            $destiny = [];

            foreach ($users as $user){
                array_push($destiny, [
                    'receiver' => $user , 'type' => 'user', 'notification' => $notification->id
                ]);
            }
            setReceiver($destiny, $this->notificationReceiverRepository, $notification);
            DB::commit();
            return redirect()->back()->with('status', 'Notificación enviada con éxito');
        }catch (\Throwable $e){
            DB::rollBack();
            abort(500, $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        //
    }

    public function  my_notifications(Request $request){
        $roles = Auth::user()->getRoleNames();
        $roles = Role::query()->whereIn('name', $roles)->pluck('id');
        $receivers = NotificationReceiver::query()->where(function ($q) use ($roles){
            $q->where('type', 'role');
            $q->whereIn('receiver', $roles);
        })->orWhere(function ($q) {
            $q->where('type', 'user');
            $q->where('receiver', Auth::user()->id);
        })->distinct('notification')->pluck('notification');

        $notifications = $this->notificationRepository->search(isset($request['search'])? $request['search'] : '');
        $notifications =$notifications->whereIn('notifications.id', $receivers)->paginate(50);
        return view('pages.notifications.my_notifications')->with('notifications', $notifications);
    }

    public function remove(Request $request){
        try {
            DB::beginTransaction();
            $this->notificationReadedRepository->create([
                'reader' => Auth::user()->id,
                'notification' => $request['notification']
            ]);
            DB::commit();
            return response()->json(['status'=>200]);
        }catch (\Throwable $e){
            DB::rollBack();
            return abort(500);
        }
    }
}
