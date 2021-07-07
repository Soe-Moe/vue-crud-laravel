<template>
    <div class="col-md-8 tw-mx-auto tw-mt-10 tw-mb-10">
        <div class="tw-bg-white tw-rounded-lg tw-p-5">
            <h1 class="tw-text-lg">Customer List
                <router-link class="tw-float-right btn btn-sm btn-primary tw-text-white" :to="{name: 'add-customer'}">Add Customer</router-link>
            </h1>
            <div class="tw-mt-2">
                <table class="table tw-mb-0">
                    <thead>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Addrss</th>
                        <th>Date</th>
                    </thead>
                    <tbody>
                        <tr v-for="c in customers" :key="c.id">
                            <td v-text="c.name"></td>
                            <td v-text="c.email"></td>
                            <td v-text="c.address"></td>
                            <td v-text="c.date"></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="tw-text-center">
                                <infinite-loading spinner="waveDots" @infinite="getCustomer"></infinite-loading>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'Home',
    data(){
        return {
            page: 1,
            customers: []
        }
    },
    mounted(){
        this.$Progress.finish()
    },
    created(){
        this.$Progress.start()
    },
    methods:{
        getCustomer($state){
            axios.get(`${base_url}/customers`, {
                params: {page: this.page}
            }).then((response) => {
                let data = response.data.data
                if(response.data.status == 1){
                    if(data.length){
                        setTimeout(() => {
                            this.page +=1;
                            this.customers.push(...data)
                            $state.loaded();
                        },1200)
                    }else{
                        $state.complete();
                    }
                }


            })
        }
    }
}
</script>
