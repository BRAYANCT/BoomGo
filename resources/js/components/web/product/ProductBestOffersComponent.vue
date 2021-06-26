<template>
    <div class="row" v-if="products.length>0">
        <div class="col-12">
            <h2 class="h2 mb-3 ">
                Mejores ofertas
            </h2>
            <h3 class="h4 mb-3">
                Las mejores ofertas de la semana!
            </h3>
        </div><!--/col-->
        <div class="col-12 mb-4">
            <div class="row container-list-product mb-n1" >
                <div class="mb-3" :class="classContainerProduct" v-for="(item , index) in products" >
                    <product-card-primary
                        :item-prop="item"
                        btn-text-prop="Añadir <span class='text-car' >al carrito</span> ">
                    </product-card-primary>
                </div><!--!col-->
            </div><!--row-->
        </div><!--col-->
        <div class="col-12">
            <a :href="$root.getCompleteUrlByUri('market-place/negocios/'+businessSlug)" class="btn btn-secondary-custom btn-custom m-0">
                Ver todos los productos
            </a>
        </div>
    </div><!--row-->
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
        businessIdProp:  { default: '' },
        businessSlugProp:  { default: '' },
        classContainerProductProp:  { default: 'col-md-3' },
    },
    data(){
        return {
            products: [],
            quantity: this.quantityProp,
            businessId: this.businessIdProp,
            businessSlug: this.businessSlugProp,
            classContainerProduct: this.classContainerProductProp,
        }
    },
    mounted() {
        // console.log('Component Product Best Offers mounted.');
        this.getAllLastOffer();
    },methods: {
        getAllLastOffer: async function(){
            let params = {'best_offer':1 ,'last':1};

            if(this.businessId !== ''){
                params.business_id = this.businessId;
            }
            this.products = await productService.getAll(this.quantity,params);
            // console.log('products:',this.products);
        },
    }
}
</script>
