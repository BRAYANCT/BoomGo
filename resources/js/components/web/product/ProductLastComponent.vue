<template>
    <div class="row" v-if="products.length>0">
        <div class="col-12">
            <h2 v-if="title" class="h2 mb-3 ">
                {{ title }}
            </h2>
            <h3 v-if="subtitle" class="h4 mb-3">
                {{ subtitle }}
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
        <div v-if="showBtnAllProp" class="col-12">
            <a :href="$root.getCompleteUrlByUri('market-place/negocios/'+businessSlug)" class="btn btn-custom btn-secondary-custom m-0">
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
        titleProp:  { default: 'Los recién llegados' },
        subtitleProp:  { default: 'Nuevos productos' },
        quantityProp:  { default: 4 },
        businessIdProp:  { default: '' },
        businessSlugProp:  { default: '' },
        classContainerProductProp:  { default: 'col-md-3' },
        categoryIdProp:  { default: '' },
        offerProp:  { default: '' },
        showBtnAllProp:  { default: true },
        differentProductIdProp:  { default: '' },
    },
    data(){
        return {
            title: this.titleProp,
            subtitle: this.subtitleProp,
            products: [],
            quantity: this.quantityProp,
            businessId:this.businessIdProp,
            businessSlug:  this.businessSlugProp,
            categoryId:  this.categoryIdProp,
            offer:  this.offerProp,
            differentProductId:  this.differentProductIdProp,
            classContainerProduct: this.classContainerProductProp,
        }
    },
    mounted() {
        // console.log('Component Product last mounted.');
        this.getAllLast();
    },methods: {
        getAllLast: async function(){
            let params = { 'last':1 };

            if(!fg.isEmpty(this.offer)){
                params.offer = this.offer;
            }

            if(!fg.isEmpty(this.categoryId)){
                params.category_id = this.categoryId;
            }

            if(!fg.isEmpty(this.differentProductId)){
                params.different_product = this.differentProductId;
            }

            if(this.businessId !== ''){
                params.business_id = this.businessId;
            }

            // console.log('params:',params);

            this.products = await productService.getAll(this.quantity,params);
            // console.log('products last:',this.products);
        },
    }
}
</script>
