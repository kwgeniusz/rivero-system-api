/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
// import {ServerTable, ClientTable, Event} from 'vue-tables-2';
// Vue.use(ClientTable);

require("./bootstrap");
require("admin-lte");
require("cropperjs");
require("@xkeshi/image-compressor");
require("vue-upload-component");

window.Vue    = require("vue");
window.toastr = require("toastr");

import Permissions from "./mixins/Permissions";
Vue.mixin(Permissions);

import SweetModal from "sweet-modal-vue/src/plugin.js";
Vue.use(SweetModal);

import VueMoment from "vue-moment";
import moment from "moment-timezone";
Vue.use(VueMoment, { moment });

// import ProgressBar from 'vue-simple-progress';
Vue.component('pagination', require('laravel-vue-pagination'));

import VuePhoneNumberInput from 'vue-phone-number-input';
import 'vue-phone-number-input/dist/vue-phone-number-input.css';
Vue.component('vue-phone-number-input', VuePhoneNumberInput);

import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
// import {Spanish} from 'flatpickr/dist/l10n/es.js';
// flatpickr.localize(Spanish); // default locale is now Russian
Vue.use(flatPickr);

// Form Step With Vuejs
import VueFormWizard from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
Vue.use(VueFormWizard)

// Form Validation with Vue
import Vuelidate from 'vuelidate'
Vue.use(Vuelidate)

// Components To Popover
import Popover from 'vue-js-popover'
Vue.use(Popover)

// Components To Vue-audio-recorder
import AudioRecorder from 'vue-audio-recorder'
Vue.use(AudioRecorder)

import VueTabs from 'vue-nav-tabs'
import 'vue-nav-tabs/themes/vue-tabs.css'
Vue.use(VueTabs)

import vSelect from 'vue-select'
Vue.component('v-select', vSelect)
import 'vue-select/dist/vue-select.css';


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//###################################################
//           Module Contracts Components
//###################################################
// -----------------> Client <-------------------------//
Vue.component("main-client",require("./components/contracts/client/main.vue"));
Vue.component("table-client",require("./components/contracts/client/table.vue"));
Vue.component("addUp-client",require("./components/contracts/client/addUp.vue"));

// -----------------> Client Other Contacts <-------------------------//
Vue.component("main-other-contact",require("./components/contracts/client/otherContact/main.vue"));
Vue.component("table-other-contact",require("./components/contracts/client/otherContact/table.vue"));
Vue.component("addUp-other-contact",require("./components/contracts/client/otherContact/addUp.vue"));

// -----------------> Contract <-------------------------//
Vue.component("main-contract",require("./components/contracts/contract/main.vue"));
Vue.component("table-contract",require("./components/contracts/contract/table.vue"));
// Vue.component("addUp-contract",require("./components/contracts/client/otherContact/addUp.vue"));

// ------------------------------------------------------------------//
Vue.component("comments-contract",require("./components/contracts/CommentsOfContract.vue"));
Vue.component("comments-precontract",require("./components/contracts/CommentsOfPrecontract.vue"));
Vue.component("select-country-office",require("./components/contracts/SelectCountryOffice.vue"));
Vue.component("select-country-office-contract",require("./components/contracts/SelectCountryOfficeContract.vue"));
Vue.component("select-building-code",require("./components/contracts/SelectBuildingCode.vue"));
Vue.component("search-client",require("./components/contracts/SearchClient.vue"));
Vue.component("modal-preview-document",require("./components/contracts/ModalPreviewDocument.vue"));
Vue.component("modal-convert-precontract",require("./components/contracts/ModalConvertPrecontract.vue"));
Vue.component("modal-switch-contract",require("./components/contracts/ModalSwitchContract.vue"));
Vue.component("modal-client-details",require("./components/contracts/ModalClientDetails.vue"));
Vue.component("service-templates",require("./components/contracts/ServiceTemplates.vue"));
Vue.component("grid-files-precontract",require("./components/contracts/documents/precontracts/GridFiles.vue"));
Vue.component("grid-files",require("./components/contracts/documents/GridFiles.vue"));

