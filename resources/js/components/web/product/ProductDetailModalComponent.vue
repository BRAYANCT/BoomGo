<template>
    <div class="modal fade" :id="modalId" tabindex="-1" >
        <div class="modal-dialog modal-xl modal-primary-custom" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >
                        {{ product.name }} ha sido agregado a tu carrito de compras
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 d-flex flex-column flex-lg-row">

                            <img :src="product.picture_url_medium" class="img-fluid mr-lg-5 mb-2 mb-lg-0" >

                            <div class="mr-lg-5 ">
                                <p class="name  h5 font-weight-bold">{{ product.name }}</p>
                                <p class="price h5 font-weight-bold">
                                    {{  product.final_price }}
                                    <span v-if="product.offer_active" class="crossed-out-price">
                                        S/ {{ product.price }}
                                    </span>
                                </p>

                            </div>

                            <div>
                                <p class="name h5">{{ getTextTotalProduct() }}</p>
                                <p class="name h5">Total: S/ {{ shoppingCart.total }}</p>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer" v-if="product.business">
                    <button type="button" class="btn btn-custom btn-grey" data-dismiss="modal">Continuar comprando</button>
                    <a :href="$root.getCompleteUrlByUri(`checkout/businesses/${product.business.slug}`)"  class="btn btn-custom btn-secondary-custom">Pagar</a>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
@media (min-width: 998px) {
    .product-detail-modal img{
        width: 245px;
    }
}
</style>

<script>

import { ProductService} from "../../../services/web/product.service";

const productService = new ProductService();

export default {
    data(){
        return {
            modalId: 'product-detail-modal',
            product: {},
            shoppingCart: {},
        }
    },
    mounted() {
        // console.log('Component Product detail modal mounted.');

        this.$root.$on('show-product-detail-modal',(productId,shoppingCart)=>{
            this.showModal(productId,shoppingCart);
        });

    },methods: {
        showModal: async function(productId,shoppingCart){
            // console.log('showModal:',productId);
            // console.log('shoppingCart:',shoppingCart);
            this.shoppingCart = shoppingCart;
            this.product = await this.getProduct(productId);
            $(`#${this.modalId}`).modal('show');

            // console.log('product:',this.product);
        },
        getTextTotalProduct: function(){
            let totalQuantity = this.shoppingCart.total_quantity;
            if(totalQuantity == 1){
                return `Hay ${totalQuantity} producto en tu carrito.`;
            }
            return `Hay ${totalQuantity} productos en tu carrito.`;
        },
        getProduct: async function(productId){
            let product = null;
            try {
                product = productService.getOne(productId);
            } catch (error) {
                console.log(error);
            }
            return product;
        },
    }
}
</script>
