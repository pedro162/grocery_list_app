<template>
    <div class="create max-w-7xl mx-auto p-8 bg-white shadow-md rounded-md mt-10 ">
        <h2 class="text-2xl font-semibold mb-6" >{{title}}</h2>
        
        <div v-if="isLoading != true && error != null && String(error).length > 0 " class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
          <span class="font-medium">Error!</span> {{error}}        
        </div>

        <div v-if="isLoading != true && msg_success != null && String(msg_success).length > 0 " class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
          <span class="font-medium">Success!</span> {{msg_success}}        
        </div>

        <form @submit.prevent="submitForm" >
            <!--<input type="hidden" name="_token" :value="form_data.csrfToken">-->
            <!--
                flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4 mt-5
            -->

            <div class="mt-10">
                <h4 class="text-xl font-semibold" >Basic information</h4>
            </div>
            <div class="flex flex-col mb-4">
                <hr/>
            </div>
            <div class="mb-4">
                <div class="flex flex-col space-y-2 md:space-y-0 md:flex-row md:space-x-4">
                    <div class="flex-col md:w-1/2 w-full sm:flex-row">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2"  >Name</label>
                        <input
                            type="text"
                            id="name"
                            v-model="form_data.name"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required
                        />
                    </div>
                    <div class="flex-col md:w-1/2  w-full sm:flex-row">
                        <label for="brand" class="block text-gray-700 text-sm font-bold mb-2"  >Brand</label>
                        <select

                            id="brand"
                            v-model="form_data.brand_id"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required
                        >
                            <option value='' >Select...</option>
                            <option v-for="(item, index) in brands" :key="index+item.id" :value="item.id" >{{item.name}}</option>
                            
                        </select>
                    </div>
                </div> 
                <div class="flex flex-col space-y-2 md:space-y-0 md:flex-row md:space-x-4 mt-4">
                    <div class="flex-col md:w-1/2 w-full sm:flex-row">
                        <label for="category" class="block text-gray-700 text-sm font-bold mb-2"  >Category</label>
                        
                        <select

                            id="category"
                            v-model="form_data.category_id"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required
                        >
                            <option value='' >Select...</option>
                            <option v-for="(item, index) in categories" :key="index+item.id" :value="item.id" >{{item.name}}</option>
                            
                        </select>

                    </div>
                    <div class="flex-col md:w-1/2  w-full sm:flex-row">
                        <label for="price" class="block text-gray-700 text-sm font-bold mb-2"  >Price</label>
                        <input
                            type="text"
                            id="price"
                            v-model="form_data.price"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required
                        />
                    </div>
                </div>  
            </div>
            <div class="mt-10">
                <h4 class="text-xl font-semibold" >Photos</h4>
            </div>
            <div class="flex flex-col mb-4">
                <hr/>
            </div>
            <div class="">
                <div class="">
                    <input type="file"
                        @change="handleImageUpload"
                        multiple
                        class=""
                        hef="fileInput"
                    />
                </div>
                <div class="mt-4 flex flex-wrap">
                    <div v-for="({url, ...item}, key) in form_data.photos" :key="key" class="relative w-32 h-32 m-2">
                        <img
                            
                            :src="url"
                            class="object-cover w-full h-full rounded-md"
                            required
                        />
                        <button type="button" @click.prevent="removeImage(key)" ></button>
                    </div> 
                </div>
                
            </div>
            <div class="flex items-right justify-end">
                <button v-if="isLoading == true" type="button" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600">Saving...</button>
                <button v-else type="submit" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600">Save</button>
            </div>
        </form>
    </div>
