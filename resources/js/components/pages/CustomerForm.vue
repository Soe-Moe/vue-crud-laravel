<template>
    <div class="col-md-8 tw-mx-auto tw-mt-10">
        <div class="tw-bg-white tw-rounded-lg tw-p-5">
            <h1 class="tw-text-lg" v-text="title"></h1>
            <div class="tw-mt-3">
                <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" v-model="formdata.name" class="form-control" placeholder="Enter Name">
                    <small class="tw-text-red-500" v-if="errors && errors.name" v-text="errors.name[0]"></small>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="text" v-model="formdata.email" class="form-control" placeholder="Enter Email">
                    <small class="tw-text-red-500" v-if="errors && errors.email" v-text="errors.email[0]"></small>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Address</label>
                    <input type="text" v-model="formdata.address" class="form-control" placeholder="Address">
                    <small class="tw-text-red-500" v-if="errors && errors.address" v-text="errors.address[0]"></small>
                </div>
                <div class="tw-flex">
                    <button type="submit" :disabled="processing" class="btn btn-primary tw-flex tw-items-center" @click="save()" ><span v-text="btnTitle"></span>
                    <svg v-if="processing" class="tw-animate-spin tw-ml-2 tw-mr-3 tw-h-4 w-4 tw-text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="tw-opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="tw-opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
                <router-link class="btn btn-danger tw-ml-3" :to="{name: 'home'}">Cancel</router-link>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'CustomerForm',
    data(){
        return {
            title: '',
            btnTitle: '',
            isEdit: false,
            formdata: {
                name: '',
                email: '',
                address: ''
            },
            errors: null,
            processing: false
        }
    },
    mounted(){
        if(this.$route.name == 'add-customer') {
            this.title = 'Add Customer'
            this.btnTitle = 'Save'
        }
        if(this.$route.name == 'edit-customer') {
            this.title = 'Edit Customer'
            this.btnTitle = 'Update'
            this.isEdit = true
            this.getEditData();
        }
        this.$Progress.finish()
    },
    methods: {
        save(){
            if(this.isEdit){
                this.update()
            }else{
                this.submit()
            }
        },
        submit(){
            this.processing = true;
            const formData = new FormData();
                formData.append('name', this.formdata.name)
                formData.append('email', this.formdata.email)
                formData.append('address', this.formdata.address)
                formData.append('_token', _token)
                axios.post(`${base_url}/customer/store`, formData)
                .then(response => {
                    let data = response.data.data;
                    if(response.data.status == 1){
                        this.errors = null;
                        Vue.$toast.success(response.data.message)
                        this.$router.push({name: 'home'})
                    }

                })
                .catch(error => {
                    this.processing = false
                    Vue.$toast.error('Form validation failed.')
                    this.errors = error.response.data.errors
                });
        },
        update(){
            this.processing = true;
            let c_id = this.$route.params.id;
            const formData = new FormData();
                formData.append('name', this.formdata.name)
                formData.append('email', this.formdata.email)
                formData.append('address', this.formdata.address)
                formData.append('_token', _token)

                axios.post(`${base_url}/customer/${c_id}/update`, formData).then(response => {
                    if(response.data.status == 1){
                        Vue.$toast.success(response.data.message)
                        this.$router.push({name: 'home'});
                    }else{
                        Vue.$toast.error(response.data.message)
                    }
                })
        },
        getEditData(){
            let c_id = this.$route.params.id;
            axios.get(`${base_url}/customer/${c_id}/data`).then(response => {
                if(response.data.status == 1){
                    let data = response.data.data;
                    this.formdata.name = data.name
                    this.formdata.email = data.email
                    this.formdata.address = data.address
                }else{
                    Vue.$toast.error(response.error.message)
                }
            })
        }
    },
    created(){
        this.$Progress.start()
    },
}
</script>
