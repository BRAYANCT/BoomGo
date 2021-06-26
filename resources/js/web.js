
require('./bootstrap');

//MDB
require('./../../public/plugins/MDB-admin/js/mdb.js');

import funcGeneral from './../../public/funciones/funcGeneralNode.js';
//funciones generales
global.fg = funcGeneral;

// alertas
global.Swal = require('sweetalert2');


//************ lazy load ********************************

let LazyLoad = require('vanilla-lazyload');

global.lazyLoadInstance = new LazyLoad({
    elements_selector: ".lazy",
    // container: document.getElementById('app'),
});

//******************** fin lazy load *********************



require("select2");
require("select2/dist/js/i18n/es.js");

window.Vue = require('vue');

/**
 * Uncomment below when compiling to production
 */

if (process.env.MIX_APP_ENV === 'production') {
    Vue.config.devtools = false;
    Vue.config.debug = false;
    Vue.config.silent = true;
}

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */


Vue.component('auth-login-modal', function (resolve, reject) {
    setTimeout(function () {
        resolve(require('./components/auth/LoginModalComponent'));
    }, 500);
});

/************************ Categories **********************************/

Vue.component('web-category-list-business-filter', function (resolve, reject) {
    setTimeout(function () {
        resolve(require('./components/web/category/ListForBusinessFilterComponent'));
    }, 500);
});

Vue.component('web-category-list-business-mega-menu', function (resolve, reject) {
    setTimeout(function () {
        resolve(require('./components/web/category/ListForBusinessMegaMenuComponent'));
    }, 500);
});

Vue.component('web-category-list-card-product', function (resolve, reject) {
    setTimeout(function () {
        resolve(require('./components/web/category/ListCardForProductComponent'));
    }, 500);
});

Vue.component('web-category-products-mega-menu', function (resolve, reject) {
    setTimeout(function () {
        resolve(require('./components/web/category/ProductsMegaMenuComponent'));
    }, 500);
});


Vue.component('web-category-list-product-filter', function (resolve, reject) {
    setTimeout(function () {
        resolve(require('./components/web/category/ListForProductFilterComponent'));
    }, 500);
});

Vue.component('web-category-list-business-item-side-bar', function (resolve, reject) {
    setTimeout(function () {
        resolve(require('./components/web/category/ListForBusinessItemSideBarComponent'));
    }, 500);
});

/************************ Fin de Categories ***************************/

/************************ Reviews **********************************/

Vue.component('web-review-form-modal', function (resolve, reject) {
    setTimeout(function () {
        resolve(require('./components/web/review/FormModalComponent'));
    }, 500);
});

Vue.component('web-review-start-average', function (resolve, reject) {
    setTimeout(function () {
        resolve(require('./components/web/review/StartAverageComponent'));
    }, 500);
});

Vue.component('web-review-last-section', function (resolve, reject) {
    setTimeout(function () {
        resolve(require('./components/web/review/LastSectionComponent'));
    }, 500);
});
/************************ Fin de Reviews ***************************/

/************************ Businesses **********************************/

Vue.component('web-business-recommended-section', function (resolve, reject) {
    setTimeout(function () {
        resolve(require('./components/web/business/RecommendedSectionComponent'));
    }, 500);
});

Vue.component('web-business-last-reviews', function (resolve, reject) {
    setTimeout(function () {
        resolve(require('./components/web/business/LastReviewComponent'));
    }, 500);
});

Vue.component('web-business-images-slider-detail', function (resolve, reject) {
    setTimeout(function () {
        resolve(require('./components/web/business/ImagesSliderDetailComponent'));
    }, 500);
});

Vue.component('web-business-province-filter', function (resolve, reject) {
    setTimeout(function () {
        resolve(require('./components/web/business/ProvinceFilterComponent'));
    }, 500);
});

Vue.component('web-business-filter-modal', function (resolve, reject) {
    setTimeout(function () {
        resolve(require('./components/web/business/BusinessFilterModalComponent'));
    }, 500);
});

/************************ Fin de Businesses ***************************/

/************************ Provider Types ******************************/

Vue.component('web-provider-type-list-business-filter', function (resolve, reject) {
    setTimeout(function () {
        resolve(require('./components/web/provider-type/ListForBusinessFilterComponent'));
    }, 500);
});

/************************ Fin de Provider Types ***********************/


/************************ Products **********************************/

Vue.component('web-product-card-primary', function (resolve, reject) {
    setTimeout(function () {
        resolve(require('./components/web/product/cards/CardPrimaryComponent'));
    }, 500);
});

