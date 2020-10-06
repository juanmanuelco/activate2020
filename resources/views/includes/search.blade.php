<div class="row justify-content-end" style="margin-top:50px">
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
        <div class="form-group">
            <form method="GET">
                <div id="custom-search-input">
                    <div class="input-group col-md-12">
                         <span class="input-group-btn">
                             <a href="{{route(str_replace('index','create',Illuminate\Support\Facades\Route::currentRouteName()))}}">
                                 <button class="btn btn-info btn-lg" type="button">
                                    <i class="fas fa-plus"></i>
                                 </button>
                             </a>
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
