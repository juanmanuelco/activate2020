@extends('layouts.app')
@section('custom_styles')
    <link rel="stylesheet" href="{{asset('css/home.css')}}">
@endsection
@section('content')

<div id="billing_table">

    <div class="row">
        <div class="col-lg-5">
            <h3 class="center" style="margin-top: 50px; margin-bottom: 50px">Generar venta <button v-on:click="reload()" class="btn btn-outline-dark"><i class="fa fa-sync"></i></button></h3>
            <div id="table_billing">
                <table class="table" >
                    <thead>
                    <tr>
                        <th>Cantidad</th>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Total</th>
                        <th v-if="edit_mode">Eliminar</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(product, index) in products_to_sell">
                        <td style="width: 100px">
                            <input v-if="edit_mode" class="form-control" type="number" min="1" step="1" v-model="product.selected">
                            <p v-else>@{{ product.selected }}</p>
                        </td>
                        <td>
                            @{{ product.name }}
                        </td>
                        <td style="text-align: right">
                            $@{{ (product.price).toFixed(2) }}
                        </td>
                        <td style="text-align: right">
                            $@{{ (product.price * product.selected).toFixed(2) }}
                        </td>
                        <td v-if="edit_mode">
                            <button class="btn btn-danger" v-on:click="removeProduct(index)">Eliminar</button>
                        </td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td :colspan="edit_mode ? 3 : 2"></td>
                        <td>Subtotal</td>
                        <td style="text-align: right">$@{{ subtotal().toFixed(2) }}</td>
                    </tr>
                    <tr>
                        <td :colspan="edit_mode ? 3 : 2"></td>
                        <td>Descuento %
                            <input v-if="edit_mode" class="form-control" style="width: 100px" type="number" min="0" step="0.01" max="100" v-model="discount">
                            <p v-else>@{{ discount  }}</p>
                        </td>
                        <td style="text-align: right">$@{{ getDiscount().toFixed(2)}}</td>
                    </tr>
                    <tr>
                        <td :colspan="edit_mode ? 3 : 2"></td>
                        <td>Total</td>
                        <td style="text-align: right"><h2>$@{{ (subtotal() + getDiscount() ).toFixed(2) }}</h2></td>
                    </tr>
                    <tr v-if="edit_mode">
                        <td><button class="btn btn-info" v-on:click="printDiv()">Imprimir cotización</button></td>
                        <td><button :disabled="saving" class="btn btn-primary" v-on:click="saveBilling()">Guardar venta</button></td>
                    </tr>
                    <tr v-else>
                        <td><button class="btn btn-outline-info" v-on:click="editBilling()">Editar</button></td>
                    </tr>
                    </tfoot>
                </table>
            </div>


        </div>
        <div class="col-lg-1"></div>
        <div class="col-lg-6">
            <h3 class="center" style="margin-top: 50px; margin-bottom: 50px">Productos</h3>

            <div id="custom-search-input" style="margin-bottom: 10px">
                <div class="input-group col-md-12">
                    <input type="text" class="form-control input-lg" placeholder="Buscar" v-model="search" v-on:keyup="fillProducts('')" />
                    <span class="input-group-btn">
                <button class="btn btn-info btn-lg" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </span>
                </div>
            </div>


            <table class="table">
                <tr>
                    <th>Código</th>
                    <th>Imágen</th>
                    <th>Cantidad</th>
                    <th>Producto</th>
                    <th>Precio</th>
                </tr>
                <tr v-for="product in products.data">
                    <td>
                       <p> @{{ product.code }}</p>
                        <button class="btn btn-primary" v-on:click="addProduct(product)">Añadir</button>
                    </td>
                    <td><img :src="product.image.permalink"  width="100px" v-if="product.image != null"></td>
                    <td>@{{ product.quantity }}</td>
                    <td>
                        <h5>@{{ product.name }}</h5>
                        <p v-html="product.description"></p>
                    </td>
                    <td>$@{{ (product.price).toFixed(2) }}</td>
                </tr>
            </table>
            <div style="margin: 20px" v-if="products.last_page > 1">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li v-for="link in products.links" v-bind:class="['page-item', link.active ? 'active' : '']">
                            <button class="page-link" v-on:click="fillProducts(link.url)" v-html="link.label"></button>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

@endsection
@section('new_scripts')
    <script>
        var billing_table = new Vue({
            el: '#billing_table',
            data: {
                search          :   '',
                products        :   [],
                products_to_sell : [],
                discount : 0,
                edit_mode : true,
                saving : false
            },
            created(){
                this.fillProducts("");
            },

            methods :{
                editBilling : ()=>{
                    billing_table.edit_mode = true;
                },
                subtotal : ()=>{
                    if(billing_table === undefined) return 0;
                    return  billing_table.products_to_sell.reduce((a, b) => a + (b.price * b.selected), 0);
                },
                reload : ()=>{
                    billing_table.products_to_sell = [];
                },
                getDiscount : ()=>{
                    if(billing_table === undefined) return 0;
                    return (billing_table.subtotal() * -1 * billing_table.discount / 100);
                },
                fillProducts : function (uri){
                    if(uri === ""){
                        uri = location.origin + '/products';
                    }
                    if(this.search !== ''){
                        let prefix = uri.includes('?') ? '&' : '?';
                        uri += `${prefix}search=${this.search}`;
                    }
                    this.products = [];
                    fetch(uri).then(response => response.json()).then((data)=>{
                        this.products = data;
                    });
                },
                addProduct : function (product){
                    let found = this.products_to_sell.find(p => product.id === p.id);
                    if(found === undefined){
                        let copyProduct = {
                            'id' : product.id,
                            'code' : product.code ,
                            'name': product.name,
                            'price': product.price,
                            'selected': 1,
                            'image' : product.image,
                            'description': product.description
                        };
                        this.products_to_sell.push(copyProduct);
                    }else{
                        found.selected++;
                    }
                },
                removeProduct : function (index){
                    this.products_to_sell.splice(index, 1);
                },
                printDiv : function (){
                    this.edit_mode = false;
                    setTimeout(()=>{
                        var data=document.getElementById('table_billing').innerHTML;
                        var myWindow = window.open('', 'my div', 'height=800,width=1200');
                        myWindow.document.write('<html><head><title></title>');
                        myWindow.document.write('</head><body >');
                        myWindow.document.write(data);
                        myWindow.document.write('</body></html>');
                        myWindow.document.close();
                        myWindow.onload=function(){
                            myWindow.focus();
                            myWindow.print();
                            myWindow.close();
                        };
                    }, 1500)
                },
                saveBilling: function (){
                    this.saving = true
                    $.ajax('<?php echo route('billing.store') ?>', {
                        method: 'POST',
                        data: {products : this.products_to_sell, discount: this.getDiscount(), subtotal : this.subtotal, total: (this.subtotal() + this.getDiscount() )},
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                    }).then((data)=>{
                        alert('Venta realizada con éxito')
                        this.printDiv();
                        this.saving = false;
                    }).catch((error)=>{
                        console.log(error)
                        this.saving = false;
                    });
                }
            }
        });
    </script>
@endsection
