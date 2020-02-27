<template>
    <div class="attributes-select-wrap card">
        <table v-if="hasAttributes" class="table">
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
                <button type="button" class="btn btn-success" v-on:click.prevent="updateAttributes">Update Attributes</button>
            </div>
        </div>

        <h2>Product type</h2>
        <form class="card-body" v-on:submit.prevent="selectProductType">
            <div class="form-group row">
                <label for="type">Select Product Type</label>
                <select class="form-control" id="type" v-model="productTypeId">
                    <option value="0">Select</option>
                    <option v-for="item in productTypes" :value="item.id">
                        {{item.name}}
                    </option>
                </select>
            </div>
            <div class="form-group row">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary">Select</button>
                </div>
            </div>

        </form>
        <div v-if="error.length" class="alert alert-danger" role="alert">
            {{error}}
        </div>
    </div>
</template>

<script>
    export default {
        name: "product-attributes",
        props: {
            productId: {
                type: Number,
                default: false,
            },
        },
        data(){
            return {
                productTypeId: 0,
                productTypes: [],
                attributes: [],
                error: '',
            };
        },
        created: function () {
            this.getProductType();
            this.getProductTypes();
        },
        methods: {
            getProductType(){
                axios.get('/api/products/getType/'+this.productId)
                    .then((response)=>{
                        this.error = '';
                        if(!!response.data.data.id){
                            this.productTypeId = response.data.data.id;
                            this.getAttributes();
                        }
                    })
                    .catch((error)=>{
                        console.log(error);
                        this.error = error.message;
                    })
            },
            getAttributes(){
                axios.get('/api/products/getAttributes/'+this.productId)
                    .then((response)=>{
                        this.error = '';
                        this.attributes = response.data.data;
                    })
                    .catch((error)=>{
                        console.log(error);
                        this.error = error.message;
                    })

            },
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
                axios.post('/api/products/setType', {
                    productId: this.productId,
                    productTypeId: this.productTypeId
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
            updateAttributes(){
                axios.post('/api/products/updateAttributes/'+this.productId, {
                    productAttributes: this.attributes
                })
                    .then((response)=>{
                        this.error = '';
                    })
                    .catch((error)=>{
                        console.log(error);
                        this.error = error.message;
                    })
            },
        },
        computed: {
            hasAttributes(){
                return this.attributes.length > 0;
            },
        },
    }
</script>