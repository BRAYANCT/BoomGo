<template>
    <div class="row">
        <div class="col-md-12" >
            <div class="form-group md-style">
                <label >Provincia*</label>
                <Select2
                    v-model="provinceId"
                    name="province_id"
                    :options="optionsProvince"
                    :settings="{ theme: 'bootstrap4',width:'100%',placeholder:'Seleccione la provincia'}"
                    :class="getValidClassInput('province_id')" >
                </Select2>
                <validation-message  :errors="errors" name="province_id" ></validation-message>
            </div>
        </div><!--/col-->
    </div>
</template>

<script>

import { ProvinceService } from "../../../services/web/province.service";


import Select2 from "v-select2-component";
import { validationMixin } from "../../../mixins/validation-mixin";

const provinceService = new ProvinceService();

export default {
    components: {
        Select2,
    },
    mixins: [
        validationMixin,
    ],
    props: {
        departmentIdProp: { default:'0'},
        initLoadOptions: { default:true },
        errorsProp: { default: null},
    },
    data(){
        return {
            provinces: [],
            optionsProvince: [{id: '0', text: 'Seleccione el provincia' ,selected:true}],
            provinceId: '0',
            defaultOption: this.getDefaultOption()
        }
    },
    mounted() {
        // console.log('Component Province Select 2 mounted.');
        this.getProvinces();
    },
    methods: {
        getProvinces: async function(){
            this.provinces = await provinceService.getAll();
            // console.log('provinces:',this.provinces);
        },
        getDefaultOption: function (){
            return {id: '0', text: 'Seleccione la provincia',selected:true}
        },
        setOptionsProvince: async function(){
            // console.log("setOptionsProvince");
            this.optionsProvince = [];
            this.optionsProvince = [this.defaultOption];
            this.provinceId = "0";
            this.provinces.forEach((item)=>{
                this.optionsProvince.push({id: item.id, text: item.name});
            });
        },
        setOptionsProvinceByDepartmentId: async function(departmentId){
            // console.log("setOptionsProvince");
            this.optionsProvince = [];
            this.optionsProvince = [this.defaultOption];
            this.provinceId = "0";

            this.provinces.forEach((item)=>{
                if(parseInt(item.department_id) === parseInt(departmentId)){
                    this.optionsProvince.push({id: item.id, text: item.name});
                }
            });
        },
    },
    watch:{
        provinceId: function (val) {
            this.$emit('changeValue',val);
        },
        provinces: function (val) {
            if(this.initLoadOptions){
                this.setOptionsProvince();
            }
        },
        departmentIdProp: function (departmentId) {
            // console.log('watch departmentIdProp');
            this.setOptionsProvinceByDepartmentId(departmentId);
        },
        errorsProp: function (val) {
            this.errors = val;
        },
    }
}
</script>
