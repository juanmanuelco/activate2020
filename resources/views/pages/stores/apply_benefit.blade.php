@extends('layouts.app')
@section('content')

    <div id="id_apply_benefit" style="padding-top:20px">
        <div class="row">
            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li :class="'nav-item ' + (active != null && store.id === active.id ? 'active' : '')" role="presentation" v-for="store in stores">
                        <button v-on:click="selectStore(store)":class="'nav-link ' + (active != null && store.id === active.id ? 'active' : '')" :id="'tab-store-' + store.id" data-bs-toggle="tab" :data-bs-target="'#tab_' + store.id" type="button" role="tab">
                            <div class="tab-image" v-bind:style="{ 'background-image': 'url(' + '/images/system/' + store.image.id + '.' + store.image.extension + ')' }" >

                            </div>
                            <p style="padding-top:20px">@{{ store.name }}</p>
                        </button>
                    </li>

                </ul>

                <div class="tab-content" style="overflow-y: scroll; max-height: 600px">
                    <div v-for="store in stores" :class="'tab-pane fade ' + (active != null && store.id === active.id ? 'show active' : '')" :id="'#tab_' + store.id" role="tabpanel" :aria-labelledby="'tab-store-' + store.id">
                        <div class="card" style="margin: 10px" v-for="benefit in store.benefits">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="tab-image-benefit" v-bind:style="{ 'background-image': 'url(' + '/images/system/' + benefit.image.id + '.' + benefit.image.extension + ')' }" >

                                        </div>
                                        <div style="text-align: center">
                                            @{{benefit.unlimited ? 'Usos ilimitados' : 'Un único uso' }}
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <h5>{{__('Benefit')}}</h5>
                                        <div>
                                            @{{benefit.name}}
                                        </div>
                                        <hr>
                                        <h5>{{__('Restrictions')}}</h5>
                                        <div>
                                            @{{benefit.restriction}}
                                        </div>
                                        <div style="text-align: right">
                                            <button class="btn btn-outline-primary" v-on:click="selectBenefit(benefit)">{{__('Select to apply')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
               <h3 style="text-align: center"> {{__('Apply Benefit')}}</h3>

                <div style="text-align: center; padding:25px">
                    <img class="card-image" v-if="active_card != null" :src="'/images/system/' + active_card.image.id + '.' + active_card.image.extension" alt="">
                </div>

                <div class="form-group">
                    <label for=""><strong>{{__('Card')}}</strong></label>
                    <select name="" class="form-control" id="card_select" v-on:change="selectCard()">
                        <option v-for="card in cards" :value="card.id">@{{ card.name }}</option>
                    </select>
                </div>

                <div class="form-group" >
                    <label for=""><strong>{{__('Benefit to apply')}}</strong></label>
                    <textarea class="form-control" type="text" v-if="active_benefit != null" disabled="" v-model="active_benefit.name"></textarea>
                    <p v-if="active_benefit == null"  style="padding-left: 15px">{{__('None selected')}}</p>
                </div>

                <div class="form-group">
                    <label for=""><strong>{{__('Card number')}}</strong></label>
                    <input class="form-control" v-model="card_number" type="number" min="0" step="1">
                </div>
                <div class="form-group">
                    <button v-on:click="applyBenefit()" :disabled="active_benefit == null" type="button" class="btn btn-primary btn-block">{{__('Apply benefit')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('image_vue')
    <script>
        //console.log('@json($cards)');
        var image_component = new Vue({
            el: '#id_apply_benefit',
            data: {
                stores : @json($stores),
                active : null,
                cards : @json($cards),
                active_card : null,
                active_benefit : null,
                card_number : 0
            },
            beforeMount() {
                this.active = this.stores[0];
                this.active_card = this.cards[0];
            },
            methods :{
                selectStore : function (store) {
                    this.active = store;
                },
                selectCard : function (card){
                    let select = document.getElementById('card_select').selectedIndex;
                    this.active_card = this.cards[select];
                },
                selectBenefit : function(benefit){
                    this.active_benefit = benefit;
                },
                applyBenefit : function(){
                    if(this.card_number === 0 || this.card_number.length === 0) {
                        alert('Añadir un número de tarjeta para continuar')
                        return;
                    }
                    Swal.fire({
                        title: '¿Estas seguro(a)?',
                        text: "Este cambio no se podrá revertir",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: 'var(--confirm, var(--confirm, #3085d6))',
                        cancelButtonColor: 'var(--cancel, #d33)',
                        confirmButtonText: '¡Si, aplicar beneficio!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let url = location.origin + '/apply-benefits/';
                            let body = { 'card' : this.active_card.id, 'benefit' : this.active_benefit.id, 'number' : this.card_number };
                            let callback =()=>{
                                this.active_benefit = null;
                                this.card_number = 0;
                            };
                            loading('', url, 'POST', body, true, callback );
                        }
                    });
                }
            }
        });
    </script>
    <style>
        .tab-image{
            height: 50px;
            width: 80px ;
            background-repeat: no-repeat;
            background-size: cover;
        }
        .tab-image-benefit{
            height: 150px;
            width: 100% ;
            background-repeat: no-repeat;
            background-size: cover;
        }
        .card-image{
            width: 60% ;
            border-radius: 25px;
            background-position: center center;
        }
    </style>
@endsection
