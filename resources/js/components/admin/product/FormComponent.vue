<template>
    <div class="row ">
        <div class="col-12">
            <form v-on:submit.prevent="submit" class="form-css-validate" >

                <input type="hidden" v-model="product.offer_date_range" name="offer_date_range">

                <div class="card card-form mb-3">
                    <div class="card-header">
                        <h3 class="card-header-title">
                            Datos del producto
                        </h3>
                    </div>

                    <div class="card-body">

                        <div class="row" v-if="$root.canChooseBusiness() && !isAdminBusiness" >
                            <div class="col-md-6" >
                                <div class="form-group md-style">
                                    <label >Negocio*:</label>
                                    <Select2
                                        v-model="businessId"
                                        name="business_id"
                                        :options="optionsBusiness"
                                        :settings="{ theme: 'bootstrap4',width:'100%' }"
                                        :class="getValidClassInput('business_id')">
                                    </Select2>
                                    <validation-message  :errors="errors" name="business_id" ></validation-message>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="md-form ">
                                    <input type="text" id="name" name="name" v-model="product.name" value="" class="form-control" :class="getValidClassInput('name')" required >
                                    <label for="name">Nombre*</label>
                                    <validation-message  :errors="errors" name="name" ></validation-message>
                                    <small v-if="product.id" class="text-primary">
                                        <a :href="product.url_page" title="Ir a la página del producto">Ver página del producto</a>
                                    </small>
                                </div>
                            </div><!--/col-->

                            <div class="col-md-6" >
                                <div class="form-group md-style">
                                    <label >Categorías*:</label>
                                    <Select2
                                        v-model="categoriesId"
                                        name="categories_id[]"
                                        :options="optionsCategory"
                                        :settings="{ theme: 'bootstrap4',width:'100%',multiple:true,placeholder:'Seleccione las categorías'}"
                                        :class="fieldArrayHasErrors('categories_id',categoriesId) ? getValidClassInputArray('categories_id',categoriesId) : getValidClassInput('categories_id')">
                                    </Select2>
                                    <validation-message
                                        v-if="!fieldArrayHasErrors('categories_id',categoriesId)"
                                        :errors="errors" name="categories_id" ></validation-message>

                                    <template v-for="(item , index) in categoriesId">
                                        <validation-error-message
                                            :errors="errors" :name="'categories_id.'+index" >
                                        </validation-error-message>
                                    </template>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <admin-ckeditor-input-basic
                                    label-text-prop="Descripción corta:"
                                    size-prop="sm"
                                    name-prop="short_description"
                                    placeholder-prop="Ingrese la descripción corta"
                                    :content-prop="product.short_description"
                                >
                                </admin-ckeditor-input-basic>
                                <validation-message  :errors="errors" name="short_description" ></validation-message>
                            </div>

                            <div class="col-md-3" >
                                <div class="md-form">
                                    <imask-input
                                        id="price"
                                        type="text"
                                        name="price"
                                        v-model="product.price"
                                        :mask="Number"
                                        unmask="typed"
                                        :typedValue="Number"
                                        :scale="2"
                                        radix= "."
                                        :min= "0"
                                        :max= "999999"
                                        :padFractionalZeros="true"
                                        class="form-control"
                                        :class="getValidClassInput('price')"
                                        required
                                    />
                                    <label for="price">Precio*</label>
                                    <validation-message  :errors="errors" name="price" ></validation-message>
                                </div>
                            </div>

                            <div class="col-md-3" >
                                <div class="md-form">
                                    <imask-input
                                        id="offer-price"
                                        type="text"
                                        name="offer_price"
                                        v-model="product.offer_price"
                                        :mask="Number"
                                        unmask="typed"
                                        :typedValue="Number"
                                        :scale="2"
                                        radix= "."
                                        :min= "0"
                                        :max= "999999"
                                        :padFractionalZeros="true"
                                        class="form-control"
                                        :class="getValidClassInput('offer_price')"
                                    />
                                    <label for="offer-price">Precio de oferta</label>
                                    <small v-if="!product.offer_date_range" class="text-primary" >
                                        <a @click="toggleOfferDateRange()" >
                                            <i class="far fa-calendar-alt"></i> Elegir rango de fechas
                                        </a>
                                    </small>
                                    <validation-message  :errors="errors" name="offer_price" ></validation-message>
                                </div>
                            </div>

                            <div v-show="product.offer_date_range" class="col-md-3">
                                <div class="form-group md-style">
                                    <label >Inicio de oferta*</label>
                                    <date-picker
                                        :input-attr="{'name':'offer_start_date'}"
                                        v-model="product.display_offer_start_date"
                                        valueType="DD/MM/YYYY"
                                        format="DD/MM/YYYY"
                                        lang="es"
                                        style="width: 100%"
                                        placeholder=""
                                        :class="getValidClassInput('offer_start_date')"
                                        :disabled-date="disabledOfferStartDate"
                                    >
                                    </date-picker>
                                    <small  class="text-danger" >
                                        <a @click="toggleOfferDateRange()" >
                                            <i :class="$root.configIcons.delete.class"></i> Quitar rango de fechas
                                        </a>
                                    </small>
                                    <validation-message  :errors="errors" name="offer_start_date" ></validation-message>
                                </div>
                            </div>

                            <div v-show="product.offer_date_range" class="col-md-3">
                                <div class="form-group md-style">
                                    <label >Fin de oferta*</label>
                                    <date-picker
                                        :input-attr="{'name':'offer_end_date'}"
                                        v-model="product.display_offer_end_date"
                                        valueType="DD/MM/YYYY"
                                        format="DD/MM/YYYY"
                                        lang="es"
                                        style="width: 100%"
                                        placeholder=""
                                        :class="getValidClassInput('offer_end_date')"
                                        :disabled-date="disabledOfferEndDate"
                                    >
                                    </date-picker>
                                    <validation-message  :errors="errors" name="offer_end_date" ></validation-message>
                                </div>
                            </div>


                            <div class="col-md-12 mt-3">
                                <admin-file-input-basic
                                    :url-image="product.picture_url_medium"
                                    input-name="picture_object"
                                    :helper="$root.langHelpers.product.picture" >
                                </admin-file-input-basic>
                                <validation-message  :errors="errors" name="picture_object" ></validation-message>
                            </div>

                        </div><!--/row-->
                    </div><!--/card-body-->
                </div><!--/card-->

                <div class="card card-form mb-3" v-if="loadImages" >
                    <div class="card-header">
                        <h3 class="card-header-title">
                            Descripción del producto
                        </h3>
                    </div>
                    <div class="card-body" >
                            <admin-ckeditor-input-basic
                                label-text-prop=""
                                name-prop="description"
                                placeholder-prop="Ingrese la descripción detallada del producto"
                                :content-prop="product.description">
                            </admin-ckeditor-input-basic>
                             <validation-message  :errors="errors" name="description" ></validation-message>
                    </div><!--/card-body-->
                </div><!--/card-->

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
                            :helper-prop="$root.langHelpers.product.picture"
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


                <button v-if="id" class="submit" :class="$root.configButtons.update.class" type="submit" >
                    <i class="mr-1" :class="$root.configIcons.update.class" ></i>
                    {{ $root.langButtons.update }}
                </button>
                <button v-else class="submit" :class="$root.configButtons.store.class" type="submit" >
                    <i class="mr-1" :class="$root.configIcons.store.class" ></i>
                    {{ $root.langButtons.store }}
                </button>
                <button v-if="id"
                        @click="destroy()"
                        :class="$root.configButtons.destroy.class"
                        type="button">
                    <i :class="$root.configIcons.destroy.class" class="mr-1" ></i>
                    {{ $root.langButtons.destroy }}
                </button>

            </form>
        </div><!--/col-->
    </div><!--/row-->
