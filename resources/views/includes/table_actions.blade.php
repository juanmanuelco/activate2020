@can(Route::current()->uri. ".show")
    <a href="{{route(Route::current()->uri. ".show", [ Route::current()->uri. "" => $identity])}}" class="button_show">  <i class="fa fa-eye"></i> </a>
@endcan

@can(Route::current()->uri. ".edit")
    <a href="{{route(Route::current()->uri. ".edit", [ Route::current()->uri. "" => $identity])}}" class="button_edit">  <i class="fa fa-edit"></i> </a>
@endcan

@can(Route::current()->uri. ".destroy")
    <a href="javascript:deleteRow('{{route(Route::current()->uri. ".destroy", [ Route::current()->uri. "" => $identity])}}')" class="button_delete">  <i class="fa fa-trash"></i> </a>
@endcan
