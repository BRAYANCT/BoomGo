<template>
    <div class="row">
        <div class="col-12 text-white container-list-category scrollbar-primary-custom" style="margin-bottom: -1rem;">
            <p v-if="parentCategory" class="h5 mb-3">
                {{ parentCategory.name }}
            </p>
            <p v-for="(item , index) in categories"  :class="parentCategory ? 'ml-2' : '' ">
                <a :href="item.url_page" class="text-white">
                    {{ item.name }}
                    <span class="badge badge-pill badge-primary-custom" >{{ item.total_businesses }}</span>
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
    },
    data(){
        return {
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
        getParentCategories: async function () {
            try {
                this.categories = await categoryService.getBusinessCategories({'level':1});
                // console.log("categories:",this.categories);
            } catch (error) {
                console.error(error)
            }
        },
        getCategory: async function (id) {
            try {
                let category = await categoryService.getOne(id);
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
