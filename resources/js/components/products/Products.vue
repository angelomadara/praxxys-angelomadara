<template>
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Products</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="row">
                    <div class="col-auto form-group">
                        <input type="text" class="form-control" placeholder="Search" v-model="q" @keyup="getProducts">
                    </div>
                    <div class="col-auto">
                        <label class="visually-hidden" for="autoSizingSelect">Preference</label>
                        <select class="form-select" id="autoSizingSelect" v-model="selectedCategory" @change="getProducts">
                            <option selected value=""></option>
                            <option v-for="(category, index) in JSON.parse(categories)" :key="index" :value="category.category">{{ category.category }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <div class="col" v-for="product in products.data" :key="product.id">
                    <div class="card">
                    <img src="https://t3.ftcdn.net/jpg/02/48/42/64/360_F_248426448_NVKLywWqArG2ADUxDq6QprtIzsF82dMF.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ product.name }}</h5>
                        <p class="card-text">{{ product.description  }}</p>
                    </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <pagination align="center" :data="products" @pagination-change-page="getProducts" :limit='10' size="small" :show-disabled="true">
                    <span slot="prev-nav">&lt; Previous</span>
                    <span slot="next-nav">Next &gt;</span>
                </pagination>
            </div>
        </div>
    </div>
</template>

<script>
import pagination from 'laravel-vue-pagination'
export default {
    components : {
        pagination
    },
    props: ['categories'],
    data(){
        return {
            products: {},
            q:'',
            selectedCategory: '',
            __categories: JSON.parse(this.categories)
        }
    },
    created(){
        this.getProducts();
    },
    methods: {
        getProducts(page=1){
            axios.get(`api/products/all?page=${page}&q=${this.q}&category=${this.selectedCategory}`)
                .then(response => {
                    this.products = response.data;
                })
                .catch(error => {
                    console.log(error);
                })
        }
    }
}
</script>

<style>

</style>