// -----------------> Precontract <-------------------------//

// -----------------> Precontract - Budgets <-------------------------//
Vue.component("precontract-main-budget",require("./components/contracts/precontract/budget/main.vue"));
Vue.component("precontract-table-budget",require("./components/contracts/precontract/budget/table.vue"));
Vue.component("precontract-addUp-budget",require("./components/contracts/precontract/budget/addUp.vue"));

// -----------------> Proposals <-------------------------//
Vue.component("proposal-details",require("./components/administration/proposal/ProposalDetails.vue"));
Vue.component("duplicate-proposal",require("./components/administration/proposal/DuplicateProposal.vue"));

Vue.component("time-frame-crud",require("./components/administration/proposal/timeFrame/timeFrameCrud.vue"));
Vue.component("term-crud",require("./components/administration/proposal/term/termCrud.vue"));
Vue.component("note-crud",require("./components/administration/proposal/note/noteCrud.vue"));
Vue.component("time-payment-crud",require("./components/administration/proposal/timePayment/timePayCrud.vue"));
//###################################################
//           Module Administration Components
//###################################################
// -----------------> Receivables <-------------------------//
Vue.component("tab-receivables",require("./components/administration/receivables/tab.vue"));
Vue.component("receivables-from-clients",require("./components/administration/receivables/client/table.vue"));
// Vue.component("receivables-from-clients-details",require("./components/administration/receivables/client/details.vue"));
// Vue.component("receivables-from-employees",require("./components/administration/receivables/employee/main.vue"));
// Vue.component("receivables-from-partners",require("./components/administration/receivables/partner/main.vue"));

// -----------------> Payables <-------------------------//
Vue.component("tab-payables",require("./components/administration/payables/tab.vue"));
Vue.component("datasheet-subcontractor",require("./components/administration/payables/subcontractor/datasheet.vue")); 

// -----------------> Subcontractors <-------------------------//
Vue.component("main-subcontractor",require("./components/administration/payables/subcontractor/main.vue"));
Vue.component("table-subcontractor",require("./components/administration/payables/subcontractor/table.vue"));
Vue.component("addUp-subcontractor",require("./components/administration/payables/subcontractor/addUp.vue"));
Vue.component("datasheet-subcontractor",require("./components/administration/payables/subcontractor/datasheet.vue")); 
// Vue.component("search-subcontractor",require("./components/administration/payables/searchSubcontractor.vue"));

// -----------------> Transacion Income <-------------------------//
Vue.component("main-transaction-income",require("./components/administration/transaction/income/main.vue"));
Vue.component("table-transaction-income",require("./components/administration/transaction/income/table.vue"));
Vue.component("addUp-transaction-income",require("./components/administration/transaction/income/addUp.vue"));

// -----------------> Transacion Expense <-------------------------//
Vue.component("main-transaction-expense",require("./components/administration/transaction/expense/main.vue"));
Vue.component("table-transaction-expense",require("./components/administration/transaction/expense/table.vue"));
Vue.component("addUp-transaction-expense",require("./components/administration/transaction/expense/addUp.vue"));
// -----------------> Expense Types <-------------------------//
Vue.component("main-expense-type",require("./components/administration/transaction/expense/type/main.vue"));
Vue.component("table-expense-type",require("./components/administration/transaction/expense/type/table.vue"));
Vue.component("addUp-expense-type",require("./components/administration/transaction/expense/type/addUp.vue"));
// -----------------> Cost Category <-------------------------//
Vue.component("main-cost-category",require("./components/administration/transaction/expense/costCategory/main.vue"));
Vue.component("table-cost-category",require("./components/administration/transaction/expense/costCategory/table.vue"));
Vue.component("addUp-cost-category",require("./components/administration/transaction/expense/costCategory/addUp.vue"));

// ---------------------> Point Sale <----------------------------------------//
Vue.component("form-modal-charge", require("./components/administration/FormModalCharge.vue"));
Vue.component("confirm-payment",require("./components/administration/ModalConfirmPayment.vue"));

