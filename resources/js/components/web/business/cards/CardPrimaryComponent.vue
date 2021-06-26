<template>
    <div class="row" v-if="item">
        <div class="col-12">
            <div class="card card-business">
                <div class="view overlay image-content">
                    <img v-lazyload class="card-img-top" :data-src="item.logo_url_medium" :alt="item.name">
                    <a :href="item.url_page" title="Ir a la página del negocio">
                        <div class="mask rgba-white-slight"></div>
                    </a>
                </div>
                <div class="card-body">
                    <h4 class="card-title text-truncate">
                        <a :href="item.url_page" class="font-weight-bold h5" :title="'Ver página de '+item.name">
                            {{ item.name }}
                        </a>
                    </h4>

                    <review-start-average
                        :score-average-prop="item.score_average"
                        :total-reviews-prop="item.total_reviews"
                    ></review-start-average>

                    <p class="mb-2 text-truncate" :title="item.address" >
                        <i class="fas fa-map-marker-alt"></i> {{ item.address }}
                    </p>
                    <hr class="my-md-4">
                    <a :href="item.url_page" title="Ir a la página del negocio" class="btn btn-custom btn-yellow btn-block px-2">
                        <span class="text-dark" v-html="btnText">
                            Ver detalle del negocio
                        </span>
                    </a>
                </div><!--/card-body-->
            </div><!--/Card -->
        </div><!--/col-->
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
        btnTextProp: { default: 'Ver detalle <span class=\'d-none d-md-inline-block\' >del negocio</span>  '},
    },
    data(){
        return {
            item: this.itemProp,
            imgClass: this.imgClassProp,
            btnText: this.btnTextProp,
        }
    },
    mounted() {
        // console.log('Component Business Card Primary mounted.')
    }
}
</script>
