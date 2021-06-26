<template>
    <section v-if="businesses.length>0" >
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="h1 text-uppercase mb-5 title-section">
                        Negocios más vistos
                    </h2>
                </div><!--/col-->
            </div><!--/row-->

            <div class="row mb-n1" >
                <div class="col-6 col-lg-3 mb-3" v-for="(item , index) in businesses" >
                    <business-card-primary
                    :item-prop="item">
                    </business-card-primary>
                </div><!--!col-->
            </div><!--row-->
        </div><!--container-->
    </section>
</template>

<script>

import { BusinessService } from '../../../services/web/business.service';

import BusinessCardPrimary from "./cards/CardPrimaryComponent";


const businessService = new BusinessService();

export default {
    components: {
        'business-card-primary':BusinessCardPrimary,
    },
    data(){
        return {
            businesses: [],
        }
    },
    mounted() {
        console.log('Component Business Recommended Section mounted.');
        this.getAllRecommended();
    },
    methods: {
        getAllRecommended: async function () {
            try {
                this.businesses = await businessService.getAllRecommended(3);
                // console.log("businesses recommended: ",this.businesses);
            } catch (error) {
                console.error(error)
            }

        },
    }
}
</script>
