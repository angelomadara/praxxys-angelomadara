<template>
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Update Product</h1>
        </div>

        <form class="row">
            <div class="col-4" v-show="step == 1">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Name" v-model="product.name">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" rows="3" v-model="product.description"></textarea>
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <select class="form-control" id="category" v-model="product.category">
                        <option selected value=""></option>
                        <option v-for="(category, index) in $data._categories" :key="index" :value="category.name">{{ category.name }}</option>
                    </select>
                </div>

                <div class="m-4">
                    <button type="button" class="btn btn-primary" @click="validateFirstStep">Next</button>
                </div>
            </div>

            <div class="col-4" v-show="step == 2">
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" class="form-control-file" id="image" v-on:change="onFileChange">
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <img :src="product.image" class="img-fluid" alt="">
                </div>

                <div class="m-4">
                    <button type="button" class="btn btn-primary" @click="validateSecondStep">Next</button>
                </div>
            </div>

            <div class="col-4" v-show="step == 3">
                <div class="form-group">
                    <label for="image">Image</label>
                    <datetime format="MM/DD/YYYY h:i:s" width="300px" v-model="product._datetime"/>
                </div>

                <div class="mt-4">
                    <button type="button" class="btn btn-primary" v-on:click="updateProduct">Update Product</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import datetime from 'vuejs-datetimepicker'
export default {
    props: ['categories','item'],
    components: {
        datetime
    },
    data(){
        return {
            product: JSON.parse(this.item),
            step: 1,
            _categories: JSON.parse(this.categories)
        }
    },
    methods: {
        onFileChange(e){
            let file = e.target.files[0];
            let reader = new FileReader();
            reader.onload = (e) => {
                this.product.image = e.target.result;
            }
            reader.readAsDataURL(file);
        },
        updateProduct(){
            let formData = new FormData();
            formData.append('name', this.product.name);
            formData.append('description', this.product.description);
            formData.append('category', this.product.category);
            formData.append('image',  document.querySelector('input[type=file]').files[0]);
            formData.append('_datetime', this.product._datetime);

            axios.post(`/api/products/update/${this.product.id}`, formData).then(response => {
                if(response.data.status == 'success'){
                    location.href = `/products`
                }
            }).catch(error => {
                console.log(error);
            })
        },
        validateFirstStep(){
            if(this.product.name == '' || this.product.description == '' || this.product.category == ''){
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Please fill all fields'
                })
            }else{
                this.step = 2;
            }
        },
        validateSecondStep(){
            if(this.product.image == ''){
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Please upload an image'
                })
            }else{
                this.step = 3;
            }
        }
    }
}
</script>

<style>

</style>
