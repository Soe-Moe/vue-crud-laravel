<template>
    <div class="col-md-10 tw-mx-auto tw-mt-10 tw-mb-10">
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
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <tr v-for="c in customers" :key="c.id">
                            <td v-text="c.name"></td>
                            <td v-text="c.email"></td>
                            <td v-text="c.address"></td>
                            <td v-text="c.date"></td>
                            <td>
                                <div class="tw-flex">
                                    <router-link :to="{name: 'edit-customer', params: {id: c.id}}" class="btn btn-primary btn-sm">Edit</router-link>
                                    <button @click="deleteCustomer(c.id)" class="tw-ml-2 btn btn-danger btn-sm">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" class="tw-text-center">
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
                        },1000)
                    }else{
                        $state.complete();
                    }
                }


            })
        },
        deleteCustomer(c_id){
            this.$confirm(
                    {
                    title: `Are you sure?`,
                    message: `Are you sure you want to delete?`,
                    button: {
                        no: 'No',
                        yes: 'Yes'
                    },
                    callback: confirm => {
                        if (confirm) {
                            axios.delete(`${base_url}/customer/${c_id}/delete`).then(response => {
                                if(response.data.status == 1){
                                    let index = this.customers.findIndex(c => c.id == c_id);
                                        this.$delete(this.customers, index);
                                    Vue.$toast.success(response.data.message)
                                }else{
                                    Vue.$toast.success(response.data.message)
                                }
                            })
                        }
                    }
                    }
            )
        }
    }
}
</script>