Vue.component("modal-transaction-details",require("./components/administration/ModalTransactionDetails.vue"));
// Vue.component("form-new-service",require("./components/administration/FormNewService.vue"));
Vue.component("select-bank-with-account",require("./components/administration/SelectBankWithAccount.vue"));

// ---------------------> Invoices <----------------------------------------//
Vue.component("invoice-details",require("./components/administration/invoice/InvoiceDetails.vue"));
Vue.component("invoice-subcontractors",require("./components/administration//invoice/InvoiceSubcontractors.vue"));
Vue.component("invoice-btn-cancel",require("./components/administration/invoice/InvoiceBtnCancel.vue"));
Vue.component("invoice-btn-collection",require("./components/administration/invoice/InvoiceBtnCollection.vue"));
Vue.component("invoice-add-note",require("./components/administration/invoice/addInvoiceNote.vue"));

// ---------------------> Sales Notes <----------------------------------------//
Vue.component("credit-note",require("./components/administration/invoice/saleNote/CreditNote.vue"));
Vue.component("debit-note",require("./components/administration/invoice/saleNote/DebitNote.vue"));

// --------------------->Temporary Accounting Entry <----------------------------------------//
Vue.component("adm-main-temporary-acc-entry", require("./components/accounting/transactionHeader/main.vue"));
Vue.component("adm-table-temporary-acc-entry",require("./components/accounting/transactionHeader/table.vue"));
Vue.component("adm-addUp-temporary-acc-entry",require("./components/accounting/transactionHeader/addUp.vue"));

//###################################################
//           Inventory Module Components
//###################################################
// ---------------------> Services Catalog <----------------------------------------//
Vue.component("inventory-main-service", require("./components/inventory/service/main.vue"));
Vue.component("inventory-table-service",require("./components/inventory/service/table.vue"));
Vue.component("inventory-addUp-service",require("./components/inventory/service/addUp.vue"));



//###################################################
//           Module Accounting Components
//###################################################
// ---------------------> Transaction Header <-----------------------------//
Vue.component("accounting-main-transaction-header",require("./components/accounting/transactionHeader/main.vue"));
Vue.component("accounting-table-transaction-header",require("./components/accounting/transactionHeader/table.vue"));
Vue.component("accounting-addUp-transaction-header",require("./components/accounting/transactionHeader/addUp.vue"));
// ---------------------> Transaction <-----------------------------//
Vue.component("accounting-main-transaction",require("./components/accounting/transactionHeader/transaction/main.vue"));
Vue.component("accounting-table-transaction",require("./components/accounting/transactionHeader/transaction/table.vue"));
Vue.component("accounting-addUp-transaction",require("./components/accounting/transactionHeader/transaction/addUp.vue"));

// ---------------------> Temporal Transaction Header <-----------------------------//
Vue.component("accounting-main-transaction-header-tmp",require("./components/accounting/transactionHeaderTmp/main.vue"));
Vue.component("accounting-table-transaction-header-tmp",require("./components/accounting/transactionHeaderTmp/table.vue"));
Vue.component("accounting-addUp-transaction-header-tmp",require("./components/accounting/transactionHeaderTmp/addUp.vue"));
// ---------------------> Temporal Transaction <-----------------------------//
Vue.component("accounting-main-transaction-tmp",require("./components/accounting/transactionHeaderTmp/transactionTmp/main.vue"));
Vue.component("accounting-table-transaction-tmp",require("./components/accounting/transactionHeaderTmp/transactionTmp/table.vue"));
Vue.component("accounting-addUp-transaction-tmp",require("./components/accounting/transactionHeaderTmp/transactionTmp/addUp.vue"));

// ---------------------> General Ledger <-----------------------------//
Vue.component("accounting-main-general-ledger",require("./components/accounting/generalLedger/main.vue"));
Vue.component("accounting-table-general-ledger",require("./components/accounting/generalLedger/table.vue"));
Vue.component("accounting-addUp-general-ledger",require("./components/accounting/generalLedger/addUp.vue"));

