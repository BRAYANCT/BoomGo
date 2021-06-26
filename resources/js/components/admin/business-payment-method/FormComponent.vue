<template>
    <div class="row">
        <div class="col-12">

            <div class="row mb-4" v-if="$root.canChooseBusiness() && !isAdminBusiness" >
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


            <ul class="nav nav-tabs tertiary-custom-color mx-0" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="mercado-pago-tab" data-toggle="tab" href="#mercado-pago-pane" >Mercado pago</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="wire-transfer-tab" data-toggle="tab" href="#wire-transfer-pane" >Transferencia bancaria</a>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">

                <div class="tab-pane fade show active" id="mercado-pago-pane" >
                    <div class="row" v-show="loadMercadoPagoPayment">

                        <div v-if="mercadoPagoPayment" class="col-12">
                            <div class="alert alert-primary" role="alert">
                                Ya contamos con sus credenciales para los pagos con tarjeta.
                            </div>
                            <p>Access token:  {{ mercadoPagoPayment.access_token }}</p>
                            <p>Public key:  {{ mercadoPagoPayment.public_key }}</p>
                            <p>Client id:  {{ mercadoPagoPayment.client_id }}</p>
                        </div>
                        <div v-else class="col-12" v-show="showBtnAuthorization()" >
                            <div class="alert alert-primary" role="alert">
                                Necesitamos que nos de autorización para que su cuenta de mercado de pago puede recibir el dinero de sus compras.<br>
                                Presione en el siguiente botón y acepte los permisos.
                            </div>
                            <a :href="getUrlAuthorization()" class="btn btn-secondary-custom mx-0">
                                Autorizar mercado pago
                            </a>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="wire-transfer-pane" >

                    <div class="row"  >

                        <div class="col-12">
                            <h3 class="h4">
                                Transferencia bancaria
                            </h3>

                            <form v-on:submit.prevent="storeWireTransferByBusiness" class="form-css-validate" >
                                <div class="row">

                                    <div class="col-md-12 mb-3">
                                        <div class="md-form ">
                                            <textarea id="instructions" name="instructions" class="md-textarea form-control" placeholder="Ingrese las instrucciones que sus clientes tienen que realizar al elegir como medio de pago la transferencia bancaria." :class="getValidClassInput('instructions')" rows="5" v-model="wireTransfer.instructions" ></textarea>
                                            <label for="instructions">
                                                Instrucciones <i class="far fa-question-circle text-dark icon-helper" data-toggle="tooltip" title="Estas instrucciones se le mostrarán a sus clientes al finalizar sus compras." ></i>
                                            </label>
                                            <validation-message  :errors="errors" name="instructions" ></validation-message>
                                        </div>
                                    </div>


                                    <div class="col-12" >

                                        <h3 class="h4">
                                            Ingrese sus números de cuenta
                                        </h3>

                                        <div class="table-responsive text-nowrap">
                                            <div>
                                                <table class="table table-striped table-hover  table-bordered dt-responsive nowrap">
                                                    <thead>
                                                    <tr>
                                                        <th>Nombre de la cuenta</th>
                                                        <th>Número de cuenta</th>
                                                        <th>Nombre del banco </th>
                                                        <th>CCI </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr v-for="(item,index) in accountNumbers" >
                                                        <td>
                                                            <input type="text" class="form-control" v-model="item.name" name="name[]" :class="getValidClassInput('name.'+index)" >
                                                            <validation-message  :errors="errors" :name="'name.'+index" ></validation-message>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" v-model="item.account_number" name="account_number[]" :class="getValidClassInput('account_number.'+index)" >
                                                            <validation-message  :errors="errors" :name="'account_number.'+index" ></validation-message>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" v-model="item.name_bank" name="name_bank[]" :class="getValidClassInput('name_bank.'+index)" >
                                                            <validation-message  :errors="errors" :name="'name_bank.'+index" ></validation-message>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" v-model="item.cci" name="cci[]" :class="getValidClassInput('cci.'+index)" >
                                                            <validation-message  :errors="errors" :name="'cci.'+index" ></validation-message>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div><!--/table-responsive-->

                                        <button @click="addAccountNumber()" type="button" class="btn btn-blue btn-md">
                                            <i :class="$root.configIcons.plus.class"></i> Agregar
                                        </button>
                                        <button v-if="accountNumbers.length>1" @click="removeAccountNumber()" type="button" class="btn btn-danger btn-md">
                                            <i :class="$root.configIcons.less.class"></i> Quitar
                                        </button>

                                    </div><!--/col-->

                                    <div class="col-12">
                                        <button type="submit" :class="$root.configButtons.store.class">
                                            <i :class="$root.configIcons.store.class"></i> Guardar
                                        </button>
                                    </div>

                                </div><!--/row-->
                            </form>

                        </div><!--/col-->
                    </div><!--/row-->
                </div><!--/tab-pane-->

            </div>




        </div><!--/col-->
    </div><!--/row-->
