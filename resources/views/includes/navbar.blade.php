<nav class="navbar navbar-expand navbar-light  topbar mb-4 static-top shadow" id="navbar_principal" style="background-color: var(--ground, #000532)">

    <button id="sidebarToggleTop" class="btn d-md-none rounded-circle mr-3" style="background-color: white">
        <i class="fa fa-bars"></i>
    </button>

    <ul class="navbar-nav ml-auto">

        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="{{asset('images/email.png')}}" alt="{{__('messages')}}" width="70px">
                <!-- Counter - Alerts -->
                <span class="badge badge-light badge-counter" style="margin-top: -18px; margin-right: 8px">3+</span>
            </a>
            <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Messages Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                        <div class="icon-circle bg-success">
                            <i class="fas fa-donate text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">December 7, 2019</div>
                       Hola wey
                    </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Show All messages</a>
            </div>
        </li>


        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="{{asset('images/notification.png')}}" alt="{{__('notification')}}" width="40px">
                <span v-if="notifications_not_readed > 0" class="badge badge-light badge-counter" style="margin-top: -18px; margin-right: 8px">@{{ notifications_not_readed }}+</span>
            </a>
            <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">{{__('notification_center')}}</h6>
                <div class="dropdown-item" v-for="notification in notifications" :id="'notification_' + notification.id">
                    <div style="text-align: right">
                        <a href="#" v-on:click="closeNotification('notification_' + notification.id, notification)">
                            <span style="font-size: 18px; color: #64acad;"><i class="far fa-times-circle"></i></span>
                        </a>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="mr-3">
                            <div class="icon-circle bg-success"><i :class="notification.icon + ' text-white'"></i></div>
                        </div>
                        <div>
                            <div class="small text-gray-500">@{{ notification.created  }}</div>
                            @{{ notification.detail }}
                        </div>
                    </div>
                </div>
                <a class="dropdown-item text-center small text-gray-500" href="#">{{__('see_all')}}</a>
            </div>
        </li>

        <!-- Nav Item - Messages -->


        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-white-600 small">{{Auth::user()->name}}</span>
                <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                @if(\Illuminate\Support\Facades\Auth::user()->hasRole('Super Admin'))
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-toolbox fa-sm fa-fw mr-2 text-gray-400"></i>
                        {{__('configuration')}}
                    </a>
                    <div class="dropdown-divider"></div>
                @endif
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    {{__('profile')}}
                </a>

                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{route('logout')}}" >{{__('logout')}}</a>
            </div>
        </li>

    </ul>
</nav>
@section('vue_scripts')
    <script>
        const navbar_principal = new Vue({
            el: '#navbar_principal',
            data: {
                notifications   : @json(getNotifications()),
                notifications_not_readed : @json(getNotifications('readed')),
                messages        : [],
                messages_not_readed :0
            },
            created(){
                let elem = this;
                Echo.channel('channel-notification').listen('.notification-event', function(data) {
                    elem.notifications_not_readed =elem.notifications_not_readed +1;
                    elem.notifications.unshift(data.notification);
                    (new Audio(location.origin +'/sounds/default.ogg')).play();
                });
            },
            methods: {
                closeNotification : function (destiny, notification) {
                    let url = location.origin + '/notification/remove';
                    let data = {notification : notification.id};
                    loading(destiny, url, 'POST', data, false)
                    this.remove_method(this.notifications, notification);
                },
                remove_method : function removeItemOnce(arr, value) {
                    //USE THIS METHOD FOR DELETE ELEMENT ON LIST
                    const index = arr.indexOf(value);
                    if (index > -1) arr.splice(index, 1);
                    (new Audio(location.origin +'/sounds/remove.ogg')).play();
                    return arr;
                },
            }
        });
    </script>
@endsection
