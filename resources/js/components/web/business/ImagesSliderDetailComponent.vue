<template>
    <div class="row mx-0" v-if="images.length > 0">
        <div class="col-12 px-0">
            <div :id="owlId" class="owl-carousel owl-theme owl-custom">
                <div class="item" v-for="(item , index) in images" v-owl-callback="{key:index,items:images}" >
                    <div>
                        <img  :data-src="item.picture_url_medium" class="owl-lazy" >
                        <a class="btn btn-zoom" :href="item.picture_url" data-fancybox="gallery" data-caption="">
                            <i class="fas fa-search-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/row-->
</template>

<style>
    .owl-carousel img{
        height: 250px;
    }
    .btn-zoom{
        color: #000;
        background-color: #e2e2dddb;
        position: relative;
        margin-top: -38px;
        padding: 0.4rem 0.5rem;
        float: right;
    }
</style>

<script>

import { ImageService } from "../../../services/web/image.service";

import 'owl.carousel/dist/assets/owl.carousel.css';
import 'owl.carousel';
import '@fancyapps/fancybox/dist/jquery.fancybox.css';
import '@fancyapps/fancybox';

const imageService = new ImageService();

export default {
    props: {
        businessIdProp:  { default: '' },
    },
    data() {
        return {
            images: [],
            businessId: this.businessIdProp,
            owlId : this.getOwlId(),
        }
    },
    mounted() {
        // console.log('Component Images Slider Detail mounted.',this.businessId);
        this.getAllBusinessImages();
    },
    methods: {
        getOwlId: function () {
            return fg.generateUniqueString('owl-business-images-detail-');
        },
        getAllBusinessImages: async function () {
            this.images = await imageService.getAllBusinessImages(this.businessId);
            // console.log('images:', this.images);
        },
        initSlider: async function(){

            $(`#${this.owlId}`)
                .owlCarousel({
                    autoplay:true,
                    autoplayTimeout:5000,
                    autoplayHoverPause:true,
                    smartSpeed:1500,
                    slideSpeed: 500,
                    loop:true,

                    items: 4,
                    dots: false,
                    nav: true,
                    navText: [
                        '<i class="fas fa-chevron-left" aria-hidden="true"></i>',
                        '<i class="fas fa-chevron-right" aria-hidden="true"></i>'
                    ],
                    margin: 0,
                    lazyLoad:true,
                    responsive:{
                        0:{
                            items:1,
                        },
                        650:{
                            items:3,
                        },
                        992:{
                            items:4,
                        }
                    },
                });
        },
    },directives: {
        owlCallback(el, binding, vnode) {
            let element = binding.value;
            let key = element.key;
            let items = element.items;
            // console.log(key);

            if (key + 1 == items.length) {
                setTimeout(() => {
                    vnode.context.initSlider();
                }, 500);
            }
        },
    }
}
</script>
