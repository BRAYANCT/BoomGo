<template>
    <div class="row">
        <div class="col-12">
            <button :class="btnClass" @click="openModal">
                <i :class="$root.configIcons.review.class"></i> {{ btnText }}
            </button>
        </div>

        <div class="modal fade" :id="modalId" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title h3" > Escribe tu comentario</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form v-on:submit.prevent="store" method="POST">
                        <div class="modal-body">
                            <div class="row my-3">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Puntaje:</label>
                                        <fieldset class="rating d-inline-block">
                                            <input type="radio" id="star5-score" name="score" value="5"  />
                                            <label class = "full" for="star5-score" title="Increíble - 5 estrellas" ></label>

                                            <input type="radio" id="star4half-score" name="score" value="4.5"  />
                                            <label class="half" for="star4half-score" title="Bastante bueno - 4.5 estrellas"  ></label>

                                            <input type="radio" id="star4-score" name="score" value="4"  />
                                            <label class = "full" for="star4-score" title="Bastante bueno - 4 stars"></label>

                                            <input type="radio" id="star3half-score" name="score" value="3.5" />
                                            <label class="half" for="star3half-score" title="Bueno - 3.5 estrellas"></label>

                                            <input type="radio" id="star3-score" name="score" value="3"  />
                                            <label class = "full" for="star3-score" title="Bueno - 3 estrellas"></label>

                                            <input type="radio" id="star2half-score" name="score" value="2.5"  />
                                            <label class="half" for="star2half-score" title="Un poco malo - 2.5 estrellas"></label>

                                            <input type="radio" id="star2-score" name="score" value="2"  />
                                            <label class = "full" for="star2-score" title="Un poco malo - 2 estrellas"></label>

                                            <input type="radio" id="star1half-score" name="score" value="1.5"  />
                                            <label class="half" for="star1half-score" title="Un poco malo - 1.5 estrellas"></label>

                                            <input type="radio" id="star1-score" name="score" value="1"  />
                                            <label class="full" for="star1-score" title="Muy malo - 1 estrellas"></label>

                                            <input type="radio" id="starhalf-score" name="score" value="0.5"  />
                                            <label class="half" for="starhalf-score" title="Muy malo - 0.5 estrellas"></label>
                                        </fieldset>
                                        <validation-message :errors="errors" name="score"></validation-message>
                                    </div>

                                    <div class="form-group">
                                        <label for="commentary">Comentario:</label>
                                        <textarea id="commentary" :class="'form-control '+getValidClassInput('commentary')"  rows="5" name="commentary"></textarea>
                                        <validation-message :errors="errors" name="commentary"></validation-message>
                                    </div>

                                </div><!--/col-->
                            </div><!--/row-->
                        </div><!--/modal-body-->
                        <div class="modal-footer">
                            <button type="submit" :class="$root.configButtons.store.class">Enviar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import { ReviewService } from '../../../services/web/review-service';

import { validationMixin } from '../../../mixins/validation-mixin';


const reviewService = new ReviewService();

export default {
    mixins: [
        validationMixin,
    ],
    props: {
        modelIdProp:  { default: '' },
        btnClassProp:  { default: 'btn btn-secondary-custom' },
        btnTextProp:  { default: '' },
    },
    data(){
        return {
            modelId:this.modelIdProp,
            btnClass: this.btnClassProp,
            btnText: this.btnTextProp,
            modalId : this.getModalId(),
            scores : [
                {value:'0.5',title:'Muy malo - 0.5 estrellas'},
                {value:'1',title:'Muy malo - 1 estrella'},
                {value:'1.5',title:'Un poco malo - 1.5 estrellas'},
                {value:'2',title:'Un poco malo - 2 estrellas'},
                {value:'2.5',title:'Un poco malo - 2.5 estrellas'},
                {value:'3',title:'Bueno - 3 estrellas'},
                {value:'3.5',title:'Bueno - 3.5 estrellas'},
                {value:'4',title:'Bastante bueno - 4 stars'},
                {value:'4.5',title:'Bastante bueno - 4.5 estrellas'},
                {value:'5',title:'Increíble - 5 estrellas'},
            ],
        }
    },
    mounted() {
        // console.log('Component Review Form modal mounted.')
    },
    methods: {
        getModalId: function () {
            return fg.generateUniqueString('modal-form-review');
        },
        closeModal: function () {
            $(`#${this.modalId}`).modal('hide');
        },
        openModal: function () {
            if(this.$root.authCheck){
                $(`#${this.modalId} form`)[0].reset();
                $(`#${this.modalId}`).modal('show');
            }else{
                this.$root.showLoginModal();
            }
        },
        store: async function (event) {

            this.cleanErrors();
            let form = event.target;

            let btnSubmit = $("button[type='submit']",form);
            let formData = new FormData(form);
            fg.loadingBtn(btnSubmit);
            try {
                let response = await reviewService.storeByBusinessForAuthUser(this.modelId,formData);
                let data = response.data;

                if(!data.hasError){
                    this.closeModal();
                    fg.modalMessage(data.message,'success');
                }else{
                    fg.modalMessage(data.message,'error');
                }

            } catch (error) {
                if(error.response){
                    let response = error.response;
                    // handle error
                    if(response.status == 422){
                        this.errors = response.data.errors;
                        return;
                    }
                }
                fg.catchErrorAxios(error,"",form);
            } finally {
                fg.resetLoadingBtn(btnSubmit);
            }
        }
    }
}
</script>
