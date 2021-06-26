<template>
    <section v-if="products.length>0" >
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="h1 text-uppercase mb-5 title-section">
                        Ofertas
                    </h2>
                </div><!--/col-->
            </div><!--/row-->

            <div class="row container-list-product mb-n1" >
                <div class=" mb-3" :class="classContainerProduct" v-for="(item , index) in products" >
                    <product-card-primary
                        :item-prop="item"
                        btn-text-prop="Añadir <span class='text-car' >al carrito</span> " >
                    </product-card-primary>
                </div><!--!col-->
            </div><!--row-->
        </div><!--container-->
    </section>
</template>

<script>

import { ProductService } from "../../../services/web/product.service";
import ProductCardPrimary from "../product/cards/CardPrimaryComponent";

const productService = new ProductService();

export default {
    components: {
        'product-card-primary':ProductCardPrimary,
    },
    props: {
        quantityProp:  { default: 4 },
        classContainerProductProp:  { default: 'col-md-3' },
    },
    data(){
        return {
            products: [],
            quantity: this.quantityProp,
            classContainerProduct: this.classContainerProductProp,

        }
    },
    mounted() {
        // console.log('Component Product Sale mounted.');
        this.getAllLastOffer();
    },methods: {
        getAllLastOffer: async function(){
            let params = {'offer':1 ,'last':1};
            this.products = await productService.getAll(this.quantity,params);
            // console.log('products sale:',this.products);
        },
    }
}
</script>
