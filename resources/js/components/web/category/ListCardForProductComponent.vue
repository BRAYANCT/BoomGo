<template>
    <div class="row " v-if="categories.length>0" >
        <div class="col-12">
            <h3 class="h4 mb-3">
                Categorías
            </h3>
        </div><!--/col-->
        <div class="col-12">
            <div class="row" style="margin-bottom:-1rem !important">
                <div v-for="(item , index) in categories" :class="classContainerCard" class="mb-3">
                    <div class="card card-category">
                        <div class="card-body text-center">
                            <a :href="getUrlBusinessCategory(item)" :title="'Ver más productos de '+item.name" >
                                <img

                                    v-lazyload
                                    :data-src="item.picture_url_medium ? item.picture_url_medium : item.default_picture_url"
                                    class="img-fluid" >
                            </a>
                           <h5 class="card-title mb-0">
                                <a :href="getUrlBusinessCategory(item)" :title="'Ver más productos de '+item.name">
                                    {{ item.name }}
                                </a>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import { CategoryService } from '../../../services/web/category.service';

const categoryService = new CategoryService();

export default {
    props: {
        businessIdProp:  { default: '' },
        businessSlugProp:  { default: '' },
        classContainerCardProp: { default: 'col-md-6 col-lg-4' },
    },
    data(){
        return {
            categories: [],
            businessId: this.businessIdProp,
            businessSlug: this.businessSlugProp,
            classContainerCard:  this.classContainerCardProp,
        }
    },
    mounted() {
        // console.log('Component List card for product mounted.');
        // console.log("classContainerCard:",this.classContainerCard);
        this.getProductCategories();
    },
    methods: {
        getUrlBusinessCategory: function (category) {
            return this.$root.getMarketPlaceBusinessCategoryUrl(this.businessSlug,category.slug)
        },
        getProductCategories: async function () {
            try {

                let params = {
                    'limit': 6,
                    'level':1
                };

                if(this.businessId !== ''){
                    params.business_id = this.businessId;
                }
                // console.log('params:',params)

                this.categories = await categoryService.getProductCategories(params);
                // console.log("categories:",this.categories);
            } catch (error) {
                console.error(error)
            }
        },
    }
}
</script>
