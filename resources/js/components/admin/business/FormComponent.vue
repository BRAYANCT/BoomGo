<template>
    <div class="row">
        <div class="col-md-12">

            <form v-on:submit.prevent="submit" class="form-css-validate">

                <div class="card card-form mb-3">
                    <div class="card-header">
                        <h3 class="card-header-title">
                            Datos del negocio
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div v-if="user && !isAdminBusiness" class="col-md-6">
                                <div class="md-form has-helper-text">
                                    <input type="text" id="username" class="form-control" v-model="user.username" disabled >
                                    <label for="username">Nombre de usuario</label>
                                </div>
                                <small  class="helper-text" >
                                    <a :href="$root.getCompleteUrlByUri('admin/users/'+user.id+'/edit')">
                                        <i :class="$root.configIcons.user.class" class="mr-2"></i>Editar el usuario
                                    </a>
                                </small>
                            </div>

                            <div class="col-md-12" v-if="id=='' && !isAdminBusiness " >
                                <div class="form-group md-style">
                                    <label >Usuario*:</label>
                                    <Select2
                                        v-model="userId"
                                        name="user_id"
                                        :options="optionsUser"
                                        :settings="{ theme: 'bootstrap4',width:'100%' }"
                                        :class="getValidClassInput('user_id')">
                                    </Select2>
                                    <validation-message  :errors="errors" name="user_id" ></validation-message>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="md-form" :class="business.id ? 'has-helper-text' : ''" >
                                    <input type="text" id="name" name="name" v-model="business.name" class="form-control" :class="getValidClassInput('name')" required :maxlength="$root.configAttributes.company_name.max">
                                    <label for="name">Nombre*</label>
                                    <validation-message :errors="errors" name="name" ></validation-message>

                                    <small v-if="business.id" class="helper-text" >
                                        <a :href="business.url_page" title="Ver página del negocio" >
                                            <i :class="$root.configIcons.business.class" class="mr-2"></i>
                                            Ver página del negocio
                                        </a>
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="md-form ">
                                    <input id="email" type="email" name="email" v-model="business.email" :class="getValidClassInput('business_id')" class="form-control" required :maxlength="$root.configAttributes.email.max">
                                    <label for="email">Email*</label>
                                    <validation-message :errors="errors" name="email" ></validation-message>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="md-form ">
                                    <input type="text" id="phone" name="phone" v-model="business.phone" :class="getValidClassInput('phone')" class="form-control" required :maxlength="$root.configAttributes.phone.max">
                                    <label for="phone">Teléfono*</label>
                                    <validation-message :errors="errors" name="phone" ></validation-message>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="md-form ">
                                    <imask-input
                                        id="whatsapp"
                                        type="text"
                                        name="whatsapp"
                                        v-model="business.whatsapp"
                                        mask="{9}00000000"
                                        placeholderChar="#"
                                        :lazy="false"
                                        class="form-control"
                                        :class="getValidClassInput('whatsapp')"
                                    />
                                    <label for="whatsapp">Whatsapp*</label>
                                    <validation-message :errors="errors" name="whatsapp" ></validation-message>
                                </div>
                            </div>

                            <div class="col-md-6" >
                                <div class="form-group md-style">
                                    <label >Categoría*:</label>
                                    <Select2
                                        v-model="categoryId"
                                        name="category_id"
                                        :options="optionsCategory"
                                        :settings="{ theme: 'bootstrap4',width:'100%',placeholder:'Seleccione la categoría'}"
                                        :class="getValidClassInput('category_id')">
                                    </Select2>
                                    <validation-message  :errors="errors" name="category_id" ></validation-message>
                                </div>
                            </div>

                            <div class="col-md-6" >
                                <div class="form-group md-style">
                                    <label >Rango de precios</label>
                                    <Select2
                                        v-model="priceRangeId"
                                        name="price_range_id"
                                        :options="optionsPriceRange"
                                        :settings="{ theme: 'bootstrap4',width:'100%' }"
                                        :class="getValidClassInput('price_range_id')">
                                    </Select2>
                                    <validation-message  :errors="errors" name="price_range_id" ></validation-message>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="md-form ">
                                    <textarea id="description" name="description" class="md-textarea form-control" :class="getValidClassInput('description')" rows="5" >{{ business.description }}</textarea>
                                    <label for="description">Descripción</label>
                                    <validation-message  :errors="errors" name="description" ></validation-message>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="md-form ">
                                    <input type="text" id="catalog_link" name="catalog_link" v-model="business.catalog_link" :class="getValidClassInput('catalog_link')" class="form-control" :maxlength="$root.configAttributes.url.max">
                                    <label for="catalog_link">Link de catálogo</label>
                                    <validation-message :errors="errors" name="catalog_link" ></validation-message>
                                </div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <admin-file-input-basic
                                    :url-image="business.logo_url_thumbnail"
                                    input-label="Logo de empresa:"
                                    input-name="logo_object"
                                    :helper="$root.langHelpers.business.logo_dimensions"
                                >
                                </admin-file-input-basic>
                                <validation-message  :errors="errors" name="logo_object" ></validation-message>
                            </div>

                            <div class="col-md-3 mt-3" v-for="(item,index) in providerTypes">
                                <div class="form-group">
                                    <label >{{ item.question_registration }}</label>
                                    <input type="hidden" value="" name="provider_types_id[]">
                                    <div class="switch">
                                        <label>
                                            No
                                            <input type="checkbox" name="provider_types_id[]"  :value="item.id"  :checked="checkProviderType(item.id)" >
                                            <span class="lever"></span>
                                            Sí
                                        </label>
                                    </div>
                                    <validation-message  :errors="errors" :name="'provider_types_id.'+index" ></validation-message>
                                </div>
                            </div><!--/col-->


                        </div><!--/row-->
                    </div><!--/card-body-->
                </div><!--/card-->


                <div class="card card-form mb-3">
                    <div class="card-header">
                        <h3 class="card-header-title">
                            Dirección
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="row" >

                            <div class="col-md-4" >
                                <div class="form-group">
                                    <label >Departamento*</label>
                                    <Select2
                                        v-model="departmentId"
                                        name="department_id"
                                        :options="optionsDepartment"
                                        :settings="{ theme: 'bootstrap4',width:'100%',placeholder:'Seleccione el departamento'}"
                                        :class="getValidClassInput('department_id')">
                                    </Select2>
                                    <validation-message  :errors="errors" name="department_id" ></validation-message>
                                </div>
                            </div><!--/col-->

                            <div class="col-md-4" >
                                <div class="form-group">
                                    <label >Provincia*</label>
                                    <Select2
                                        v-model="provinceId"
                                        name="province_id"
                                        :options="optionsProvince"
                                        :settings="{ theme: 'bootstrap4',width:'100%',placeholder:'Seleccione la provincia'}"
                                        :class="getValidClassInput('province_id')">
                                    </Select2>
                                    <validation-message  :errors="errors" name="province_id" ></validation-message>
                                </div>
                            </div><!--/col-->

                            <div class="col-md-4" >
                                <div class="form-group">
                                    <label >Distrito*</label>
                                    <Select2
                                        v-model="districtId"
                                        name="district_id"
                                        :options="optionsDistrict"
                                        :settings="{ theme: 'bootstrap4',width:'100%',placeholder:'Seleccione el distrito'}"
                                        :class="getValidClassInput('district_id')">
                                    </Select2>
                                    <validation-message  :errors="errors" name="district_id" ></validation-message>
                                </div>
                            </div><!--/col-->

                            <div class="col-md-12 mb-2" >
                                <input id="latitude" type="hidden" name="latitude"  >
                                <input id="longitude" type="hidden" name="longitude"  >
                                <input id="address-map" class="address-map enter-prevent" type="text" name="address" placeholder="Buscar dirección" v-model="business.address"  >
                                <div id="map" ></div>
                            </div>

                        </div><!--/ row  -->
                    </div><!--/ card body  -->
                </div><!--/ card  -->

                <div class="card card-form mb-3" v-if="loadImages" >
                    <div class="card-header">
                        <h3 class="card-header-title">
                            Galería de imágenes
                        </h3>
                    </div>
                    <div class="card-body" >
                        <admin-file-input-multiple
                            :images-prop="images"
                            @changeFiles="changeFiles"
                            :helper-prop="$root.langHelpers.business.pictures"
                        ></admin-file-input-multiple>

                        <validation-message
                            v-if="!fieldArrayHasErrors('image_gallery',filesToUpload)"
                            :errors="errors" name="image_gallery" ></validation-message>

                        <template v-for="(item , index) in filesToUpload">
                            <validation-error-message
                                :errors="errors" :name="'image_gallery.'+index" >
                            </validation-error-message>
                        </template>
                    </div><!--/card-body-->
                </div><!--/card-->

                <button :class="$root.configButtons.store.class" class="mx-0" type="submit" >
                    <i :class="id == '' ? $root.configIcons.store.class : $root.configIcons.update.class"></i>
                    {{ id == '' ? $root.langButtons.store : $root.langButtons.update }}
                </button>

            </form>

        </div><!--/col-->
    </div><!--/row-->
