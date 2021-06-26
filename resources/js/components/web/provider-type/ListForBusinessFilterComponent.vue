<template>
    <div class="row">
        <div class="col-12 text-white" style="margin-bottom: -1rem;">
            <p v-for="(item , index) in providerTypes" >
                <a :href="getUrl(item.id)" class="text-white">{{ item.name }}</a>
            </p>
        </div><!--/col-->
    </div><!--/row-->
</template>

<script>
import { ProviderTypeService } from '../../../services/web/provider-type.service';

const providerTypeService = new ProviderTypeService();

export default {
    props: {
        categoryIdProp:  { default: '' },
        urlProp:  { default: '' },
    },
    data(){
        return {
            providerTypes: [],
            url: this.urlProp,
        }
    },
    mounted() {
        // console.log('Component Provider Type List for business filter mounted.');
        this.getAllProviderTypes();
    },
    methods: {
        getUrl: function (id) {
            let url = new URL(this.url);
            if(url.searchParams.has('provider_type_id')){
                url.searchParams.set('provider_type_id', id);
            }else{
                url.searchParams.append('provider_type_id', id);
            }

            return url.href;
        },
        getAllProviderTypes: async function () {
            try {
                this.providerTypes = await providerTypeService.getAll();
                // console.log("providerTypes:",this.providerTypes);
            } catch (error) {
                console.error(error)
            }
        },
    }
}
</script>
