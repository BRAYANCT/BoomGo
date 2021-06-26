<template>
    <div class="row ">
        <div class="col-12">
            <div class="card" style="border-radius: 25px;">
                <div class="card-body">
                    <h5 class="card-title h1 font-weight-bold mt-4">
                        <span class="text-primary-custom">Hola</span><span class="text-tertiary-custom">!</span>
                    </h5>
                    <p class="text-dark">
                        Déjanos tus datos y nos pondremos en contacto para poder ayudarte:
                    </p>

                    <form v-on:submit.prevent="store" class="form-css-validate form-btn-loader" method='POST' >
                        <div class="row">

                            <div class="col-12">
                                <div class="form-group mb-1">
                                    <input type="text" id="contact-names" name="names"  class="form-control form-control-lg" placeholder="Nombres*" :class="getValidClassInput('names')" :maxlength="$root.configAttributes.names.max" >
                                    <validation-message  :errors="errors" name="names" ></validation-message>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group mb-1">
                                    <input type="text" id="contact-surnames" name="surnames" class="form-control form-control-lg"  placeholder="Apellidos*" :class="getValidClassInput('surnames')" :maxlength="$root.configAttributes.surnames.max" >
                                    <validation-message  :errors="errors" name="surnames" ></validation-message>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="row" style="margin-right: -0.25rem !important;margin-left: -0.25rem !important;">
                                    <div class="col-md-6 px-1">
                                        <div class="form-group mb-1">
                                            <input type="email" id="contact-email" name="email" class="form-control form-control-lg" placeholder="Email*" :class="getValidClassInput('email')" :maxlength="$root.configAttributes.email.max" >
                                            <validation-message  :errors="errors" name="email" ></validation-message>
                                        </div>
                                    </div>

                                    <div class="col-md-6 px-1">
                                        <div class="form-group mb-1">
                                            <input type="text" id="contact-phone" name="phone" class="form-control form-control-lg" placeholder="Teléfono*" :class="getValidClassInput('phone')" :maxlength="$root.configAttributes.phone.max" >
                                            <validation-message  :errors="errors" name="phone" ></validation-message>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="row" style="margin-right: -0.25rem !important;margin-left: -0.25rem !important;">
                                    <div class="col-md-6 px-1">
                                        <div class="form-group mb-1">
                                            <input type="text" id="contact-company-name" name="company_name" placeholder="Negocio*" class="form-control form-control-lg" :class="getValidClassInput('company_name')" :maxlength="$root.configAttributes.company_name.max" >
                                            <validation-message  :errors="errors" name="company_name" ></validation-message>
                                        </div>
                                    </div>

                                    <div class="col-md-6 px-1">
                                        <button type="submit" class="btn btn-secondary-custom m-0 btn-block text-white">
                                            Enviar
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>

                </div><!--/card-body-->
            </div><!--/card-->
        </div><!--/col-->
    </div><!--/row-->
</template>

<script>

import { ContactService } from "../../../services/web/contact.service";

import { validationMixin } from "../../../mixins/validation-mixin";

const contactService = new ContactService();

export default {
    mixins: [
        validationMixin,
    ],
    mounted() {
        // console.log('Component Contact Create Form mounted.')
    },
    methods: {
        store: async function(event){
            this.cleanErrors();
            let form = event.target;

            let btnSubmit = $("button[type='submit']",form);
            let formData = new FormData(form);

            fg.loadingBtn(btnSubmit);
            try {

                let response = await contactService.store(formData);
                let data = response.data;

                // console.log("data:",data);
                if(!data.hasError){
                    let model = data.model;
                    await fg.modalMessage(data.message,'success');
                    $(form)[0].reset();
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
    }
}
</script>
