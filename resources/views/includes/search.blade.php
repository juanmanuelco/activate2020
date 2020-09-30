<div class="row justify-content-end">
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
        <div class="form-group">
            <form method="GET">
                <div id="custom-search-input">
                    <div class="input-group col-md-12">
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
