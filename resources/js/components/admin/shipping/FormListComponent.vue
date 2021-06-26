<template>
    <div class="row ">
        <div class="col-12">

            <button type="button" @click="create" :class="$root.configButtons.create.class" >
                <i :class="$root.configIcons.create.class" class="mr-2"></i>
                {{ $root.langButtons.create }}
            </button>

            <div class="row">
                <div class="col-12">
                    <div class="card card-cascade card-table narrower mt-5">

                        <!--Card image-->
                        <div class="view gradient-card-header narrower py-2 mx-4 mb-3 d-flex justify-content-between align-items-center">

                            <h2 class="h5 card-header-title">
                                Lista de envíos
                            </h2>

                            <div>

                                <a 	id="borrar-array-ids"
                                      @click="destroyByIds"
                                      data-url="destroy_by_ids"
                                      :class="$root.configButtons.destroy_by_ids.class" class="px-2"
                                      data-toggle="tooltip"
                                      :title="$root.langButtons.destroy_by_ids_title" >
                                    <i :class="$root.configIcons.destroy.class + ' ' +$root.configIcons.destroy.color"  class="mt-0">
                                    </i>
                                </a>
                            </div>

                        </div><!--/Card image-->

                        <div class="px-2 px-sm-4 mt-1 mb-4">

                            <div class="table-wrapper ">

                                <table id="tabla-listado" class="table table-striped table-hover  table-bordered dt-responsive nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="30">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input checkbox-table " id="checkbox-head">
                                                    <label class="custom-control-label" for="checkbox-head"></label>
                                                </div>
                                            </th>
                                            <th>Negocio</th>
                                            <th>Envíos Por</th>
                                            <th>Nombre</th>
                                            <th>Precio</th>
                                            <th width="30" ></th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input checkbox-table " id="checkbox-head">
                                                    <label class="custom-control-label" for="checkbox-head"></label>
                                                </div>
                                            </th>
                                            <th>Negocio</th>
                                            <th>Envíos Por</th>
                                            <th>Nombre</th>
                                            <th>Precio</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>

                            </div> <!--// table-wrapper -->
                        </div>
                    </div><!--// card -->
                </div>
            </div>


            <div class="modal fade" :id="modalId" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <form v-on:submit.prevent="submit" class="form-css-validate" >

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" >
                                    {{ id == "" ? 'Registrar' : 'Actualizar' }} envío
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
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
                                    <div class="col-md-6 col-lg-4" >
                                        <div class="form-group md-style">
                                            <label >Envíos por*</label>
                                            <Select2
                                                v-model="shippingType"
                                                name="shipping_type"
                                                :options="optionsShippingType"
                                                :settings="{ theme: 'bootstrap4',width:'100%',placeholder:'Tipo de envío',minimumResultsForSearch:-1}"
                                                :class="getValidClassInput('shipping_type')">
                                            </Select2>
                                            <validation-message :errors="errors" name="shipping_type" ></validation-message>
                                        </div>
                                    </div><!--/col-->

                                    <div class="col-md-6 col-lg-4" v-show="shippingType==='department'" >
                                        <div class="form-group md-style">
                                            <label >Departamento*</label>
                                            <Select2
                                                v-model="departmentId"
                                                name="department_id"
                                                :options="optionsDepartment"
                                                :settings="{ theme: 'bootstrap4',width:'100%',placeholder:'Seleccione el departamento'}"
                                                :class="getValidClassInput('department_id')">
                                            </Select2>
                                            <validation-message :errors="errors" name="department_id" ></validation-message>
                                        </div>
                                    </div><!--/col-->

                                    <div class="col-md-6 col-lg-4" v-show="shippingType==='province'" >
                                        <div class="form-group md-style">
                                            <label >Provincia*</label>
                                            <Select2
                                                v-model="provinceId"
                                                name="province_id"
                                                :options="optionsProvince"
                                                :settings="{ theme: 'bootstrap4',width:'100%',placeholder:'Seleccione la provincia'}"
                                                :class="getValidClassInput('province_id')">
                                            </Select2>
                                            <validation-message :errors="errors" name="province_id" ></validation-message>
                                        </div>
                                    </div><!--/col-->

                                    <div class="col-md-6 col-lg-4" v-show="shippingType==='district'" >
                                        <div class="form-group md-style">
                                            <label >Distrito*</label>
                                            <Select2
                                                v-model="districtId"
                                                name="district_id"
                                                :options="optionsDistrict"
                                                :settings="{ theme: 'bootstrap4',width:'100%',placeholder:'Seleccione el distrito'}"
                                                :class="getValidClassInput('district_id')">
                                            </Select2>
                                            <validation-message :errors="errors" name="district_id" ></validation-message>
                                        </div>
                                    </div><!--/col-->

                                    <div class="col-md-6 col-lg-4" >
                                        <div class="form-group md-style">
                                            <label for="price">Precio</label>
                                            <imask-input
                                                id="price"
                                                type="text"
                                                name="price"
                                                v-model="price"
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
                                            />
                                            <validation-message  :errors="errors" name="price" ></validation-message>
                                        </div>
                                    </div>
                                </div><!--/row-->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>
                                <button :class="$root.configButtons.store.class" class="mx-0" type="submit" >
                                    <i :class="id == '' ? $root.configIcons.store.class : $root.configIcons.update.class"></i>
                                    {{ id == '' ? $root.langButtons.store : $root.langButtons.update }}
                                </button>
                            </div>
                        </div><!--/modal-content-->
                    </form>
                </div><!--/modal-dialog-->
            </div><!--/modal-->


        </div><!--/col-->
    </div><!--/row-->
