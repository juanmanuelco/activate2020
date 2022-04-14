@extends('layouts.app')
@section('custom_styles')
    <link rel="stylesheet" href="{{asset('css/home.css')}}">
@endsection
@section('content')

<div id="billing_table">

    <div class="row">
        <div class="col-lg-4">
            <h3 class="center" style="margin-top: 50px; margin-bottom: 50px">Generar venta</h3>

            <table class="table">
                <tr>
                    <th>Cantidad</th>
                    <th>Producto</th>
                    <th>Val. Unitario</th>
                    <th>Valor Total</th>
                    <th>Eliminar</th>
                </tr>
                <tr v-for="product in products_to_sell">
                    <td><input type="number" min="1" step="1" v-model="product.selected"></td>
                </tr>
            </table>

        </div>
        <div class="col-lg-8">
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
                    <th>Seleccionar</th>
                </tr>
                <tr v-for="product in products.data">
                    <td>@{{ product.code }}</td>
                    <td><img :src="product.image.permalink"  width="100px" v-if="product.image != null"></td>
                    <td>@{{ product.quantity }}</td>
                    <td>
                        <h5>@{{ product.name }}</h5>
                        <p v-html="product.description"></p>
                    </td>
                    <td>$@{{ product.price }}</td>
                    <td>
                        <button class="btn btn-primary" v-on:click="addProduct(product)">Añadir</button>
                    </td>
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
                products_to_sell : []
            },
            created(){
                this.fillProducts("");
            },
            methods :{
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
                        let copyProduct = {'id' : product.id, 'code' : product.code , 'name': product.name, 'price': product.price, 'selected': 1};
                        this.products_to_sell.push(copyProduct);
                    }else{
                        found.selected++;
                    }
                }
            }
        });
    </script>
@endsection