</template>

<script>

import { BusinessService } from '../../../services/admin/business.service';
import { BusinessPaymentMethodService } from "../../../services/admin/business-payment-method.service";

import Select2 from "v-select2-component";
import { validationMixin } from "../../../mixins/validation-mixin";

const businessService = new BusinessService();
const businessPaymentMethodService = new BusinessPaymentMethodService();


export default {
    components: {
        Select2,
    },
    mixins: [
        validationMixin,
    ],
    props: {
        businessIdProp: { default:''},
        isAdminBusinessProp : { default:false , type:Boolean },
        urlAuthMercadoPagoProp : { default:''},
    },
    data(){
        return {
            isAdminBusiness : this.isAdminBusinessProp,
            optionsBusiness: [{id: '0', text: 'Seleccione' ,selected:true}],
            businessId: this.businessIdProp != '' ? this.businessIdProp : '0',
            urlAuthMercadoPago : this.urlAuthMercadoPagoProp,
            businessPaymentMethod: null,
            mercadoPagoPayment: null,
            loadMercadoPagoPayment: false,

            wireTransfer: {},
            accountNumbers: [{}],
        }
    },
    mounted() {
        console.log('Component Business Payment Form mounted.');

        if(this.isAdminBusiness){
            this.getMercadoPagoByBusiness(this.businessId);
            this.getWireTransferByBusiness(this.businessId)
        }else{
            this.setBusinessOptions();
        }

    },
    methods: {
        getMercadoPagoByBusiness: async function (businessId) {
            this.mercadoPagoPayment = await businessPaymentMethodService.getMercadoPagoByBusiness(businessId);
            // console.log('mercadoPagoPayment',this.mercadoPagoPayment);
            this.loadMercadoPagoPayment = true;
        },
        getWireTransferByBusiness: async function (businessId) {
            let wireTransfer = await businessPaymentMethodService.getWireTransferByBusiness(businessId);
            if(wireTransfer){
                this.wireTransfer = wireTransfer
                this.accountNumbers = wireTransfer.account_numbers
            }else{
                this.wireTransfer = {};
                this.accountNumbers = [{}];
            }
            setTimeout(function(){
                $('input,textarea').trigger('change');
            }, 300);
            // console.log('wireTransfer:',this.wireTransfer);
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
        showBtnAuthorization: function(){
            if(this.isAdminBusiness){
                return true;
            }
            return !(this.businessId === '0');
        },
        getUrlAuthorization: function () {
            let url = new URL(this.urlAuthMercadoPago);
            if(!this.isAdminBusiness){
                url.searchParams.append('state',this.businessId);
            }
            return url.href;
        },
        addAccountNumber: async function(){
            this.accountNumbers.push({});
        },
        removeAccountNumber: async function(){
            if(this.accountNumbers.length > 1){
                this.accountNumbers.pop();
            }
        },
        storeWireTransferByBusiness: async function(event){
            this.cleanErrors();
            let form = event.target;
            let btnSubmit = $("button.submit[type='submit']",form);
            let formData = new FormData(form);

            fg.loadingBtn(btnSubmit);
            try {

                let response = await businessPaymentMethodService.storeOrUpdateWireTransferByBusiness(this.businessId,formData);
                let data = response.data;

                if(!data.hasError){
                    let model = data.model;
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
    },
    watch: {
        businessId(val) {
            this.loadMercadoPagoPayment = false;
            if(val !== ''){
                this.getMercadoPagoByBusiness(val);
                this.getWireTransferByBusiness(val);
            }
        },
    }
}
</script>
