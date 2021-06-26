
import dtb from 'datatables.net-bs4';
import dtr from 'datatables.net-responsive-bs4';
import dtFunc from './../../public/plugins/datatables/js/funciones.js';
import dtExtends from './../../public/plugins/datatables/datatable-extends.js';

import dtl from './../../public/plugins/datatables/i18n/es.js';


global.dtFunc = dtFunc;

global.dtl = dtl;

window.dt_es = dtl.es;

$(document).ready(function() {
    dtExtends.init();
})

