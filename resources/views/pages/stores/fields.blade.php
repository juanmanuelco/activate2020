
<div class="row">
    <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            {!! Form::label('name', __('Name')); !!}
            {!! Form::text('name',old('name'), ['class'=> 'form-control', 'required'=> true]); !!}
            <small id="nameHelp" class="form-text text-muted">{{__('name_help')}}</small>
        </div>

        <div class="form-group">
            {!! Form::label('description', __('Description')); !!}
            {!! Form::textarea('description',old('description'), ['class'=> 'form-control', 'required'=> true, 'rows' => 3]); !!}
            <small id="nameHelp" class="form-text text-muted">{{__('description_help')}}</small>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    {!! Form::label('facebook', __('Facebook')); !!}
                    {!! Form::text('facebook',old('facebook'), ['class'=> 'form-control']); !!}
                </div>

                <div class="form-group">
                    {!! Form::label('instagram', __('Instagram')); !!}
                    {!! Form::text('instagram',old('instagram'), ['class'=> 'form-control']); !!}
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    {!! Form::label('web_page', __('Web page')); !!}
                    {!! Form::text('web_page',old('web_page'), ['class'=> 'form-control']); !!}
                </div>

                <div class="form-group">
                    {!! Form::label('phone', __('Phone')); !!}
                    {!! Form::text('phone',old('phone'), ['class'=> 'form-control', 'rel' =>'tel']); !!}
                </div>
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('category', __('Category')); !!}
            {!! Form::select('category',$categories,null, ['class'=> 'form-control']); !!}
            <small id="nameHelp" class="form-text text-muted">{{__('category_help')}}</small>
        </div>

        <div class="form-group">
            {!! Form::label('owner', __('Owner')); !!}
            {!! Form::select('owner',$owners,null, ['class'=> 'form-control', 'required' =>true]); !!}
            <small id="nameHelp" class="form-text text-muted">{{__('owner_help')}}</small>
        </div>



        <div class="form-group">

            {!! Form::label('schedule', __('Schedule')); !!}
            <div id="schedule">
                @if(!empty($store))
                    {!! $store->schedule !!}
                @endif
            </div>
            <input type="hidden" id="desc_schedule" name="schedule" value="{{ empty($store) ? '' : $store->schedule  }}">

        </div>


        <hr>
        <div id="branch_container">
            <h2><button v-on:click="addBranch()" type="button" class="btn btn-primary"> <i class="fa fa-plus"></i> </button> {{__('Branches')}} </h2>
            <hr>
            <table class="table">
                <thead>
                <tr>
                    <td>{{__('Name')}}</td>
                    <td>{{__('Latitude')}}</td>
                    <td>{{__('Longitude')}}</td>
                    <td>{{__('Option')}}</td>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="branch in branches" :key="branch.id">
                        <td><input class="form-control" type="text" v-model:id="branch.name" required></td>
                        <td><input class="form-control" type="number" step="0.000000000000000001" required v-model:id="branch.latitude"></td>
                        <td><input class="form-control" type="number" step="0.000000000000000001" required v-model:id="branch.longitude"></td>
                        <td>
                            <button class="btn btn-danger" v-on:click="removeBranch(branch.id, branch.exists)" type="button">
                                <i class="fa fa-trash"> </i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <input type="hidden" name="branches" v-model="this.jsonBranches()">
        </div>

    </div>
    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
        @include('includes.images')
    </div>
</div>

@section('new_scripts')
    <script>
        let quill = new Quill('#schedule', {
            theme: 'snow',
            modules: {
                toolbar: quill_toolbar
            }
        });
        quill.on('editor-change', function(eventName, ...args) {
            document.getElementById('desc_schedule').value = document.getElementById('schedule').getElementsByClassName('ql-editor')[0].innerHTML;
            if(document.getElementById('desc_schedule').value == '<p><br></p> '){
                document.getElementById('desc_schedule').value = '' ;
            }
        });
    </script>
    <script>
        let val = false;
        let selected = document.getElementById('owner').getElementsByTagName('option');
        for(let i=0; i < selected.length; i++){
            if(selected[i].getAttribute('selected')) val= true;
        }
        if(!val)   document.getElementById('owner').selectedIndex = -1;


        val = false;
        selected = document.getElementById('category').getElementsByTagName('option');
        console.log(selected)
        for(let i=0; i < selected.length; i++){
            if(selected[i].getAttribute('selected')) val= true;
        }
        if(!val)   document.getElementById('category').selectedIndex = -1;


        var branch_container = new Vue({
            el: '#branch_container',
            data: {
                branches : @json(isset($object) ? $object->branchesJson() : [] )
            },
            methods :{
                addBranch : function () {
                    this.branches.push({
                        'id': (new Date()).getMilliseconds(),
                        'name': '',
                        'latitude' : 0,
                        'longitude' : 0,
                        'exists' : false
                    })
                },
                jsonBranches : function(){
                    return JSON.stringify(this.branches);
                },
                deleteBranch : function(branch){
                    this.branches = this.branches.filter((value, index, arr)=>{
                        return value.id !== branch;
                    });
                },
                removeBranch : function (branch, exists) {
                    if(exists){
                        console.log(location.origin+'/branch/' + branch);
                        $.ajax(location.origin+'/branch/' + branch, {
                            method: 'DELETE',
                            data: {'id' : branch},
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            processData: false,
                            contentType: false,
                            xhr: ()=> {
                                var xhr = new XMLHttpRequest();
                                xhr.upload.onprogress = (e) => {
                                    let percent = Math.round((e.loaded / e.total) * 100);
                                    document.getElementById('progress_nav').style.width = percent + '%';
                                };
                                return xhr;
                            },
                            success: (success) => {
                                this.deleteBranch(branch);
                            },
                            error: (error)=> {
                                document.getElementById('progress_nav').style.width = '100%';
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: JSON.parse(error.responseText).message
                                })
                            },
                            complete: ()=> {
                                document.getElementById('progress_nav').style.width =  '0%';
                            }
                        });
                    }else {
                        this.deleteBranch(branch);
                    }
                },
            }
        });


    </script>
@endsection

