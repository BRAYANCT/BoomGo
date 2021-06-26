<template>
    <div class="row">
        <div class="col-md-12" >

            <form v-on:submit.prevent="store" class="form-css-validate form-btn-loader" method='POST' >

                <div class="row mb-5">

                    <div class="col-12">
                        <h2 class="h3" >Datos del cliente</h2>
                    </div>

                    <div class="col-md-4">
                        <div class="md-form ">
                            <input type="text" id="names" name="names"  class="form-control" :class="getValidClassInput('names')" :maxlength="$root.configAttributes.names.max" >
                            <label for="names">Nombres*</label>
                            <validation-message  :errors="errors" name="names" ></validation-message>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="md-form ">
                            <input type="text" id="surnames" name="surnames" class="form-control" :class="getValidClassInput('surnames')" :maxlength="$root.configAttributes.surnames.max" >
                            <label for="surnames">Apellidos*</label>
                            <validation-message  :errors="errors" name="surnames" ></validation-message>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-6">
                                <web-document-type-select
                                    :errors-prop="errors" ></web-document-type-select>
                            </div>
                            <div class="col-6">
                                <div class="md-form ">
                                    <input type="text" id="identification_document" name="identification_document" class="form-control" :class="getValidClassInput('identification_document')" :maxlength="$root.configAttributes.identification_document.max" >
                                    <label for="identification_document">Número Doc.*</label>
                                    <validation-message  :errors="errors" name="identification_document" ></validation-message>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="md-form ">
                            <input type="text" id="phone" name="phone" class="form-control" :class="getValidClassInput('phone')" :maxlength="$root.configAttributes.phone.max" >
                            <label for="phone">Teléfono fijo/Celular</label>
                            <validation-message  :errors="errors" name="phone" ></validation-message>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="md-form ">
                            <input type="email" id="email" name="email" class="form-control" :class="getValidClassInput('email')" :maxlength="$root.configAttributes.email.max" >
                            <label for="email">Email</label>
                            <validation-message  :errors="errors" name="email" ></validation-message>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <web-department-select
                            :errors-prop="errors"
                            @changeValue="changeDepartment" ></web-department-select>
                    </div>

                    <div class="col-md-4">
                        <web-province-select
                            :errors-prop="errors"
                            @changeValue="changeProvince"
                            :init-load-options="false"
                            :department-id-prop="departmentId" ></web-province-select>
                    </div>

                    <div class="col-md-4">
                        <web-district-select
                            :errors-prop="errors"
                            :init-load-options="false"
                            :province-id-prop="provinceId" ></web-district-select>
                    </div>

                    <div class="col-md-4">
                        <div class="md-form ">
                            <input type="text" id="address" name="address" class="form-control" :class="getValidClassInput('address')" :maxlength="$root.configAttributes.address.max" >
                            <label for="address">Dirección*</label>
                            <validation-message  :errors="errors" name="address" ></validation-message>
                        </div>
                    </div>
                </div><!--/row-->

                <div class="row mb-5">
                    <div class="col-12">
                        <h2 class="h3" >Completar estos datos si el cliente es menor de edad</h2>
                    </div>

                    <div class="col-md-4">
                        <div class="md-form ">
                            <input type="text" id="tutor_full_name" name="tutor_full_name" class="form-control" :class="getValidClassInput('tutor_full_name')" :maxlength="$root.configAttributes.full_name.max" >
                            <label for="tutor_full_name">Nombre completo</label>
                            <validation-message  :errors="errors" name="tutor_full_name" ></validation-message>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="md-form ">
                            <input type="email" id="tutor_email" name="tutor_email"  class="form-control" :class="getValidClassInput('tutor_email')" :maxlength="$root.configAttributes.email.max" >
                            <label for="tutor_email">Email</label>
                            <validation-message  :errors="errors" name="tutor_email" ></validation-message>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-6">
                                <web-document-type-select
                                    :errors-prop="errors"
                                    document-type-input-name="tutor_document_type_id" ></web-document-type-select>
                            </div>
                            <div class="col-6">
                                <div class="md-form ">
                                    <input type="text" id="tutor_identification_document" name="tutor_identification_document" class="form-control" :class="getValidClassInput('tutor_identification_document')" :maxlength="$root.configAttributes.identification_document.max" >
                                    <label for="tutor_identification_document">Número Doc.*</label>
                                    <validation-message  :errors="errors" name="tutor_identification_document" ></validation-message>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <h2 class="h3" >Datos del reclamo</h2>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group md-style">
                            <label>Tipo*</label>
                            <div class="custom-control custom-radio p-0">
                                <input id="claim_type_reclamo" type="radio" class="custom-control-input"  name="claim_type" value="Reclamo">
                                <label class="custom-control-label" for="claim_type_reclamo">Reclamo (1)</label>
                            </div>
                            <div class="custom-control custom-radio p-0">
                                <input id="claim_type_queja" type="radio" class="custom-control-input"  name="claim_type" value="Queja">
                                <label class="custom-control-label" for="claim_type_queja">Queja (2)</label>
                            </div>
                            <validation-message  :errors="errors" name="claim_type" ></validation-message>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group md-style">
                            <label>Relacionado a*</label>
                            <div class="custom-control custom-radio p-0">
                                <input id="related_claim_product" type="radio" class="custom-control-input"  name="related_claim" value="Producto">
                                <label class="custom-control-label" for="related_claim_product">Producto</label>
                            </div>
                            <div class="custom-control custom-radio p-0">
                                <input id="related_claim_service" type="radio" class="custom-control-input"  name="related_claim" value="Servicio">
                                <label class="custom-control-label" for="related_claim_service">Servicio</label>
                            </div>
                            <validation-message  :errors="errors" name="related_claim" ></validation-message>
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <div class="md-form">
                            <textarea id="detail_claims" name="detail_claims" class="md-textarea form-control" :class="getValidClassInput('detail_claims')" rows="5"></textarea>
                            <label for="detail_claims">Detalle del reclamo / Queja, según indica el cliente*</label>
                            <validation-message  :errors="errors" name="detail_claims" ></validation-message>
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <div class="md-form">
                            <textarea id="client_request" name="client_request" class="md-textarea form-control" :class="getValidClassInput('client_request')" rows="8"></textarea>
                            <label for="client_request">Pedido del cliente*</label>
                            <validation-message  :errors="errors" name="client_request" ></validation-message>
                        </div>
                    </div>

                    <div class="col-12 mt-4 mb-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="agreed_to_be_owner" name="agreed_to_be_owner" value="1">
                            <label class="custom-control-label" for="agreed_to_be_owner">
                                Declaro ser el titular del servicio y acepto el contenido del presente formulario manifestando bajo Declaracion jurada la veracidad de los hechos descritos.(*)
                            </label>
                        </div>
                        <validation-message  :errors="errors" name="agreed_to_be_owner" ></validation-message>
                    </div>
                    <div class="col-12">
                        <ul>
                            <li>La formulación del reclamo no impide acudir a otras vías de solución de controversias ni es requisito previo para interponer una denuncia ante el INDECOPI.</li>
                            <li>El proveedor deberá dar respuesta al reclamo en un plazo no mayor a treinta (30) días calendario, pudiendo ampliar el plazo hasta por treinta (30) días más, previa comunicación al consumidor.</li>
                            <li>Mediante la suscripción del presente documento el cliente autoriza a que lo contacten luego de atendido el reclamo a fin de evaluar la calidad y satisfacción con el proceso de atención de reclamos.</li>
                        </ul>
                    </div>

                </div><!--/row-->

                <div class="row mb-4">
                    <div class="col-12">
                        <p class="mb-1">(1) Reclamo: Disconformidad relacionada a los productos y/o servicios.</p>
                        <p class="mb-1" >(2) Queja: Disconformidad no relacionada a los productos y/o servicios; o, malestar o descontento a la atención al público.</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 ">
                        <button type="submit" class="btn btn-primary-custom">
                            Enviar
                        </button>
                    </div>
                </div><!--/row-->
            </form>

        </div><!--/col-->
    </div>
</template>

<script>

import { ClaimService } from "../../../services/web/claim.service";

import { validationMixin } from "../../../mixins/validation-mixin";

const claimService = new ClaimService();

export default {
    mixins: [
        validationMixin,
    ],
    data(){
        return {
            departmentId:'0',
            provinceId:'0',
        }
    },
    mounted() {
        // console.log('Component Claim Create Form mounted.');
    },
    methods: {
        changeDepartment: function(departmentId){
            // console.log('changeDepartment:',departmentId);
            this.departmentId = departmentId;
        },
        changeProvince: function(provinceId){
            // console.log('changeProvince:',provinceId);
            this.provinceId = provinceId;
        },
        store: async function(event){
            this.cleanErrors();
            let form = event.target;

            let btnSubmit = $("button[type='submit']",form);
            let formData = new FormData(form);

            fg.loadingBtn(btnSubmit);
            try {

                let response = await claimService.store(formData);
                let data = response.data;

                // console.log("data:",data);
                if(!data.hasError){
                    let model = data.model;
                    await fg.modalMessage(data.message,'success');
                    fg.loadPage();
                    location.reload()
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
    watch:{

    }
}
</script>
