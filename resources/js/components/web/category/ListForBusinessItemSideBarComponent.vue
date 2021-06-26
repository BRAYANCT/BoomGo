<template>
    <li class="" v-if="categories.length > 0">

        <a href="#menu-categories-business" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" >
            <i :class="$root.configIcons.business.class"></i>
            Proveedores
        </a>
        <ul class="collapse list-unstyled" id="menu-categories-business">
            <li  v-for="(item , index) in categories" >
                <a  :href="item.url_page" :title="'Ver más '+item.name" class="waves-effect">
                    {{ item.name }}
                </a>
            </li>
        </ul>
    </li><!--/row-->
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
