
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('admin-lte');

window.Vue = require('vue');

import {ServerTable, ClientTable, Event} from 'vue-tables-2';
Vue.use(ClientTable);
import SweetModal from 'sweet-modal-vue/src/plugin.js';
Vue.use(SweetModal);
 
window.toastr = require('toastr');

      
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
Vue.component('modal-preview-document', require('./components/ModalPreviewDocument.vue'));
Vue.component('vue-table', require('./components/VueTable.vue'));

const app = new Vue({
    el: '#app',
    data: {
       
        },
    methods: {
 
    }
 
});
