<template>
    <div class="modal fade" id="modal-login" tabindex="-1" role="dialog" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold grey-text">Login</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form v-on:submit.prevent="login"  >
                    <div class="modal-body mx-3">
                        <div class="md-form mb-5">
                            <i class="fa fa-envelope prefix grey-text"></i>
                            <input type="text" id="email-ml" name="email" class="form-control" v-model="email">
                            <label  for="email-ml">Email o usuario</label>
                            <validation-error-message :errors="errors" name="email" ></validation-error-message>
                        </div>

                        <div class="md-form mb-4">
                            <i class="fa fa-lock prefix grey-text"></i>
                            <input type="password" id="password-ml" name="password" class="form-control" v-model="password" >
                            <label  for="password-ml">Contraseña</label>
                            <validation-error-message :errors="errors" name="password" ></validation-error-message>
                        </div>

                        <div class="text-center mt-4">
                            <button id="btn-login-modal" type="submit" class="btn btn-blue">
                                Login
                            </button>
                        </div>


                        <p class="dark-grey-text text-right d-flex justify-content-center mb-3 pt-2">o inicia sesión con</p>

                        <div class="row my-3 d-flex justify-content-center">
                            <!--Facebook-->
                            <a :href="$root.getCompleteUrlByUri('auth/facebook')" class="btn btn-fb btn-rounded " >
                                <i class="fab fa-facebook-f fa-2x"></i>
                            </a>
                            <!--Google +-->
                            <a :href="$root.getCompleteUrlByUri('auth/google')" class="btn btn-gplus btn-rounded ">
                                <i class="fab fa-google-plus-g fa-2x"></i>
                            </a>

                        </div>

                    </div><!--/modal-body -->
                </form>
                <div class="modal-footer ">
                    <div class="options font-weight-light">
                        <p class="black-text" >
                            Si no tienes cuenta <a :href="$root.getCompleteUrlByUri('register')">Regístrate</a>
                        </p>
                        <p>
                            <a :href="$root.getCompleteUrlByUri('recuperar-password')">¿Olvidó su contraseña?</a>
                        </p>
                    </div>
                </div><!--/modal-footer -->
            </div><!--/modal-content -->
        </div><!--/modal-dialog -->
    </div><!--/modal-->
</template>

<script>

import { validationMixin } from '../../mixins/validation-mixin';

import { AuthService } from '../../services/web/auth.service';

const authService = new AuthService();

export default {
    mixins: [
        validationMixin,
    ],
    data(){
        return {
            email: '',
            password: '',
        }
    },
    mounted() {
        // console.log('Login modal Component.',this.$root.authCheck);

        this.$root.$on('clean-login-modal-form',()=>{
            this.cleanModalForm();
        });
    },
    methods: {
        cleanModalForm(){
            this.cleanErrors();
            this.email = '';
            this.password = '';
        },
        login: async function (event) {

            this.cleanErrors();

            let form = event.target;
            let btnSubmit = $("button[type='submit']",event.target);

            let formData = new FormData(form);
            fg.loadingBtn(btnSubmit);

            try {
                let response = await authService.login(formData);
                let data = response.data;

                if(!data.hasError){
                    location.reload()
                }else{
                    fg.resetLoadingBtn(btnSubmit);
                }

            } catch (error) {
                console.error(error);

                if(error.response){
                    let response = error.response;
                    // handle error
                    if(response.status == 422){
                        this.errors = response.data.errors;
                    }
                }

                fg.resetLoadingBtn(btnSubmit);
            }

        },
    },
}
</script>