</template>


<script>

// import from 'https://maps.googleapis.com/maps/api/js?language=es&key={{ config('app.api_key_google_maps') }}&libraries=places&callback=initAutocomplete';

import { BusinessService } from "../../../services/admin/business.service";
import { UserService } from "../../../services/admin/user.service";
import { CategoryService } from "../../../services/admin/category.service";
import { PriceRangeService } from "../../../services/admin/price-range.service";
import { ProviderTypeService } from "../../../services/admin/provider-type.service";

import { DepartmentService } from "../../../services/admin/department.service";
import { ProvinceService } from "../../../services/admin/province.service";
import { DistrictService } from "../../../services/admin/district.service";

import Select2 from "v-select2-component";
import { validationMixin } from "../../../mixins/validation-mixin";
import {IMaskComponent} from "vue-imask";

const userService = new UserService();
const categoryService = new CategoryService();
const priceRangeService = new PriceRangeService();
const providerTypeService = new ProviderTypeService();
const businessService = new BusinessService();

const departmentService = new DepartmentService();
const provinceService = new ProvinceService();
const districtService = new DistrictService();

export default {
    components: {
        Select2,
        'imask-input': IMaskComponent,
    },
    mixins: [
        validationMixin,
    ],
    props: {
        idProp: { default:''},
        isAdminBusinessProp : { default:false , type:Boolean },
    },
    data() {
        return {
            isAdminBusiness: this.isAdminBusinessProp,
            id: this.idProp,
            business:{id:''},
            user: null,
            users:[],
            optionsUser: [ {id: '0', text: 'Seleccione' ,selected:true} ],
            userId: '0',

            categories:[],
            optionsCategory: [ {id: '0', text: 'Seleccione' ,selected:true} ],
            categoryId: '0',

            priceRanges:[],
            optionsPriceRange: [ {id: '0', text: 'Sin especificar' ,selected:true} ],
            priceRangeId: '0',

            providerTypes:[],

            filesToUpload: [],
            images: [],
            loadImages : false,

            departments: [],
            optionsDepartment: [{id: '0', text: 'Seleccione el departamento', selected: true}],
            departmentId: '0',
            provinces: [],
            optionsProvince: [{id: '0', text: 'Seleccione la provincia', selected: true}],
            provinceId: '0',
            districts: [],
            optionsDistrict: [{id: '0', text: 'Seleccione el distrito', selected: true}],
            districtId: '0',

            loadDepartments: false,
            loadProvinces:false,
            loadDistricts:false,

            loadProvinceIdBusiness:false,
            loadDistrictIdBusiness:false,
        }
    },
    mounted() {
        // console.log('Component Business Form mounted.',this.id);
        // console.log('isAdminBusiness:',this.isAdminBusiness);
        this.init();
    },
    methods: {
        init: async function (){

            if(!fg.isEmpty(this.id)){
                this.getBusiness(this.id);
            }else{
                this.loadProvinceIdBusiness = true;
                this.loadDistrictIdBusiness = true;
                this.loadImages = true;
            }

            if(!this.isAdminBusiness){
                this.getUsers();
            }

            this.getBusinessCategories();
            this.getPriceRanges();
            this.getProviderTypes();

            this.getDepartments();
            this.getProvinces();
            this.getDistricts();
        },
        changeFiles:function(filesToUpload){
            this.filesToUpload = filesToUpload;
        },
        checkProviderType : function (providerTypeId){
            if(this.business.id && this.business.provider_types){
                let exist = false;
                this.business.provider_types.some((item,index)=>{
                    if(item.id == providerTypeId){
                        exist = true;
                        return exist;
                    }
                });
                return exist;
            }
            return false;
        },
        getBusiness: async function (id) {
            try {
                this.business = await businessService.getOne(id);
                this.user = this.business.user;
                this.categoryId =  this.business.category_id;
                this.priceRangeId =  this.business.price_range_id ? this.business.price_range_id : '0';

                let interval = setInterval(()=>{
                    if(this.loadDepartments && this.loadDistricts && this.loadProvinces){

                        if(this.business.district){
                            this.departmentId = this.business.district.province.department_id;
                            this.provinceId = this.business.district.province_id;
                            this.districtId = this.business.district_id;
                        }
                        clearInterval(interval);
                    }

                }, 1000);



                this.images = this.business.images;
                this.loadImages = true;

                $('#latitude').val(this.business.latitude);
                $('#longitude').val(this.business.longitude);


                // console.log('business:',this.business);

                setTimeout(function(){
                    $('input,textarea').trigger('change');
                }, 300);

            } catch (error) {
                console.error(error);
            }
        },
        getProviderTypes: async function () {
            this.providerTypes = await providerTypeService.getAll();
        },
        getUsers: async function () {
            let param = {'doesnt_have_business':1};
            this.users = await userService.getAll(param);
        },
        setOptionsUser: async function(){
            this.users.forEach((item)=>{
                this.optionsUser.push({id: item.id, text: item.full_name});
            });
        },
        getPriceRanges: async function () {
            this.priceRanges = await priceRangeService.getAll();
        },
        setOptionsPriceRange: async function(){
            this.priceRanges.forEach((item)=>{
                this.optionsPriceRange.push({id: item.id, text: item.display_name});
            });
        },
        getBusinessCategories: async function () {
            let params = {'level':1};
            this.categories = await categoryService.getBusinessCategories(params);
        },
        setOptionsCategory: async function () {
            this.categories.forEach((item)=>{

                if(item.childs.length > 0){
                    let group = {
                        "text": item.name,
                        "children" : []
                    }
                    group.children = item.childs.map((itemChild)=>{
                        return {id: itemChild.id, text: itemChild.name};
                    });

                    this.optionsCategory.push(group);
                }else{
                    this.optionsCategory.push({id: item.id, text: item.name});
                }

            });
        },
        getDepartments: async function(){
            this.departments = await departmentService.getAll();
            this.loadDepartments = true;
            // console.log('departments:',this.departments);
        },
        getProvinces: async function(){
            this.provinces = await provinceService.getAll();
            this.loadProvinces = true;
            // console.log('provinces:',this.provinces);
        },
        getDistricts: async function(){
            this.districts = await districtService.getAll();
            this.loadDistricts = true;
            // console.log('districts:',this.districts);
        },
        setOptionsDepartment: async function(){
            this.departments.forEach((item)=>{
                this.optionsDepartment.push({id: item.id, text: item.name});
            });
        },
        setOptionsProvince: async function(){
            // console.log("setOptionsProvince");
            this.optionsProvince = [{id: '0', text: 'Seleccione la provincia' ,selected:true}];

            if(this.loadProvinceIdBusiness){
                this.provinceId = "0";
            }else{
                this.loadProvinceIdBusiness = true;
            }

            this.provinces.forEach((item)=>{
                if(parseInt(item.department_id) === parseInt(this.departmentId)){
                    this.optionsProvince.push({id: item.id, text: item.name});
                }
            });
        },
        setOptionsDistrict: async function(){
            // console.log("setOptionsProvince");
            this.optionsDistrict = [{id: '0', text: 'Seleccione el distrito',selected:true}];
            if(this.loadDistrictIdBusiness){
                this.districtId = "0";
            }else{
                this.loadDistrictIdBusiness;
            }
            this.districts.forEach((item)=>{
                if(parseInt(item.province_id) === parseInt(this.provinceId)){
                    this.optionsDistrict.push({id: item.id, text: item.name});
                }
            });
        },
        submit: function(event){
            let form = event.target;

            // console.log("product:",this.product);

            this.cleanErrors();

            if(this.isAdminBusiness){
                this.storeOrUpdateForAuthUser(form);
            }else{
                if(fg.isEmpty(this.id)){
                    this.store(form);
                }else{
                    this.update(form);
                }
            }

        },
        store: async function(form){

            let btnSubmit = $("button[type='submit']",form);
            let formData = new FormData(form);
            // formData.append('is_admin_business',this.isAdminBusiness);

            this.filesToUpload.forEach((item, index, array)=>{
                formData.append('image_gallery[]',item.file);
            });

            fg.loadingBtn(btnSubmit);
            try {

                let response = await businessService.store(formData);
                let data = response.data;

                if(!data.hasError){
                    let model = data.model;
                    await fg.modalMessage(data.message,'success');

                    let urlEdit = `${urlPagina}/admin/negocios/${model.id}/edit`;
                    fg.loadPage(urlEdit);

                }else{
                    fg.modalMessage(data.message,'error');
                }

            }catch (error) {
                console.log(error);
                if(error.response){
                    // console.log(error.response);
                    let response = error.response;
                    if(response.status == 422){
                        this.errors = response.data.errors;
                        fg.modalMessage(this.errors,'error');
                        return;
                    }
                }
                fg.catchErrorAxios(error,"",form);
            }finally {
                fg.resetLoadingBtn(btnSubmit);
            }

        },
        update: async function(form){

            let btnSubmit = $("button[type='submit']",form);
            let formData = new FormData(form);

            // formData.append('is_admin_business',this.isAdminBusiness);

            this.filesToUpload.forEach((item, index, array)=>{
                formData.append('image_gallery[]',item.file);
            });

            fg.loadingBtn(btnSubmit);
            try {
                let response = await businessService.update(this.id,formData);
                let data = response.data;

                if(!data.hasError){
                    let model = data.model;
                    fg.modalMessage(data.message,'success');

                }else{
                    fg.modalMessage(data.message,'error');
                }

            } catch (error) {
                console.log(error);
                if(error.response){
                    let response = error.response;
                    if(response.status == 422){
                        this.errors = response.data.errors;
                        fg.modalMessage(this.errors,'error');
                        return;
                    }
                }
                fg.catchErrorAxios(error,"",form);
            } finally {
                fg.resetLoadingBtn(btnSubmit);
            }
        },
        storeOrUpdateForAuthUser: async function(form){
            console.log('storeOrUpdateForAuthUser');
            let btnSubmit = $("button[type='submit']",form);
            let formData = new FormData(form);
            // formData.append('is_admin_business',this.isAdminBusiness);

            this.filesToUpload.forEach((item, index, array)=>{
                formData.append('image_gallery[]',item.file);
            });

            fg.loadingBtn(btnSubmit);
            try {

                let response = await businessService.storeOrUpdateForAuthUser(formData);
                let data = response.data;

                if(!data.hasError){
                    let model = data.model;
                    await fg.modalMessage(data.message,'success');

                    if(fg.isEmpty(this.id)){
                        let urlEdit = `${urlPagina}/businesses-admin/negocios/perfil`;
                        fg.loadPage(urlEdit);
                    }

                }else{
                    fg.modalMessage(data.message,'error');
                }

            }catch (error) {
                console.log(error);
                if(error.response){
                    // console.log(error.response);
                    let response = error.response;
                    if(response.status == 422){
                        this.errors = response.data.errors;
                        fg.modalMessage(this.errors,'error');
                        return;
                    }
                }
                fg.catchErrorAxios(error,"",form);
            }finally {
                fg.resetLoadingBtn(btnSubmit);
            }

        },
    },
    watch: {
        users(val) {
            this.setOptionsUser();
        },
        categories(val){
            this.setOptionsCategory()
        },
        priceRanges(val){
            this.setOptionsPriceRange()
        },
        departments(val) {
            this.setOptionsDepartment();
        },
        departmentId(val){
            if(val !== '0'){
                this.setOptionsProvince();
            }
        },
        provinceId(val){
            if(val !== '0'){
                this.setOptionsDistrict();
            }
        },
    }
}

</script>
