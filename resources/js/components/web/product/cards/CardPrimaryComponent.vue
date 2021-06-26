<template>
    <div class="row" v-if="item">
        <div class="col-12">
            <div class="card card-product">

                <span v-if="item.offer_active" class="badge badge-pill badge-success" style="z-index: 1;position: absolute;top: 10px;left: 10px;">
                    Oferta
                </span>

                <div class="view overlay">
                    <img v-lazyload class="card-img-top" :data-src="item.picture_url_medium" :alt="item.name">
                    <a :href="item.url_page" title="Ver detalle del producto">
                        <div class="mask rgba-white-slight"></div>
                    </a>
                </div>

                <div class="card-body">
                    <h4 class="card-title mb-1 text-truncate">
                        <a :href="item.url_page" title="Ver detalle del producto" class="font-weight-bold">
                            {{ item.name }}
                        </a>
                    </h4>

                    <p class="mb-1 text-truncate">
                        <a :href="item.business.url_page" title="Ir a la página del negocio" class=" font-weight-bold small h6 business-name">
                            {{ item.business.name }}
                        </a>
                    </p>

                    <p class="h5 d-flex justify-content-between">
                        <span class="price">
                            S/ {{ item.final_price }}
                        </span>
                        <span v-if="item.offer_active" class="crossed-out-price" >
                             S/ {{ item.price }}
                        </span>
                    </p>

                    <web-shopping-cart-button-increase-item
                        :btn-text-prop="btnText"
                        btn-class-prop="btn btn-secondary-custom btn-custom px-2 btn-block"
                        :product-id-prop="item.id"
                        :show-product-detail-modal-prop="true"
                    ></web-shopping-cart-button-increase-item>

                </div><!--card-body-->
            </div><!--card-->
        </div><!--/col-->
    </div><!--/row-->


</template>

<script>
export default {
    props: {
        itemProp:  { default: null },
        imgClassProp: { default: ''},
        btnTextProp: { default: 'Añadir al carrito'},
    },
    data(){
        return {
            item: this.itemProp,
            imgClass: this.imgClassProp,
            btnText: this.btnTextProp,
        }
    },
    mounted() {
        // console.log('Component Product card primary mounted.')
    }
}
</script>
