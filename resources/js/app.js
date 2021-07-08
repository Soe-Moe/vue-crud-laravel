require('./bootstrap');
import "tailwindcss/tailwind.css"
window.Vue = require('vue').default;

//vue progress bar
import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
    color: '#4331d8',
    failedColor: '#4331d8',
    thickness: '5px',
    transition: {
        speed: '1s',
        opacity: '1s',
        termination: 500
    }
})

//infinite loading
import InfiniteLoading from 'vue-infinite-loading'
Vue.use(InfiniteLoading, { /* options */ });

//Vue toast
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
Vue.use(VueToast, {
    position: 'bottom-right'
});

//Vue Dialog
import VueConfirmDialog from 'vue-confirm-dialog'
Vue.use(VueConfirmDialog)
Vue.component('vue-confirm-dialog', VueConfirmDialog.default)

//Master
import Master from './components/layouts/Master'
Vue.component('master', Master)

//Vue router
import Home from './components/pages/Index'
import CustomerForm from './components/pages/CustomerForm'

import VueRouter from "vue-router";
Vue.use(VueRouter)
const routes = [
    { path: '/',name: 'home', component: Home },
    { path: '/add-customer', name: 'add-customer', component: CustomerForm },
    { path: '/:id/edit-customer', name: 'edit-customer', component: CustomerForm },
];

const router = new VueRouter({
    routes,
    mode: 'history'
})

//global variables
window.base_url = '/api/v1'
window._token = document.querySelector('meta[name="_token"]').getAttribute('content')

const app = new Vue({
    el: '#app',
    router
});
