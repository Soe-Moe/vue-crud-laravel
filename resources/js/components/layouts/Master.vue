<template>
    <div>
        <navbar></navbar>
        <div class="container">
            <router-view :key="$route.path"></router-view>
            <vue-progress-bar></vue-progress-bar>
            <vue-confirm-dialog></vue-confirm-dialog>
        </div>
    </div>
</template>
<script>
import Navbar from '../layouts/Navbar.vue'

export default {
    name: 'master',
    components:{
        Navbar
    }
}
</script>
