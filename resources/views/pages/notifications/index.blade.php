@extends('layouts.app')
@section('content')
    @php
        use Carbon\CarbonImmutable;
        use \Spatie\Permission\Models\Role;
        use App\Models\User;
    @endphp
    @include('includes.search')
    <div class="table table-responsive" style ="text-align: left">
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th>{{__('id')}}</th>
                <th>{{__('actions')}}</th>
                <th>{{__('icon')}}</th>
                <th>{{__('detail')}}</th>
                <th>{{__('receivers')}}</th>
                <th>{{__('created_at')}}</th>
                <th>{{__('expiration')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($notifications as $notification)
                <tr id="td_row_{{$notification->id}}">
                    <td> {{$notification->id}} </td>
                    <td>
                        @include('includes.table_actions', ['identity' => $notification->id])
                    </td>
                    <td>
                        <i class="{{$notification->icon}}"></i>
                    </td>
                    <td> {{$notification->detail}} </td>
                    <td>
                        @foreach($notification->receivers as $receiver)
                            @if($receiver->type == 'rol')
                                <div style="border-bottom: 1px solid gray; padding-top: 10px">
                                    {{__('role')}}: {{Role::find($receiver->receiver)->name}}
                                </div>
                            @elseif($receiver->type == 'user')
                                <div style="border-bottom: 1px solid gray; padding-top: 10px">
                                    {{__('user')}}: {{User::find($receiver->receiver)->name}}
                                </div>
                            @endif
                        @endforeach
                    </td>

                    <td>
                        {{CarbonImmutable::parse($notification->created_at)->calendar()}}
                    </td>
                    <td>
                        @if(!empty($notification->expiration))
                            {{CarbonImmutable::parse($notification->expiration)->calendar()}}
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div style="width: 100%;">
        {{ $notifications->links() }}
    </div>
@endsection
