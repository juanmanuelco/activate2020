<div class="row">
    <div class="col-lg-4" style="text-align: center">
        <div class="panel-body">
            <div class="upload-drop-zone" id="drop-zone">
                <input type="file" name="file" id="image_content" class="inputfile" />
                <label for="image_content" style="height: 100%; width: 100%; padding: 15px">
                    <div style="margin: 15px">
                        {{__('add_new_image')}}
                    </div>
                    <img src="" alt="" id="img_receiver" width="100%" style="max-height: 320px">
                </label>
            </div>
            <button class="btn btn-primary btn-block" type="button"></button>
        </div>
    </div>
    @php
        $images = \App\Models\ImageFile::select('id', 'extension', 'name')->orderBy('id', 'desc')->limit(1000)->get();
    @endphp
    <div class="col-lg-8">
        <label for="">{{__('select_an_image')}}</label>
        <div style="max-height: 440px; min-height: 440px;overflow-y: scroll; overflow-x: hidden; background-color: #f2f2f2">
            @foreach($images as $image)
                <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                    <a class="thumbnail" href="#" data-image-id="" data-toggle="modal" data-title="{{$image->name}}"
                       data-image="{{'/images/system/' . $image->id . '.' . $image->extension}}"
                       data-target="#image-gallery">
                        <img class="img-thumbnail rounded "
                             src="{{'/images/system/' . $image->id . '.' . $image->extension}}"
                             alt="{{$image->name}}">
                    </a>
                    <button type="button" class="btn btn-info btn-block">{{__('select')}}</button>
                </div>
            @endforeach
        </div>
    </div>
</div>
<div class="modal fade" id="image-gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="image-gallery-title"></h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="image-gallery-image" class="img-responsive col-md-12" src="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary float-left" id="show-previous-image"><i class="fa fa-arrow-left"></i>
                </button>

                <button type="button" id="show-next-image" class="btn btn-secondary float-right"><i class="fa fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>

