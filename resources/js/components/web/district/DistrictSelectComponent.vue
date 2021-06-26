<template>
    <div class="row">
        <div class="col-md-12" >
            <div class="form-group md-style">
                <label >Distrito*</label>
                <Select2
                    v-model="districtId"
                    name="district_id"
                    :options="optionsDistrict"
                    :settings="{ theme: 'bootstrap4',width:'100%',placeholder:'Seleccione el distrito'}"
                    :class="getValidClassInput('district_id')" >
                </Select2>
                <validation-message  :errors="errors" name="district_id" ></validation-message>
            </div>
        </div><!--/col-->
    </div>
</template>

<script>

import { DistrictService } from "../../../services/web/district.service";


import Select2 from "v-select2-component";
import { validationMixin } from "../../../mixins/validation-mixin";

const districtService = new DistrictService();

export default {
    components: {
        Select2,
    },
    mixins: [
        validationMixin,
    ],
    props: {
        provinceIdProp: { default:'0'},
        initLoadOptions: { default:true },
        errorsProp: { default: null},
    },
    data(){
        return {
            districts: [],
            optionsDistrict: [{id: '0', text: 'Seleccione el distrito' ,selected:true}],
            districtId: '0',
            defaultOption: this.getDefaultOption()
        }
    },
    mounted() {
        // console.log('Component District Select 2 mounted.');
        this.getDistricts();
    },
    methods: {
        getDistricts: async function(){
            this.districts = await districtService.getAll();
            // console.log('districts:',this.districts);
        },
        getDefaultOption: function (){
            return {id: '0', text: 'Seleccione el distrito',selected:true}
        },
        setOptionsDistrict: async function(){
            // console.log("setOptionsProvince");
            this.optionsDistrict = [];
            this.optionsDistrict = [this.defaultOption];
            this.districtId = "0";
            this.districts.forEach((item)=>{
                this.optionsDistrict.push({id: item.id, text: item.name});
            });
        },
        setOptionsDistrictByProvinceId: async function(provinceId){
            // console.log("setOptionsProvince");
            this.optionsDistrict = [];
            this.optionsDistrict = [this.defaultOption];
            this.districtId = "0";

            this.districts.forEach((item)=>{
                if(parseInt(item.province_id) === parseInt(provinceId)){
                    this.optionsDistrict.push({id: item.id, text: item.name});
                }
            });
        },
    },
    watch:{
        districts: function (val) {
            if(this.initLoadOptions) {
                this.setOptionsDistrict();
            }
        },
        provinceIdProp: function (provinceId) {
            this.setOptionsDistrictByProvinceId(provinceId);
        },
        errorsProp: function (val) {
            this.errors = val;
        },
    }
}
</script>
