@extends('layouts.app')
@section('content')
    @include('includes.search')
    <div class="table table-responsive" style ="text-align: left">
        @foreach($cards as $card)
            <div>

                <div class="alert-primary" style="padding:10px">
                    @if(!empty($card->getImage()))
                        <img width="100px" src="<?php echo  '/images/system/' . $card->getImage()->id . '.' . $card->getImage()->extension ?>" alt="<?php echo $card->getImage()->name ?>">
                    @endif
                    {{$card->name}}
                </div>

                <div id="accordion">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseAssigned" aria-expanded="true" aria-controls="collapseAssigned">
                                    <i class="fa fa-chevron-down"></i> {{__('Assigned to seller')}}
                                </button>
                            </h5>
                        </div>
                        <div id="collapseAssigned" class="collapse" aria-labelledby="collapseAssigned" data-parent="#collapseAssigned">
                            <div class="card-body">
                                <div class="flex" style="margin-left: 20px; overflow-y: scroll; max-height: 550px">
                                    <div class="card" style="margin: 5px" v-for="assignment in with_seller.data">
                                        <div class="card-body">
                                            <p>
                                                <strong>{{__('Number')}} :</strong> <small>@{{ assignment.number }}</small>
                                            </p>
                                            <p>
                                                <strong>{{__('Assigned to')}} :</strong> <small :id="'assigned_to_' + assignment.id">@{{ assignment.seller.name }}</small>
                                            </p>

                                            <small><strong>{{__('Change assignment')}}</strong></small>


                                            <div class="form-group">
                                                <select name="" :id="'select_assignated_' + assignment.id" class="form-control">
                                                    <option value="0" >{{__('Set as free')}}</option>
                                                    <option v-for="seller in sellers " :value="seller.id" :selected="assignment.seller.id == seller.id">@{{ seller.name }}</option>
                                                </select>

                                            </div>

                                            <div :id="'qr_assignment_' + assignment.id">

                                            </div>

                                            <div class="form-group" style="float: right">
                                                <button class="btn btn-outline-primary" v-on:click="change_assignment_card(assignment)">{{__('Save')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <li v-for="link in with_seller.links" class="page-item">
                                            <button class="page-link" v-on:click="fillAssignments(0, link.url)" v-html="link.label"></button>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapsefree" aria-expanded="true" aria-controls="collapsefree">
                                    <i class="fa fa-chevron-down"></i>  {{__('Without seller')}}
                                </button>
                            </h5>
                        </div>
                        <div id="collapsefree" class="collapse" aria-labelledby="collapsefree" data-parent="#collapsefree">
                            <div>
                                <div class="flex" style="margin-left: 20px; overflow-y: scroll; max-height: 550px">
                                    <div class="card" style="margin: 5px" v-for="assignment in free_seller.data">
                                        <div class="card-body">
                                            <p>
                                                <strong>{{__('Number')}} :</strong> <small>@{{ assignment.number }}</small>
                                            </p>
                                            <small><strong>{{__('Change assignment')}}</strong></small>
                                            <div class="form-group">
                                                <select name="" :id="'select_assignated_' + assignment.id" class="form-control">
                                                    <option value="0" >{{__('Set as free')}}</option>
                                                    <option v-for="seller in sellers " :value="seller.id">@{{ seller.name }}</option>
                                                </select>
                                            </div>
                                            <div :id="'qr_assignment_' + assignment.id"></div>

                                            <div class="form-group" style="float: right">
                                                <button class="btn btn-outline-primary" v-on:click="change_assignment_card(assignment)">{{__('Save')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="margin: 20px">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination">
                                            <li v-for="link in free_seller.links" v-bind:class="['page-item', link.active ? 'active' : '']">
                                                <button class="page-link" v-on:click="fillAssignments(1, link.url)" v-html="link.label"></button>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        @endforeach
    </div>
    <div style="width: 100%;">
        {{ $cards->links() }}
    </div>
@endsection

@section('new_scripts')
    <script src="{{asset('js/qrcode.js')}}"></script>
    <script>
        var accordion = new Vue({
            el: '#accordion',
            data: {
                with_seller : [],
                free_seller : [],
                current_card : @json($card->id),
                sellers : @json($sellers)
            },
            created(){
                this.fillAssignments(1, "");
                this.fillAssignments(0, "");
            },
            methods :{
                fillAssignments : function (free, uri){
                    if(uri === ""){
                        uri = location.origin + '/card/assignments/' + this.current_card + '?free=' + free;
                    }
                    uri = uri + "&free=" + free;
                    if(free){
                        this.free_seller = [];
                    }else{
                        this.with_seller = [];
                    }

                    fetch(uri)
                        .then(response => response.json()).then((data)=>{
                            if(free){
                                this.free_seller = data;
                            }else{
                                this.with_seller = data;
                            }
                        }).catch((error)=>{
                            console.log(error)
                    }).finally(()=>{
                        if(free){
                            for(let i = 0; i < this.free_seller.data.length; i++ ){
                                new QRCode(document.getElementById("qr_assignment_" + this.free_seller.data[i].id), {
                                    text : this.free_seller.data[i].code,
                                    width: 100,height: 100,
                                    correctLevel : QRCode.CorrectLevel.H
                                })
                            }
                        }else{
                            for(let j = 0; j < this.with_seller.data.length; j++ ){
                                new QRCode(document.getElementById("qr_assignment_" + this.with_seller.data[j].id), {
                                    text : this.with_seller.data[j].code,
                                    width: 100,height: 100,
                                    correctLevel : QRCode.CorrectLevel.H
                                })
                            }
                        }
                    });
                },
                change_assignment_card : function(assignment){
                    let id = assignment.id;
                    Swal.fire({
                        title: '¿Estas seguro(a)?',
                        text: "Otro vendedor tendrá la asignación",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: 'var(--confirm, var(--confirm, #3085d6))',
                        cancelButtonColor: 'var(--cancel, #d33)',
                        confirmButtonText: '¡Si, cambiar!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let new_value = $('#select_assignated_' +id).val();
                            let url = location.origin + '/assignments/' +id;
                            let body = { 'seller' : new_value, 'id' : id };
                            let callback =()=>{

                            };
                            loading('', url, 'PUT', body, true, callback );
                        }
                    });
                }
            }
        });
    </script>
@endsection


