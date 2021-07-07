<template>
    <div>
        <navbar></navbar>
        <div class="container">
            <router-view></router-view>
            <vue-progress-bar></vue-progress-bar>
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
