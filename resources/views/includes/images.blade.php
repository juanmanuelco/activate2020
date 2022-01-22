@php
	    if(!empty($roles)){
            $images = \App\Models\ImageFile::select('id', 'extension', 'name')->orderBy('id', 'desc')->limit(1000)->get();
        }else{
            $images = \App\Models\ImageFile::where('owner', \Illuminate\Support\Facades\Auth::id())
            ->select('id', 'extension', 'name')
            ->orderBy('id', 'desc')->limit(1000)->get();
        }
@endphp
<div id="image_container">
    <img width="260px"
        src="<?php echo isset($object) && !empty($object->getImage())  ? '/images/system/' . $object->getImage()->id . '.' . $object->getImage()->extension : '' ?>" alt="">
    <div class="panel-body">
        <label for="">{{__('select_an_image')}}</label>
        <div class="upload-drop-zone" id="drop-zone" style="background-color: #f2f2f2">
            <input type="file" name="file" id="image_content" class="inputfile" accept=".jpg, .jpeg, .png"/>
            <label for="image_content" style="height: 100%; width: 100%; padding: 15px">
                <div style="width: 100%; text-align: center">
                    <p id="image_label">{{__('add_new_image')}}</p>
                    <img :src="image_source" alt="" id="img_receiver" width="50%" style="max-height: 380px; margin-bottom: 15px">
                </div>
            </label>
        </div>
    </div>

    <div id="custom-search-input">
        <div class="input-group col-md-12">
            <input type="text" class="form-control input-lg" placeholder="Buscar" v-model="search" />
            <span class="input-group-btn">
                <button class="btn btn-info btn-lg" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </span>
        </div>
    </div>

    <div class="row" style="max-height: 230px; overflow-y: scroll; margin-top: 15px">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6 thumb" v-for="image in images" v-if="compare(image)" v-bind:style= "image.id === image_selected ? 'background-color:#f2f2f2': 'background-color:#ffffff'">
            <a class="thumbnail" href="#" :data-image-id="image.id" data-toggle="modal" :data-title="image.name"
               :data-image="'/images/system/' + image.id + '.' + image.extension"
               data-target="#image-gallery">
                <img class="img-thumbnail rounded" :src="'/images/system/' + image.id + '.' + image.extension" width="100%" height="150px">
                <p style="text-align: center; padding-left: 4px; padding-right: 4px">@{{ image.name }}</p>
            </a>
            <button type="button" class="btn btn-info btn-block" v-on:click="select_image(image)">{{__('select')}}</button>
        </div>
    </div>
    <input type="hidden" name="image" v-model="image_selected">
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

@section('image_vue')
    <script>

        var image_component = new Vue({
            el: '#image_container',
            data: {
                search          :   '',
                images          :   @json($images),
                image_selected  :   @json(isset($object) && $object->getImage() != null ? $object->getImage()->id : null),
                image_source    :   @json(isset($image) ? '/images/system/' . $image->id . '.' . $image->extension : null)
            },
            methods :{
                addImage : function (image) {
                    this.images.unshift(image);
                    this.select_image(image)
                    document.getElementById('image_label').style.display = 'block'
                },
                compare : function(image){
                    let filter = this.search.toLowerCase();
                    if(filter.trim().length<1) return true;
                    let objective = image.name.toLowerCase();
                    return (objective.indexOf(filter) > -1);
                },
                select_image : function (image){
                    this.image_selected = image.id
                    //document.getElementById('image_for_object').value = image.id;
                    this.image_source = location.origin +'/images/system/' + image.id + '.'+ image.extension
                }
            }
        });
        $("#image_content").change(function() {  show_image_preview(this); });
    </script>
@endsection

