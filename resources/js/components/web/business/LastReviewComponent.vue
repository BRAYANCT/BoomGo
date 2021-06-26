<template>
    <div class="row" v-if="reviews.length>0">
        <div class="col-12">
<!--            <h2 class="h2 mb-3 ">-->
<!--                Mejores ofertas-->
<!--            </h2>-->
            <h3 class="h4 mb-3">
                Comentarios
            </h3>
        </div><!--/col-->
        <div class="col-12">
            <div class="row" style="margin-bottom: -1rem;">
                <div class="mb-3" :class="classContainerReview" v-for="(item , index) in reviews" >

                    <div class="d-flex d-flex flex-column flex-lg-row">
                        <div class="mr-5 d-flex flex-column" style="min-width: 200px">
                            <img v-lazyload width="50" height="50" class="rounded-circle mb-3" :data-src="item.user.profile_picture_url_thumbnail ? item.user.profile_picture_url_thumbnail : item.user.profile_picture_default_url">
                            <span class="font-weight-bold">{{ item.user.display_name }}</span>
                        </div>
                        <div>
                            <div class="d-flex mb-2">
                                <web-review-start-average
                                    :score-average-prop="item.score"
                                    total-reviews-prop=""
                                    text-total-reviews-prop=""
                                    class="mr-2"
                                >
                                </web-review-start-average>
                                <span class="text-muted">{{ item.display_date_created_at }}</span>
                            </div>
                            <p>
                                {{ item.commentary }}
                            </p>
                        </div>
                    </div>

                </div><!--!col-->
            </div><!--row-->
        </div><!--col-->
    </div><!--row-->
</template>

<script>

import { ReviewService } from '../../../services/web/review-service';

const reviewService = new ReviewService();


export default {
    props: {
        quantityProp:  { default: 4 },
        businessIdProp:  { default: '' },
        classContainerReviewProp:  { default: 'col-md-3' },
    },
    data(){
        return {
            quantity: this.quantityProp,
            reviews: [],
            classContainerReview: this.classContainerReviewProp,
            businessId: this.businessIdProp
        }
    },
    mounted() {
        // console.log('Component Business Last review mounted.')
        this.getAllLast();
    },
    methods: {
        getAllLast: async function () {
            try {
                let params = {'last':1};

                if(this.businessId !== ''){
                    params.business_id = this.businessId;
                }

                this.reviews = await reviewService.getBusinessReviews(3,params);
                // console.log("reviews last: ",this.reviews);
            } catch (error) {
                console.error(error)
            }
        },
    }
}
</script>
