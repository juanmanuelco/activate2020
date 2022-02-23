<div id="image_container">
    <div class="row">
        <div class="col-lg-3">
            <div class="panel-body">
                <label for="">{{__('select_an_image')}}</label>
                <div class="upload-drop-zone" id="drop-zone" style="background-color: #f2f2f2">
                    <input type="file" name="file" id="image_content" class="inputfile" accept=".jpg, .jpeg, .png"/>
                    <label for="image_content" style="height: 100%; width: 100%; padding: 15px">
                        <div style="width: 100%; text-align: center">
                            <p id="image_label">{{__('add_new_image')}}</p>
                            <img :src="image_selected.permalink" v-if="image_selected != null" alt="" id="img_receiver" width="50%" style="max-height: 100%; margin-bottom: 15px">
                        </div>
                    </label>
                </div>
            </div>
        </div>
        <div class="col-lg-9" style="padding-top: 20px">
            <div id="custom-search-input">
                <div class="input-group col-md-12">
                    <input type="text" class="form-control input-lg" placeholder="Buscar" v-model="search" v-on:keyup="fillImages('')" />
                    <span class="input-group-btn">
                <button class="btn btn-info btn-lg" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </span>
                </div>
            </div>

            <div class="row" style="overflow-y: scroll; margin-top: 15px">
                <div class="col-lg-2 col-md-3 col-sm-3 col-xs-4 thumb" v-for="image in images.data">
                    <div style="text-align: center;">
                        <div style="color: white; background-color: var(--background, black); padding-left:10px ;  padding-right:10px " class="overflowed">
                            @{{ image.name }}

                        </div>
                    </div>
                    <div style="border: 2px solid var(--background, black); padding: 10px">
                        <img :src="image.permalink" width="100%"  v-on:click="select_image(image)" style="cursor: pointer">
                    </div>
                    <a href="#" style="cursor: pointer" v-on:click="show_image(image)" class="link-secondary">
                        <small>{{__('View Image')}}</small>
                    </a>
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
        </div>
    </div>
    <div class="modal fade" id="image-gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" v-if="(image_show != null)">
                <div class="modal-header">
                    <h4 class="modal-title" id="image-gallery-title">@{{ image_show.name }}</h4>
                    <button type="button" v-on:click="closeModal()" class="close" ><span aria-hidden="true">×</span><span class="sr-only">Close</span>
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
    <style>
        .overflowed{
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 12px;
        }
    </style>
    <script src="{{asset('js/images.js')}}"></script>
    <script>
        var image_component = new Vue({
            el: '#image_container',
            data: {
                search          :   '',
                images          :   [],
                image_show      :   null,
                image_selected  :   null
            },
            created(){
                this.fillImages("");
            },
            methods :{
                fillImages : function (uri){
                    if(uri === ""){
                        uri = location.origin + '/imageFIle';
                    }
                    if(this.search !== ''){
                        let prefix = uri.includes('?') ? '&' : '?';
                        uri += `${prefix}search=${this.search}`;
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
                select_image : function (image){
                    this.image_selected = image
                },
                show_image : function(image){
                    this.image_show = image;
                    $('#image-gallery').modal();
                },
                closeModal : function(){
                    $('#image-gallery').modal('hide');
                }
            }
        });
        $("#image_content").change(function() {  show_image_preview(this); });
    </script>
@endsection