Vue.component("accounting-close-year",require("./components/accounting/ModalCloseYear.vue"));

// ---------------------> Auxiliary Book <-----------------------------//
Vue.component("accounting-main-auxiliary-book",require("./components/accounting/auxiliaryBook/main.vue"));
Vue.component("accounting-table-auxiliary-book",require("./components/accounting/auxiliaryBook/table.vue"));
Vue.component("accounting-addUp-auxiliary-book",require("./components/accounting/auxiliaryBook/addUp.vue"));

//###################################################
//           Module Human Resource Components
//###################################################
// ---------------------> Deparment <-----------------------------//
Vue.component('rrhh-departments', function (resolve) {
  // Esta sintaxis de requerimiento especial le indicará a Webpack que
  // divida automáticamente su código construido en paquetes
  // que se cargan a través de solicitudes Ajax.
  require(['./components/rrhh/department/rrhhDepartments.vue'], resolve)
})
Vue.component('rrhh-table-departments', function (resolve) {
  require(['./components/rrhh/department/rrhhTableDepartaments'], resolve)
})
Vue.component('add-Departements', function (resolve) {
  require(['./components/rrhh/department/addDepartements'], resolve)
})
Vue.component('add-Departements', function (resolve) {
  require(['./components/rrhh/department/addDepartements'], resolve)
})

// ---------------------> Payroll Type <---------------------------//
Vue.component('mainpayroll-type', function (resolve) {
  require(['./components/rrhh/payrolltype/mainPayrollType'], resolve)
})
Vue.component('listpayroll-type', function (resolve) {
  require(['./components/rrhh/payrolltype/listPayrollType'], resolve)
})
Vue.component('AddUp-Payroll-Type', function (resolve) {
  require(['./components/rrhh/payrolltype/AddUpPayrollType'], resolve)
})

// ---------------------> Position <------------------------------//
Vue.component("main-position",require("./components/rrhh/position/mainPosition.vue"));
Vue.component("list-position",require("./components/rrhh/position/listPosition.vue"));
Vue.component("add-position",require("./components/rrhh/position/addPosition.vue"));

// ---------------------> Transaction Type <----------------------//
Vue.component("main-transactions-type",require("./components/rrhh/transactionstype/mainTransactionsType.vue"));
Vue.component("list-transaction-type",require("./components/rrhh/transactionstype/listTransactionType.vue"));
Vue.component("addUp-transactions-type",require("./components/rrhh/transactionstype/addUpTransactionsType.vue"));

// ---------------------> Periods <----------------------//
Vue.component("main-periods",require("./components/rrhh/periods/mainPeriods.vue"));
Vue.component("list-periods",require("./components/rrhh/periods/listPeriods.vue"));
Vue.component("addUp-periods",require("./components/rrhh/periods/addUpPeriods.vue"));

// ---------------------> Process <----------------------//
Vue.component("main-process",require("./components/rrhh/process/mainProcess.vue"));
Vue.component("list-process",require("./components/rrhh/process/listProcess.vue"));
Vue.component("addUp-process",require("./components/rrhh/process/addUpProcess.vue"));

// ---------------------> Process Details <----------------------//
Vue.component("list-process-detail",require("./components/rrhh/process/processDetail/listProcessDetail.vue"));
Vue.component("add-up-process-detail",require("./components/rrhh/process/processDetail/addUpProcessDetail.vue"));

// ---------------------> Staff <----------------------//
Vue.component("main-staff", require("./components/rrhh/staff/mainStaff.vue"));
Vue.component("list-staff", require("./components/rrhh/staff/listStaff.vue"));
Vue.component("add-up-staff",require("./components/rrhh/staff/addUpStaff.vue"));

// ---------------------> vacation Control <----------------------//
Vue.component('pre-vacations', function (resolve) {
  require(['./components/rrhh/vacations/PreVacations'], resolve)
})
// Vue.component('list-vacations', function (resolve) {
//   require(['./components/rrhh/vacations/Vacations'], resolve)
// })

