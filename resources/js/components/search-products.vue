<template>
    <div class="attributes-select-wrap card">
        <h2>Product type</h2>
        <form class="card-body" v-on:submit.prevent="selectProductType">
            <div class="form-group row">
                <label for="type">Select Product Type</label>
                <select class="form-control" id="type" v-on:change="updateFilters" v-model="productType">
                    <option :value="0">Select</option>
                    <option v-for="item in productTypes" :value="item.id">
                        {{item.name}}
                    </option>
                </select>
            </div>
            <div class="form-group row">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary">Show filters</button>
                </div>
            </div>
        </form>
        <div class="card-body">
            <table class="table" v-if="hasAttributes">
                <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Value</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item, index) in attributes">
                    <td>{{item.name}}</td>
                    <td>
                        <template v-if="item.type === 'string'">
                            <input v-model="item.value" type="text" :key="index">
                        </template>
                        <template v-else-if="item.type === 'integer'">
                            <input v-model="item.value" type="number" :key="index">
                        </template>
                        <template v-else-if="item.type === 'float'">
                            <input v-model="item.value" type="text" :key="index">
                        </template>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="form-group row">
                <div class="col-sm-12">
                    <button type="submit" v-on:click.prevent="searchProducts" class="btn btn-primary">Search</button>
                </div>
            </div>
        </div>
        <div v-if="error.length" class="alert alert-danger" role="alert">
            {{error}}
        </div>
        <table v-if="hasProducts" class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Product Name</th>
                <th scope="col">Product Sku</th>
                <th scope="col">Type Data</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(product, index) in products">
                <th scope="row">{{index+1}}</th>
                <td>{{product.name}}</td>
                <td>{{product.sku}}</td>
                <td>
                    <p v-for="data in product.data">{{data.name}}: {{data.value}}</p>
                </td>
            </tr>
            </tbody>
        </table>

    </div>
</template>

<script>
    export default {
        name: "search-products",
        data(){
            return {
                productTypes: [],
                productType: 0,
                attributes: [],
                products: [],
                error: '',
            };
        },
        created: function () {
            this.getProductTypes();
        },
        methods: {
            getProductTypes(){
                axios.get('/api/productTypes')
                    .then((response)=>{
                        this.error = '';
                        this.productTypes = response.data.data;
                    })
                    .catch((error)=>{
                        console.log(error);
                        this.error = error.message;
                    })
            },
            selectProductType(){
                if(!this.productType){
                    this.error = 'Select product type';
                    return;
                }
                axios.get('/api/attributes', {
                    params: {
                        productTypeId: this.productType
                    }
                })
                    .then((response)=>{
                        this.error = '';
                        this.attributes = response.data.data;
                    })
                    .catch((error)=>{
                        console.log(error);
                        this.error = error.message;
                    })
            },
            searchProducts(){
                axios.post('/api/products/search', {
                    productAttributes: this.attributes,
                    productTypeId: this.productType,
                })
                    .then((response)=>{
                        this.error = '';
                        this.products = response.data.data;
                    })
                    .catch((error)=>{
                        console.log(error);
                        this.error = error.message;
                    })
            },
            updateFilters(){
                if(this.productType === 0){
                    this.attributes = [];
                }
            },
        },
        computed: {
            hasAttributes(){
                return this.attributes.length > 0;
            },
            hasProducts(){
                return this.products.length > 0;
            },
        },
    }
</script>
