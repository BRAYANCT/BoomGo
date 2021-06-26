<template>
    <div class="row" >
        <div class="col-12">
            <div id="big" class="owl-carousel owl-theme">
                <div class="item" v-for="(item , index) in images" v-owl-big-callback="{key:index,items:images}" >
                    <a :href="item.picture_url" data-fancybox="gallery" data-caption="">
                        <img :data-src="item.picture_url_medium" class="owl-lazy" >
                    </a>
                </div>
            </div>
            <div id="thumbs" class="owl-carousel owl-theme">
                <div class="item" v-for="(item , index) in images" v-owl-thumbs-callback="{key:index,items:images}">
                    <img v-lazyload :data-src="item.picture_url_thumbnail" class="owl-lazy" >
                </div>
            </div>
        </div><!--/-col-->
    </div><!--/row-->
</template>

<style>

#big{
    margin-bottom: 1rem;
}

#big img{
    height: 350px;
    border-radius: 5px;
}

#thumbs img{
    height: 100px;
    border-radius: 5px;
}

@media (min-width: 720px){
    #big img{
        height: 330px;
    }

    #thumbs img{
        height: 100px;
    }
}

@media (min-width: 992px){
    #big img{
        height: 450px;
    }

    #thumbs img{
        height: 100px;
    }
}

@media (min-width: 1200px){
    #big img{
        height: 540px;
    }

    #thumbs img{
        height: 130px;
    }
}




/*#thumbs .current .item {*/
/*    background:#FF5722;*/
/*}*/
</style>

<script>
// https://codepen.io/pankajthakur/pen/yVrXxj
import { ImageService } from "../../../services/web/image.service";
import { ProductService } from "../../../services/web/product.service";

import 'owl.carousel/dist/assets/owl.carousel.css';
import 'owl.carousel';
import '@fancyapps/fancybox/dist/jquery.fancybox.css';
import '@fancyapps/fancybox';

const imageService = new ImageService();
const productService = new ProductService();

export default {
    props: {
        productIdProp:  { default: '' },
    },
    data(){
        return {
            images: [],
            productId:this.productIdProp,
            owlBigId: 'big',
            owlThumbsId: 'thumbs',
            owlThumbs : null,
            owlBig : null,
        }
    },
    mounted() {
        console.log('Component Product images detail mounted.');
        this.getAllProductImages();
        // this.initSlider();

        this.owlThumbs = $(`#${this.owlThumbsId}`);
        this.owlBig = $(`#${this.owlBigId}`);

    },
    methods: {
        getAllProductImages: async function()
        {
            let product = await productService.getOne(this.productId)
            let images = await imageService.getAllProductImages(this.productId);

            images.unshift({
                'picture_url':product.picture_url,
                'picture_url_medium': product.picture_url_medium,
                'picture_url_thumbnail':product.picture_url_thumbnail
            })

            this.images = images;
            console.log('images:',this.images);
        },
        syncPosition: async function(el)
        {
            //if loop is set to false, then you have to uncomment the next line
            //var current = el.item.index;

            //to disable loop, comment this block
            var count = el.item.count - 1;
            var current = Math.round(el.item.index - el.item.count / 2 - 0.5);

            if (current < 0) {
                current = count;
            }
            if (current > count) {
                current = 0;
            }
            //to this
            this.owlThumbs
                .find(".owl-item")
                .removeClass("current")
                .eq(current)
                .addClass("current");
            var onscreen = this.owlThumbs.find(".owl-item.active").length - 1;
            var start = this.owlThumbs
                .find(".owl-item.active")
                .first()
                .index();
            var end = this.owlThumbs
                .find(".owl-item.active")
                .last()
                .index();

            if (current > end) {
                this.owlThumbs.data("owl.carousel").to(current, 100, true);
            }
            if (current < start) {
                this.owlThumbs.data("owl.carousel").to(current - onscreen, 100, true);
            }
        },
        syncPosition2: async function(el)
        {
            var number = el.item.index;
            this.owlBig.data("owl.carousel").to(number, 100, true);
        },
        initThumbsSlider: async function(){
            this.owlThumbs
                .on("initialized.owl.carousel", () => {
                    this.owlThumbs
                        .find(".owl-item")
                        .eq(0)
                        .addClass("current");
                })
                .owlCarousel({
                    items: 4,
                    // dots: true,
                    // nav: true,
                    // navText: [
                    //     '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
                    //     '<i class="fa fa-arrow-right" aria-hidden="true"></i>'
                    // ],
                    margin: 10,
                    smartSpeed: 200,
                    slideSpeed: 500,
                    slideBy: 4,
                    lazyLoad:true,
                    responsiveRefreshRate: 100,
                        responsive:{
                            0:{
                                items:3,
                            },
                            650:{
                                items:3,
                            },
                            992:{
                                items:4,
                            }
                        },
                })
                .on("changed.owl.carousel", this.syncPosition2);

            let owlBig = this.owlBig;
            this.owlThumbs.on("click", ".owl-item", function (e){
                e.preventDefault();
                let number = $(this).index();
                owlBig.data("owl.carousel").to(number, 300, true);
            });
        },
        initBigSlider: async function(){
            console.log('initSlider');

            // $("#big").owlCarousel({
            //     autoplay:true,
            //     autoplayTimeout:5000,
            //     autoplayHoverPause:true,
            //     smartSpeed:1500,
            //     lazyLoad:true,
            //     margin: 10,
            //     //autoHeight: true,
            //     items:1,
            //     responsiveClass:true,
            //     navigation : true,
            //     nav:true,
            //     dots:false,
            //     loop:true,
            //     navText : [
            //         '<i class="fas fa-angle-left" aria-hidden="true"></i>',
            //         '<i class="fas fa-angle-right" aria-hidden="true"></i>'
            //     ],
            //     responsive:{
            //         0:{
            //             items:1,
            //         },
            //         650:{
            //             items:1,
            //         },
            //         1000:{
            //             items:1,
            //         }
            //     },
            // });


            this.owlBig
                .owlCarousel({
                    items: 1,
                    autoplay: false,
                    autoplayTimeout:5000,
                    autoplayHoverPause:true,
                    slideSpeed: 3000,
                    nav: false,
                    dots: false,
                    loop: true,
                    lazyLoad:true,
                    responsiveRefreshRate: 200,
                    // navText: [
                    //     '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
                    //     '<i class="fa fa-arrow-right" aria-hidden="true"></i>'
                    // ]
                })
                .on("changed.owl.carousel", this.syncPosition);

        }
    }
    ,directives: {
        owlBigCallback(el, binding,vnode){
            let element = binding.value;
            let key = element.key;
            let items = element.items;
            // console.log(key);

            if(key+1 == items.length ){
                setTimeout( () => {
                    vnode.context.initBigSlider();
                }, 500);
            }
        },
        owlThumbsCallback(el, binding,vnode){
            let element = binding.value;
            let key = element.key;
            let items = element.items;
            // console.log(key);

            if(key+1 == items.length ){
                setTimeout( () => {
                    vnode.context.initThumbsSlider();
                }, 500);
            }
        },
    }
}



