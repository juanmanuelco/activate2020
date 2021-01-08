<div class="row justify-content-between" style="margin-top:15px">
    <div class="col-lg-3 col-md-6 col-sm-8 col-xs-12">
        @php
            $currentRouteName = Illuminate\Support\Facades\Route::currentRouteName();
            $explode = explode('.', $currentRouteName);
        @endphp
        @if(!isset($object))
            {{ DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render($currentRouteName) }}
        @else
            {{ DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render($currentRouteName, $object) }}
        @endif
    </div>
    <div class="col-lg-3 col-md-6 col-sm-8 col-xs-12">
        <div class="form-group">
            <form method="GET">
                <div id="custom-search-input">
                    <div class="input-group col-md-12">
                         <span class="input-group-btn">
                             @php
                               $execute = false;
                                try {
                                    $num = route(Illuminate\Support\Facades\Route::currentRouteName());
                                    $execute = true;
                                }catch (\Throwable $e){
                                    $execute = false;
                                }
                             @endphp
                             @if($execute)
                                 @if(Illuminate\Support\Facades\Route::has(str_replace('index','create',Illuminate\Support\Facades\Route::currentRouteName())))
                                     <a href="{{route(str_replace('index','create',Illuminate\Support\Facades\Route::currentRouteName()))}}">
                                         <button class="btn btn-info btn-lg" type="button">
                                            <i class="fas fa-plus"></i>
                                         </button>
                                     </a>
                                 @endif
                             @endif
                        </span>
                        <input type="text" class="form-control input-lg" name="search" value="{{isset($_REQUEST['search']) ? $_REQUEST['search'] : ''}}" placeholder="Buscar" />
                        <span class="input-group-btn">
                            <button class="btn btn-info btn-lg" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


