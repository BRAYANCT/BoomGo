<template>
    <div class="row" v-if="categories.length > 0">
        <div class="col-12 ">
            <div class="dropdown mega-dropdown dropdown-hover">
                <a class="btn dropdown-toggle " :class="btnClass"  data-toggle="dropdown">
                    {{ btnText }}
                </a>
                <div class="dropdown-menu mega-menu p-5 w-100 tertiary-custom-color" >
                    <div class="row">
                        <div  v-for="(item , index) in categories" class="col-md-6 col-lg-4 col-xl-3  text-center sub-menu mb-xl-0 mb-4">

                            <h6 class="sub-title text-uppercase">
                                <a class="text-white font-weight-bold" :href="getUrlBusinessCategory(item)" :title="'Ver más productos de '+item.name"  >
                                    {{ item.name }}
                                </a>
                            </h6>
                            <ul  class="list-unstyled text-left" >
                                <li v-for="(itemChild , index) in item.childs" >
                                    <a class="menu-item pl-0 text-white" :href="getUrlBusinessCategory(itemChild)" :title="'Ver más productos de '+item.name" >
                                        <i class="fas fa-caret-right pl-1 pr-3"></i> {{ itemChild.name }}
                                    </a>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div><!--/col-->
    </div><!--/row-->
</template>
<style>
    .dropdown-menu.mega-menu{
        position: absolute !important;
        transform: translate3d(0px, 54px, 0px) !important;
        top: 0 !important;
        left: 0 !important;
        will-change: transform !important;
    }
</style>
<script>


import { CategoryService } from '../../../services/web/category.service';

const categoryService = new CategoryService();

export default {
    props: {
        businessIdProp:  { default: '' },
        businessSlugProp:  { default: '' },
        btnClassProp: { default: 'btn-tertiary-custom btn-custom mb-0' },
        btnTextProp: { default: 'Categorías' },
    },
    data(){
        return {
            categories: [],
            businessId: this.businessIdProp,
            businessSlug: this.businessSlugProp,
            btnClass: this.btnClassProp,
            btnText: this.btnTextProp,
        }
    },
    mounted() {
        // console.log('Component Category List Mega Menu For product mounted.');
        this.getProductCategories();
    },
    methods: {
        getUrlBusinessCategory: function (category) {
            return this.$root.getMarketPlaceBusinessCategoryUrl(this.businessSlug,category.slug)
        },
        getObjectCategory:function(category){
            return {
                'id':category.id,
                'category_type_id': category.category_type_id,
                'parent_id': category.parent_id,
                'name': category. name,
                'slug': category. slug,
                'level': category. level,
                'url_page': category. url_page,

                'picture_url_thumbnail':category.picture_url_thumbnail,
                'picture_url_medium':category.picture_url_medium,
                'picture_url_large':category.picture_url_large,
                'picture_url':category.picture_url,
                'default_picture_url':category.default_picture_url,
                'childs': [],
            }
        },
        groupCategoriesByLevel:  async function (categories) {

            let newCategories = [];

            categories.forEach((item,index)=>{
                if(item.level == 1){
                    let exist = false;
                    newCategories.some((item1,index1)=>{
                        if(item.id == item1){
                            exist = true;
                            return true
                        }
                    });
                    if(!exist){
                        newCategories.push(this.getObjectCategory(item));
                    }
                }
            });

            newCategories.forEach((item,index)=>{
                categories.forEach((item1,index1)=>{
                   if(item.id == item1.parent_id) item.childs.push(this.getObjectCategory(item1));
                });
            });

            return newCategories;
        },
        getProductCategories: async function () {
            try {

                let params = {};

                if(this.businessId !== ''){
                    params.business_id = this.businessId;
                }
                // console.log('params:',params)
                let categories = await categoryService.getProductCategories(params);

                // console.log("categories de products mega menu:",categories);

                this.categories = await this.groupCategoriesByLevel(categories);

            } catch (error) {
                console.error(error)
            }
        },
    }
}
</script>