// function syncPosition(el) {
//     //if loop is set to false, then you have to uncomment the next line
//     //var current = el.item.index;
//
//     //to disable loop, comment this block
//     var count = el.item.count - 1;
//     var current = Math.round(el.item.index - el.item.count / 2 - 0.5);
//
//     if (current < 0) {
//         current = count;
//     }
//     if (current > count) {
//         current = 0;
//     }
//     //to this
//     $("#thumbs")
//         .find(".owl-item")
//         .removeClass("current")
//         .eq(current)
//         .addClass("current");
//     var onscreen = $("#thumbs").find(".owl-item.active").length - 1;
//     var start = $("#thumbs")
//         .find(".owl-item.active")
//         .first()
//         .index();
//     var end = $("#thumbs")
//         .find(".owl-item.active")
//         .last()
//         .index();
//
//     if (current > end) {
//         $("#thumbs").data("owl.carousel").to(current, 100, true);
//     }
//     if (current < start) {
//         $("#thumbs").data("owl.carousel").to(current - onscreen, 100, true);
//     }
// }

// function syncPosition2(el) {
//     console.log('syncPosition2',el);
//     // if (syncedSecondary) {
//         var number = el.item.index;
//         $("#big").data("owl.carousel").to(number, 100, true);
//     // }
// }




// function syncPosition(el){
//     console.log('syncPosition');
//     var current = this.currentItem;
//     $("#sync2")
//         .find(".owl-item")
//         .removeClass("synced")
//         .eq(current)
//         .addClass("synced")
//     if($("#sync2").data("owlCarousel") !== undefined){
//         center(current)
//     }
// }
//
// $("#sync2").on("click", ".owl-item", function(e){
//     console.log('click');
//     e.preventDefault();
//     var number = $(this).data("owlItem");
//     $("#big").trigger("owl.goTo",number);
// });
//
// function center(number){
//     var sync2visible = $("#thumbs").data("owlCarousel").owl.visibleItems;
//     var num = number;
//     var found = false;
//     for(var i in sync2visible){
//         if(num === sync2visible[i]){
//             var found = true;
//         }
//     }
//
//     if(found===false){
//         if(num>sync2visible[sync2visible.length-1]){
//             $("#sync2").trigger("owl.goTo", num - sync2visible.length+2)
//         }else{
//             if(num - 1 === -1){
//                 num = 0;
//             }
//             $("#sync2").trigger("owl.goTo", num);
//         }
//     } else if(num === sync2visible[sync2visible.length-1]){
//         $("#sync2").trigger("owl.goTo", sync2visible[1])
//     } else if(num === sync2visible[0]){
//         $("#sync2").trigger("owl.goTo", num-1)
//     }
//
// }

</script>
