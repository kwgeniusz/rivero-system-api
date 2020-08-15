
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
import Permissions from './mixins/Permissions';
Vue.mixin(Permissions);
// import ProgressBar from 'vue-simple-progress';

import VueMoment from 'vue-moment'
import moment from 'moment-timezone'
 
Vue.use(VueMoment, {
    moment,
})


// Vue.use(require('vue-moment'));
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//########### module contracts components #############
Vue.component('comments-contract', require('./components/contracts/CommentsOfContract.vue'));
Vue.component('select-country-office', require('./components/contracts/SelectCountryOffice.vue'));
Vue.component('select-country-office-contract', require('./components/contracts/SelectCountryOfficeContract.vue'));
Vue.component('select-building-code', require('./components/contracts/SelectBuildingCode.vue'));
Vue.component('search-client', require('./components/contracts/SearchClient.vue'));
Vue.component('subcontractor-datasheet', require('./components/contracts/SubcontractorDatasheet.vue'));
Vue.component('modal-preview-document', require('./components/contracts/ModalPreviewDocument.vue'));
Vue.component('modal-convert-precontract', require('./components/contracts/ModalConvertPrecontract.vue'));
Vue.component('modal-switch-contract', require('./components/contracts/ModalSwitchContract.vue'));
Vue.component('modal-client-details', require('./components/contracts/ModalClientDetails.vue'));
Vue.component('service-templates', require('./components/contracts/ServiceTemplates.vue'));
Vue.component('grid-files', require('./components/contracts/documents/GridFiles.vue'));

//########### module administration components #############
Vue.component('form-modal-charge', require('./components/administration/FormModalCharge.vue'));
Vue.component('confirm-payment', require('./components/administration/ModalConfirmPayment.vue'));
Vue.component('invoice-details', require('./components/administration/InvoiceDetails.vue'));
Vue.component('proposal-details', require('./components/administration/ProposalDetails.vue'));
Vue.component('form-new-service', require('./components/administration/FormNewService.vue'));
Vue.component('form-new-note', require('./components/administration/FormNewNote.vue'));
Vue.component('select-bank-cashbox', require('./components/administration/SelectBankOrCashbox.vue'));
Vue.component('select-bank-with-account', require('./components/administration/SelectBankWithAccount.vue'));
Vue.component('invoice-subcontractors', require('./components/administration/InvoiceSubcontractors.vue'));
Vue.component('search-subcontractor', require('./components/administration/SearchSubcontractor.vue'));

Vue.component('btn-invoice-cancel', require('./components/administration/BtnInvoiceCancel.vue'));
Vue.component('btn-invoice-collection', require('./components/administration/BtnInvoiceCollection.vue'));
// Vue.component('subcontractor-datasheet', require('./components/contracts/SubcontractorDatasheet.vue'));

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
// PRINT PRE-PAYROLL
Vue.component('main-pre-payroll', require('./components/rrhh/printPrePayroll/mainPrintPrePayroll.vue'));
Vue.component('list-pre-payroll', require('./components/rrhh/printPrePayroll/listPrintPrePayroll.vue'));
Vue.component('list-pre-payroll-detail', require('./components/rrhh/printPrePayroll/listPrePayrollDetail/listPrePayrollDetail.vue'));
Vue.component('list-pre-payroll-detail-staff', require('./components/rrhh/printPrePayroll/listPrePayrollDetail/listPrePayrollDetailStaff.vue'));
// permanent Transaction
Vue.component('main-permanent-trans', require('./components/rrhh/permanetTransaction/mainPermanetTrac.vue'));
Vue.component('list-permanent-trans', require('./components/rrhh/permanetTransaction/listPermanentTrac.vue'));
Vue.component('addUp-permanent-trans', require('./components/rrhh/permanetTransaction/addUpPertmanetTrac.vue'));
// uptade payroll
Vue.component('main-update-payroll', require('./components/rrhh/update-payroll/mainUpdatePayroll.vue'));
Vue.component('list-payroll-history', require('./components/rrhh/update-payroll/listPayrollHistory.vue'));
Vue.component('add-up-payroll-history', require('./components/rrhh/update-payroll/addUpPayrollHistory.vue'));



//########### Dashboard Counters #############
// --> Front Page
Vue.component('client-counter', require('./components/srcComponent/ClientCounter.vue'));
Vue.component('contract-counter', require('./components/srcComponent/ContractCounter.vue'));
Vue.component('invoice-counter', require('./components/srcComponent/InvoiceCounter.vue'));
Vue.component('contract-chart', require('./components/srcComponent/ContractChart.vue'));

//############ COMFIGURATION COMPANY COMPONENTS ##############
Vue.component('main-company', require('./components/configuration/company/mainCompany.vue'));
Vue.component('panel-heading-add', require('./components/configuration/company/panelHeadingAdd.vue'));
Vue.component('panel-heading-update', require('./components/configuration/company/panelHeadingUpdate.vue'));
Vue.component('list-company', require('./components/configuration/company/listCompany.vue'));

// ########### srcComponent 
Vue.component('button-form', require('./components/srcComponent/buttonForm.vue'));
Vue.component('loading', require('./components/srcComponent/loading.vue'));
Vue.component('time-live', require('./components/srcComponent/timeLive.vue'));


const app = new Vue({
    el: '#app',
    data: {
         menu:-1,
        },
    methods: {
       
    },

});
