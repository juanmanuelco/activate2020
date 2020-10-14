@extends('layouts.app')
@section('content')
    @php
        use Carbon\CarbonImmutable;
        use \Spatie\Permission\Models\Role;
        use App\Models\User;
    @endphp
    @include('includes.search')
    <div class="row" style="text-align: left">
        @foreach($notifications as $notification)
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <div class="card" style="margin-top: 15px">
                    <div class="d-flex align-items-center card-body">
                        <div class="mr-3">
                            <div class="icon-circle bg-success"><i class="{{$notification->icon}} text-white"></i></div>
                        </div>
                        <div>
                            <div class="small text-gray-500">{{CarbonImmutable::parse($notification->created_at)->calendar()}}</div>
                            {{$notification->detail}}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div style="width: 100%;">
        {{ $notifications->links() }}
    </div>
@endsection
