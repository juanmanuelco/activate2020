<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\NotificationReaded;
use App\Models\NotificationReceiver;
use App\Repositories\NotificationReadedRepository;
use App\Repositories\NotificationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class NotificationController extends Controller
{
    private $notificationRepository;
    private $notificationReadedRepository;

    /**
     * NotificationController constructor.
     * @param NotificationRepository $notificationRepo
     * @param NotificationReadedRepository $notificationReadedRepo
     */
    public function __construct(NotificationRepository $notificationRepo, NotificationReadedRepository $notificationReadedRepo)
    {
        $this->notificationRepository = $notificationRepo;
        $this->notificationReadedRepository = $notificationReadedRepo;
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('pages.notifications.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
