<template>
    <div class="row">
        <div class="col-12 d-flex  align-items-center">
            <imask-input v-if="showInput"
                type="text"
                v-model="quantity"
                :mask="Number"
                unmask="typed"
                :typedValue="Number"
                :scale="0"
                :min= "0"
                :max= "999999"
                class="form-control mr-4 text-center "
                style="max-width: 50px"
            />
            <button :id="btnId" @click="increaseItem" :class="btnClass" class="m-0">
                <i :class="$root.configIcons.shopping_cart.class" ></i> <span v-html="btnText" ></span>
            </button>
        </div><!--col-->
    </div><!--/row-->
</template>

<script>

import { ShoppingCartService } from "../../../services/web/shopping-cart.service";
import { shoppingCartMixin } from "../../../mixins/shopping-cart-mixin";

import { IMaskComponent } from 'vue-imask';

const shoppingCart = new ShoppingCartService();

export default {
    components: {
        'imask-input': IMaskComponent,
    },
    mixins: [
        shoppingCartMixin
    ],
    props: {
        productIdProp: { default: '' },
        btnClassProp:  { default: 'btn btn-secondary-custom btn-custom' },
        btnTextProp:  { default: 'Agregar al carrito' },
        showInputProp: { default: false },
        showProductDetailModalProp : { default: false },
    },
    data(){
        return {
            btnId: this.getIdBtn('btn-add-product'),
            productId: this.productIdProp,
            quantity: 1,
            btnClass: this.btnClassProp,
            btnText: this.btnTextProp,
            showInput : this.showInputProp,
            showProductDetailModal : this.showProductDetailModalProp
        }
    },
    mounted() {
        // console.log('Component Shopping cart add item mounted.');
    },
    methods: {
        getIdBtn: function (prefix) {
            return fg.generateUniqueString(prefix);
        },
        increaseItem: async function (event) {

            let cookieToken = this.getCookieToken();

            let btn = $(`#${this.btnId}`);

            try {
                fg.loadingBtn(btn);
                let response = await shoppingCart.increaseItem(this.productId,this.quantity,cookieToken);
                let data = response.data;
                // console.log('data:',data)
                if(!data.hasError){


                    if(this.showProductDetailModal){
                        this.$root.$emit('show-product-detail-modal',this.productId,data.model);
                    }else{
                        fg.toastMessage(data.message,'success');
                    }

                    this.setShoppingCartNotification(data.model);
                }else{
                    fg.modalMessage(data.errors,'error');
                }

            } catch (error) {
                console.error(error);
                if(error.response){
                    let data = error.response.data;
                    if(error.response.status == 422){
                        fg.modalMessage(data.errors,'error');
                    }
                }
            }

            fg.resetLoadingBtn(btn);
        },
    }
}
</script>
