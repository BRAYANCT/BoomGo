<template>
    <div class="row" v-if="item">
        <div class="col-12">
            <div class="card card-review">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <img v-lazyload :data-src="item.user.profile_picture_url_thumbnail ? item.user.profile_picture_url_thumbnail : item.user.profile_picture_default_url"  width="50" height="50" class="mr-2 user-image rounded-circle" >
                        <h4 class="h5 font-weight-bold mb-0 user-full-name">
                            {{ item.user.first_name }} {{ item.user.first_surname }}
                        </h4>
                    </div>
                </div>

                <div class="view overlay image-content">
                    <img  v-lazyload :data-src="item.reviewable.logo_url_medium" class="img-fluid"  :alt="item.reviewable.name"/>
                    <a :href="item.reviewable.url_page" title="Ir a la página del negocio">
                        <div class="mask rgba-white-slight"></div>
                    </a>
                </div>

                <div class="card-body">
                    <h4 class="card-title mb-1">
                        <a :href="item.reviewable.url_page" title="Ir a la página del negocio" class="font-weight-bold h5">
                            {{ item.reviewable.name }}
                        </a>
                    </h4>

                    <review-start-average  class="mb-1"
                        :score-average-prop="item.score"
                    ></review-start-average>

                    <p class="card-text force-3-lines">
                        {{ item.commentary }}
                    </p>

                </div><!--/card-body-->
            </div><!--/ card--->
        </div><!--/col--->
    </div><!--/row-->
</template>

<script>

import ReviewStartAverage  from './../../review/StartAverageComponent';

export default {
    components: {
        'review-start-average':ReviewStartAverage,
    },
    props: {
        itemProp:  { default: null },
        imgClassProp: { default: ''},
    },
    data(){
        return {
            item: this.itemProp,
            imgClass: this.imgClassProp,
        }
    },
    mounted() {
        // console.log('Component Business Card Primary mounted.')
    }
}
</script>
