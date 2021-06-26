<template>
    <div class="row" v-if="categories.length > 0">

        <div  v-for="(item , index) in categories" class="col-md-6 col-xl-3 sub-menu mb-xl-0 mb-4">

            <h6 class="sub-title text-uppercase  white-text">
                <a class="font-weight-bold" :href="item.url_page" :title="'Ver más '+item.name">
                    {{ item.name }}
                </a>
            </h6>

<!--            <h6 class="sub-title text-uppercase font-weight-bold white-text">-->
<!--                <a :href="item.url_page" v-if="item.childs.length === 0" >-->
<!--                    {{ item.name }}-->
<!--                </a>-->
<!--                <span v-else >{{ item.name }}</span>-->
<!--            </h6>-->

<!--            <ul  class="list-unstyled" >-->
<!--                <li v-for="(itemChild , index) in item.childs" >-->
<!--                    <a class="menu-item pl-0 text-white" :href="itemChild.url_page" >-->
<!--                        <i class="fas fa-caret-right pl-1 pr-3"></i> {{ itemChild.name }}-->
<!--                    </a>-->
<!--                </li>-->
<!--            </ul>-->

        </div>
    </div><!--/row-->
</template>

<script>
import { CategoryService } from '../../../services/web/category.service';

const categoryService = new CategoryService();

export default {
    data(){
        return {
            parentCategory:null,
            categories: [],
            categoryId: this.categoryIdProp,
        }
    },
    mounted() {
        // console.log('Component List for business mega menu mounted.');
        this.getParentCategories();
    },
    methods: {
        getParentCategories: async function () {
            try {
                this.categories = await categoryService.getBusinessCategories({'level':1});
                // console.log("categories:",this.categories);
            } catch (error) {
                console.error(error)
            }
        }
    }
}
</script>
