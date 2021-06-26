<template>
    <div class="row ">
        <div class="col-12 mb-3">
            <h4 class="h5 text-secondary-custom ">Dónde</h4>
            <div class="input-group input-icon-custom group-append">
                <input v-model="searchText" type="text" class="form-control" :class="searchText.length==0 ? 'rounded-pill' : '' " placeholder="Escribe la provincia" >
                <div class="input-group-append" v-if="searchText.length>0">
                    <span class="input-group-text" @click="searchText='' ">
                        <i class="fas fa-times"></i>
                    </span>
                </div>
            </div>
        </div><!--/col-->
        <div class="col-12 container-list-province scrollbar-primary-custom">
            <p v-if="provincesFilter.length == 0 && loadProvinces" class="text-white mb-0">
                No se encontraron resultados
            </p>
            <p v-for="(item , index) in provincesFilter"  >
                <a :href="getFilterUrl(item)" class="text-white">
                    {{ item.name }}
                    <span class="badge badge-pill badge-primary-custom" >{{ item.total_businesses }}</span>
                </a>
            </p>
        </div><!--/col-->
    </div><!--/row-->
</template>

<style>

.container-list-province{
    max-height: 300px;
    overflow-y: auto;
}

.container-list-province.scrollbar-primary-custom::-webkit-scrollbar{
    border-radius: 10px;
}

</style>

<script>

import { ProvinceService } from "../../../services/web/province.service";

const provinceService = new ProvinceService();

export default {
    props: {
        urlProp:  { default: '' },
    },
    data(){
        return {
            provinces: [],
            provincesFilter: [],
            url: this.urlProp,
            searchText : '',
            loadProvinces :false,
        }
    },
    mounted() {
        // console.log('Component Business Province Filter mounted.');
        this.getProvinces();
    },
    methods: {
        getProvinces: async function(){
            this.provinces = await provinceService.getAll();

            this.provincesFilter = JSON.parse(JSON.stringify(this.provinces));

            this.loadProvinces = true;

            // this.provinces = provinces.map((item)=>{
            //     item.show = true;
            //     return item;
            // });
            // console.log('provinces:',this.provinces);
        },
        getFilterUrl: function(province){
            let url = new URL(this.url);

            if(url.searchParams.has('province_id')){
                url.searchParams.set('province_id', province.id);
            }else{
                url.searchParams.append('province_id', province.id);
            }
            url.searchParams.delete('page');
            return url.href;
        },
        searchProvince: function(text){

            let searchText = text.toLowerCase().trim();

            this.provincesFilter = this.provinces.filter(item =>{
                //es falso por defecto
                let name = item.name.toLowerCase().trim();
                return name.indexOf(searchText) >= 0;
            });

        }

    },
    watch: {
        searchText(val) {
            this.searchProvince(val);
        },
    }
}
</script>