</template>

<script>

import { BusinessService } from '../../../services/admin/business.service';
import { DepartmentService } from "../../../services/admin/department.service";
import { ProvinceService } from "../../../services/admin/province.service";
import { DistrictService } from "../../../services/admin/district.service";
import { ShippingService } from "../../../services/admin/shipping.service";


import {validationMixin} from "../../../mixins/validation-mixin";
import Select2 from "v-select2-component";
import { IMaskComponent } from 'vue-imask';

const businessService = new BusinessService();
const departmentService = new DepartmentService();
const provinceService = new ProvinceService();
const districtService = new DistrictService();
const shippingService = new ShippingService();

let tableList = null;
let component = null;

export default {
    components: {
        Select2,
        'imask-input': IMaskComponent,
    },
    props: {
        idProp: { default:''},
        isAdminBusinessProp : { default:false , type:Boolean },
    },
    mixins: [
        validationMixin,
    ],
    data() {
        return {
            id: '',
            businesses:[],
            optionsBusiness: [ {id: '0', text: 'Seleccione' ,selected:true} ],
            businessId: '0',
            departments: [],
            optionsDepartment: [{id: '0', text: 'Seleccione el departamento', selected: true}],
            departmentId: '0',
            provinces: [],
            optionsProvince: [{id: '0', text: 'Seleccione la provincia', selected: true}],
            provinceId: '0',
            districts: [],
            optionsDistrict: [{id: '0', text: 'Seleccione el distrito', selected: true}],
            districtId: '0',

            optionsShippingType: [
                { id: 'department', text: 'Departamento', selected: true },
                { id: 'province', text: 'Provincia' },
                { id: 'district', text: 'Distrito' }
            ],
            shippingType: 'department',
            price: '',
            isAdminBusiness : this.isAdminBusinessProp,

            modalId : this.getModalId(),
        }
    },
    mounted() {
        console.log('Component Shipping Form List mounted.');

        this.getDepartments();
        this.getProvinces();
        this.getDistricts();

        if(this.$root.canChooseBusiness() && !this.isAdminBusiness ){
            this.getBusinesses();
        }

        this.initTable();

        component = this;
    },
    methods: {
        getModalId: function () {
            return fg.generateUniqueString('modal-form-shipping');
        },
        closeModal: function () {
            $(`#${this.modalId}`).modal('hide');
        },
        openModal: function () {
            $(`#${this.modalId}`).modal('show');
        },
        create: function(){
            this.cleanForm();
            this.openModal();
        },
        cleanForm:function(){
            this.cleanErrors()
            this.id = "";
            this.shippingType = 'department';
            this.departmentId = '0';
            this.provinceId = '0';
            this.districtId = '0';
            this.price = '';
            this.businessId = '0';
        },
        initTable: async function(){

            let urlAjax = `${urlPagina}/api/admin/shipping/list-table`;

            let columnDefs = [
                { "orderable": false, targets: [0,5] },
            ];

            if(this.isAdminBusiness){
                columnDefs.push({
                    "targets": [ 1 ],
                    "visible": false,
                    "searchable": false,
                })
            }

            tableList = $('#tabla-listado').DataTable( {
                "initComplete" : function(settings, json) {
                    $('[data-toggle="tooltip"]').tooltip();
                    dtFunc.inicializarCheckBox();
                },
                "ajax": {
                    "url": urlAjax,
                    "type": 'GET',
                    "data": {'is_admin_business':this.isAdminBusiness},
                },
                "columns": [
                    { "data": "checkbox" }, // envia el id para luego armar el check
                    { "data": "business_name" },
                    { "data": "shipping_type_name" },
                    { "data": "shippingable_name" },
                    { "data": "price" },
                    { "data": "actions" },
                ],
                "responsive":false,
                "scrollX": true,
                "columnDefs": columnDefs ,
                "order": [[ 1, 'asc' ]],
                "language": window.dt_es,
                "pageLength": 10,
                "aLengthMenu": [ 5 ,10, 25, 50, 75, 100 ]
            });
        },
        getDepartments: async function(){
            this.departments = await departmentService.getAll();
            // console.log('departments:',this.departments);
        },
        getProvinces: async function(){
            this.provinces = await provinceService.getAll();
            // console.log('provinces:',this.provinces);
        },
        getDistricts: async function(){
            this.districts = await districtService.getAll();
            // console.log('districts:',this.districts);
        },
        getBusinesses: async function () {
            this.businesses = await businessService.getAll();
        },
        setOptionsDepartment: async function(){

            this.departments.forEach((item)=>{
                this.optionsDepartment.push({id: item.id, text: item.name});
            });
        },
        setOptionsProvince: async function(){
            // console.log("setOptionsProvince");
            this.provinces.forEach((item)=>{
                this.optionsProvince.push({id: item.id, text: item.name});
            });
        },
        setOptionsDistrict: async function(){
            // console.log("setOptionsProvince");
            this.districts.forEach((item)=>{
                this.optionsDistrict.push({id: item.id, text: item.name});
            });
        },
        setBusinessOptions: async function () {
            this.businesses.forEach((item)=>{
                this.optionsBusiness.push({id: item.id, text: item.name});
            });
        },
        destroyByIds:  function (event) {
            console.log('event:',event);
            let url = `${urlPagina}/api/admin/shipping/destroy-by-ids`;
            let element = event.target;
            fg.deleteByArrayId(url,element);
        },
        editModalForm:  async function (element) {
            // console.log('edit modal form component');
            let id = $(element).attr('data-id');
            try{
                let shipping = await shippingService.getOne(id);

                this.id = shipping.id;
                this.shippingType = shipping.shipping_type;
                this.departmentId = shipping.shippingable_id;
                this.provinceId = shipping.shippingable_id;
                this.districtId = shipping.shippingable_id;
                this.price = shipping.price;
                this.businessId = shipping.business_id;
                this.openModal();
                // console.log('shipping:',shipping);

            }catch (error){
                console.log(error);
            }
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

            let btnSubmit = $("button[type='submit']",form);

            let formData = new FormData(form);
            formData.append('is_admin_business',this.isAdminBusiness);

            fg.loadingBtn(btnSubmit);
            try {

                let response = await shippingService.store(formData);
                let data = response.data;

                if(!data.hasError){
                    let modelTable = data.modelTable;
                    tableList.row.add(data.modelTable).draw();
                    this.closeModal();
                    await fg.modalMessage(data.message,'success');
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
            formData.append('is_admin_business',this.isAdminBusiness);

            fg.loadingBtn(btnSubmit);
            try {
                let response = await shippingService.update(this.id,formData);
                let data = response.data;

                if(!data.hasError){
                    let modelTable = data.modelTable;

                    let element = $("#edit-item-"+data.model.id).parents('tr');
                    fg.removeRowTable(element,tableList);

                    //inserta la fila con los datos nuevos
                    tableList.row.add(modelTable).draw();

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
    },
    watch: {
        businesses(val) {
            this.setBusinessOptions();
        },
        departments(val) {
            this.setOptionsDepartment();
        },
        provinces(val){
            this.setOptionsProvince();
        },
        districts(val){
            this.setOptionsDistrict();
        },
    },
}

    global.editModalForm  = function (element){
        component.editModalForm(element);
    }
</script>