// ---------------------> Payroll Control <----------------------//
Vue.component("main-payroll-control",require("./components/rrhh/payrollControl/mainPayrollControl.vue"));
Vue.component("list-payroll-control",require("./components/rrhh/payrollControl/listPayrollControl.vue"));
Vue.component("add-up-payroll-control",require("./components/rrhh/payrollControl/addUpPayrollControl.vue"));

// --> Print Pre-payroll 
Vue.component("main-pre-payroll",require("./components/rrhh/printPrePayroll/mainPrintPrePayroll.vue"));
Vue.component("list-pre-payroll",require("./components/rrhh/printPrePayroll/listPrintPrePayroll.vue"));
Vue.component("list-pre-payroll-detail",require("./components/rrhh/printPrePayroll/listPrePayrollDetail/listPrePayrollDetail.vue"));
Vue.component("list-pre-payroll-detail-staff",require("./components/rrhh/printPrePayroll/listPrePayrollDetail/listPrePayrollDetailStaff.vue"));

// --> Print Payroll
Vue.component("main-payroll",require("./components/rrhh/print-payroll/mainPrintPayroll.vue"));
Vue.component("list-payroll",require("./components/rrhh/print-payroll/listPrintPayroll.vue"));

// permanent Transaction
Vue.component("main-permanent-trans",require("./components/rrhh/permanetTransaction/mainPermanetTrac.vue"));
Vue.component("list-permanent-trans",require("./components/rrhh/permanetTransaction/listPermanentTrac.vue"));
Vue.component("addUp-permanent-trans",require("./components/rrhh/permanetTransaction/addUpPertmanetTrac.vue"));

// uptade payroll
Vue.component("main-update-payroll",require("./components/rrhh/update-payroll/mainUpdatePayroll.vue"));
Vue.component("list-payroll-history",require("./components/rrhh/update-payroll/listPayrollHistory.vue"));
Vue.component("add-up-payroll-history",require("./components/rrhh/update-payroll/addUpPayrollHistory.vue"));

// paycheck
Vue.component("main-paycheck",require("./components/rrhh/paycheck/mainPaycheck.vue"));
Vue.component("list-paycheck",require("./components/rrhh/paycheck/listPaycheck.vue"));
Vue.component("add-up-paycheck",require("./components/rrhh/paycheck/addUpPaycheck.vue"));
Vue.component("list-recipt-detail",require("./components/rrhh/paycheck/paycheckDetail/listReciptDetail.vue"));



//###################################################
//           Module Statistic Components
//###################################################
// --> Front Page
Vue.component("client-counter",require("./components/srcComponent/ClientCounter.vue"));
Vue.component("contract-counter",require("./components/srcComponent/ContractCounter.vue"));
Vue.component("invoice-counter",require("./components/srcComponent/InvoiceCounter.vue"));
Vue.component("contract-chart",require("./components/srcComponent/ContractChart.vue"));
Vue.component("contract-status-chart",require("./components/srcComponent/ContractStatusChart.vue"));

//###################################################
//           Module Configuration Components
//###################################################
Vue.component("main-company",require("./components/configuration/company/mainCompany.vue"));
Vue.component("panel-heading-add",require("./components/configuration/company/panelHeadingAdd.vue"));
Vue.component("panel-heading-update",require("./components/configuration/company/panelHeadingUpdate.vue"));
Vue.component("list-company",require("./components/configuration/company/listCompany.vue"));

//###################################################
//            Sources Components
//###################################################
Vue.component("button-form",require("./components/srcComponent/buttonForm.vue"));
Vue.component("loading", require("./components/srcComponent/loading.vue"));
Vue.component("time-live", require("./components/srcComponent/timeLive.vue"));
Vue.component("recursive-select", require("./components/srcComponent/RecursiveSelect.vue"));
Vue.component("recursive-table", require("./components/srcComponent/recursiveTable/FoodCalculatorExample.vue"));


const app = new Vue({
  el: "#app",
  data: {
    menu: -1,
  },
  methods: {},
});