</template>
<script>
import { PRODUCT_STORE, PRODUCT_UPDATE, PRODUCT_GET_ONE, PRODUCT_BRAND_LOAD, PRODUCT_CATEGORY_LOAD} from '../../functions/endpoints';
export default {
    name:'ProductCreate',
    props:{
      setBreadcrumb:Function,
      breadcrumb:Array,
      setTitle:Function,
    },
    components:{
        
    },
    data(){
        return({
            form_data:{
                //csrfToken: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                name:'',
                brand_id:'',
                category_id:'',
                price:'',
                photos:[]
            },
            isLoading:false,
            error:null,
            msg_success:null,
            title:"Create new product",
            request:{
                product_id:null
            },
            brands:[],
            categories:[],
        })
    },
    methods:{
        async submitForm(){
            try{

                this.isLoading  = true;
                this.error      = null;
                let url, options;
                if(Number(this.request?.product_id) > 0){
                    
                    let config = PRODUCT_UPDATE(this.request?.product_id, {...this.form_data})
                    url = config?.url
                    options = config?.options;
                }else{
                    let config = PRODUCT_STORE({...this.form_data})
                    url = config?.url
                    options = config?.options;
                }
                let response = await fetch(url, options)
                response = await response.json()
                let {state, data} = response
                if(data?.id > 0){
                    this.isLoading=false;
                    this.msg_success = "Register successfully"
                    //alert('Register successfully')
                    setTimeout(()=>{
                        this.$router.push({name:'Products'})
                    }, 1000)
                    
                }else{
                    throw new Error(data)
                }
            }catch(e){
                this.error = e.message
            }finally{
                this.isLoading=false;
            }
        },
        async loadProduct(id){
            try{

                this.isLoading  = true;
                this.error      = null;
                if(Number(id) > 0){
                    let { url, options } = PRODUCT_GET_ONE(id, {})
                    let response = await fetch(url, options)
                    response = await response.json()
                    let {state, data} = response
                    if(state == true && Number(data?.id) > 0){
                        this.form_data.name = data?.name;
                        this.form_data.category_id = data?.category_id;
                        this.form_data.brand_id = data?.brand_id;
                        this.form_data.price = data?.price;
                    }else{
                        throw new Error(data)
                    }
                }
                
            }catch(e){
                this.error = e.message
            }finally{
                this.isLoading=false;
            }
        },
        async loadCategory(){
            try{
                this.categories = []
                this.isLoading  = true;
                this.error      = null;
                let { url, options } = PRODUCT_CATEGORY_LOAD({})
                let response = await fetch(url+'?no_paginate=1', options)
                response = await response.json()
                let {state, data} = response

                if(state == true ){
                    this.categories = data;
                }else{
                    throw new Error(data)
                }
                
            }catch(e){
                this.error = e.message
            }finally{
                this.isLoading=false;
            }
        },
        async loadBrands(){
            try{
                this.brands = []
                this.isLoading  = true;
                this.error      = null;
                let { url, options } = PRODUCT_BRAND_LOAD({})
                let response = await fetch(url+'?no_paginate=1', options)
                response = await response.json()
                let {state, data} = response

                if(state == true ){
                    this.brands = data;
                }else{
                    throw new Error(data)
                }
                
            }catch(e){
                this.error = e.message
            }finally{
                this.isLoading=false;
            }
        },
        resetForm(){

        },
        triggerFileInput(){
            this.$refs.fileInput.click()
        },
        handleImageUpload(event){
            
            const files = event.target.files
            for(let i=0; i<files.length; i++){
                const render = new FileReader()
                render.onload = e=>{
                    this.form_data.photos.push({
                        url:e.target.result
                    })
                }
                render.readAsDataURL(files[i])
            }
        },
        removeImage(key){
            this.form_data.photos.splice(index, 1)
        }
    },
    created(){
        this.request.product_id = this.$route.params.id;
        if(Number(this.request.product_id) > 0){
            this.title = `Editing product nº ${this.request.product_id}`
            this.loadProduct(this.request.product_id)
        }
        this.loadCategory()
        this.loadBrands()
        this.setBreadcrumb(this.breadcrumb)
        this.setTitle('Create new product')
    }
}
</script>

<style scoped>
    .create{
    }
</style>