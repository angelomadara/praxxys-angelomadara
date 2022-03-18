<template>
    <div class="col">
        <div class="card">
        <img v-if="product.image" :src="product.image" class="card-img-top" alt="...">
        <img v-else src="https://t3.ftcdn.net/jpg/02/48/42/64/360_F_248426448_NVKLywWqArG2ADUxDq6QprtIzsF82dMF.jpg" class="card-img-top" alt="...">
        <div class="card-body">
            <div class="row">
                <div class="col" v-for="img in product.images" :key="img.id">
                    <img :src="img.image" alt="..." width="100px">
                </div>
            </div>
            <h5 class="card-title">{{ shortenDescription(product.name,50) }}</h5>
            <p class="card-text">{{ shortenDescription(product.description,200)  }}</p>
            <p><a :href="'/products/edit/'+product.id" class="btn btn-primary btn-sm">Edit</a></p>
        </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['product'],
    methods:{
        /**
         * shorten the description use ellipsis if the string is longer than 100 characters
         */
        shortenDescription(description,length){
            if(description.length > length){
                return description.substring(0, length) + '...';
            }
            return description;
        }
    }
}
</script>

<style>

</style>
