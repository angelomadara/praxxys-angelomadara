<template>
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Create Products</h1>
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
                    <button type="button" class="btn btn-primary" v-on:click="createProduct">Save New Product</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import datetime from 'vuejs-datetimepicker'
export default {
    props: ['categories'],
    components: {
        datetime
    },
    data(){
        return {
            product: {
                name: '',
                description: '',
                category: '',
                image: '',
                _datetime: '',
            },
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
        createProduct(){
            let formData = new FormData();
            formData.append('name', this.product.name);
            formData.append('description', this.product.description);
            formData.append('category', this.product.category);
            formData.append('image',  document.querySelector('input[type=file]').files[0]);
            formData.append('_datetime', this.product._datetime);

            axios.post('/api/products/store', formData).then(response => {
                if(response.data.status == 'success'){
                    location.href = `/products`
                    // Swal.mixin({
                    //     toast: true,
                    //     position: 'top-end',
                    //     showConfirmButton: false,
                    //     timer: 3000,
                    //     timerProgressBar: true,
                    //     didOpen: (toast) => {
                    //         toast.addEventListener('mouseenter', Swal.stopTimer)
                    //         toast.addEventListener('mouseleave', Swal.resumeTimer)
                    //     }
                    // }).fire({
                    //     icon: 'success',
                    //     title: 'Signed in successfully'
                    // })
                    // this.step = 1;
                    // this.product = {
                    //     name: '',
                    //     description: '',
                    //     category: '',
                    //     image: ''
                    // }
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
