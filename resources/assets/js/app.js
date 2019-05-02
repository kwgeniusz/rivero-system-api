
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('print-contract', require('./components/PrintContract.vue'));
Vue.component('contract-summary', require('./components/ContractSummary.vue'));
Vue.component('search-client', require('./components/SearchClient.vue'));
Vue.component('form-modal-charge', require('./components/FormModalCharge.vue'));
Vue.component('select-country-office', require('./components/SelectCountryOffice.vue'));
Vue.component('select-country-office-contract', require('./components/SelectCountryOfficeContract.vue'));
Vue.component('select-country-office-edit', require('./components/SelectCountryOfficeEdit.vue'));


const app = new Vue({
    el: '#app'
});
