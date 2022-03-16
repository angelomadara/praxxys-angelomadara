import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import dashboard from './components/admin/Dashboard.vue'

const routes = [
    { path: '/', component: dashboard },
];

const router = new VueRouter({
    routes: routes,
    hashbang : false,
    mode : 'history'
});

export default router