</template>

<script>

import { BusinessService } from '../../../services/admin/business.service';
import { ProductService } from '../../../services/admin/product.service';
import { CategoryService } from "../../../services/admin/category.service";
import { validationMixin } from '../../../mixins/validation-mixin';


import Select2 from 'v-select2-component';
import { IMaskComponent } from 'vue-imask';

import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/locale/es';
import 'vue2-datepicker/index.css';


const businessService = new BusinessService();
const productService = new ProductService();
const categoryService = new CategoryService();

let moment = require('moment'); // require

export default {
    components: {
        Select2,
        'imask-input': IMaskComponent,
        DatePicker,
    },
    mixins: [
        validationMixin,
    ],
    props: {
        idProp: { default:''},
        isAdminBusinessProp : { default:false , type:Boolean },
    },
    data(){
        return {
            id: this.idProp,
            product: {'name':'',price:'',offer_date_range:false,display_offer_start_date:'',short_description:''},
            optionsBusiness: [{id: '0', text: 'Seleccione' ,selected:true}],
            businessId: '0',
            optionsCategory: [],
            categoriesId: [],
            filesToUpload: [],
            images: [],
            loadImages : false,
            isAdminBusiness : this.isAdminBusinessProp,
        }
    },
    mounted() {
        // console.log('Component Product Form mounted.',this.isAdminBusiness);

        if(!fg.isEmpty(this.id)){
            this.getProduct(this.id);
        }else{
            this.loadImages = true;
        }

        if(this.$root.canChooseBusiness() && !this.isAdminBusiness ){
            this.setBusinessOptions();
        }else{
            // this.setOptionsEmployees();
        }

        this.setCategoryOptions();
    },
    methods: {
        changeFiles:function(filesToUpload){
            this.filesToUpload = filesToUpload;
        },
        disabledOfferStartDate : function(date){

            const today = new Date();
            today.setHours(0, 0, 0, 0);

            if(date < today ){
                return true;
            }

            let offerEndDate = this.product.display_offer_end_date;

            if(!fg.isEmpty(offerEndDate)){
                let momentOfferEndDate = moment(offerEndDate, "DD-MM-YYYY");
                let momentDate = moment(date);
                return !momentDate.isSameOrBefore(momentOfferEndDate);
            }
            return false;
        },
        disabledOfferEndDate : function(date){

            const today = new Date();
            today.setHours(0, 0, 0, 0);

            if(date < today ){
                return true;
            }

            let offerStartDate = this.product.display_offer_start_date;

            if(!fg.isEmpty(offerStartDate)){
                let momentOfferStartDate = moment(offerStartDate, "DD-MM-YYYY");
                let momentDate = moment(date);
                return !momentDate.isSameOrAfter(momentOfferStartDate);
            }
            return false;
        },
        toggleOfferDateRange: async function(){
            this.product.offer_date_range = !this.product.offer_date_range;
        },
        getProduct: async function (id) {
            try {
                this.product = await productService.getOne(id);

                this.businessId = this.product.business_id;

                this.categoriesId = this.product.categories.map((item)=>{
                    return item.id;
                });

                this.images = this.product.images;

                this.loadImages = true;

                console.log('product',this.product);

                setTimeout(function(){
                    $('input').trigger('change');
                }, 300);
            } catch (error) {
                console.error(error);
            }
        },
        getAllBusiness: async function () {
            let businesses = [];
            try {
                businesses = await businessService.getAll();

            } catch (error) {
                console.error(error)
            }
            return businesses;
        },
        setBusinessOptions: async function () {
            let businesses = await this.getAllBusiness();
            businesses.forEach((item)=>{
                this.optionsBusiness.push({id: item.id, text: item.name});
            });
        },
        getProductCategories: async function () {
            let categories = [];
            try {

                let params = {'level':1};
                categories = await categoryService.getProductCategories(params);

            } catch (error) {
                console.error(error)
            }
            return categories;
        },
        setCategoryOptions: async function () {
            let categories = await this.getProductCategories();
            categories.forEach((item)=>{

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
        submit: function(event){
            let form = event.target;

            // console.log("product:",this.product);

            this.cleanErrors();

            if(fg.isEmpty(this.id)){
                this.store(form);
            }else{
                this.update(form);
            }

        },
        store: async function(form){
            let btnSubmit = $("button.submit[type='submit']",form);
            let formData = new FormData(form);
            formData.append('is_admin_business',this.isAdminBusiness);

            this.filesToUpload.forEach((item, index, array)=>{
                formData.append('image_gallery[]',item.file);
            });

            fg.loadingBtn(btnSubmit);
            try {

                let response = await productService.store(formData);
                let data = response.data;

                if(!data.hasError){
                    let model = data.model;
                    await fg.modalMessage(data.message,'success');

                    let urlEdit = `${urlPagina}/admin/productos/${model.id}/edit`;

                    if(this.isAdminBusiness){
                        urlEdit = `${urlPagina}/businesses-admin/productos/${model.id}/edit`;
                    }

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

            let btnSubmit = $("button.submit[type='submit']",form);
            let formData = new FormData(form);
            formData.append('is_admin_business',this.isAdminBusiness);

            this.filesToUpload.forEach((item, index, array)=>{
                formData.append('image_gallery[]',item.file);
            });

            fg.loadingBtn(btnSubmit);
            try {
                let response = await productService.update(this.id,formData);
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
        destroy: async function(){
            let confirm = await fg.confirmarModal();
            if(confirm){
                document.getElementById("form-destroy").submit();
                fg.loadPage();
            }
        }
    }
}
</script>
