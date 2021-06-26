<template>
    <section v-if="reviews.length>0" >
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="h1 text-uppercase mb-5 title-section">
                        Calificaciones y comentarios
                    </h2>
                </div><!--/col-->
            </div><!--/row-->

            <div class="row mb-n1" >
                <div class="col-6 col-md-4 col-lg-3 mb-3" v-for="(item , index) in reviews" >
                    <review-card-primary
                        :item-prop="item">
                    </review-card-primary>
                </div><!--!col-->
            </div><!--row-->
        </div><!--container-->
    </section>
</template>

<script>
import { ReviewService } from '../../../services/web/review-service';

import ReviewCardPrimary from "./cards/CardPrimaryComponent";

const reviewService = new ReviewService();

export default {
    components: {
        'review-card-primary':ReviewCardPrimary,
    },
    data(){
        return {
            reviews: [],
        }
    },
    mounted() {
        // console.log('Component Review Last Section mounted.');
        this.getAllLast();
    },
    methods: {
        getAllLast: async function () {
            try {
                this.reviews = await reviewService.getAllLatest(3);
                // console.log("reviews last: ",this.reviews);
            } catch (error) {
                console.error(error)
            }
        },
    }
}
</script>
