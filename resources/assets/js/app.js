
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
Vue.component('confirm-payment', require('./components/ModalConfirmPayment.vue'));
Vue.component('grid-files', require('./components/GridFiles.vue'));

Vue.component('select-building-code', require('./components/SelectBuildingCode.vue'));
Vue.component('invoice-details', require('./components/InvoiceDetails.vue'));
Vue.component('proposal-details', require('./components/ProposalDetails.vue'));
Vue.component('service-templates', require('./components/ServiceTemplates.vue'));
Vue.component('form-new-service', require('./components/FormNewService.vue'));
Vue.component('form-new-note', require('./components/FormNewNote.vue'));

//########### human resource components #############
// --> Department
Vue.component('rrhh-departments', require('./components/rrhh/department/rrhhDepartments.vue'));
Vue.component('rrhh-table-departments', require('./components/rrhh/department/rrhhTableDepartaments.vue'));
Vue.component('add-Departements', require('./components/rrhh/department/addDepartements.vue'));
Vue.component('add-Departements', require('./components/rrhh/department/addDepartements.vue'));
// --> payroll type
Vue.component('mainpayroll-type', require('./components/rrhh/payrolltype/mainPayrollType.vue'));
Vue.component('listpayroll-type', require('./components/rrhh/payrolltype/listPayrollType.vue'));
Vue.component('AddUp-Payroll-Type', require('./components/rrhh/payrolltype/AddUpPayrollType.vue'));
// --> position
Vue.component('main-position', require('./components/rrhh/position/mainPosition.vue'));
Vue.component('list-position', require('./components/rrhh/position/listPosition.vue'));
Vue.component('add-position', require('./components/rrhh/position/addPosition.vue'));
//--> Transactions Type
Vue.component('main-transactions-type', require('./components/rrhh/transactionstype/mainTransactionsType.vue'));
Vue.component('list-transaction-type', require('./components/rrhh/transactionstype/listTransactionType.vue'));
Vue.component('addUp-transactions-type', require('./components/rrhh/transactionstype/addUpTransactionsType.vue'));
//--> periods
Vue.component('main-periods', require('./components/rrhh/periods/mainPeriods.vue'));
Vue.component('list-periods', require('./components/rrhh/periods/listPeriods.vue'));
Vue.component('addUp-periods', require('./components/rrhh/periods/addUpPeriods.vue'));



//############ COMFIGURATION COMPANY COMPONENTS ##############
Vue.component('main-company', require('./components/configuration/company/mainCompany.vue'));
Vue.component('panel-heading-add', require('./components/configuration/company/panelHeadingAdd.vue'));
Vue.component('panel-heading-update', require('./components/configuration/company/panelHeadingUpdate.vue'));
Vue.component('list-company', require('./components/configuration/company/listCompany.vue'));



// ########### srcComponent 
Vue.component('button-form', require('./components/srcComponent/buttonForm.vue'));





const app = new Vue({
    el: '#app',
    data: {
        menu:-1,
        },
    methods: {
       
    }
 
});
