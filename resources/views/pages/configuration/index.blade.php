@extends('layouts.app')
@section('content')
    @php
        $images = \App\Models\ImageFile::where('owner', \Illuminate\Support\Facades\Auth::id())->select('id', 'extension', 'name')->orderBy('id', 'desc')->limit(1000)->get();
    @endphp
    <h1>{{__('param_config')}}</h1>
    <p>{{__('config_detail')}}</p>
    <hr>
   <div id="table_configuration">
       @include('includes.search')
       <nav>
           <div class="nav nav-tabs" id="nav-tab" role="tablist" >
               <a v-for="(value, key) in configurations"
                   :class="(key == 'text') ? 'nav-link active' : 'nav-link'"
                   :id="'nav-configuration-tab-' + key"
                   data-toggle="tab"
                   :href="'#nav-configuration-' + key"
                   role="tab"
                   :aria-controls="'nav-configuration-' + key"
                   aria-selected="true">@{{ (key).toUpperCase() }}</a>
           </div>
       </nav>
       <div class="tab-content" id="nav-tabContent">
           <div
               v-for="(value, key) in configurations"
               :class="(key == 'text') ? 'tab-pane fade show active' : 'tab-pane fade' "
               :id="'nav-configuration-' + key"
               role="tabpanel"
               :aria-labelledby="'nav-configuration-tab-' + key">

               <div class="card-header" style="padding-bottom: 23px" >
                   <div style="float: left;">
                       <button class="btn btn-success" v-on:click="addConfiguration(key)" style="margin-right: 10px;"><i class="fa fa-plus"></i></button>
                   </div>
                   <h6 data-toggle="collapse" :data-target="'#'+key" aria-expanded="false" style="cursor: pointer; padding-top: 10px">
                       <strong  style="cursor: pointer">{{__('Add')}}</strong>
                   </h6>
               </div>

               <div class="row">
                   <div class="col-lg-3 col-sm-6 col-md-4 col-xs-12" v-for="configuration in value">
                       <div class="card" style="margin-top: 10px; margin-bottom: 10px">
                           <div class="card-body" >
                               <button type="button" class="close" aria-label="Close" v-on:click="removeConfiguration(configuration, key)">
                                   <span aria-hidden="true">&times;</span>
                               </button>
                               <div class="form-group">
                                   <label :for="configuration.id">{{__('Name')}}</label>
                                   <input :id="configuration.id" class="form-control" type="text" v-model="configuration.name" :readonly="configuration.exists">
                               </div>
                               <div class="form-group">
                                   <label :for="configuration.id">{{__('value')}}</label>
                                   <textarea v-model="configuration.text" v-if="configuration.type === 'text'" class="form-control"></textarea>
                                   <input type="color" v-model="configuration.text" v-if="configuration.type === 'color'" class="form-control">
                                   <input type="double" v-model="configuration.number" v-if="configuration.type === 'number'" class="form-control">
                                   <input type="date" v-model="configuration.date" v-if="configuration.type === 'date'" class="form-control">
                                   <input type="time" v-model="configuration.time" v-if="configuration.type === 'time'" class="form-control">
                                   <input type="datetime" v-model="configuration.datetime" v-if="configuration.type === 'datetime'" class="form-control">
                                   <input type="checkbox" v-model="configuration.boolean" v-if="configuration.type === 'boolean'">
                                   <select class="form-control" v-model="configuration.image" v-if="configuration.type === 'image'">
                                       <option v-for="image in images" v-bind:value="image.id">@{{  image.name }}</option>
                                   </select>
                               </div>
                               <button class="btn btn-primary" v-on:click="saveConfiguration(configuration)" type="button">{{__('save')}}</button>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>

@endsection

@section('new_scripts')
    <script>
        var vue_configuration = new Vue({
            el: '#table_configuration',
            data: {
                configurations   : @json($configurations->all()),
                images : []
            },
            methods:{
                remove_method : function removeItemOnce(arr, value) {
                    const index = arr.indexOf(value);
                    if (index > -1) arr.splice(index, 1);
                    return arr;
                },
                saveConfiguration : function (configuration){
                    $.ajax(location.origin+"/configuration", {
                        method: 'POST',
                        data: configuration,
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        xhr: ()=> {
                            let xhr = new XMLHttpRequest();
                            xhr.upload.onprogress = (e) => {
                                let percent = Math.round((e.loaded / e.total) * 100) -2;
                                document.getElementById('progress_nav').style.width = percent + '%';
                            };
                            return xhr;
                        },
                        success: (success) => {
                            Swal.fire({
                                icon: 'success',
                                title: '@json(getConfiguration('text', 'GUARDADO'))',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        },
                        error: (error)=> {
                            Swal.fire({
                                title: 'Error!',
                                text: @json(getConfiguration('text', 'NO-GUARDO')),
                                icon: 'error',
                                confirmButtonText: @json(getConfiguration('text', 'ACEPTAR'))
                            })
                        },
                        complete : ()=>{
                            document.getElementById('progress_nav').style.width = '0%';
                        }
                    });
                },
                addConfiguration : function(key){
                    this.configurations[key].unshift({
                        'id'        :   (new Date()).getTime(),
                        'name'      :   '',
                        'type'      :  key,
                        'text'      :   '',
                        'number'    :   0,
                        'date'      :   null,
                        'time'      :   null,
                        'datetime'  :   null,
                        'boolean'   :   false,
                        'image'     :   null,
                        'exists'    :   false
                    });
                },
                removeConfiguration : function (configuration, key){
                    Swal.fire({
                        title: @json(getConfiguration('text', 'ESTA-SEGURO')),
                        text: @json(getConfiguration('text', 'NO-REVERSIBLE')),
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: 'var(--confirm, var(--confirm, #3085d6))',
                        cancelButtonColor: 'var(--cancel, #d33)',
                        confirmButtonText: @json(getConfiguration('text', 'CONFIRMACION-ELIMINAR'))
                    }).then((result) => {
                        if (result.value) {
                            if(!configuration.exists){
                                this.remove_method(this.configurations[key], configuration);
                            }else{
                                $.ajax(location.origin+"/configuration/delete", {
                                    method: 'POST',
                                    data: configuration,
                                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                    xhr: ()=> {
                                        let xhr = new XMLHttpRequest();
                                        xhr.upload.onprogress = (e) => {
                                            let percent = Math.round((e.loaded / e.total) * 100) -2;
                                            document.getElementById('progress_nav').style.width = percent + '%';
                                        };
                                        return xhr;
                                    },
                                    success: (success) => {
                                        this.remove_method(this.configurations[key], configuration);
                                    },
                                    error: (error)=> {
                                        Swal.fire({
                                            title: 'Error!',
                                            text: NO_ELIMINO,
                                            icon: 'error',
                                            confirmButtonText: @json(getConfiguration('text', 'ACEPTAR'))
                                        })
                                    },
                                    complete : ()=>{
                                        document.getElementById('progress_nav').style.width = '0%';
                                    }
                                });
                            }
                        }
                    })
                },
            }
        });
    </script>
@endsection
