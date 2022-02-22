<div id="image_container">
    <div class="row">
        <div class="col-lg-4">
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
        </div>
        <div class="col-lg-8" style="padding-top: 20px">
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

            <div class="row" style="height: 50vh;  overflow-y: scroll; margin-top: 15px">
                <div class="col-lg-2 col-md-3 col-sm-3 col-xs-4 thumb" v-for="image in images.data" v-if="compare(image)" v-bind:style= "image.id === image_selected ? 'background-color:#f2f2f2': 'background-color:#ffffff'">
                    <a class="thumbnail" v-on:click="show_image(image)" href="#">
                        <img class="img-thumbnail rounded" :src="image.permalink" width="100%" height="150px">
                        <p style="text-align: center; padding-left: 4px; padding-right: 4px">@{{ image.name }}</p>
                    </a>
                    <button type="button" class="btn btn-info btn-block" v-on:click="select_image(image)">{{__('select')}}</button>
                </div>
            </div>
            <div style="margin: 20px">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li v-for="link in images.links" v-bind:class="['page-item', link.active ? 'active' : '']">
                            <button class="page-link" v-on:click="fillImages(link.url)" v-html="link.label"></button>
                        </li>
                    </ul>
                </nav>
            </div>
            <input type="hidden" name="image" v-model="image_selected">
        </div>
    </div>
    <div class="modal fade" id="image-gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" v-if="(image_show != null)">
                <div class="modal-header">
                    <h4 class="modal-title" id="image-gallery-title">@{{ image_show.name }}</h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="image-gallery-image" class="img-responsive col-md-12" :src="image_show.permalink">
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
</div>



@section('image_vue')
    <script src="{{asset('js/images.js')}}"></script>
    <script>
        var image_component = new Vue({
            el: '#image_container',
            data: {
                search          :   '',
                images          :   [],
                image_show      :   null,
                image_selected  :   @json(isset($object) && $object->getImage() != null ? $object->getImage()->id : null),
                image_source    :   @json(isset($image) ? '/images/system/' . $image->id . '.' . $image->extension : null)
            },
            created(){
                this.fillImages("");
            },
            methods :{
                fillImages : function (uri){
                    if(uri === ""){
                        uri = location.origin + '/imageFIle';
                    }
                    this.images = [];
                    fetch(uri).then(response => response.json()).then((data)=>{
                        this.images = data;
                    });
                },
                addImage : function (image) {
                    this.images.data.unshift(image);
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
                    this.image_source = location.origin +'/images/system/' + image.id + '.'+ image.extension
                },
                show_image : function(image){
                    this.image_show = image;
                    $('#image-gallery').modal();
                }
            }
        });
        $("#image_content").change(function() {  show_image_preview(this); });
    </script>
@endsection

