<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\NotificationReaded;
use App\Repositories\NotificationReadedRepository;
use App\Repositories\NotificationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        //
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
