
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
// import {ServerTable, ClientTable, Event} from 'vue-tables-2';
// Vue.use(ClientTable);

require('./bootstrap');
require('admin-lte');
require('cropperjs')
require('@xkeshi/image-compressor')
require('vue-upload-component')

window.Vue = require('vue');
window.toastr = require('toastr');

import SweetModal from 'sweet-modal-vue/src/plugin.js';
Vue.use(SweetModal);
Vue.use(require('vue-moment'));
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Vue.component('select-country-office', require('./components/SelectCountryOffice.vue'));
Vue.component('select-country-office-edit', require('./components/SelectCountryOfficeEdit.vue'));
Vue.component('select-country-office-contract', require('./components/SelectCountryOfficeContract.vue'));
Vue.component('print-contract', require('./components/PrintContract.vue'));
Vue.component('contract-summary', require('./components/contractsummary.vue'));
Vue.component('search-client', require('./components/SearchClient.vue'));
Vue.component('form-modal-charge', require('./components/FormModalCharge.vue'));
// Vue.component('vue-table', require('./components/VueTable.vue'));
Vue.component('vue-upload', require('./components/vueUpload.vue'));
Vue.component('grid-files', require('./components/GridFiles.vue'));
Vue.component('invoices-details', require('./components/InvoicesDetails.vue'));

const app = new Vue({
    el: '#app',
    data: {
       
        },
    methods: {
       
    }
 
});
