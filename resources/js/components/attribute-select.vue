<template>
    <div class="attributes-select-wrap card">
        <table v-if="hasAttributes" class="table">
            <thead>
            <tr>
                <th scope="col">#ID</th>
                <th scope="col">Name</th>
                <th scope="col">Type</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in attributes">
                <th scope="row">{{item.id}}</th>
                <td>{{item.name}}</td>
                <td>{{item.type}}</td>
                <td><a href="#" v-on:click.prevent="deleteAttribute" :data-id="item.id">Delete</a></td>
            </tr>
            </tbody>
        </table>
        <h2>Add new attribute</h2>
        <form class="card-body" v-on:submit.prevent="addNewAttribute">
            <div class="form-group row">
                <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" v-model="name" id="inputName" placeholder="">
                </div>
            </div>
            <div class="form-group row">
                <label for="type">Select Type</label>
                <select class="form-control" id="type" v-model="type">
                    <option value="0">Select</option>
                    <option v-for="item in attributeTypes" :value="item.type">
                        {{item.name}}
                    </option>
                </select>
            </div>
            <div class="form-group row">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary">Add</button>
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
        name: "attribute-select",
        props: {
            productTypeId: {
                type: Number,
                default: false,
            },
            attributeTypes: {
                type: Array,
                default: [],
            },
        },
        data(){
            return {
                name: '',
                type: 0,
                attributes: [],
                error: '',
            };
        },
        created: function () {
            this.getAttributes();
        },
        methods: {
            addNewAttribute(){
                axios.post('/api/attributes/store', {
                    name: this.name,
                    productTypeId: this.productTypeId,
                    type: this.type
                })
                    .then((response)=>{
                        this.error = '';
                        this.attributes.unshift({
                            name: response.data.data.name,
                            type: response.data.data.type,
                            id: response.data.data.id,
                        });
                        this.name = '';
                        this.type = 0;
                    })
                    .catch((error)=>{
                        console.log(error);
                        this.error = error.message;
                    })
            },
            getAttributes(){
                axios.get('/api/attributes', {
                    params: {
                        productTypeId: this.productTypeId
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
            deleteAttribute(event){
                let attributeId = parseInt(event.target.dataset.id);
                console.log(attributeId);
                axios.delete('/api/attributes', {
                    params: {
                        productTypeId: this.productTypeId,
                        attributeId: attributeId,
                    }
                })
                    .then((response)=>{
                        this.error = '';
                        if(response.data.status){
                            this.attributes = this.attributes.filter(x=> x.id !== attributeId);
                        } else {
                            this.error = response.data.error;
                        }
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
