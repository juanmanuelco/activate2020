@extends('layouts.app')
@section('content')
    @php
        $images = \App\Models\ImageFile::where('owner', \Illuminate\Support\Facades\Auth::id())->select('id', 'extension', 'name')->orderBy('id', 'desc')->limit(1000)->get();
    @endphp
    <div class="text-justify" style="margin-top: 30px">
        <h1>{{__('param_config')}}</h1>
        <p>{{__('config_detail')}}</p>
        <hr>
    </div>
    <div class="row" >
        <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12" id="table_configuration">
            @include('includes.search')
            <div class="table table-responsive" >
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th colspan="2">
                            <button class="btn btn-success" v-on:click="addConfiguration()"><i class="fa fa-plus"></i></button>
                        </th>
                        <th>{{__('Name')}}</th>
                        <th>{{__('type')}}</th>
                        <th>{{__('value')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="configuration in configurations">
                            <td>
                                <button type="button" class="btn btn-danger" v-on:click="removeConfiguration(configuration)"><i class="fa fa-trash"></i></button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary" v-on:click="saveConfiguration(configuration)"><i class="fa fa-save"></i></button>
                            </td>
                            <td>
                                <input class="form-control" type="text" v-model="configuration.name" :readonly="configuration.exists">
                            </td>
                            <td>
                                <select class="form-control" v-model="configuration.type">
                                    <option v-for="type in types" v-bind:value="type.type" :selected="configuration.type === type.type">@{{ type.text }}</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" v-model="configuration.text" v-if="configuration.type === 'text'" class="form-control">
                                <input type="color" v-model="configuration.text" v-if="configuration.type === 'color'" class="form-control">
                                <input type="double" v-model="configuration.number" v-if="configuration.type === 'number'" class="form-control">
                                <input type="date" v-model="configuration.date" v-if="configuration.type === 'date'" class="form-control">
                                <input type="time" v-model="configuration.time" v-if="configuration.type === 'time'" class="form-control">
                                <input type="datetime" v-model="configuration.datetime" v-if="configuration.type === 'datetime'" class="form-control">
                                <input type="checkbox" v-model="configuration.boolean" v-if="configuration.type === 'boolean'">
                                <select class="form-control" v-model="configuration.image" v-if="configuration.type === 'image'">
                                    <option v-for="image in images" v-bind:value="image.id">@{{  image.name }}</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div style="width: 100%;">
                    {{ $configurations->links() }}
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
            @include('includes/images')
        </div>
    </div>
@endsection

@section('new_scripts')
    <script>
        var vue_configuration = new Vue({
            el: '#table_configuration',
            data: {
                configurations   : @json($configurations->all()),
                types           :   [
                    {'type':'text'      ,   'text' : 'Texto'},
                    {'type':'number'    ,   'text' : 'Número'},
                    {'type':'date'      ,   'text' : 'Fecha'},
                    {'type':'time'      ,   'text' : 'Hora'},
                    {'type':'datetime'  ,   'text' : 'Fecha y hora'},
                    {'type':'boolean'   ,   'text' : 'Boleano'},
                    {'type':'image'     ,   'text' : 'Imágen'},
                    {'type':'color'     ,   'text' : 'Color'},
                ],
                images : image_component.images
            },
            methods:{
                addConfiguration : function(){
                    this.configurations.unshift({
                        'id'        :   (new Date()).getTime(),
                        'name'      :   '',
                        'type'      :   this.types[0].type,
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
                removeConfiguration : function (configuration){
                    if(!configuration.exists){
                        this.remove_method(this.configurations, configuration);
                    }else{
                        Swal.fire({
                            title: @json(getConfiguration('text', 'ESTA-SEGURO')),
                            text: @json(getConfiguration('text', 'NO-REVERSIBLE')),
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: 'var(--confirm, var(--confirm, #3085d6))',
                            cancelButtonColor: 'var(--cancel, #d33)',
                            confirmButtonText: @json(getConfiguration('text', 'CONFIRMACION-ELIMINAR'))
                        }).then((result) => {
                            this.variation_list = [];
                            if (result.value) {
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
                                        this.remove_method(this.configurations, configuration);
                                    },
                                    error: (error)=> {
                                        Swal.fire({
                                            title: 'Error!',
                                            text: NO_ELIMINO,
                                            icon: 'error',
                                            confirmButtonText: 'Aceptar'
                                        })
                                    },
                                    complete : ()=>{
                                        document.getElementById('progress_nav').style.width = '0%';
                                    }
                                });
                            }
                        })
                    }
                },
                saveConfiguration : function (configuration) {
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
                            console.log(success)
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
                                confirmButtonText: 'Aceptar'
                            })
                        },
                        complete : ()=>{
                            document.getElementById('progress_nav').style.width = '0%';
                        }
                    });
                },
                remove_method : function removeItemOnce(arr, value) {
                    const index = arr.indexOf(value);
                    if (index > -1) arr.splice(index, 1);
                    return arr;
                },
            }
        });
    </script>
@endsection
