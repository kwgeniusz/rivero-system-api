
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
// import VModal from 'vue-js-modal'
// Vue.use(VModal)
import Permissions from './mixins/Permissions';
Vue.mixin(Permissions);

Vue.use(require('vue-moment'));
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('select-country-office', require('./components/SelectCountryOffice.vue'));
Vue.component('select-country-office-contract', require('./components/SelectCountryOfficeContract.vue'));
Vue.component('search-client', require('./components/SearchClient.vue'));
Vue.component('form-modal-charge', require('./components/FormModalCharge.vue'));
Vue.component('confirm-payment', require('./components/ModalConfirmPayment.vue'));
Vue.component('grid-files', require('./components/GridFiles.vue'));
Vue.component('modal-preview-document', require('./components/ModalPreviewDocument.vue'));
Vue.component('modal-convert-precontract', require('./components/ModalConvertPrecontract.vue'));
Vue.component('modal-switch-contract', require('./components/ModalSwitchContract.vue'));
Vue.component('modal-client-details', require('./components/ModalClientDetails.vue'));

Vue.component('select-bank-cashbox', require('./components/SelectBankOrCashbox.vue'));
Vue.component('select-building-code', require('./components/SelectBuildingCode.vue'));
Vue.component('select-bank-with-account', require('./components/SelectBankWithAccount.vue'));
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
//--> process
Vue.component('main-process', require('./components/rrhh/process/mainProcess.vue'));
Vue.component('list-process', require('./components/rrhh/process/listProcess.vue'));
Vue.component('addUp-process', require('./components/rrhh/process/addUpProcess.vue'));
//--> --> process-Detail
Vue.component('list-process-detail', require('./components/rrhh/process/processDetail/listProcessDetail.vue'));
Vue.component('add-up-process-detail', require('./components/rrhh/process/processDetail/addUpProcessDetail.vue'));
// --> Staff
Vue.component('main-staff', require('./components/rrhh/staff/mainStaff.vue'));
Vue.component('list-staff', require('./components/rrhh/staff/listStaff.vue'));
Vue.component('add-up-staff', require('./components/rrhh/staff/addUpStaff.vue'));
// --> payrollControll
Vue.component('main-payroll-control', require('./components/rrhh/payrollControl/mainPayrollControl.vue'));
Vue.component('list-payroll-control', require('./components/rrhh/payrollControl/listPayrollControl.vue'));
Vue.component('add-up-payroll-control', require('./components/rrhh/payrollControl/addUpPayrollControl.vue'));


//############ COMFIGURATION COMPANY COMPONENTS ##############
Vue.component('main-company', require('./components/configuration/company/mainCompany.vue'));
Vue.component('panel-heading-add', require('./components/configuration/company/panelHeadingAdd.vue'));
Vue.component('panel-heading-update', require('./components/configuration/company/panelHeadingUpdate.vue'));
Vue.component('list-company', require('./components/configuration/company/listCompany.vue'));



// ########### srcComponent 
Vue.component('button-form', require('./components/srcComponent/buttonForm.vue'));
Vue.component('loading', require('./components/srcComponent/loading.vue'));


const app = new Vue({
    el: '#app',
    data: {
         menu:-1,
        },
    methods: {
       
    }
 
});
