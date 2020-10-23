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
            <div class="accordion" id="configuration_items">
                <div class="card">
                    <div  v-for="(value, key) in configurations">
                        <div class="card-header" data-toggle="collapse" :data-target="'#'+key" aria-expanded="false" style="cursor: pointer">
                           <h6><strong>@{{ key.toUpperCase() }}</strong></h6>
                        </div>
                        <div :id="key" class="collapse" aria-labelledby="headingOne" data-parent="#configuration_items" style="padding-left:5px; padding-right: 5px">
                           <div class="row">
                               <div class="col-lg-4 col-sm-12 col-md-6 col-xs-12" v-for="configuration in value">
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
                                      </div>
                                  </div>
                               </div>
                           </div>
                        </div>
                    </div>
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
                remove_method : function removeItemOnce(arr, value) {
                    const index = arr.indexOf(value);
                    if (index > -1) arr.splice(index, 1);
                    return arr;
                },
                removeConfiguration : function (configuration, key) {

                }
            }
        });
    </script>
@endsection