Vue.component('web-product-detail-modal', function (resolve, reject) {
    setTimeout(function () {
        resolve(require('./components/web/product/ProductDetailModalComponent'));
    }, 500);
});

Vue.component('web-product-sale-section', function (resolve, reject) {
    setTimeout(function () {
        resolve(require('./components/web/product/ProductSaleSectioncomponent'));
    }, 500);
});

Vue.component('web-product-best-offers', function (resolve, reject) {
    setTimeout(function () {
        resolve(require('./components/web/product/ProductBestOffersComponent'));
    }, 500);
});

Vue.component('web-product-last', function (resolve, reject) {
    setTimeout(function () {
        resolve(require('./components/web/product/ProductLastComponent'));
    }, 500);
});

Vue.component('web-product-images-detail', function (resolve, reject) {
    setTimeout(function () {
        resolve(require('./components/web/product/ImagesDetailComponent'));
    }, 500);
});

/************************ Fin de Products ***************************/


/************************ Shopping Carts ****************************/

Vue.component('web-shopping-cart-button-increase-item', function (resolve, reject) {
    setTimeout(function () {
        resolve(require('./components/web/shopping-cart/ButtonIncreaseItemComponent'));
    }, 500);
});

Vue.component('web-shopping-cart-list', function (resolve, reject) {
    setTimeout(function () {
        resolve(require('./components/web/shopping-cart/ShoppingCartLisComponent'));
    }, 500);
});

/************************ Fin de Shopping Carts **********************/



/************************ Orders ************************************/

Vue.component('web-order-check-out', function (resolve, reject) {
    setTimeout(function () {
        resolve(require('./components/web/order/CheckOutComponent'));
    }, 500);
});

/************************ Fin de Orders *****************************/


/************************ Claims ********************************/

Vue.component('web-claim-create-form', function (resolve, reject) {
    setTimeout(function () {
        resolve(require('./components/web/claim/ClaimCreateFormComponent'));
    }, 500);
});

/************************ Fin de Claims *************************/


/************************ Departments ********************************/

Vue.component('web-department-select', function (resolve, reject) {
    setTimeout(function () {
        resolve(require('./components/web/department/DepartmentSelectComponent'));
    }, 500);
});

/************************ Fin de Departments *************************/

/************************ Provinces *********************************/

Vue.component('web-province-select', function (resolve, reject) {
    setTimeout(function () {
        resolve(require('./components/web/province/ProvinceSelectComponent'));
    }, 500);
});

/************************ Fin de Provinces *************************/


/************************ Districts ************************************/

Vue.component('web-district-select', function (resolve, reject) {
    setTimeout(function () {
        resolve(require('./components/web/district/DistrictSelectComponent'));
    }, 500);
});

/************************ Fin de Districts *****************************/

/************************ Document Types *******************************/

Vue.component('web-document-type-select', function (resolve, reject) {
    setTimeout(function () {
        resolve(require('./components/web/document-type/DocumentTypeSelectComponent'));
    }, 500);
});

/************************ Fin de Document Types **********************/


/************************ Contacts ********************************/

Vue.component('web-contact-create-form', function (resolve, reject) {
    setTimeout(function () {
        resolve(require('./components/web/contact/ContactCreateFormComponent'));
    }, 500);
});

/************************ Fin de Contacts *************************/

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import LazyLoadDirective from "./directives/LazyLoadDirective";
Vue.directive("lazyload", LazyLoadDirective);

import { urlMixin } from "./mixins/url-mixin";
import { constantMixin } from "./mixins/constant-mixin";
import { loginModalMixin } from "./mixins/auth-mixin";
import { authMixin } from "./mixins/auth-mixin";
import { shoppingCartMixin } from "./mixins/shopping-cart-mixin";


const app = new Vue({
    mixins: [
        constantMixin,
        urlMixin,
        loginModalMixin,
        authMixin,
        shoppingCartMixin
    ],
    el: '#app',
    mounted () {
        this.setShoppingCart(true);
    }
});

$(document).ready(function() {

    // Sidebar
    $('#dismiss, .side-bar-overlay').on('click', function () {
        $('#sidebar').removeClass('active');
        $('.side-bar-overlay').removeClass('active');
    });

    $('.sidebarCollapse').on('click', function () {
        $('#sidebar').addClass('active');
        $('.side-bar-overlay').addClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    });
    // fin de sidebar

    $('.select-2.init').select2({
        theme: 'bootstrap4',
        language: "es"
    });

    lazyLoadInstance.update();

    window.addEventListener('load',e => {
        lazyLoadInstance.update();
    });

});
