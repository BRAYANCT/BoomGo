/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

//MDB
require('./../../public/plugins/MDB-admin/js/mdb.js');

import funcGeneral from './../../public/funciones/funcGeneralNode.js';
//funciones generales
global.fg = funcGeneral;


// alertas
global.Swal = require('sweetalert2');

//************ datatables ********************************
require('./datatable');
//******************** fin datatables *********************

//************ lazy load ********************************

let LazyLoad = require('vanilla-lazyload');

global.lazyLoadInstance = new LazyLoad({
    elements_selector: ".lazy",
    // container: document.getElementById('app'),
  });

//******************** fin lazy load *********************

//******************** select2 *********************
require("select2");
require("select2/dist/js/i18n/es.js");

//******************** bootstrap-datepicker *********************
require("bootstrap-datepicker");
require("bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js");

window.moment = require('moment'); // require

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

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component(
  'admin-file-input-basic',
  require('./components/admin/file-input/BasicImageComponent').default
);

Vue.component(
    'admin-file-input-multiple',
    require('./components/admin/file-input/MultipleImageComponent').default
);

Vue.component(
    'admin-ckeditor-input-basic',
    require('./components/admin/ckeditor/BasicInputComponent').default
);

/************* Inicio de User ****************/

Vue.component(
    'admin-user-password',
    require('./components/admin/user/PasswordComponent.vue').default
);

/************* Fin de User ****************/


/************* Inicio de Business ****************/

Vue.component('admin-business-form', function (resolve, reject) {
    setTimeout(function () {
        resolve(require('./components/admin/business/FormComponent'))
    }, 500)
});

/************* Fin de Business ****************/

/************* Inicio de Product ****************/

Vue.component('admin-product-form', function (resolve, reject) {
    setTimeout(function () {
        resolve(require('./components/admin/product/FormComponent'))
    }, 500)
});

/************* Fin de Product ****************/


/************************ Shippings *********************************/

Vue.component('admin-shipping-form-list', function (resolve, reject) {
    setTimeout(function () {
        resolve(require('./components/admin/shipping/FormListComponent'));
    }, 500);
});

/************************ Fin de Shippings *************************/

/************************ Business Payment Method ******************/

Vue.component('admin-business-payment-method', function (resolve, reject) {
    setTimeout(function () {
        resolve(require('./components/admin/business-payment-method/FormComponent'));
    }, 500);
});

/************************ Fin de Business Payment Method ***********/

/************************ Orders *********************************/

Vue.component('admin-order-list-for-auth-user', function (resolve, reject) {
    setTimeout(function () {
        resolve(require('./components/admin/order/ListForAuthUserComponent'));
    }, 500);
});

/************************ Fin de Orders *************************/

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

import CKEditor from '@ckeditor/ckeditor5-vue';
Vue.use( CKEditor );


import { urlMixin } from './mixins/url-mixin';
import { constantMixin } from './mixins/constant-mixin';
import { langMixin } from './mixins/lang-mixin';
import { authMixin } from './mixins/auth-mixin';

const app = new Vue({
    el: '#app',
    mixins: [
        constantMixin,
        langMixin,
        authMixin,
        urlMixin
    ],
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

    //inicializa los combos de material
    $('.mdb-select.init').material_select();

	new WOW().init();

	// Animations initialization
	$('[data-toggle="popover"]').popover();
	$('[data-toggle="tooltip"]').tooltip();
});
