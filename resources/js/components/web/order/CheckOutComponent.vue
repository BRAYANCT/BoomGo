<template>
    <div class="row"  >

        <div class="col-12" v-if="!loadShoppingCart"  >
            <div class=" py-5 bg-white-grey">
                <div class="sk-three-bounce">
                    <div class="sk-child sk-bounce1"></div>
                    <div class="sk-child sk-bounce2"></div>
                    <div class="sk-child sk-bounce3"></div>
                </div>
            </div>
        </div>

        <div class="col-12" v-else >

            <div class="alert alert-primary" v-if="!shoppingCartHasItems()"  >
                El carrito de compras está vacío.
                <a :href="$root.getCompleteUrlByUri('market-place')">Ir a la tienda</a>
            </div>

            <div class="row" v-else >

                <div class="col-12" v-if="!$root.authCheck">
                    <div class="alert alert-primary"   >
                        ¿Ya eres cliente nuestro? <i class="fas fa-long-arrow-alt-right mx-2" ></i> <a @click="$root.showLoginModal()" >Haz click para ingresar a su cuenta.</a>
                    </div>
                </div>

                <div class="col-12" >

                    <validation-error-message class-tag="alert alert-danger" :errors="errors" name="shopping_cart" >
                    </validation-error-message>

                    <form id="form-order" v-on:submit.prevent="submit" class="form-css-validate" >
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <h2 class="h2 mb-3 col-md-12">Detalles de facturación</h2>

                                    <div class="col-md-6">
                                        <label for="names">Nombres*</label>
                                        <input type="text" v-model="names" id="names" class="form-control" name="names" :class="getValidClassInput('names')" required>
                                        <validation-message  :errors="errors" name="names" ></validation-message>
                                    </div><!--/col-->

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="surnames">Apellidos*</label>
                                            <input type="text" v-model="surnames" id="surnames" class="form-control" name="surnames" :class="getValidClassInput('surnames')" required>
                                            <validation-message  :errors="errors" name="surnames" ></validation-message>
                                        </div>
                                    </div><!--/col-->

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address">Email*</label>
                                            <input type="email" v-model="email" id="email" name="email" class="form-control" :class="getValidClassInput('email')" required >
                                            <small v-if="!$root.authCheck" class="helper-text">Se utilizará el email para crear su cuenta.</small>
                                            <validation-message  :errors="errors" name="email" ></validation-message>
                                        </div>
                                    </div><!--/col-->

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Teléfono*</label>
                                            <input type="text" v-model="phone" id="phone" name="phone" class="form-control" :class="getValidClassInput('phone')" required>
                                            <validation-message  :errors="errors" name="phone" ></validation-message>
                                        </div>
                                    </div><!--/col-->

                                    <h2 class="h2 mb-3 col-md-12">¿Dónde quieres recibir tu pedido?</h2>

                                    <div class="col-md-12" >
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

                                    <div class="col-md-12" >
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

                                    <div class="col-md-12" >
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

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address">Dirección*</label>
                                            <input v-model="address" type="text" id="address" name="address" class="form-control" :class="getValidClassInput('address')" required>
                                            <validation-message  :errors="errors" name="address" ></validation-message>
                                        </div>
                                    </div><!--/col-->


                                </div><!--/row-->

                                <div class="row">
                                    <h2 class="h2 mb-3 col-md-12">Información adicional</h2>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="observation">Añada notas a su pedido(Opcional)</label>
                                            <textarea class="form-control rounded-0" id="observation" name="observation" :class="getValidClassInput('observation')" rows="5"></textarea>
                                            <validation-message  :errors="errors" name="observation" ></validation-message>
                                        </div>
                                    </div><!--/col-->

                                </div><!--/row-->
                            </div><!--/col-->

                            <div class="col-md-6">

                                <div class="row mb-3">
                                    <div class="col-12" >
                                        <h2 class="h2 mb-3">Resumen de compra</h2>
                                        <div class="card bg-white-grey" >
                                            <div class="card-body">

                                                <template v-if="businessId === '' " >
                                                    <div  class="row mb-2" v-for="(item , index) in shoppingCart.items" >
                                                        <div class="col-7">
                                                            {{ item.name }} x {{ item.quantity }}
                                                        </div>
                                                        <div class="col-5 text-right">
                                                            S/{{ item.final_price }}
                                                            <span v-if="item.offer_active" class="crossed-out-price" >
                                                        S/ {{ item.price }}
                                                    </span>
                                                        </div>
                                                    </div>
                                                </template>
                                                <template v-else >
                                                    <div  class="row mb-2" v-for="(item , index) in businessItems" >
                                                        <div class="col-7">
                                                            {{ item.name }} x {{ item.quantity }}
                                                        </div>
                                                        <div class="col-5 text-right">
                                                            S/{{ item.final_price }}
                                                            <span v-if="item.offer_active" class="crossed-out-price" >
                                                        S/ {{ item.price }}
                                                    </span>
                                                        </div>
                                                    </div>
                                                </template>


                                                <div class="row" >
                                                    <div class="col-7">
                                                        Envío
                                                    </div>
                                                    <div class="col-5 text-right">
                                                        S/ {{ shippingPrice }}
                                                    </div>
                                                </div>

                                            </div>
                                            <hr class="my-0">

                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-7">
                                                        Total
                                                    </div>
                                                    <div class="col-5 text-right">
                                                        S/{{ businessId === '' ? getTotal() :  getTotalByItems(businessItems) }}
                                                    </div>
                                                </div>

                                            </div><!--/card-body-->
                                        </div><!--/card-->
                                    </div><!--/col-->
                                </div><!--/row-->

                                <div class="row mb-3" >
                                    <div class="col-12">
                                        <h2 class="h2 mb-3">Método de pago</h2>
                                        <div class="card bg-white-grey">
                                            <div class="card-body" >

                                                <div class="row" style="margin-bottom: -1.5rem !important;">
                                                    <div class="col-12" v-for="(item,index) in paymentMethods">
                                                        <div class="custom-control custom-radio mb-4 p-0"  >
                                                            <input type="radio" class="custom-control-input" :id="'payment-method-id-'+index" v-model="paymentMethodId" name="payment_method_id" :value="item.id" >
                                                            <label class="custom-control-label" :for="'payment-method-id-'+index">
                                                                {{ item.name }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!--/card-body-->
                                        </div><!--/card-->
                                        <validation-error-message class="alert alert-danger m-0 mt-2" :errors="errors" name="payment_method_id" ></validation-error-message>
                                    </div><!--/col-->
                                </div><!--/row-->


<!--                                <div class="row" v-if="paymentMethodId == 1">-->

<!--                                    <div class="col-md-6">-->
<!--                                        <div class="form-group">-->
<!--                                            <label for="docType" >Tipo de documento*</label>-->
<!--                                            <select id="docType" name="docType" data-checkout="docType" class="browser-default custom-select">-->
<!--                                            </select>-->
<!--                                        </div>-->
<!--                                    </div>-->

<!--                                    <div class="col-md-6">-->
<!--                                        <div class="form-group">-->
<!--                                            <label for="cardholderName" >Número de documento*</label>-->
<!--                                            <input type="text" id="docNumber" name="doc_number" data-checkout="docNumber" class="form-control" required>-->
<!--                                        </div>-->
<!--                                    </div>&lt;!&ndash;/col&ndash;&gt;-->

<!--                                    <div class="col-md-12">-->
<!--                                        <div class="form-group">-->
<!--                                            <label for="cardholderName" >Titular de la tarjeta*</label>-->
<!--                                            <input type="text" id="cardholderName" data-checkout="cardholderName" class="form-control" required>-->
<!--                                        </div>-->
<!--                                    </div>&lt;!&ndash;/col&ndash;&gt;-->


<!--                                    <div class="col-md-6">-->
<!--                                        <div class="form-group">-->
<!--                                            <label for="cardNumber">Número de la tarjeta*</label>-->
<!--                                            <input v-model="cardNumber" class="form-control" type="text" id="cardNumber" data-checkout="cardNumber"-->
<!--                                                   onselectstart="return false" onpaste="return false"-->
<!--                                                   oncopy="return false" oncut="return false"-->
<!--                                                   ondrag="return false" ondrop="return false" autocomplete=off>-->
<!--                                        </div>-->
<!--                                    </div>&lt;!&ndash;/col&ndash;&gt;-->

<!--                                    <div class="col-md-6">-->
<!--                                        <div class="form-group">-->
<!--                                            <label for="cardholderName">Fecha de vencimiento*</label>-->
<!--                                            <div class="d-flex">-->
<!--                                                <input type="text" class="form-control" placeholder="MM" id="cardExpirationMonth" data-checkout="cardExpirationMonth"-->
<!--                                                       onselectstart="return false" onpaste="return false"-->
<!--                                                       oncopy="return false" oncut="return false"-->
<!--                                                       ondrag="return false" ondrop="return false" autocomplete=off>-->
<!--                                                <span class="date-separator mx-1 h2">/</span>-->
<!--                                                <input type="text" class="form-control" placeholder="YY" id="cardExpirationYear" data-checkout="cardExpirationYear"-->
<!--                                                       onselectstart="return false" onpaste="return false"-->
<!--                                                       oncopy="return false" oncut="return false"-->
<!--                                                       ondrag="return false" ondrop="return false" autocomplete=off>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>&lt;!&ndash;/col&ndash;&gt;-->

<!--                                    <div class="col-md-6">-->
<!--                                        <div class="form-group">-->
<!--                                            <label for="securityCode">Código de seguridad*</label>-->
<!--                                            <input id="securityCode" class="form-control" placeholder="CVV" data-checkout="securityCode" type="text"-->
<!--                                                   onselectstart="return false" onpaste="return false"-->
<!--                                                   oncopy="return false" oncut="return false"-->
<!--                                                   ondrag="return false" ondrop="return false" autocomplete=off>-->
<!--                                        </div>-->
<!--                                    </div>&lt;!&ndash;/col&ndash;&gt;-->

<!--                                    <div class="col-md-12" v-show="optionsIssuer.length > 0" >-->
<!--                                        <div class="form-group">-->
<!--                                            <label >Banco emisor*</label>-->
<!--                                            <Select2-->
<!--                                                v-model="issuer"-->
<!--                                                name="issuer"-->
<!--                                                :options="optionsIssuer"-->
<!--                                                :settings="{ theme: 'bootstrap4',width:'100%',placeholder:'Seleccione el banco'}"-->
<!--                                            >-->
<!--                                            </Select2>-->
<!--                                        </div>-->
<!--                                    </div>&lt;!&ndash;/col&ndash;&gt;-->

<!--                                    <div class="col-md-12" >-->
<!--                                        <div class="form-group">-->
<!--                                            <label >Cuotas*</label>-->
<!--                                            <Select2-->
<!--                                                v-model="installments"-->
<!--                                                name="installments"-->
<!--                                                :options="optionsInstallments"-->
<!--                                                :settings="{ theme: 'bootstrap4',width:'100%',placeholder:'Seleccione las cuotas',minimumResultsForSearch:-1}"-->
<!--                                            >-->
<!--                                            </Select2>-->
<!--                                        </div>-->
<!--                                    </div>&lt;!&ndash;/col&ndash;&gt;-->

<!--                                    <input type="hidden" name="transactionAmount" id="transactionAmount" :value="businessId === '' ? getTotal() :  getTotalByItems(businessItems)" />-->
<!--                                    <input v-model="cardPaymentMethod" type="hidden" name="paymentMethodId" id="paymentMethodId" />-->
<!--                                    <input type="hidden" name="description" id="description" />-->
<!--                                    &lt;!&ndash;                            <input type="hidden" name="docType" id="docType" value="DNI" />&ndash;&gt;-->
<!--                                </div>&lt;!&ndash;/row&ndash;&gt;-->


                                <button type="submit" class="btn btn-secondary-custom">
                                    Finalizar
                                </button>

                            </div><!--/col-->

                        </div><!--/row-->
                    </form>



                </div><!--/col-->
            </div><!--/row-->
        </div><!--/col-->
    </div><!--/row-->
</template>

<!--<script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>-->

<script>

import {shoppingCartMixin} from "../../../mixins/shopping-cart-mixin";

// require('../../../../../public/plugins/mercado-pago/mercadopago')


import { DepartmentService } from "../../../services/web/department.service";
import { ProvinceService } from "../../../services/web/province.service";
import { DistrictService } from "../../../services/web/district.service";
import { OrderService } from "../../../services/web/order.service";
import { PaymentMethodService } from "../../../services/web/payment-method.service";
import { BillingInformationService } from "../../../services/admin/billing-information.service";
import Select2 from "v-select2-component";
import { validationMixin } from "../../../mixins/validation-mixin";

const departmentService = new DepartmentService();
const provinceService = new ProvinceService();
const districtService = new DistrictService();
const orderService = new OrderService();
const paymentMethodService = new PaymentMethodService();
const billingInformationService = new BillingInformationService();

// let mercadopago = require('mercadopago');

export default {
    components: {
        Select2,
    },
    mixins: [
        validationMixin,
        shoppingCartMixin,
    ],
    props: {
        businessIdProp: { default:''},
    },
    data(){
        return {
            businessId: this.businessIdProp,

            names:'',
            surnames:'',
            email:'',
            phone:'',

            departments: [],
            optionsDepartment: [{id: '0', text: 'Seleccione el departamento' ,selected:true}],
            departmentId: '0',
            provinces: [],
            optionsProvince: [{id: '0', text: 'Seleccione la provincia' ,selected:true}],
            provinceId: '0',
            districts: [],
            optionsDistrict: [{id: '0', text: 'Seleccione el distrito' ,selected:true}],
            districtId: '0',

            provinceInitData:false,
            districtInitData:false,

            address: '',

            optionsInstallments: [],
            installments: '',

            optionsIssuer: [],
            issuer: '',

            cardNumber:'',
            cardPaymentMethod:'',
            cardToken:'',


            paymentMethods: [],
            paymentMethodId:'',

            mercadoPagoPublicKey: 'APP_USR-7635d160-41a5-400d-90fe-c2b09b69aedf'

        }
    },
    mounted() {
        // console.log('Component Web Check Out mounted.');
        // console.log('businessId:',this.businessId);


        // console.log("authUser:",this.$root.authUser);

        this.setShoppingCart();

        this.getDepartments();
        this.getProvinces();
        this.getDistricts();

        if(fg.isEmpty(this.businessId)){
            this.getPaymentMethodsOfShoppingCartBusinesses();
        }else{
            this.getPaymentMethodByBusiness(this.businessId)
        }

        // mercadopago.configure({
        //     access_token: this.mercadoPagoPublicKey
        // })
        //
        // mercadopago.getIdentificationTypes();

        // window.Mercadopago.setPublishableKey(this.mercadoPagoPublicKey);
        // window.Mercadopago.getIdentificationTypes();
        // console.log('mercadoPagoPublicKey:',this.mercadoPagoPublicKey)

        this.setInitData();

    },
    methods: {
        setInitData: async function(){
            try {

                if(this.$root.authCheck){
                    let billingInformation = await billingInformationService.getLastOneForAuthUser();

                    if(billingInformation){
                        this.names = billingInformation.names;
                        this.surnames = billingInformation.surnames;
                        this.email = billingInformation.email;
                        this.phone = billingInformation.phone;
                        this.departmentId = billingInformation.district.province.department_id;
                        this.provinceId = billingInformation.district.province_id;
                        this.districtId = billingInformation.district_id;
                        this.address = billingInformation.address;
                    }else{

                        if(this.$root.authUser){
                            let authUser = this.$root.authUser
                            this.names = authUser.names;
                            this.surnames = authUser.surnames;
                            this.email = authUser.email;
                        }

                        this.provinceInitData = true;
                        this.districtInitData = true;
                    }
                    console.log('billingInformation ',billingInformation);
                }

            }catch (error) {
                console.log(error);
            }
        },
        setShippingPrice: function(){
            let shippingPrice = 0;
            if(this.shippings){
                this.shippings.forEach((item)=>{
                    shippingPrice += parseFloat(item.price);
                });
            }
            this.shippingPrice = parseFloat(shippingPrice).toFixed(2);
        },
        setFirstPaymentMethod: async function(){
            if(this.paymentMethods.length>0){
                this.paymentMethodId = this.paymentMethods[0].id;
            }
        },
        getPaymentMethodByBusiness: async function(businessId){
            this.paymentMethods = await paymentMethodService.getAllByBusiness(businessId);
            this.setFirstPaymentMethod();
        },
        getPaymentMethodsOfShoppingCartBusinesses: async function(){
            this.paymentMethods = await paymentMethodService.getAllOfShoppingCartBusinesses();
            this.setFirstPaymentMethod();
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
        setOptionsDepartment: async function(){

            this.departments.forEach((item)=>{
                this.optionsDepartment.push({id: item.id, text: item.name});
            });
        },
        setOptionsProvince: async function(){
            // console.log("setOptionsProvince");
            this.optionsProvince = [{id: '0', text: 'Seleccione la provincia' ,selected:true}];

            if(this.provinceInitData){
                this.provinceId = "0";
            }else{
                this.provinceInitData = true;
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

            if(this.districtInitData){
                this.districtId = "0";
            }else{
                this.districtInitData = true;
            }
            this.districts.forEach((item)=>{
                if(parseInt(item.province_id) === parseInt(this.provinceId)){
                    this.optionsDistrict.push({id: item.id, text: item.name});
                }
            });
        },
        guessPaymentMethod: async function(){
            // console.log('guessPaymentMethod')
            if (this.cardNumber.length >= 6) {
                // console.log('mayor a 6');
                let bin = this.cardNumber.substring(0,6);
                window.Mercadopago.getPaymentMethod({
                    "bin": bin
                }, this.setPaymentMethod);
            }
        },
        setPaymentMethod: async function(status, response){
            console.log('setPaymentMethod',status)
            if (status == 200) {
                let paymentMethod = response[0];
                this.cardPaymentMethod = paymentMethod.id;
                if(paymentMethod.additional_info_needed.includes("issuer_id")){
                    this.getIssuers(this.cardPaymentMethod);
                } else {
                    this.getInstallments(
                        this.cardPaymentMethod,
                        document.getElementById('transactionAmount').value
                    );
                }
            } else {
                alert(`payment method info error: ${response}`);
            }
        },
        getIssuers: async function(paymentMethodId) {
            window.Mercadopago.getIssuers(
                paymentMethodId,
                this.setIssuers
            );
        },
        setIssuers: async function(status, response) {
            if (status == 200) {

                response.forEach( (issuer,index) => {
                    if(index == 0) this.issuer = issuer.id;
                    this.optionsInstallment.push({id: issuer.id, text: issuer.name})
                });

                this.getInstallments(
                    this.cardPaymentMethod,
                    document.getElementById('transactionAmount').value,
                    this.issuer,
                );

            } else {
                alert(`issuers method info error: ${response}`);
            }
        },
        getInstallments: async function(paymentMethodId, transactionAmount, issuerId){
            window.Mercadopago.getInstallments({
                "payment_method_id": paymentMethodId,
                "amount": parseFloat(transactionAmount),
                "issuer_id": issuerId ? parseInt(issuerId) : undefined
            }, this.setInstallments);
        },
        setInstallments: async function (status, response){
            if (status == 200) {
                this.optionsInstallment = [];
                response[0].payer_costs.forEach( (payerCost,index) => {
                    if(index ==0) this.installments = payerCost.installments;
                    this.optionsInstallments.push({id: payerCost.installments, text: payerCost.recommended_message})
                });
            } else {
                alert(`installments method info error: ${response}`);
            }
        },
        getCardToken: async function (form){
            window.Mercadopago.createToken(form, this.setCardTokenAndPay);
        },
        setCardTokenAndPay: async function (status, response) {
            console.log("setCardTokenAndPay");
            if (status == 200 || status == 201) {
                console.log('token:',response.id);
                this.cardToken = response.id;
                this.store();

            } else {
                alert("Verify filled data!\n"+JSON.stringify(response, null, 4));
            }
        },
        submit: async function(event){
            let form = event.target;

            this.cleanErrors()

            // if(this.paymentMethodId == 1){
            //     this.getCardToken(form);
            // }else{
            //     this.store(form);
            // }

            this.store();

        },
        store: async function(){

            let form = $("#form-order")[0];

            let btnSubmit = $("button[type='submit']",form);
            let formData = new FormData(form);
            formData.append('cardToken',this.cardToken);

            fg.loadingBtn(btnSubmit);
            try {
                let response = null;

                if(fg.isEmpty(this.businessId)){
                    response = await orderService.store(formData);
                }else{
                    response = await orderService.storeByBusiness(this.businessId,formData);
                }

                let data = response.data;

                console.log("data:",data);

                if(!data.hasError){
                    let model = data.model;
                    if(this.paymentMethodId == 1){
                        fg.loadPage(data.url_redirect);
                    }else{
                        await fg.modalMessage(data.message,'success');
                        fg.loadPage(this.$root.getCompleteUrlByUri(`checkout/${model.id}/thanks`));
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
        districtId(districtId){
            if(districtId !== '0'){
                if(this.businessId === ''){
                    this.getShippings(districtId);
                }else{
                    this.getShippingByBusinessAndPriorityDistrict(this.businessId,districtId);
                }
            }
        },
        cardNumber(val){
            this.guessPaymentMethod();
        },
        shippings(val){
            this.setShippingPrice();
        }
    },
}


// function getCardToken(event){
//     event.preventDefault();
//     if(!doSubmit){
//         let $form = document.getElementById('paymentForm');
//         window.Mercadopago.createToken($form, setCardTokenAndPay);
//         return false;
//     }
// };
//
// function setCardTokenAndPay(status, response) {
//     if (status == 200 || status == 201) {
//         let form = document.getElementById('paymentForm');
//         let card = document.createElement('input');
//         card.setAttribute('name', 'token');
//         card.setAttribute('type', 'hidden');
//         card.setAttribute('value', response.id);
//         form.appendChild(card);
//         doSubmit=true;
//         form.submit();
//     } else {
//         alert("Verify filled data!\n"+JSON.stringify(response, null, 4));
//     }
// };

//
// function guessPaymentMethod(event) {
//     console.log('guessPaymentMethod');
//     let cardnumber = document.getElementById("cardNumber").value;
//     if (cardnumber.length >= 6) {
//         let bin = cardnumber.substring(0,6);
//         window.Mercadopago.getPaymentMethod({
//             "bin": bin
//         }, setPaymentMethod);
//     }
// };
//
// function setPaymentMethod(status, response) {
//     if (status == 200) {
//         let paymentMethod = response[0];
//         document.getElementById('paymentMethodId').value = paymentMethod.id;
//
//         if(paymentMethod.additional_info_needed.includes("issuer_id")){
//             getIssuers(paymentMethod.id);
//         } else {
//             getInstallments(
//                 paymentMethod.id,
//                 document.getElementById('transactionAmount').value
//             );
//         }
//     } else {
//         alert(`payment method info error: ${response}`);
//     }
// }
//
// function getIssuers(paymentMethodId) {
//     window.Mercadopago.getIssuers(
//         paymentMethodId,
//         setIssuers
//     );
// }
//
// function setIssuers(status, response) {
//     console.log('setIssuers:');
//     if (status == 200) {
//         let issuerSelect = document.getElementById('issuer');
//         response.forEach( issuer => {
//             let opt = document.createElement('option');
//             opt.text = issuer.name;
//             opt.value = issuer.id;
//             issuerSelect.appendChild(opt);
//         });
//
//         getInstallments(
//             document.getElementById('paymentMethodId').value,
//             document.getElementById('transactionAmount').value,
//             issuerSelect.value
//         );
//     } else {
//         alert(`issuers method info error: ${response}`);
//     }
// }
//
// function getInstallments(paymentMethodId, transactionAmount, issuerId){
//     window.Mercadopago.getInstallments({
//         "payment_method_id": paymentMethodId,
//         "amount": parseFloat(transactionAmount),
//         "issuer_id": issuerId ? parseInt(issuerId) : undefined
//     }, setInstallments);
// }
//
// function setInstallments(status, response){
//     if (status == 200) {
//         document.getElementById('installments').options.length = 0;
//         response[0].payer_costs.forEach( payerCost => {
//             let opt = document.createElement('option');
//             opt.text = payerCost.recommended_message;
//             opt.value = payerCost.installments;
//             document.getElementById('installments').appendChild(opt);
//         });
//     } else {
//         alert(`installments method info error: ${response}`);
//     }
// }


</script>
