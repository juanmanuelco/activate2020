<label for="">{{__('receivers')}}</label>
<div class="form-group" style="max-height: 1000px">
    <div class="form-check" style="cursor: pointer">
        <input class="form-check-input" id="role_all" type="checkbox" checked>
        <strong>
            <label class="form-check-label" for="role_all">{{trans('role_all')}}</label>
        </strong>
    </div>
    @foreach($roles as $role)
        <div class="form-check" style="padding-left: 45px">
            <input class="form-check-input roles_checked" id="role_{{$role->id}}" value="{{$role->id}}" type="checkbox" name="roles[]" checked onclick="setChecked(this)">
            <strong>
                <label class="form-check-label" for="role_{{$role->id}}">
                    {{$role->name}}
                </label>
            </strong>
        </div>
        <div style="padding-left: 90px; max-height: 100px; overflow-y: scroll">
            @foreach($role->users as $user)
                <div class="form-check" style="cursor: pointer">
                    <input class="form-check-input users_checked role_{{$role->id}}" value="{{$user->id}}" id="role_{{$role->id}}_user_{{$user->id}}" onclick="setCheckedCustom('role_{{$role->id}}')" type="checkbox" name="users[]" checked>
                    <label class="form-check-label" for="role_{{$role->id}}_user_{{$user->id}}">
                        {{$user->name}}
                    </label>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
