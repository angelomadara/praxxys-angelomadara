<template>
    <div>
        <h1 class="h2">Products</h1>

    </div>
</template>

<script>
export default {
    data(){
        return {
            products: {}
        }
    },
    created(){
        this.getProducts();
    },
    methods: {
        getProducts(){
            axios.get(`api/products/all`)
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
