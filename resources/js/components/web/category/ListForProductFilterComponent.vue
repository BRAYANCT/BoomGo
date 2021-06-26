<template>
    <div class="row">
        <div class="col-12 text-white container-list-category scrollbar-primary-custom" style="margin-bottom: -1rem;">
            <p v-if="parentCategory" class="h5 mb-3">
                {{ parentCategory.name }}
            </p>
            <p v-for="(item , index) in categories"  :class="parentCategory ? 'ml-2' : '' ">
                <a :href="getUrlCategory(item)" class="text-white">
                    {{ item.name }}
                </a>
            </p>
        </div><!--/col-->
    </div><!--/row-->
</template>
<style>

.container-list-category{
    max-height: 300px;
    overflow-y: auto;
}

.container-list-category.scrollbar-primary-custom::-webkit-scrollbar{
    border-radius: 10px;
}
</style>
<script>
import { CategoryService } from '../../../services/web/category.service';

const categoryService = new CategoryService();

export default {
    props: {
        categoryIdProp:  { default: '' },
        businessIdProp : { default: '' },
        businessSlugProp : { default: '' },
    },
    data(){
        return {
            businessId: this.businessIdProp,
            businessSlug: this.businessSlugProp,
            parentCategory:null,
            categories: [],
            categoryId: this.categoryIdProp,
        }
    },
    mounted() {
        // console.log('Component Filter List mounted.');
        if(fg.isEmpty(this.categoryId)){
            this.getParentCategories();
        }else{
            this.getCategory(this.categoryId);
        }
    },
    methods: {
        getUrlCategory: function (category) {
            if(!fg.isEmpty(this.businessSlug)){
                return this.$root.getCompleteUrlByUri(`market-place/negocios/${this.businessSlug}/categorias/${category.slug}`);
            }
            return category.url_page;
        },
        getParentCategories: async function () {
            try {

                let params = {'level':1};

                if(this.businessId !== ''){
                    params.business_id = this.businessId;
                }

                this.categories = await categoryService.getProductCategories(params);
                // console.log("categories:",this.categories);
            } catch (error) {
                console.error(error)
            }
        },
        getCategory: async function (id) {
            try {
                let params = {};
                if(this.businessId !== ''){
                    params.business_id = this.businessId;
                }

                let category = await categoryService.getOne(id,params);
                // console.log("category:",category);

                // tiene hijos
                if(category.childs.length > 0){
                    this.parentCategory = category;
                    this.categories = category.childs;
                    return;
                }

                if(category.parent_id){
                    this.parentCategory = category.parent;
                    this.categories = category.parent.childs;
                }else{
                    this.getParentCategories();
                }

            } catch (error) {
                console.error(error)
            }
        },
    }
}
</script>
