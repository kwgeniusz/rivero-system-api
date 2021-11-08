<<<<<<< HEAD
<<<<<<< HEAD
webpackJsonp([1],{

/***/ 728:
=======
webpackJsonp([1],{

/***/ 707:
>>>>>>> module-rrhh
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
<<<<<<< HEAD
  __webpack_require__(741)
}
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(743)
/* template */
var __vue_template__ = __webpack_require__(753)
=======
  __webpack_require__(720)
}
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(722)
/* template */
var __vue_template__ = __webpack_require__(732)
>>>>>>> module-rrhh
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-77894614"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/components/rrhh/vacations/PreVacations.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-77894614", Component.options)
  } else {
    hotAPI.reload("data-v-77894614", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

<<<<<<< HEAD
/***/ 741:
=======
/***/ 720:
>>>>>>> module-rrhh
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
<<<<<<< HEAD
var content = __webpack_require__(742);
=======
var content = __webpack_require__(721);
>>>>>>> module-rrhh
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(3)("b3be31e8", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../../node_modules/css-loader/index.js!../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-77894614\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./PreVacations.vue", function() {
     var newContent = require("!!../../../../../../node_modules/css-loader/index.js!../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-77894614\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./PreVacations.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

<<<<<<< HEAD
/***/ 742:
=======
/***/ 721:
>>>>>>> module-rrhh
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(2)(false);
// imports


// module
exports.push([module.i, "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n", ""]);

// exports


/***/ }),

<<<<<<< HEAD
/***/ 743:
=======
/***/ 722:
>>>>>>> module-rrhh
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
<<<<<<< HEAD
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__LisPreVacation_vue__ = __webpack_require__(744);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__LisPreVacation_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__LisPreVacation_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__AddPreVacation_vue__ = __webpack_require__(747);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__AddPreVacation_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__AddPreVacation_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__ListVacation_vue__ = __webpack_require__(750);
=======
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__LisPreVacation_vue__ = __webpack_require__(723);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__LisPreVacation_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__LisPreVacation_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__AddPreVacation_vue__ = __webpack_require__(726);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__AddPreVacation_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__AddPreVacation_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__ListVacation_vue__ = __webpack_require__(729);
>>>>>>> module-rrhh
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__ListVacation_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__ListVacation_vue__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

// @ is an alias to /src





/* harmony default export */ __webpack_exports__["default"] = ({
	components: {
		LisPreVacation: __WEBPACK_IMPORTED_MODULE_0__LisPreVacation_vue___default.a,
		AddPreVacation: __WEBPACK_IMPORTED_MODULE_1__AddPreVacation_vue___default.a,
		ListVacation: __WEBPACK_IMPORTED_MODULE_2__ListVacation_vue___default.a
	},
	data: function data() {
		return {
			currentComponent: 'LisPreVacation',
			currentCompVacatio: 'ListVacation'
		};
	},
	mounted: function mounted() {},

	computed: {
		currentTabComponent: function currentTabComponent() {
			return this.currentComponent;
		},
		currentComponentVacation: function currentComponentVacation() {
			return this.currentCompVacatio;
		}
	},
	methods: {}
});

/***/ }),

<<<<<<< HEAD
/***/ 744:
=======
/***/ 723:
>>>>>>> module-rrhh
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
<<<<<<< HEAD
var __vue_script__ = __webpack_require__(745)
/* template */
var __vue_template__ = __webpack_require__(746)
=======
var __vue_script__ = __webpack_require__(724)
/* template */
var __vue_template__ = __webpack_require__(725)
>>>>>>> module-rrhh
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/components/rrhh/vacations/LisPreVacation.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-7f36c0ab", Component.options)
  } else {
    hotAPI.reload("data-v-7f36c0ab", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

<<<<<<< HEAD
/***/ 745:
=======
/***/ 724:
>>>>>>> module-rrhh
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    name: 'LisPreVacation',
    components: {},
    data: function data() {
        return {
            objPreVacation: {},
            lengths: false,
            loading: false,
            currency: 1
        };
    },
    mounted: function mounted() {
        this.getListPreVacation();
    },

    computed: {},
    methods: {
        getListPreVacation: function getListPreVacation() {
            var _this = this;

            axios.get('pre-vacations/list').then(function (res) {
                res.data.length > 0 ? _this.lengths = false : _this.lengths = true;
                _this.objPreVacation = res.data;
                // console.log(this.objPreVacation)
            });
        },
        deletePreVacation: function deletePreVacation(id) {
            var _this2 = this;

            // console.log(id)
            if (confirm("Delete?")) {
                axios.delete('pre-vacations/' + id).then(function (res) {
                    // console.log(res)
                    _this2.getListPreVacation();
                }).catch(function (error) {
                    alert("Error");
                    console.log(error);
                });
            }
        },
        process: function process(id) {
            var _this3 = this;

            this.loading = true;
            var URL = 'pre-vacations/' + id;
            axios.get(URL).then(function (res) {
                var transProcessed = res.data.transProcessed;
                // console.log(res)
                if (res.statusText === 'OK') {
                    if (transProcessed > 0) {
                        alert('Transacciones registradas: ' + transProcessed);
                    } else {
                        alert('No se registraron transacciones para este periodo..');
                    }
                    _this3.loading = false;
                } else if (res.status === 204) {
                    alert('No se registraron transacciones para este periodo..');
                    _this3.loading = false;
                } else {
                    alert('Error al calcular');
                    _this3.loading = false;
                }
            });
        },
        upgradeVacation: function upgradeVacation(year, payrollNumber, payrollTypeId) {
            var _this4 = this;

            this.loading = true;
            var URL = 'vacations/upgrade/' + year + '/' + payrollNumber + '/' + payrollTypeId;
            axios.get(URL).then(function (res) {
                // let transProcessed = res.data.transProcessed
                // console.log(res)
                if (res.statusText === 'OK') {
                    alert('Vacaciones Actualizadas');
                    _this4.getListPreVacation();
                } else if (res.status === 204) {
                    alert('Sin Contenido...');
                    _this4.getListPreVacation();
                    _this4.loading = false;
                }
            });
        },
        formatDate: function formatDate() {
            function formatZero(n) {
                if (n < 10) {
                    n = '0' + n;
                    return n;
                } else {
                    return n;
                }
            }
            var dataTime = new Date();
            var dd = dataTime.getDate();
            var mm = dataTime.getMonth() + 1;
            var yyyy = dataTime.getFullYear();
            dd = formatZero(dd);
            mm = formatZero(mm);
            return dd + '/' + mm + '/' + yyyy;
        },
        printPreVacation: function printPreVacation(year, payrollNumber, payrollTypeId) {
            var _this5 = this;

            var URL = 'pre-vacations/print/' + year + '/' + payrollNumber + '/' + payrollTypeId;
            var selecCurrency1 = this.currency;

            axios.get(URL).then(function (res) {
                // console.log(res)
                if (res.status === 204) {
                    return alert('Sin contenido');
                }
                var objPrePayrollDetail = res.data.print;
                // return
                var period = objPrePayrollDetail[0];
                var country = objPrePayrollDetail[1];
                var company = objPrePayrollDetail[2];
                var logo = objPrePayrollDetail[3];
                var payrollTypeName = objPrePayrollDetail[4];
                var companyAddress = objPrePayrollDetail[7];
                var companyNumber = objPrePayrollDetail[8];
                var companyId = objPrePayrollDetail[9];
                var color = objPrePayrollDetail[10];
                var userProcess = objPrePayrollDetail[13];
                var icoMap = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEIAAAA4CAYAAABJ7S5PAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAA1qSURBVGhD7ZoHVFTXFoZ/W+ygYldEkaqIaBIUO7YotmcvQUGUaIxBjcaQ+MwzeWkmMcbYjfEZUWPvsYCK2LED9oIxFkRBBcGK+M5/uDPcGQYYhhn0rfW+tWbNvXdm7pz7n3322XufU+ilAP8Hr1SIW7fisDt8DyKPHkNqaipOnjqFl+kvUdO2JqpXq4q69nXRuVNHuLo4o1ixYsqvLEOBCsG/evLkiXjgKMyYORtR0TF49uyZ8mn21Lazg7+fL7r4dEY5a2sUKVJE+cR8FJgQaWlpOHP2HBb/HoIdYTulIHnFydERo94PhHfr1ihbtqxy1TwUiBCPHj9GeHgEpv44DTdu3FSums7IEYHo16eXtBRzYXEhUsTY37hxM3746WckJycrV7NSvnx5FFVMPv1lOlJTUvHk6VN5rg+HRvt2bTFh3BjUrWuvXM0fFhWCw2HNuvXSH8TH31GuZkLzdqtfT7zqo3ZtOxQrWlReT09PR+K9e7h8+QpOnDwpreiFuKamRIkS6NbFB2OCPhCOtZpy1XQsKkTkkaP4+tupOHvuvHw4DcWLF0fDhu7o0ukdvNm4EexFr5YQ19S8ePECdxMScObMWezcFS79yoMHD5RPM7C2tkKAvx+GBwxFyZIllKumUWSKQDk2KwniIX5b9DsOHjosLUMDe7KzEGCs6MkWzZujmpgmiyqWoKZw4cIoU6aM9APu7m4oX84aMafP6DjZp2LopIgh5OLsiBo1aihXTaOw8m52jojY4HDkEZ3pkQ9HC/ho7Ieo5+oqRNG1AkPwN1UqV8aAfn0xbkwQ3njjDeWTDC5cvIidu/cg+eFD5YppWESIR48eiVghGjdu6s4QFW1s8PWXU1CjenUUKlRIuWocpUqVEmL0QY/uXZUrGTx//hwnTpzC1diryhXTsIgQ16/fkD2l736GBfijVi1bgyJw+DC6pKnTigy5Lg6hsR+OlkGVmkuXL+Ha39cN/sZYLCOEsAR6fDUlhW8YNKCfcqYLx/rK1WvQyrsDGnt64YuvvsHt27eVT3WhT2HYrebhwxQhxmUhYopyJe9YRIjkpGQ5/anx8mqC0qVLK2e60AnOmbcA98WsQMvYuGkLQpavUD7NSlvvNspRJnfv3pWBm6mYXQhOe6nCR3DsqmF4nB1xcbfFcMj8PmeGK1dilbOsODs5KUeZJN67jyeP8x62a7CIEMYkUmocHerKbFPjO8qWLQOvpp7y2BAlS5ZUjsyH2YWgQytloKHnL1xUjrLiIIQIGj0K3bt1RYf2bfHe8GHoKqLG7IiKiVaOMmGaXriI6Y9jdiE471ewqSCnSjVHjx1DYqKu39BA8dq0boWPx4/FpOBP4DtoYJbfq9m2LVQ5yqRmzeooWyb3jDRJ+K/rN27oRLrE7EIQWxHlsZfVpKY+wuKQpcpZVphIMWfg9MqhkR137tzF9lBdIeiEXZycYWVlWAj6q/PnL+DnX2bBf1gghvgPw6w585VPM8i3EEeOHsWEiZ/Cq0UbGQcQPowhh7ZBZKGa75jK3AW/SlHV1HN1kcLTGtXwv5j0jfwgCIMG+2Pu/F8RHXNaxhyz585TvpVBnoRIE46QHv30mTP4ftpP8G7fSfzBUKzbsBEPkpIQsW+//B5zhObNvWBfp4481xAfH49fZs/NYpbGcu78eaxavVY5y4AP39C9ARyUdJzO+pKIYT7757/QtmNnTAyehPA9EbJ9tAxN0KU/q+UqBOf1xMREXBDObuXK1Rg+YhQG+vpj3vyFQtm/tQ+VJm68det2GRyRBiK1dnFxQhFVL/Fe/M5pkVHmFXYAzfmZXo3C0dEBLVu2kCE4Cdu5C9179sGKVatFbJEgrxmDQSGo1h0RoETHxGDLn9vw5dffYqAwrclTvpTZpCHzZr3g+MmTwikel+dVqlQWM0A78V5FnmtISExAyNLlMngyFoq9PTRMDkN1XYLpfFNPT7zZyEOes120Tv3eNgYdIR5Lsz8rx9XPM2biownBGD8xGJu3bM1SC9CnuMgKK4ssMUFYj4YO7dqimVdTnYzx6dNn2HfgoPD8O4xuMMP1pcv+wD0RNGlgzFHX3h7duvporWHf/oOIiooxaehphWAQxLT5u+9/xDfffS9Maw1ir17NMZFhRYmlMp/O72DsmA8xflyQCISa4P79jAazgf1FxlitalV5roG1io2btxg1RO6Je61auw4XL17SaUtpce92bdvAvYGbPL9//4GwXtFhSZkdxg5gBaxN65aoUaO6ctUwWiHibsdjpXh4VpX0vbI+lSpWFI3wRvDECZgyeRI++Xg8RgQOQ6sWLZD+Il3c45iM/QkdWf++vXXWJdhjzC/Wb9hksISngY5vT8RebN8RKmufGugg3cV9+/bppS3qhO3aheMnTgorS5PZafduXRAs2jV50qfwG+yLmrkUbrSlobi4OBw4eEj+uSFYWWri+TaaNvGUvVC9ejXZ0/qFElrWgUOHREb4ED3/0V02dED/vtgv7k3/ooHO789t2+Hk5IA+vXrK++vDqe6PFatkLqKGJbrRo0ZqH44xwo7QnTIz9RviC4+G7qhla4uKFW1k+1juyw2tEM/EeDXkBO3s7NDFpxNaNm8mC6wsuDKlzqmwkhH0hMkG0auXK1cOX3w+CT169dPJEDmElv2xEi7OzmgsHJ46Doi/c0f6Kjps/eE5RPTwW282Vs6EvxC/GzUiEFWFEOXFf2l8Rl4wOGtooEmvX70CY0Qe4Pn2W7Jkxjwit+oSTX+viCm2h4VpxbUXju3zyZ/JYzUc+/NEkJSQkOlkOQWHh+/B6jXrpKmrobh8aM2QIEzaGjVuJCtfpohAchSC47pUqZLyPbeH14dDjGZNX8Ae5e97dO8mxnVvnZ7nZ7vDI7Bg4W9y1uJ5VFQ0/v3NVJ2iL2Fvz5k1I8s6KO9XOI/t0ydHIfLLbeGAZ82Zp5TRhBcXDxAY4I8GbvWzCLto8RJsEM4z9upfmCCiwcd6RZYyIp/4LHiidNSWwKJCEDrIlSLKS0t7Lh/ezq4W3hembciLf/XtVJm33BDZoRrWHzgNt2/nbZEFYGJxIcjiJUvxVCnW0Kw58wwa2B82FSrIaxpoBVHRurUGhuitRQg92HeQmC10i7bmpECEkPmHyvNbWVnJed6ncycZGOVEAzFVD/UbnGsckF8KRAhDMAbxfXcAWoneZs5giDq1awsRhsjlQTpECsoM1BK8MiEIc4WAoX5wdnLM4vVtbGykX/D2bq0N2jZs2oz9Bw7JY3PzSoVgLzMEHz9ujEzYNLDixP0PA/v3k7MFYdS7cNHiXJM/U3mlQhAGRs2beeHT4I/lEOGs4N2mFd4bHqAt2TGEnjZ9BmJjc04C88MrF4LQMrjX4cjBvfhz0zr8Mn2adoa4JXKg2XPnawMzS/FaCKGBeYx6IYjD4PeQpdi9Z0+2yaC5eK2E0OfAwcOyRvk4HytYxvJaC5GSmiLXIQqC11qIgsSsQrC+cCgyUla3/9cwixDMD36aMRPvjx4jPfy1a9eUTzIZN+ETmWGeO2eZyDA76GS5rSi3LQMmC8GaZMiy5fD1C8DooI/wH/GQ3Dd18+atLMUUwkWWmbPmYFTQWASNGy8r45oiryVISkqS+yzGi2yWizwsAOVE1u1sOcBYn/P5qjVrEbF3n3Rk6tWjnGDVKik5Wb6YZoft3I3y5cuhY4d26N2zp9x4rq46mQrXPrZuD8WO0DAx/SbJ4o4xU2+OFsHG8+G5XLZg4SIMeNcP/Qb6Ys3a9XIVKbu9Tqw78KGyqx28eJFxXxZuloQsR49efdHRpxtmzZkrtww9efI0o/G56KtZgrx46RKmi6GpWYJcErJMVsf5H4ZEYADXp3dP5SwD7YbTvfsPwD8gUF7UwPpgxUoVcVDM59wplxtc57AuZy1XtT0aNpR7mrgDP/FeotznZEzPUDxuEfAWrzghCn2OmuEB/nLpgDXOY8dPYNuOUPkfhgrP+vDezF2Y2k//capM7DTkKISxVKpUCVUqV4Kjg4Nc72jS5G1t0YWbvA5HHkVk5BFcunIFd+/clRaWG2w0X/q7b7iAxDI9V7WMScDY+8xZuPRoZ2sr2uaJrj6dZJvV5UKThWBRt06dOrCvXVtuFPNwd4eLGOc5ceTYMZw6FY1o0YNXRALFaZambQm4BMmyoKMI2bnaxfI//VB2Ve48CcFxz5I+TYuLPB4e7qjv6ipzBGPh39EiTgunS5OmN+fSH3exGDN0coJDs5Z4eNY3Gri5wcXZCfXruQoLyr3ga5QQNFGua3ARppGHh9yLwJWu/Hp5zjjxYqjExsbizNmzcgjFxJw2auioYWWbS4BvNW6EevVd5f5t25o1lU+NQysECx/DAkfKFS8NVatWQaeOHWSxlQs0lYXjZL3REjDg4SzCzSRcfw2P2IsL5y/otEcNTb+R6JjWrVpqlyAri3HPpUP9pQJj0ArBbcM/TJsuBeFs0a1rF7i51Zdq09nQ6RQEbA1ngKTkJPz11zWRgkfg0OFIWZSh46wnTJ2zSstmzaQPsLK2ynUJ0hi0QvCNf8QAhEOBZXe+v0rSRZu4E4e+g7EHAwu2iUOSr/w+fCbAfwEUfBz1/GmfDQAAAABJRU5ErkJggg==';
                var icoPhone = 'data:image/png;base64,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';
                var icoGlobe = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAzCAYAAADVY1sUAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAL7SURBVHgB7VqLcdswDH3JdQB1AnODaAR1g25QdgNvEHcCuxM4nSDdQO4ETieQO4HTCVLBthoEESVApBKdz+8Od7QNgHgU+BFoYDzktZS17Gt5quW+FoeJIqvltpYv4nv63BCQInX9yYfDO6DAcbQpsApHQg1ytBPgUjD97OSDvl/jjQhlp854UB7tQXWJJO/F76MSakuXSujcop9EIwthW7X49kiMZSAYz3Qc9CRIaFD4U1kE9JZIAOqo7AjGMd05bETkU8kQXiC2eEnaTGLbEcRPoV/BTmQvfHQN2mAy254gPNMtYCfRSMH8+B7dLYxYKgJwTH+t0A/JivnJFPrqOeMVzuTIVAobbXr1ZQLJHD1wyqBWwuYpUmbM30pJ3vHAr1/yUB8VNqxdIB6fWPtBoU8pGEwxB/0I5sxOM4JjPeGihYd6wlqWTK3IObdX2pWNwQdm/OskfXgUn7/X8gNxkD6/ImIDvGAKuMJxcnmDDR1NmpWFJv1npEGM38NiQQaWick7GHJQDAnf5LzR1tM+UsAGPjFTTkjuawcbciJyg+FISWTG2o+wwRERBxsq1h5ribQSuRlCZIrIrnEeOBsih9OvNR8niXMhsiMimvM/x0eMg7+sbV0ND0T+wIaYjasLMRvt7yFPxKG981jEEHmg9xE6rDmLEWtvavmGNNiw9s7od4MLJoYr1vbQgXKZl0vpWB975orxeSe/oBf5IcUHTUFNXUQ4QVt8kPXnAwpDxzNml7oclBvs/pel+FlrE2LYAmtBrQ/ch4MOd+jo20H3WFOXTHPmb1DJtA2a9/CURexK+CoVNnMooRmVzKgfkjXzo7lWWMGIs7joIfRdvZVCX7tkdqXVfQ+J0e4RNbeyXcKvBtxYJDhCc2DBdLpuZUPimL1HojnRB4/Xq5Pc5RfQk5ABtvlWr05WOBw3otCkt/yFwzE7L35/s38SOTwToqB4/hboJ5ILfw35Emmu8sxwOKaITAGPMAnforvAhC92HJ6XU8p3Gu0cF3TjH2L2H0VgekrQAAAAAElFTkSuQmCC';
                var icoMail = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAmCAYAAACGeMg8AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAG6SURBVHgB7VnbcYMwEFwnDVCCPvPpEijBHYQO4s/84Q5MB6YDpwPSgd0BdIA7IJyRJhiONzIS4505PDDotCstOpCBf/h5xHlklsQlDw8VnA0l2yeIO96lqm/Yi488NhsUU7SF3UhISIYV4A0rwaqE/MJ+XOkgYFf94OqJUIqcPALDCXMRSu417A0k2xR7dEDAbKsRN7bunVHyWElMCCxOuhrEtWqlrbzeOlWmWC1t4PdVuuehwYlRLLCs1WLUreRIrlmTENVQMA2XWNUC8FaKmXsbk/iow0MxzboFpGC+NfBopd5ClNVEJZmAXqtdwDsi6mjXmZhIu6jjoEFEwPTjot/A9e7En9DJ2ME6DsgxedrpfMqncgR+pYwG5hk1eh7qOIzIxdWGHcYtKKNH8oj+S2MfKzkYZqXZhChCokKIzsOWNifoKbqTGlM0vT64KJ6dVEYE/oH+xDy1aXKCNqu1YaqVtAlRVvPQDRfzF9VZk6mIpKDyDDnyWqSjz2fsayXyV0AjXht0puElxDSQkBvsx42EXGE/fuhAL3rP+HzVFcRdKEUu7Nz/TSX3ex0pYwd7/r1KUFjq/oz/Ad4q72Jw+8N+AAAAAElFTkSuQmCC';
                var dataTime = _this5.formatDate();
                var colorPri1 = void 0;
                var colorPri2 = void 0;
                var colorPri3 = void 0;
                var colorSec1 = void 0;
                var colorSec2 = void 0;
                var colorSec3 = void 0;

                // chequear si el total general es el local o moneda extrangera
                var totalAsignacion = void 0;
                var totalDeduccion = void 0;
                if (selecCurrency1 == 1) {
                    totalAsignacion = objPrePayrollDetail[5];
                    totalDeduccion = objPrePayrollDetail[6];
                } else {
                    totalAsignacion = objPrePayrollDetail[11];
                    totalDeduccion = objPrePayrollDetail[12];
                }
                // plantilla de colores
                switch (color) {
                    case 'YELLOW':
                        colorPri1 = 230;
                        colorPri2 = 219;
                        colorPri3 = 153;
                        colorSec1 = 242;
                        colorSec2 = 237;
                        colorSec3 = 209;
                        break;
                    case 'BLUE':
                        colorPri1 = 113;
                        colorPri2 = 160;
                        colorPri3 = 228;
                        colorSec1 = 160;
                        colorSec2 = 229;
                        colorSec3 = 251;
                        break;

                    default:
                        colorPri1 = 255;
                        colorPri2 = 255;
                        colorPri3 = 255;
                        colorSec1 = 255;
                        colorSec2 = 255;
                        colorSec3 = 255;
                        break;
                }
                // white

                // funcion para centrado de texto en company
                function centerText(text) {
                    var numCenter = 220;
                    // console.log(text)
                    // si es jdrivero CA o jd rivero INC
                    if (text.length < 20) {

                        // console.log('entro: ' + numCenter)
                        numCenter = numCenter + 30;
                        return numCenter;
                    } else {
                        // si es rivero visual group o otras con nombres largos
                        return numCenter;
                    }
                }

                var imgLogoURL = window.location.origin + '/' + logo;

                // funcion para combertir imagen a Base64 a partir de la url de la imagen
                function toDataUrl(src, callback) {
                    var xhttp = new XMLHttpRequest();
                    xhttp.onload = function () {
                        var fileReader = new FileReader();
                        fileReader.onloadend = function () {
                            callback(fileReader.result);
                        };
                        fileReader.readAsDataURL(xhttp.response);
                    };
                    xhttp.responseType = 'blob';
                    xhttp.open('GET', src, true);
                    xhttp.send();
                    // console.log(xhttp)
                }

                // funcion para crear pdf
                function crearPDF(imgData) {

                    var doc = new jsPDF('p', 'pt', 'letter');

                    // determino la cantidad de paginas en el documento
                    var numPage = 1;
                    var cont = 155;
                    for (var i = 0; i < objPrePayrollDetail.length; i++) {
                        var element = objPrePayrollDetail;
                        // condiciono que comienze a leer los datos a partir de la posicion 11 del array
                        if (i > 13) {
                            var name = true;
                            element[i].forEach(function (element2) {
                                // doc.text( 'text test11', 220, cont ); //######### only test
                                cont += 15; //18 es el tamaño aproximado de separacion entre lineas de palabras
                                if (cont > 720) {
                                    //720 es el tamaño establecido de contenido dento de la hoja letter
                                    numPage = numPage + 1;
                                    // doc.addPage(); //######### only test
                                    cont = 155; // 155 es el espacion definido para la cabecera
                                }
                                // doc.text( 'text test2', 220, cont ); //######### only test
                            });
                            cont += 20;
                        }
                    }

                    // doc.text( 'izquierda?.', eje X, eje Y );
                    //  console.log(colorPri1,colorPri2,colorPri3)
                    //  Encabezado
                    doc.setDrawColor(0);
                    doc.setFillColor(colorPri1, colorPri2, colorPri3); // color de los rectangulos
                    doc.rect(30, 25, 550, 20, 'F');
                    doc.addImage(imgData, 'JPEG', 35, 50, 85, 60);
                    doc.setFont("helvetica");
                    doc.setFontType("bold");
                    doc.setFontSize(14);
                    doc.text('PRE-VACACIONES', 240, 40);
                    // doc.setFontType("courier");

                    doc.setFontType("bold");
                    doc.text(company, centerText(company), 70);
                    // doc.setFontType("courier");

                    doc.setFontSize(8.5);
                    doc.text('Rif: ' + companyNumber, 265, 80);
                    doc.setFontType("normal");
                    // console.log('conpany: ' + company)
                    if (companyId == 4) {
                        doc.addImage(icoPhone, 'JPEG', 260, 92, 9, 9);
                        doc.addImage(icoGlobe, 'JPEG', 304, 103, 9, 9);
                        doc.addImage(icoMail, 'JPEG', 179, 103, 9, 8);
                        doc.text('+58 (247) 342-9544', 270, 100);
                        doc.text('info@riverovisualgroup.com', 190, 110);
                        doc.text('www.riverovisualgroup.com', 315, 110);
                        // pie de pagina
                        doc.setFontSize(7.5);
                        doc.setFontType("italic");
                        var _dataTime = new Date();
                        var yearYYYY = _dataTime.getFullYear();
                        doc.text('\xA9 Copyright ' + yearYYYY + ' Rivero Visual Group - All rights reserved ', 210, 760);
                        doc.setFontType("normal");
                    }
                    if (companyId == 5) {
                        doc.addImage(icoPhone, 'JPEG', 260, 92, 9, 9);
                        doc.addImage(icoGlobe, 'JPEG', 304, 103, 9, 9);
                        doc.addImage(icoMail, 'JPEG', 219, 103, 9, 7);
                        doc.text('+58 (247) 342-9544', 270, 100);
                        doc.text('info@jdrivero.com       www.jdrivero.com', 230, 110);
                        // pie de pagina
                        doc.setFontType("italic");
                        doc.setFontSize(7.5);
                        var _dataTime2 = new Date();
                        var _yearYYYY = _dataTime2.getFullYear();
                        doc.text('\xA9 Copyright ' + _yearYYYY + ' JD Rivero Global - All rights reserved ', 215, 760);
                        doc.setFontType("normal");
                    }
                    doc.addImage(icoMap, 'JPEG', 181, 82, 11, 9);
                    doc.text(companyAddress, 195, 90);
                    // pie de pagina
                    doc.setFontSize(7.5);
                    doc.text('Pagina:', 515, 760);
                    doc.text('1/' + numPage, 545, 760);
                    doc.setFontType("italic");
                    doc.text('Designed By Rivero Visual Group', 250, 775);
                    doc.setFontType("normal");

                    doc.setFontSize(7.5);
                    doc.setFontType("bold");
                    // doc.setFontSize(12);
                    doc.text('Fecha: ', 435, 80);
                    doc.text('Periodo: ', 435, 90);
                    doc.text('Tipo De Nomina:', 435, 100);
                    doc.text('Pais:', 435, 110);
                    doc.text('Generado Por:', 435, 70);
                    doc.text('Pagina:', 435, 60);
                    doc.setFontType("normal");
                    doc.text('1/' + numPage, 465, 60);
                    doc.text(userProcess, 489, 70);
                    doc.text(dataTime, 462, 80);
                    doc.text(period, 468, 90);
                    doc.text(payrollTypeName, 500, 100);
                    doc.text(country, 455, 110);
                    doc.setFontSize(12);
                    doc.setFontType("normal");

                    // // titulos tablas
                    doc.setDrawColor(0);
                    doc.setFillColor(colorSec1, colorSec2, colorSec3);
                    doc.rect(30, 117, 550, 20, 'F');
                    // doc.line(30, 115, 580, 115);
                    doc.setFontSize(8);
                    doc.setFontType("bold");
                    doc.text('CODIGO', 30, 130);
                    doc.text('NOMBRE', 76, 130);
                    doc.text('CONCEPTO', 195, 130);
                    doc.text('CANTIDAD', 315, 130);
                    doc.text('ASIGNACION', 385, 130);
                    doc.text('DEDUCCION', 453, 130);
                    doc.text('NETO', 545, 130);
                    // doc.line(30, 138, 580, 138);
                    doc.setFontSize(7.5);
                    doc.setFontType("normal");
                    var n = 155;
                    var nRectangulo = 2;
                    var nunIniRectangulo = 145;
                    var page = 1;

                    function formatNumber(number) {
                        var currencyCurrent = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;

                        number = parseFloat(number);
                        number = number.toFixed(2);
                        if (currencyCurrent) {
                            var montoNuevo = number.toString().replace(/\D/g, "").replace(/([0-9])([0-9]{2})$/, '$1.$2').replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
                            return '$' + montoNuevo;
                        } else {
                            var _montoNuevo = number.toString().replace(/\D/g, "").replace(/([0-9])([0-9]{2})$/, '$1,$2').replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
                            return 'Bs' + _montoNuevo;
                        }

                        // let num = parseFloat(number).toFixed(2);
                        // return num
                    }

                    for (var _i = 0; _i < objPrePayrollDetail.length; _i++) {
                        var _element = objPrePayrollDetail;
                        //  console.log( element[i]) 
                        //  console.log('numero de pagina3: ' + numPage) 

                        // condiciono que comienze a leer los datos a partir de la posicion 11 del array
                        if (_i > 13) {
                            (function () {

                                var name = true;

                                _element[_i].forEach(function (element2) {
                                    // console.log('Numero pagina2: ' + numPage)
                                    // indica si imprime linea amarilla
                                    if (nRectangulo % 2 == 0) {
                                        doc.setDrawColor(0);
                                        doc.setFillColor(colorSec1, colorSec2, colorSec3);
                                        doc.rect(30, nunIniRectangulo, 550, 15, 'F');
                                    }

                                    if (name) {
                                        doc.line(30, n - 10, 580, n - 10); //horizontal line
                                        doc.setFontType("bold");
                                        // doc.line(30, n - 10, 580, n - 10);
                                        // doc.text(`n es: ${n}`, 150, n);
                                        doc.text(element2.staffCode, 30, n);
                                        doc.text(element2.staffName, 76, n);
                                        name = false;
                                        doc.setFontType("normal");
                                    }
                                    doc.line(193, n - 10, 193, n + 5); // vertical line
                                    doc.line(309, n - 10, 309, n + 5); // vertical line
                                    doc.line(365, n - 10, 365, n + 5); // vertical line
                                    doc.line(448, n - 10, 448, n + 5); // vertical line
                                    doc.line(510, n - 10, 510, n + 5); // vertical line
                                    doc.text(element2.transactionTypeName, 195, n);
                                    doc.text(element2.quantity, 361, n, 'right');
                                    // validacion de moneda
                                    var amount = element2.amount;
                                    if (selecCurrency1 === false) {
                                        amount = element2.localAmount;
                                    }
                                    if (element2.isIncome == 1) {
                                        if (amount == null) {
                                            //  console.log('entro')
                                            // doc.text('0', 436, n, 'right' );
                                        } else {
                                            doc.text(formatNumber(amount, selecCurrency1), 445, n, 'right');
                                        }
                                    }
                                    if (element2.isIncome == 0) {
                                        if (amount == null) {
                                            // console.log('entro')
                                            // doc.text('0', 502, n, 'right' );
                                        } else {
                                            doc.text(formatNumber(amount, selecCurrency1), 508, n, 'right');
                                        }

                                        // doc.text( '2.07', 502, 155, 'right' );
                                    }
                                    // doc.text(element2.staffCode);
                                    n += 15;

                                    nunIniRectangulo += 15;
                                    nRectangulo += 1;
                                    if (n > 720) {
                                        page += 1;
                                        doc.addPage();

                                        //  Encabezado
                                        doc.setDrawColor(0);
                                        doc.setFillColor(colorPri1, colorPri2, colorPri3); // color de los rectangulos
                                        doc.rect(30, 25, 550, 20, 'F');
                                        doc.addImage(imgData, 'JPEG', 35, 50, 95, 60);
                                        doc.setFont("helvetica");
                                        doc.setFontType("bold");
                                        doc.setFontSize(14);
                                        doc.text('PRE-VACACIONES', 240, 40);
                                        // doc.setFontType("courier");


                                        // doc.text( 'PAIS:', 30, 74 );
                                        // doc.text( country, 63, 74 );
                                        // doc.text( 'EMPRESA:', 30, 84 );
                                        doc.setFontType("bold");
                                        doc.text(company, centerText(company), 70);
                                        // doc.setFontType("courier");

                                        doc.setFontSize(8.5);
                                        doc.text('Rif: ' + companyNumber, 265, 80);
                                        doc.setFontType("normal");
                                        // console.log('conpany: ' + company)
                                        if (companyId == 4) {
                                            doc.addImage(icoPhone, 'JPEG', 260, 92, 9, 9);
                                            doc.addImage(icoGlobe, 'JPEG', 304, 103, 9, 9);
                                            doc.addImage(icoMail, 'JPEG', 179, 103, 9, 8);
                                            doc.text('+58 (247) 342-9544', 270, 100);
                                            doc.text('info@riverovisualgroup.com', 190, 110);
                                            doc.text('www.riverovisualgroup.com', 315, 110);
                                            // pie de pagina
                                            doc.setFontSize(7.5);
                                            doc.setFontType("italic");
                                            var _dataTime3 = new Date();
                                            var _yearYYYY2 = _dataTime3.getFullYear();
                                            doc.text('\xA9 Copyright ' + _yearYYYY2 + ' Rivero Visual Group - All rights reserved ', 210, 760);
                                            doc.setFontType("normal");
                                        }
                                        if (companyId == 5) {
                                            doc.addImage(icoPhone, 'JPEG', 260, 92, 9, 9);
                                            doc.addImage(icoGlobe, 'JPEG', 304, 103, 9, 9);
                                            doc.addImage(icoMail, 'JPEG', 219, 103, 9, 7);
                                            doc.text('+58 (247) 342-9544', 270, 100);
                                            doc.text('info@jdrivero.com       www.jdrivero.com', 230, 110);
                                            // pie de pagina
                                            doc.setFontType("italic");
                                            doc.setFontSize(7.5);
                                            var _dataTime4 = new Date();
                                            var _yearYYYY3 = _dataTime4.getFullYear();
                                            doc.text('\xA9 Copyright ' + _yearYYYY3 + ' JD Rivero Global - All rights reserved ', 215, 760);
                                            doc.setFontType("normal");
                                        }
                                        doc.addImage(icoMap, 'JPEG', 181, 82, 11, 9);
                                        doc.text(companyAddress, 195, 90);
                                        // pie de pagina
                                        doc.setFontSize(7.5);
                                        doc.text('Pagina:', 515, 760);
                                        doc.text(page + '/' + numPage, 545, 760);
                                        doc.setFontType("italic");
                                        doc.text('Designed By Rivero Visual Group', 250, 775);
                                        doc.setFontType("normal");

                                        doc.setFontSize(7.5);
                                        doc.setFontType("bold");
                                        // doc.setFontSize(12);
                                        doc.text('Fecha: ', 435, 80);
                                        doc.text('Periodo: ', 435, 90);
                                        doc.text('Tipo De Nomina:', 435, 100);
                                        doc.text('Pais:', 435, 110);
                                        doc.text('Generado Por:', 435, 70);
                                        doc.text('Pagina:', 435, 60);
                                        doc.setFontType("normal");
                                        doc.text(page + '/' + numPage, 465, 60);
                                        doc.text(userProcess, 489, 70);
                                        doc.text(dataTime, 462, 80);
                                        doc.text(period, 468, 90);
                                        doc.text(payrollTypeName, 500, 100);
                                        doc.text(country, 455, 110);
                                        doc.setFontSize(12);
                                        doc.setFontType("normal");

                                        // // titulos tablas
                                        doc.setDrawColor(0);
                                        doc.setFillColor(colorSec1, colorSec2, colorSec3);
                                        doc.rect(30, 117, 550, 20, 'F');
                                        // doc.line(30, 115, 580, 115);
                                        doc.setFontSize(8);
                                        doc.setFontType("bold");
                                        doc.text('CODIGO', 30, 130);
                                        doc.text('NOMBRE', 76, 130);
                                        doc.text('CONCEPTO', 195, 130);
                                        doc.text('CANTIDAD', 315, 130);
                                        doc.text('ASIGNACION', 385, 130);
                                        doc.text('DEDUCCION', 453, 130);
                                        doc.text('NETO', 545, 130);
                                        // doc.line(30, 138, 580, 138);

                                        doc.setFontSize(7.5);
                                        doc.setFontType("normal");

                                        n = 155;
                                        nunIniRectangulo = 145;
                                        // nRectangulo = 2
                                    }
                                });
                                // indica si imprime linea amarilla
                                if (nRectangulo % 2 == 0) {
                                    doc.setDrawColor(0);
                                    doc.setFillColor(colorSec1, colorSec2, colorSec3);
                                    doc.rect(30, nunIniRectangulo, 550, 15, 'F');
                                }
                                doc.setFontSize(7.5);
                                // doc.line(193, n-10, 193, n+5); // vertical line
                                // doc.line(309, n-10, 309, n+5); // vertical line
                                doc.line(365, n - 10, 365, n + 5); // vertical line
                                doc.line(448, n - 10, 448, n + 5); // vertical line
                                doc.line(510, n - 10, 510, n + 5); // vertical line
                                doc.setFontType("bold");
                                doc.text('TOTALES', 215, n);

                                // asignacion para los montos
                                var asignacion = void 0;
                                var deduccion = void 0;
                                if (selecCurrency1 === false) {
                                    asignacion = _element[_i][0].asignacionLocal;
                                    deduccion = _element[_i][0].deduccionLocal;
                                } else {
                                    asignacion = _element[_i][0].asignacion;
                                    deduccion = _element[_i][0].deduccion;
                                }

                                if (asignacion === null) {
                                    asignacion = 0;
                                    // doc.text(`${asignacion}`, 436, n, 'right' );
                                } else {
                                    doc.text('' + formatNumber(asignacion, selecCurrency1), 445, n, 'right');
                                }
                                if (deduccion === null) {
                                    deduccion = 0;
                                    // doc.text(`${deduccion}`, 502, n, 'right' );
                                } else {
                                    doc.text('' + formatNumber(deduccion, selecCurrency1), 508, n, 'right');
                                }

                                var total = asignacion - deduccion; // calculo para el total
                                // console.log('total: ');
                                // console.log(total);
                                if (total < 0) {
                                    doc.text('( ' + formatNumber(total, selecCurrency1) + ' )', 578, n, 'right');
                                } else {
                                    doc.text('' + formatNumber(total, selecCurrency1), 578, n, 'right');
                                }
                                // doc.text(total, 574, n, 'right' );

                                doc.setFontType("normal");
                                n += 20;
                                nunIniRectangulo += 20;
                                nRectangulo += 1;
                            })();
                        }

                        // return
                    }
                    doc.setFontType("bold");

                    totalAsignacion;
                    totalDeduccion;
                    var totalNeto = totalAsignacion - totalDeduccion;
                    n = n + 5;
                    doc.text('TOTAL GENERAL:', 215, n);
                    doc.text(' ' + formatNumber(totalAsignacion, selecCurrency1), 438, n, 'right');
                    doc.text(' ' + formatNumber(totalDeduccion, selecCurrency1), 508, n, 'right');
                    doc.text(' ' + formatNumber(totalNeto, selecCurrency1), 578, n, 'right');

                    doc.save(company + '-' + period + '.pdf');
                    // console.log(res.data.print)
                    // this.$emit("prePayrollDetail", objPrePayrollDetail)
                }

                // llamo la funcion para combertir imagen a base64 y le paso por parametro la variable ' imgLogoURL' con la URL
                toDataUrl(imgLogoURL, function (dataURL) {
                    function closeFrame() {}
                    // como callback llamo una funcion para crear el pdf y le para por varible 'dataURL' la imagen convertida en base64
                    crearPDF(dataURL);
                });
            });
        }
    }
});

/***/ }),

<<<<<<< HEAD
/***/ 746:
=======
/***/ 725:
>>>>>>> module-rrhh
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "col-md-12" }, [
    _c("h2", { staticClass: "text-uppercase" }, [_vm._v("Pre vacaciones")]),
    _vm._v(" "),
    _c("div", { staticClass: "panel panel-default" }, [
      _c("div", { staticClass: "container" }, [
        _c("div", { staticClass: "row" }, [
          _vm._m(0),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-3 col-md-offset-6" }, [
            _c("label", {
              staticClass: "form-group",
              attrs: { for: "currency" },
              domProps: { textContent: _vm._s("Moneda") }
            }),
            _vm._v("   \n                        "),
            _c("label", [
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.currency,
                    expression: "currency"
                  }
                ],
                attrs: { type: "radio", value: "1", id: "currency1" },
                domProps: { checked: _vm._q(_vm.currency, "1") },
                on: {
                  change: function($event) {
                    _vm.currency = "1"
                  }
                }
              }),
              _vm._v(" USD   \n                        ")
            ]),
            _vm._v(" "),
            _c("label", [
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.currency,
                    expression: "currency"
                  }
                ],
                attrs: { type: "radio", value: "2", id: "currency2" },
                domProps: { checked: _vm._q(_vm.currency, "2") },
                on: {
                  change: function($event) {
                    _vm.currency = "2"
                  }
                }
              }),
              _vm._v(" VEF \n                        ")
            ])
          ])
        ])
      ])
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "panel panel-default" }, [
      _c("div", { staticClass: "table-responsive text-center" }, [
        _c(
          "table",
          { staticClass: "table table-striped table-bordered text-center" },
          [
            _vm._m(1),
            _vm._v(" "),
            _vm.objPreVacation.length > 0
              ? _c(
                  "tbody",
                  _vm._l(_vm.objPreVacation, function(preVacation, index) {
                    return _c("tr", { key: preVacation.hrpayrollControlId }, [
                      _c("td", [_vm._v(_vm._s(index + 1))]),
                      _vm._v(" "),
                      _c("td", { staticClass: "form-inline" }, [
                        _c("p", { staticClass: "text-left" }, [
                          _vm._v(
                            "\n                                    " +
                              _vm._s(preVacation.countryName) +
                              "\n                                "
                          )
                        ])
                      ]),
                      _vm._v(" "),
                      _c("td", [
                        _c("p", { staticClass: "text-left" }, [
                          _vm._v(
                            "\n                                    " +
                              _vm._s(preVacation.companyName) +
                              " \n                                "
                          )
                        ])
                      ]),
                      _vm._v(" "),
                      _c("td", [
                        _c("p", { staticClass: "text-left" }, [
                          _vm._v(
                            "\n                                    " +
                              _vm._s(preVacation.payrollTypeName) +
                              "\n                                "
                          )
                        ])
                      ]),
                      _vm._v(" "),
                      _c("td", [
                        _vm._v(
                          "\n                                " +
                            _vm._s(preVacation.year) +
                            "\n                            "
                        )
                      ]),
                      _vm._v(" "),
                      _c("td", [
                        _c("p", { staticClass: "text-left" }, [
                          _vm._v(
                            "\n                                    " +
                              _vm._s(preVacation.payrollName) +
                              " \n                                "
                          )
                        ])
                      ]),
                      _vm._v(" "),
                      _c("td", [
                        _vm.loading === false
                          ? _c(
                              "button",
                              {
                                staticClass: "btn btn-sm btn-primary",
                                on: {
                                  click: function($event) {
                                    return _vm.process(
                                      preVacation.hrpayrollControlId
                                    )
                                  }
                                }
                              },
                              [
                                _c("i", { staticClass: "fa fa-edit" }),
                                _vm._v("Calcular")
                              ]
                            )
                          : _c(
                              "button",
                              {
                                staticClass: "btn btn-sm btn-primary",
                                attrs: { disabled: "disabled" }
                              },
                              [
                                _c("i", { staticClass: "fa fa-edit" }),
                                _vm._v("Calcular")
                              ]
                            ),
                        _vm._v(" "),
                        _c(
                          "button",
                          {
                            staticClass: "btn btn-sm btn-info",
                            on: {
                              click: function($event) {
                                return _vm.printPreVacation(
                                  preVacation.year,
                                  preVacation.payrollNumber,
                                  preVacation.payrollTypeId
                                )
                              }
                            }
                          },
                          [
                            _c("i", { staticClass: "fa fa-print" }),
                            _vm._v(" Imprimir")
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "button",
                          {
                            staticClass: "btn btn-sm btn-warning",
                            on: {
                              click: function($event) {
                                return _vm.upgradeVacation(
                                  preVacation.year,
                                  preVacation.payrollNumber,
                                  preVacation.payrollTypeId
                                )
                              }
                            }
                          },
                          [
                            _c("i", { staticClass: "fa fa-edit" }),
                            _vm._v("Actualizar")
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "button",
                          {
                            staticClass: "btn btn-sm btn-danger",
                            on: {
                              click: function($event) {
                                return _vm.deletePreVacation(
                                  preVacation.hrpayrollControlId
                                )
                              }
                            }
                          },
                          [_c("i", { staticClass: "fa fa-times-circle" })]
                        )
                      ])
                    ])
                  }),
                  0
                )
              : _c("tbody", [
                  _c("tr", [
                    this.lengths
                      ? _c("td", { attrs: { colspan: "9" } }, [
                          _vm._v(
                            "\n                                No hay datos registrados\n                            "
                          )
                        ])
                      : _c(
                          "td",
                          { attrs: { colspan: "9" } },
                          [_c("loading")],
                          1
                        )
                  ])
                ])
          ]
        )
      ])
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "form-group col-md-12" }, [
      _c("h4", { staticClass: "text-uppercase" }, [
        _vm._v("Opciones de Filtrado")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", [_vm._v("N.")]),
        _vm._v(" "),
        _c("th", [_vm._v("PAIS")]),
        _vm._v(" "),
        _c("th", [_vm._v("EMPRESA")]),
        _vm._v(" "),
        _c("th", [_vm._v("TIPO DE NOMINA")]),
        _vm._v(" "),
        _c("th", [_vm._v("AÑO")]),
        _vm._v(" "),
        _c("th", [_vm._v("PEROÍDO")]),
        _vm._v(" "),
        _c("th", [_vm._v("Acciones")])
      ])
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-7f36c0ab", module.exports)
  }
}

/***/ }),

<<<<<<< HEAD
/***/ 747:
=======
/***/ 726:
>>>>>>> module-rrhh
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
<<<<<<< HEAD
var __vue_script__ = __webpack_require__(748)
/* template */
var __vue_template__ = __webpack_require__(749)
=======
var __vue_script__ = __webpack_require__(727)
/* template */
var __vue_template__ = __webpack_require__(728)
>>>>>>> module-rrhh
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/components/rrhh/vacations/AddPreVacation.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-4214b340", Component.options)
  } else {
    hotAPI.reload("data-v-4214b340", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

<<<<<<< HEAD
/***/ 748:
=======
/***/ 727:
>>>>>>> module-rrhh
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

// @ is an alias to /src

/* harmony default export */ __webpack_exports__["default"] = ({
    name: 'AddPreVacation',
    components: {},
    data: function data() {
        return {
            selectPayrollNumber: {},
            selectPayrollType: {},
            selectProcessCode: {},
            payrollTypeId: "",
            payrollNumber: 0,
            processCode: 0,
            thereIs: false,
            regData: '',
            year: "",
            years: 0,
            editId: 0,
            nameField1: 'Tipo de nomina',
            nameField2: 'Año',
            nameField3: 'Periodo',
            nameField4: 'Proceso'
        };
    },
    mounted: function mounted() {
        this.getYears();
        this.getPayrollType();
    },

    computed: {
        addSuccess: function addSuccess() {
            return {
                background: '#dff0d8'

            };
        },
        ediPrimary: function ediPrimary() {
            return {
                background: '#d9edf7'

            };
        }
    },
    methods: {
        getYears: function getYears() {
            var year = new Date();
            this.years = year.getFullYear() - 3;
        },
        getPayrollType: function getPayrollType() {
            var _this = this;

            axios.get('payrolltypes/list').then(function (res) {
                res.data.length > 0 ? _this.selectPayrollType = res.data.map(function (item) {
                    return { id: item.payrollTypeId, vText: item.payrollTypeName };
                }) : _this.regData = 'No hay registros para la empresa';
            });
        },
        getPayrollNumber: function getPayrollNumber() {
            var _this2 = this;

            if (this.payrollTypeId !== "" && this.year !== "") {
                axios.get('payrollcontrol/payrollNumber/vacation/' + this.payrollTypeId + '/' + this.year).then(function (res) {
                    console.log(res);
                    if (res.data.length > 0) {
                        payrollNumberId.disabled = false;
                        _this2.selectPayrollNumber = res.data.map(function (item) {
                            return { id: item.payrollNumber, periodId: item.periodId, vText: item.periodName };
                        });
                    } else {
                        alert('No hay registros');
                        payrollNumberId.disabled = true;
                    }
                });
                //obtener proceso
                axios.get('payrollcontrol/process/' + 0 + '/' + 0).then(function (res) {
                    if (res.data.length > 0) {
                        processCodeId.disabled = false;
                        _this2.selectProcessCode = res.data.map(function (item) {
                            return { id: item.processCode, vText: item.processName };
                        });
                        _this2.thereIs = true;
                    } else {
                        _this2.thereIs = false;
                        processCodeId.disabled = true;
                    }
                });
            } else {
                alert('Debe seleccionar tipo de nomina y año');
            }
        },
        newUpForm: function newUpForm() {
            if (this.editId === 0) {
                var data = this.payrollNumber.split('-');
                var payrollNumber = parseInt(data[0]);
                var periodId = parseInt(data[2]);
                var params = {
                    countryId: this.selectCountry,
                    companyId: this.companyId,
                    payrollTypeId: this.payrollTypeId,
                    payrollNumber: payrollNumber,
                    periodId: periodId,
                    year: this.year,
                    payrollName: data[1],
                    processCode: this.processCode
                };
                axios.post('pre-vacations/', params).then(function (response) {
                    if (response.statusText == "OK") {
                        document.querySelector("#newUpForm").reset();
                        alert("Success");
                    } else {
                        alert("Error");
                    }
                }).catch(function (error) {
                    // alert("Faile")
                    console.log(error);
                });
            }
        }
    }
});

/***/ }),

<<<<<<< HEAD
/***/ 749:
=======
/***/ 728:
>>>>>>> module-rrhh
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "container" }, [
    _c("div", { staticClass: "row" }, [
      _c("div", { staticClass: "col-md-6 col-md-offset-3" }, [
        _c("div", { staticClass: "panel panel-default" }, [
          _c("div", { staticClass: "panel-heading", style: _vm.addSuccess }, [
            _c("h4", { staticClass: "text-uppercase" }, [
              _vm._v("Agregar Pre Vacacion")
            ])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "panel-body" }, [
            _c(
              "form",
              {
                staticClass: "form",
                attrs: { role: "form", autocomplete: "off", id: "newUpForm" },
                on: {
                  submit: function($event) {
                    $event.preventDefault()
                    return _vm.newUpForm()
                  }
                }
              },
              [
                _c("div", { staticClass: "row" }, [
                  _c("div", { staticClass: "form-group col-md-6" }, [
                    _c("label", {
                      staticClass: "form-group",
                      attrs: { for: "payrollTypeId" },
                      domProps: { textContent: _vm._s(_vm.nameField1) }
                    }),
                    _vm._v(" "),
                    _c(
                      "select",
                      {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.payrollTypeId,
                            expression: "payrollTypeId"
                          }
                        ],
                        staticClass: "form-control",
                        attrs: {
                          id: "payrollTypeId",
                          autocomplete: "off",
                          required: "required"
                        },
                        on: {
                          change: function($event) {
                            var $$selectedVal = Array.prototype.filter
                              .call($event.target.options, function(o) {
                                return o.selected
                              })
                              .map(function(o) {
                                var val = "_value" in o ? o._value : o.value
                                return val
                              })
                            _vm.payrollTypeId = $event.target.multiple
                              ? $$selectedVal
                              : $$selectedVal[0]
                          }
                        }
                      },
                      [
                        _c("option", { attrs: { value: "" } }, [
                          _vm._v(_vm._s(_vm.regData))
                        ]),
                        _vm._v(" "),
                        _vm._l(_vm.selectPayrollType, function(item) {
                          return _c(
                            "option",
                            { key: item.id, domProps: { value: item.id } },
                            [_vm._v(_vm._s(item.vText))]
                          )
                        })
                      ],
                      2
                    )
                  ])
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "row" }, [
                  _c(
                    "div",
                    { staticClass: "form-group col-md-8 form-inline" },
                    [
                      _c("label", {
                        staticClass: "form-group",
                        attrs: { for: "year" },
                        domProps: { textContent: _vm._s(_vm.nameField2) }
                      }),
                      _vm._v(" "),
                      _c("div", { staticClass: "form-inline" }, [
                        _vm.editId === 0
                          ? _c(
                              "select",
                              {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: _vm.year,
                                    expression: "year"
                                  }
                                ],
                                staticClass: "form-control",
                                attrs: {
                                  id: "year",
                                  autocomplete: "off",
                                  required: "required"
                                },
                                on: {
                                  change: function($event) {
                                    var $$selectedVal = Array.prototype.filter
                                      .call($event.target.options, function(o) {
                                        return o.selected
                                      })
                                      .map(function(o) {
                                        var val =
                                          "_value" in o ? o._value : o.value
                                        return val
                                      })
                                    _vm.year = $event.target.multiple
                                      ? $$selectedVal
                                      : $$selectedVal[0]
                                  }
                                }
                              },
                              [
                                _c("option", { attrs: { value: "" } }),
                                _vm._v(" "),
                                _vm._l(5, function(n) {
                                  return _c(
                                    "option",
                                    {
                                      key: n,
                                      domProps: { value: n + _vm.years }
                                    },
                                    [_vm._v(_vm._s(n + _vm.years))]
                                  )
                                })
                              ],
                              2
                            )
                          : _vm._e()
                      ])
                    ]
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "row" }, [
                  _c("div", { staticClass: "form-group col-md-6" }, [
                    _c("label", {
                      staticClass: "form-group",
                      attrs: { for: "payrollNumber" },
                      domProps: { textContent: _vm._s(_vm.nameField3) }
                    }),
                    _vm._v(" "),
                    _vm.editId === 0
                      ? _c(
                          "button",
                          {
                            staticClass: "btn btn-sm btn-success",
                            attrs: {
                              type: "button",
                              title: "Obtener periodo",
                              "data-original-title": "Obtener periodo"
                            },
                            on: {
                              click: function($event) {
                                return _vm.getPayrollNumber()
                              }
                            }
                          },
                          [
                            _c("i", {
                              staticClass: "glyphicon glyphicon-search"
                            })
                          ]
                        )
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.editId === 0
                      ? _c(
                          "select",
                          {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.payrollNumber,
                                expression: "payrollNumber"
                              }
                            ],
                            staticClass: "form-control",
                            attrs: {
                              id: "payrollNumberId",
                              autocomplete: "off",
                              disabled: "disabled",
                              required: "required"
                            },
                            on: {
                              change: function($event) {
                                var $$selectedVal = Array.prototype.filter
                                  .call($event.target.options, function(o) {
                                    return o.selected
                                  })
                                  .map(function(o) {
                                    var val = "_value" in o ? o._value : o.value
                                    return val
                                  })
                                _vm.payrollNumber = $event.target.multiple
                                  ? $$selectedVal
                                  : $$selectedVal[0]
                              }
                            }
                          },
                          [
                            _c("option", { attrs: { value: "" } }),
                            _vm._v(" "),
                            _vm._l(_vm.selectPayrollNumber, function(item) {
                              return _c(
                                "option",
                                {
                                  key: item.id,
                                  domProps: {
                                    value:
                                      item.id +
                                      "-" +
                                      item.vText +
                                      "-" +
                                      item.periodId
                                  }
                                },
                                [_vm._v(_vm._s(item.vText))]
                              )
                            })
                          ],
                          2
                        )
                      : _vm._e()
                  ])
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "row" }, [
                  _c("div", { staticClass: "form-group col-md-6" }, [
                    _c("label", {
                      staticClass: "form-group",
                      attrs: { for: "processCode" },
                      domProps: { textContent: _vm._s(_vm.nameField4) }
                    }),
                    _vm._v(" "),
                    _vm.editId === 0
                      ? _c(
                          "select",
                          {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.processCode,
                                expression: "processCode"
                              }
                            ],
                            staticClass: "form-control",
                            attrs: {
                              id: "processCodeId",
                              autocomplete: "off",
                              disabled: "disabled",
                              required: "required"
                            },
                            on: {
                              change: function($event) {
                                var $$selectedVal = Array.prototype.filter
                                  .call($event.target.options, function(o) {
                                    return o.selected
                                  })
                                  .map(function(o) {
                                    var val = "_value" in o ? o._value : o.value
                                    return val
                                  })
                                _vm.processCode = $event.target.multiple
                                  ? $$selectedVal
                                  : $$selectedVal[0]
                              }
                            }
                          },
                          _vm._l(_vm.selectProcessCode, function(item) {
                            return _c(
                              "option",
                              { key: item.id, domProps: { value: item.id } },
                              [_vm._v(_vm._s(item.vText))]
                            )
                          }),
                          0
                        )
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.thereIs === false
                      ? _c("span", [
                          _vm._v(" No hay procesos para esta empresa")
                        ])
                      : _vm._e()
                  ])
                ]),
                _vm._v(" "),
                _vm.editId === 0 ? _c("div", [_vm._m(0)]) : _vm._e()
              ]
            )
          ])
        ])
      ])
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "div",
      { staticClass: "form-group col-ms-12 col-md-12 col-lg-12 text-center" },
      [
        _c(
          "button",
          { staticClass: "btn btn-success", attrs: { type: "submit" } },
          [_c("span", { staticClass: "fa fa-check" }), _vm._v(" Guardar")]
        )
      ]
    )
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-4214b340", module.exports)
  }
}

/***/ }),

<<<<<<< HEAD
/***/ 750:
=======
/***/ 729:
>>>>>>> module-rrhh
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
<<<<<<< HEAD
var __vue_script__ = __webpack_require__(751)
/* template */
var __vue_template__ = __webpack_require__(752)
=======
var __vue_script__ = __webpack_require__(730)
/* template */
var __vue_template__ = __webpack_require__(731)
>>>>>>> module-rrhh
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/components/rrhh/vacations/ListVacation.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-8c602448", Component.options)
  } else {
    hotAPI.reload("data-v-8c602448", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

<<<<<<< HEAD
/***/ 751:
=======
/***/ 730:
>>>>>>> module-rrhh
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    name: 'ListVacation',
    components: {},
    data: function data() {
        var _ref;

        return _ref = {
            objVacation: {},
            lengths: false
        }, _defineProperty(_ref, 'lengths', false), _defineProperty(_ref, 'fromDate', ''), _defineProperty(_ref, 'toDate', ''), _defineProperty(_ref, 'startVacation', ''), _defineProperty(_ref, 'endVacation', ''), _defineProperty(_ref, 'currency', 1), _defineProperty(_ref, 'selectStaff', ''), _defineProperty(_ref, 'objSelectStaffs', {}), _ref;
    },
    mounted: function mounted() {
        this.getListVacation();
        this.getComboEmployees();
    },

    computed: {},
    methods: {
        getListVacation: function getListVacation() {
            var _this = this;

            axios.get('vacations/list').then(function (res) {
                // console.log(res)
                // return
                res.data.payrollHistory.length > 0 ? _this.lengths = false : _this.lengths = true;
                _this.objVacation = res.data.payrollHistory;
                console.log(_this.objVacation);
            });
        },
        getComboEmployees: function getComboEmployees() {
            var _this2 = this;

            var URL1 = 'combo-staff/' + 0 + '/' + 0;
            // obtiene el personal 
            axios.get(URL1).then(function (res) {
                _this2.objSelectStaffs = res.data;
                // console.log(this.objSelectStaffs)
            });
        },
        printVacationByEmployee: function printVacationByEmployee() {
            var _this3 = this;

            // obtengo el periodo
            var URL2 = 'get-payroll-number-vacation/' + this.fromDate + '/' + this.toDate;

            axios.get(URL2).then(function (res) {
                // console.log(res)
                // return
                if (res.status === 204) {
                    alert('sin contenido para este periodo');
                    return;
                }

                var year = res.data.year;
                var payrollNumber = res.data.payrollNumber;
                var payrollTypeId = res.data.payrollTypeId;
                var payrollCategory = res.data.payrollCategory;
                var selecCurrency1 = _this3.currency;

                var URL = 'vacations-employees/print/' + year + '/' + payrollNumber + '/' + payrollTypeId + '/' + payrollCategory + '/' + _this3.selectStaff;

                axios.get(URL).then(function (res) {
                    console.log(res);
                    if (res.status === 204) {
                        alert('sin contenido para este periodo');
                        return;
                    }

                    var objPrePayrollDetail = res.data.print;
                    // return
                    var period = objPrePayrollDetail[0];
                    var country = objPrePayrollDetail[1];
                    var company = objPrePayrollDetail[2];
                    var logo = objPrePayrollDetail[3];
                    var payrollTypeName = objPrePayrollDetail[4];
                    var companyAddress = objPrePayrollDetail[7];
                    var companyNumber = objPrePayrollDetail[8];
                    var companyId = objPrePayrollDetail[9];
                    var color = objPrePayrollDetail[10];
                    var userProcess = objPrePayrollDetail[13];
                    var employeeName = objPrePayrollDetail[14][0].staffName;
                    var employmentDate = objPrePayrollDetail[14][0].employmentDate;
                    var employeePosition = objPrePayrollDetail[14][0].positionName;
                    var employeeID = objPrePayrollDetail[14][0].idDocument;
                    var startVacation = _this3.formatDate2(_this3.startVacation);
                    var endVacation = _this3.formatDate2(_this3.endVacation);
                    var icoMap = 'data:image/png;base64,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';
                    var icoPhone = 'data:image/png;base64,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';
                    var icoGlobe = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAzCAYAAADVY1sUAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAL7SURBVHgB7VqLcdswDH3JdQB1AnODaAR1g25QdgNvEHcCuxM4nSDdQO4ETieQO4HTCVLBthoEESVApBKdz+8Od7QNgHgU+BFoYDzktZS17Gt5quW+FoeJIqvltpYv4nv63BCQInX9yYfDO6DAcbQpsApHQg1ytBPgUjD97OSDvl/jjQhlp854UB7tQXWJJO/F76MSakuXSujcop9EIwthW7X49kiMZSAYz3Qc9CRIaFD4U1kE9JZIAOqo7AjGMd05bETkU8kQXiC2eEnaTGLbEcRPoV/BTmQvfHQN2mAy254gPNMtYCfRSMH8+B7dLYxYKgJwTH+t0A/JivnJFPrqOeMVzuTIVAobbXr1ZQLJHD1wyqBWwuYpUmbM30pJ3vHAr1/yUB8VNqxdIB6fWPtBoU8pGEwxB/0I5sxOM4JjPeGihYd6wlqWTK3IObdX2pWNwQdm/OskfXgUn7/X8gNxkD6/ImIDvGAKuMJxcnmDDR1NmpWFJv1npEGM38NiQQaWick7GHJQDAnf5LzR1tM+UsAGPjFTTkjuawcbciJyg+FISWTG2o+wwRERBxsq1h5ribQSuRlCZIrIrnEeOBsih9OvNR8niXMhsiMimvM/x0eMg7+sbV0ND0T+wIaYjasLMRvt7yFPxKG981jEEHmg9xE6rDmLEWtvavmGNNiw9s7od4MLJoYr1vbQgXKZl0vpWB975orxeSe/oBf5IcUHTUFNXUQ4QVt8kPXnAwpDxzNml7oclBvs/pel+FlrE2LYAmtBrQ/ch4MOd+jo20H3WFOXTHPmb1DJtA2a9/CURexK+CoVNnMooRmVzKgfkjXzo7lWWMGIs7joIfRdvZVCX7tkdqXVfQ+J0e4RNbeyXcKvBtxYJDhCc2DBdLpuZUPimL1HojnRB4/Xq5Pc5RfQk5ABtvlWr05WOBw3otCkt/yFwzE7L35/s38SOTwToqB4/hboJ5ILfw35Emmu8sxwOKaITAGPMAnforvAhC92HJ6XU8p3Gu0cF3TjH2L2H0VgekrQAAAAAElFTkSuQmCC';
                    var icoMail = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAmCAYAAACGeMg8AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAG6SURBVHgB7VnbcYMwEFwnDVCCPvPpEijBHYQO4s/84Q5MB6YDpwPSgd0BdIA7IJyRJhiONzIS4505PDDotCstOpCBf/h5xHlklsQlDw8VnA0l2yeIO96lqm/Yi488NhsUU7SF3UhISIYV4A0rwaqE/MJ+XOkgYFf94OqJUIqcPALDCXMRSu417A0k2xR7dEDAbKsRN7bunVHyWElMCCxOuhrEtWqlrbzeOlWmWC1t4PdVuuehwYlRLLCs1WLUreRIrlmTENVQMA2XWNUC8FaKmXsbk/iow0MxzboFpGC+NfBopd5ClNVEJZmAXqtdwDsi6mjXmZhIu6jjoEFEwPTjot/A9e7En9DJ2ME6DsgxedrpfMqncgR+pYwG5hk1eh7qOIzIxdWGHcYtKKNH8oj+S2MfKzkYZqXZhChCokKIzsOWNifoKbqTGlM0vT64KJ6dVEYE/oH+xDy1aXKCNqu1YaqVtAlRVvPQDRfzF9VZk6mIpKDyDDnyWqSjz2fsayXyV0AjXht0puElxDSQkBvsx42EXGE/fuhAL3rP+HzVFcRdKEUu7Nz/TSX3ex0pYwd7/r1KUFjq/oz/Ad4q72Jw+8N+AAAAAElFTkSuQmCC';
                    var dataTime = _this3.formatDate();
                    var colorPri1 = void 0;
                    var colorPri2 = void 0;
                    var colorPri3 = void 0;
                    var colorSec1 = void 0;
                    var colorSec2 = void 0;
                    var colorSec3 = void 0;

                    employmentDate = _this3.formatDate2(employmentDate);

                    // chequear si el total general es el local o moneda extrangera
                    var totalAsignacion = void 0;
                    var totalDeduccion = void 0;
                    if (selecCurrency1 == 1) {
                        totalAsignacion = objPrePayrollDetail[5];
                        totalDeduccion = objPrePayrollDetail[6];
                    } else {
                        totalAsignacion = objPrePayrollDetail[11];
                        totalDeduccion = objPrePayrollDetail[12];
                    }
                    // plantilla de colores
                    switch (color) {
                        case 'YELLOW':
                            colorPri1 = 230;
                            colorPri2 = 219;
                            colorPri3 = 153;
                            colorSec1 = 242;
                            colorSec2 = 237;
                            colorSec3 = 209;
                            break;
                        case 'BLUE':
                            colorPri1 = 113;
                            colorPri2 = 160;
                            colorPri3 = 228;
                            colorSec1 = 160;
                            colorSec2 = 229;
                            colorSec3 = 251;
                            break;

                        default:
                            colorPri1 = 255;
                            colorPri2 = 255;
                            colorPri3 = 255;
                            colorSec1 = 255;
                            colorSec2 = 255;
                            colorSec3 = 255;
                            break;
                    }
                    // white

                    // funcion para centrado de texto en company
                    function centerText(text) {
                        var numCenter = 220;
                        // console.log(text)
                        // si es jdrivero CA o jd rivero INC
                        if (text.length < 20) {

                            // console.log('entro: ' + numCenter)
                            numCenter = numCenter + 30;
                            return numCenter;
                        } else {
                            // si es rivero visual group o otras con nombres largos
                            return numCenter;
                        }
                    }

                    var imgLogoURL = window.location.origin + '/' + logo;

                    // funcion para combertir imagen a Base64 a partir de la url de la imagen
                    function toDataUrl(src, callback) {
                        var xhttp = new XMLHttpRequest();
                        xhttp.onload = function () {
                            var fileReader = new FileReader();
                            fileReader.onloadend = function () {
                                callback(fileReader.result);
                            };
                            fileReader.readAsDataURL(xhttp.response);
                        };
                        xhttp.responseType = 'blob';
                        xhttp.open('GET', src, true);
                        xhttp.send();
                        // console.log(xhttp)
                    }

                    // funcion para crear pdf
                    function crearPDF(imgData) {

                        var doc = new jsPDF('p', 'pt', 'letter');

                        // determino la cantidad de paginas en el documento
                        var numPage = 1;
                        // let cont = 155
                        // for (let i = 0; i < objPrePayrollDetail.length; i++) {
                        // const element = objPrePayrollDetail;
                        // // condiciono que comienze a leer los datos a partir de la posicion 11 del array
                        //     if (i > 13) {
                        //         let name = true
                        //         element[i].forEach(element2 => { 
                        //             // doc.text( 'text test11', 220, cont ); //######### only test
                        //             cont += 15 //18 es el tamaño aproximado de separacion entre lineas de palabras
                        //             if (cont > 720) { //720 es el tamaño establecido de contenido dento de la hoja letter
                        //                 numPage = numPage + 1
                        //                 // doc.addPage(); //######### only test
                        //                 cont = 155 // 155 es el espacion definido para la cabecera
                        //             }
                        //             // doc.text( 'text test2', 220, cont ); //######### only test

                        //         });
                        //         cont += 20
                        //     }
                        // }

                        // doc.text( 'izquierda?.', eje X, eje Y );
                        //  console.log(colorPri1,colorPri2,colorPri3)
                        //  Encabezado
                        doc.setDrawColor(0);
                        doc.setFillColor(colorPri1, colorPri2, colorPri3); // color de los rectangulos
                        doc.rect(30, 25, 550, 20, 'F');
                        doc.addImage(imgData, 'JPEG', 35, 50, 85, 60);
                        doc.setFont("helvetica");
                        doc.setFontType("bold");
                        doc.setFontSize(14);
                        doc.text('VACACIONES', 260, 40);
                        // doc.setFontType("courier");

                        doc.setFontType("bold");
                        doc.text(company, centerText(company), 70);
                        // doc.setFontType("courier");

                        doc.setFontSize(8.5);
                        doc.text('Rif: ' + companyNumber, 265, 80);
                        doc.setFontType("normal");
                        // console.log('conpany: ' + company)
                        if (companyId == 4) {
                            doc.addImage(icoPhone, 'JPEG', 260, 92, 9, 9);
                            doc.addImage(icoGlobe, 'JPEG', 304, 103, 9, 9);
                            doc.addImage(icoMail, 'JPEG', 179, 103, 9, 8);
                            doc.text('+58 (247) 342-9544', 270, 100);
                            doc.text('info@riverovisualgroup.com', 190, 110);
                            doc.text('www.riverovisualgroup.com', 315, 110);
                            // pie de pagina
                            doc.setFontSize(7.5);
                            doc.setFontType("italic");
                            var _dataTime = new Date();
                            var yearYYYY = _dataTime.getFullYear();
                            doc.text('\xA9 Copyright ' + yearYYYY + ' Rivero Visual Group - All rights reserved ', 210, 760);
                            doc.setFontType("normal");
                        }
                        if (companyId == 5) {
                            doc.addImage(icoPhone, 'JPEG', 260, 92, 9, 9);
                            doc.addImage(icoGlobe, 'JPEG', 304, 103, 9, 9);
                            doc.addImage(icoMail, 'JPEG', 219, 103, 9, 7);
                            doc.text('+58 (247) 342-9544', 270, 100);
                            doc.text('info@jdrivero.com       www.jdrivero.com', 230, 110);
                            // pie de pagina
                            doc.setFontType("italic");
                            doc.setFontSize(7.5);
                            var _dataTime2 = new Date();
                            var _yearYYYY = _dataTime2.getFullYear();
                            doc.text('\xA9 Copyright ' + _yearYYYY + ' JD Rivero Global - All rights reserved ', 215, 760);
                            doc.setFontType("normal");
                        }
                        doc.addImage(icoMap, 'JPEG', 181, 82, 11, 9);
                        doc.text(companyAddress, 195, 90);
                        // pie de pagina
                        doc.setFontSize(7.5);
                        doc.text('Pagina:', 515, 760);
                        doc.text('1/1', 545, 760);
                        // doc.text( `1/${numPage}`, 545, 760 );
                        doc.setFontType("italic");
                        doc.text('Designed By Rivero Visual Group', 250, 775);
                        doc.setFontType("normal");

                        doc.setFontSize(7.5);
                        doc.setFontType("bold");
                        // doc.setFontSize(12);
                        doc.text('Fecha: ', 435, 80);
                        doc.text('Periodo: ', 435, 90);
                        doc.text('Tipo De Nomina:', 435, 100);
                        doc.text('Pais:', 435, 110);
                        doc.text('Generado Por:', 435, 70);
                        doc.text('Pagina:', 435, 60);
                        doc.setFontType("normal");
                        doc.text('1/1', 465, 60);
                        // doc.text( `1/${numPage}`, 465, 60 );
                        doc.text(userProcess, 489, 70);
                        doc.text(dataTime, 462, 80);
                        doc.text(period, 468, 90);
                        doc.text(payrollTypeName, 500, 100);
                        doc.text(country, 455, 110);

                        doc.setFontSize(12);
                        doc.setFontType("normal");

                        // // titulos tablas
                        doc.setDrawColor(0);
                        doc.setFillColor(colorSec1, colorSec2, colorSec3);
                        doc.rect(30, 117, 550, 20, 'F');
                        // doc.line(30, 115, 580, 115);
                        doc.setFontSize(8);
                        doc.setFontType("bold");
                        doc.text('CODIGO', 30, 130);
                        doc.text('CONCEPTO', 76, 130);
                        doc.text(' ', 195, 130);
                        doc.text('CANTIDAD', 315, 130);
                        doc.text('ASIGNACION', 385, 130);
                        doc.text('DEDUCCION', 453, 130);
                        doc.text('NETO', 545, 130);
                        // doc.line(30, 138, 580, 138);
                        doc.setFontSize(7.5);
                        doc.setFontType("normal");
                        var n = 155;
                        var nRectangulo = 2;
                        var nunIniRectangulo = 145;
                        var page = 1;

                        function formatNumber(number) {
                            var currencyCurrent = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;

                            number = parseFloat(number);
                            number = number.toFixed(2);
                            if (currencyCurrent) {
                                var montoNuevo = number.toString().replace(/\D/g, "").replace(/([0-9])([0-9]{2})$/, '$1.$2').replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
                                return '$' + montoNuevo;
                            } else {
                                var _montoNuevo = number.toString().replace(/\D/g, "").replace(/([0-9])([0-9]{2})$/, '$1,$2').replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
                                return 'Bs' + _montoNuevo;
                            }

                            // let num = parseFloat(number).toFixed(2);
                            // return num
                        }

                        for (var i = 0; i < objPrePayrollDetail.length; i++) {
                            var element = objPrePayrollDetail;
                            //  console.log( element[i]) 
                            //  console.log('numero de pagina3: ' + numPage) 

                            // condiciono que comienze a leer los datos a partir de la posicion 11 del array
                            if (i > 13) {
                                (function () {

                                    var name = true;

                                    element[i].forEach(function (element2) {
                                        // console.log('Numero pagina2: ' + numPage)
                                        // indica si imprime linea amarilla
                                        if (nRectangulo % 2 == 0) {
                                            doc.setDrawColor(0);
                                            doc.setFillColor(colorSec1, colorSec2, colorSec3);
                                            doc.rect(30, nunIniRectangulo, 550, 15, 'F');
                                        }

                                        if (name) {
                                            doc.line(30, n - 10, 580, n - 10); //horizontal line
                                            doc.setFontType("bold");
                                            // doc.line(30, n - 10, 580, n - 10);
                                            // doc.text(`n es: ${n}`, 150, n);
                                            doc.text(element2.staffCode, 30, n);
                                            name = false;
                                            doc.setFontType("normal");
                                        }
                                        doc.line(213, n - 10, 213, n + 5); // vertical line
                                        doc.line(309, n - 10, 309, n + 5); // vertical line
                                        doc.line(365, n - 10, 365, n + 5); // vertical line
                                        doc.line(448, n - 10, 448, n + 5); // vertical line
                                        doc.line(510, n - 10, 510, n + 5); // vertical line
                                        doc.text(element2.transactionTypeName, 76, n);
                                        doc.text(element2.comment, 218, n);
                                        doc.text(element2.quantity, 361, n, 'right');
                                        // validacion de moneda
                                        var amount = element2.amount;
                                        if (selecCurrency1 === false) {
                                            amount = element2.localAmount;
                                        }
                                        if (element2.isIncome == 1) {
                                            if (amount == null) {
                                                //  console.log('entro')
                                                // doc.text('0', 436, n, 'right' );
                                            } else {
                                                doc.text(formatNumber(amount, selecCurrency1), 445, n, 'right');
                                            }
                                        }
                                        if (element2.isIncome == 0) {
                                            if (amount == null) {
                                                // console.log('entro')
                                                // doc.text('0', 502, n, 'right' );
                                            } else {
                                                doc.text(formatNumber(amount, selecCurrency1), 508, n, 'right');
                                            }

                                            // doc.text( '2.07', 502, 155, 'right' );
                                        }
                                        // doc.text(element2.staffCode);
                                        n += 15;

                                        nunIniRectangulo += 15;
                                        nRectangulo += 1;
                                        if (n > 720) {
                                            page += 1;
                                            doc.addPage();

                                            //  Encabezado
                                            doc.setDrawColor(0);
                                            doc.setFillColor(colorPri1, colorPri2, colorPri3); // color de los rectangulos
                                            doc.rect(30, 25, 550, 20, 'F');
                                            doc.addImage(imgData, 'JPEG', 35, 50, 95, 60);
                                            doc.setFont("helvetica");
                                            doc.setFontType("bold");
                                            doc.setFontSize(14);
                                            doc.text('VACACIONES', 260, 40);
                                            // doc.setFontType("courier");


                                            // doc.text( 'PAIS:', 30, 74 );
                                            // doc.text( country, 63, 74 );
                                            // doc.text( 'EMPRESA:', 30, 84 );
                                            doc.setFontType("bold");
                                            doc.text(company, centerText(company), 70);
                                            // doc.setFontType("courier");

                                            doc.setFontSize(8.5);
                                            doc.text('Rif: ' + companyNumber, 265, 80);
                                            doc.setFontType("normal");
                                            // console.log('conpany: ' + company)
                                            if (companyId == 4) {
                                                doc.addImage(icoPhone, 'JPEG', 260, 92, 9, 9);
                                                doc.addImage(icoGlobe, 'JPEG', 304, 103, 9, 9);
                                                doc.addImage(icoMail, 'JPEG', 179, 103, 9, 8);
                                                doc.text('+58 (247) 342-9544', 270, 100);
                                                doc.text('info@riverovisualgroup.com', 190, 110);
                                                doc.text('www.riverovisualgroup.com', 315, 110);
                                                // pie de pagina
                                                doc.setFontSize(7.5);
                                                doc.setFontType("italic");
                                                var _dataTime3 = new Date();
                                                var _yearYYYY2 = _dataTime3.getFullYear();
                                                doc.text('\xA9 Copyright ' + _yearYYYY2 + ' Rivero Visual Group - All rights reserved ', 210, 760);
                                                doc.setFontType("normal");
                                            }
                                            if (companyId == 5) {
                                                doc.addImage(icoPhone, 'JPEG', 260, 92, 9, 9);
                                                doc.addImage(icoGlobe, 'JPEG', 304, 103, 9, 9);
                                                doc.addImage(icoMail, 'JPEG', 219, 103, 9, 7);
                                                doc.text('+58 (247) 342-9544', 270, 100);
                                                doc.text('info@jdrivero.com       www.jdrivero.com', 230, 110);
                                                // pie de pagina
                                                doc.setFontType("italic");
                                                doc.setFontSize(7.5);
                                                var _dataTime4 = new Date();
                                                var _yearYYYY3 = _dataTime4.getFullYear();
                                                doc.text('\xA9 Copyright ' + _yearYYYY3 + ' JD Rivero Global - All rights reserved ', 215, 760);
                                                doc.setFontType("normal");
                                            }
                                            doc.addImage(icoMap, 'JPEG', 181, 82, 11, 9);
                                            doc.text(companyAddress, 195, 90);
                                            // pie de pagina
                                            doc.setFontSize(7.5);
                                            doc.text('Pagina:', 515, 760);
                                            doc.text(page + '/' + numPage, 545, 760);
                                            doc.setFontType("italic");
                                            doc.text('Designed By Rivero Visual Group', 250, 775);
                                            doc.setFontType("normal");

                                            doc.setFontSize(7.5);
                                            doc.setFontType("bold");
                                            // doc.setFontSize(12);
                                            doc.text('Fecha: ', 435, 80);
                                            doc.text('Periodo: ', 435, 90);
                                            doc.text('Tipo De Nomina:', 435, 100);
                                            doc.text('Pais:', 435, 110);
                                            doc.text('Generado Por:', 435, 70);
                                            doc.text('Pagina:', 435, 60);
                                            doc.setFontType("normal");
                                            doc.text(page + '/' + numPage, 465, 60);
                                            doc.text(userProcess, 489, 70);
                                            doc.text(dataTime, 462, 80);
                                            doc.text(period, 468, 90);
                                            doc.text(payrollTypeName, 500, 100);
                                            doc.text(country, 455, 110);
                                            doc.setFontSize(12);
                                            doc.setFontType("normal");

                                            // // titulos tablas
                                            doc.setDrawColor(0);
                                            doc.setFillColor(colorSec1, colorSec2, colorSec3);
                                            doc.rect(30, 117, 550, 20, 'F');
                                            // doc.line(30, 115, 580, 115);
                                            doc.setFontSize(8);
                                            doc.setFontType("bold");
                                            doc.text('CODIGO', 30, 130);
                                            doc.text('NOMBRE', 76, 130);
                                            doc.text('CONCEPTO', 195, 130);
                                            doc.text('CANTIDAD', 315, 130);
                                            doc.text('ASIGNACION', 385, 130);
                                            doc.text('DEDUCCION', 453, 130);
                                            doc.text('NETO', 545, 130);
                                            // doc.line(30, 138, 580, 138);

                                            doc.setFontSize(7.5);
                                            doc.setFontType("normal");

                                            n = 155;
                                            nunIniRectangulo = 145;
                                            // nRectangulo = 2
                                        }
                                    });
                                    // indica si imprime linea amarilla
                                    if (nRectangulo % 2 == 0) {
                                        doc.setDrawColor(0);
                                        doc.setFillColor(colorSec1, colorSec2, colorSec3);
                                        doc.rect(30, nunIniRectangulo, 550, 15, 'F');
                                    }
                                    doc.setFontSize(7.5);
                                    // doc.line(193, n-10, 193, n+5); // vertical line
                                    // doc.line(309, n-10, 309, n+5); // vertical line
                                    doc.line(365, n - 10, 365, n + 5); // vertical line
                                    doc.line(448, n - 10, 448, n + 5); // vertical line
                                    doc.line(510, n - 10, 510, n + 5); // vertical line
                                    doc.setFontType("bold");
                                    doc.text('TOTALES', 215, n);

                                    // asignacion para los montos
                                    var asignacion = void 0;
                                    var deduccion = void 0;
                                    if (selecCurrency1 === false) {
                                        asignacion = element[i][0].asignacionLocal;
                                        deduccion = element[i][0].deduccionLocal;
                                    } else {
                                        asignacion = element[i][0].asignacion;
                                        deduccion = element[i][0].deduccion;
                                    }

                                    if (asignacion === null) {
                                        asignacion = 0;
                                        // doc.text(`${asignacion}`, 436, n, 'right' );
                                    } else {
                                        doc.text('' + formatNumber(asignacion, selecCurrency1), 445, n, 'right');
                                    }
                                    if (deduccion === null) {
                                        deduccion = 0;
                                        // doc.text(`${deduccion}`, 502, n, 'right' );
                                    } else {
                                        doc.text('' + formatNumber(deduccion, selecCurrency1), 508, n, 'right');
                                    }

                                    var total = asignacion - deduccion; // calculo para el total
                                    // console.log('total: ');
                                    // console.log(total);
                                    if (total < 0) {
                                        doc.text('( ' + formatNumber(total, selecCurrency1) + ' )', 578, n, 'right');
                                    } else {
                                        doc.text('' + formatNumber(total, selecCurrency1), 578, n, 'right');
                                    }
                                    // doc.text(total, 574, n, 'right' );

                                    doc.setFontType("normal");
                                    n += 20;
                                    nunIniRectangulo += 20;
                                    nRectangulo += 1;
                                })();
                            }

                            // return
                        }
                        doc.setFontType("bold");

                        totalAsignacion;
                        totalDeduccion;
                        var totalNeto = totalAsignacion - totalDeduccion;
                        n = n + 5;
                        doc.text('TOTAL GENERAL:', 215, n);
                        doc.text(' ' + formatNumber(totalAsignacion, selecCurrency1), 445, n, 'right');
                        doc.text(' ' + formatNumber(totalDeduccion, selecCurrency1), 508, n, 'right');
                        doc.text(' ' + formatNumber(totalNeto, selecCurrency1), 578, n, 'right');

                        // datos personales de empleados
                        doc.setFontType("bold");
                        doc.text('Empleado:', 30, n + 30);
                        doc.text('Cedula:', 30, n + 40);
                        doc.text('Cargo:', 30, n + 50);
                        doc.text('Fecha de ingreso:', 30, n + 60);
                        doc.text('Fecha salida vacaiones:', 30, n + 70);
                        doc.text('Fecha retorno vacaciones:', 30, n + 80);
                        doc.setFontType("normal");
                        doc.text(employeeName, 76, n + 30);
                        doc.text(employeeID, 65, n + 40);
                        doc.text(employeePosition, 65, n + 50);
                        doc.text(employmentDate, 100, n + 60);
                        doc.text(startVacation, 124, n + 70);
                        doc.text(endVacation, 130, n + 80);

                        doc.text('Con el pago de estos montos la empresa cancela todo lo relacionado con vacaciones del per\xEDodo que se menciona en este mismo recibo y por tal raz\xF3n nada', 30, n + 100);
                        doc.text('tendr\xE9 que reclamar a futuro por este concepto.', 30, n + 110);
                        doc.text('_________________________________________', 215, n + 190);
                        doc.text('FIRMA EMPLEADO', 270, n + 205);

                        doc.save(company + '-' + period + '.pdf');
                        // console.log(res.data.print)
                        // this.$emit("prePayrollDetail", objPrePayrollDetail)
                    }

                    // llamo la funcion para combertir imagen a base64 y le paso por parametro la variable ' imgLogoURL' con la URL
                    toDataUrl(imgLogoURL, function (dataURL) {
                        function closeFrame() {}
                        // como callback llamo una funcion para crear el pdf y le para por varible 'dataURL' la imagen convertida en base64
                        crearPDF(dataURL);
                    });
                });
            });
        },
        formatDate: function formatDate() {
            function formatZero(n) {
                if (n < 10) {
                    n = '0' + n;
                    return n;
                } else {
                    return n;
                }
            }
            var dataTime = new Date();
            var dd = dataTime.getDate();
            var mm = dataTime.getMonth() + 1;
            var yyyy = dataTime.getFullYear();
            dd = formatZero(dd);
            mm = formatZero(mm);
            return dd + '/' + mm + '/' + yyyy;
        },
        formatDate2: function formatDate2(date) {
            function formatZero(n) {
                if (n < 10) {
                    n = '0' + n;
                    return n;
                } else {
                    return n;
                }
            }
            var dataTime = new Date(date);
            var dd = dataTime.getDate();
            var mm = dataTime.getMonth() + 1;
            var yyyy = dataTime.getFullYear();
            dd = formatZero(dd);
            mm = formatZero(mm);
            return dd + '/' + mm + '/' + yyyy;
        },
        printVacation: function printVacation(year, payrollNumber, payrollTypeId) {
            var _this4 = this;

            var URL = 'vacations/print/' + year + '/' + payrollNumber + '/' + payrollTypeId + '/vacation';
            var selecCurrency1 = this.currency;

            axios.get(URL).then(function (res) {
                // console.log(res)
                // return
                if (res.status === 204) {
                    return alert('Sin contenido');
                }
                var objPrePayrollDetail = res.data.print;
                // return
                var period = objPrePayrollDetail[0];
                var country = objPrePayrollDetail[1];
                var company = objPrePayrollDetail[2];
                var logo = objPrePayrollDetail[3];
                var payrollTypeName = objPrePayrollDetail[4];
                var companyAddress = objPrePayrollDetail[7];
                var companyNumber = objPrePayrollDetail[8];
                var companyId = objPrePayrollDetail[9];
                var color = objPrePayrollDetail[10];
                var userProcess = objPrePayrollDetail[13];
                var icoMap = 'data:image/png;base64,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';
                var icoPhone = 'data:image/png;base64,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';
                var icoGlobe = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAzCAYAAADVY1sUAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAL7SURBVHgB7VqLcdswDH3JdQB1AnODaAR1g25QdgNvEHcCuxM4nSDdQO4ETieQO4HTCVLBthoEESVApBKdz+8Od7QNgHgU+BFoYDzktZS17Gt5quW+FoeJIqvltpYv4nv63BCQInX9yYfDO6DAcbQpsApHQg1ytBPgUjD97OSDvl/jjQhlp854UB7tQXWJJO/F76MSakuXSujcop9EIwthW7X49kiMZSAYz3Qc9CRIaFD4U1kE9JZIAOqo7AjGMd05bETkU8kQXiC2eEnaTGLbEcRPoV/BTmQvfHQN2mAy254gPNMtYCfRSMH8+B7dLYxYKgJwTH+t0A/JivnJFPrqOeMVzuTIVAobbXr1ZQLJHD1wyqBWwuYpUmbM30pJ3vHAr1/yUB8VNqxdIB6fWPtBoU8pGEwxB/0I5sxOM4JjPeGihYd6wlqWTK3IObdX2pWNwQdm/OskfXgUn7/X8gNxkD6/ImIDvGAKuMJxcnmDDR1NmpWFJv1npEGM38NiQQaWick7GHJQDAnf5LzR1tM+UsAGPjFTTkjuawcbciJyg+FISWTG2o+wwRERBxsq1h5ribQSuRlCZIrIrnEeOBsih9OvNR8niXMhsiMimvM/x0eMg7+sbV0ND0T+wIaYjasLMRvt7yFPxKG981jEEHmg9xE6rDmLEWtvavmGNNiw9s7od4MLJoYr1vbQgXKZl0vpWB975orxeSe/oBf5IcUHTUFNXUQ4QVt8kPXnAwpDxzNml7oclBvs/pel+FlrE2LYAmtBrQ/ch4MOd+jo20H3WFOXTHPmb1DJtA2a9/CURexK+CoVNnMooRmVzKgfkjXzo7lWWMGIs7joIfRdvZVCX7tkdqXVfQ+J0e4RNbeyXcKvBtxYJDhCc2DBdLpuZUPimL1HojnRB4/Xq5Pc5RfQk5ABtvlWr05WOBw3otCkt/yFwzE7L35/s38SOTwToqB4/hboJ5ILfw35Emmu8sxwOKaITAGPMAnforvAhC92HJ6XU8p3Gu0cF3TjH2L2H0VgekrQAAAAAElFTkSuQmCC';
                var icoMail = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAmCAYAAACGeMg8AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAG6SURBVHgB7VnbcYMwEFwnDVCCPvPpEijBHYQO4s/84Q5MB6YDpwPSgd0BdIA7IJyRJhiONzIS4505PDDotCstOpCBf/h5xHlklsQlDw8VnA0l2yeIO96lqm/Yi488NhsUU7SF3UhISIYV4A0rwaqE/MJ+XOkgYFf94OqJUIqcPALDCXMRSu417A0k2xR7dEDAbKsRN7bunVHyWElMCCxOuhrEtWqlrbzeOlWmWC1t4PdVuuehwYlRLLCs1WLUreRIrlmTENVQMA2XWNUC8FaKmXsbk/iow0MxzboFpGC+NfBopd5ClNVEJZmAXqtdwDsi6mjXmZhIu6jjoEFEwPTjot/A9e7En9DJ2ME6DsgxedrpfMqncgR+pYwG5hk1eh7qOIzIxdWGHcYtKKNH8oj+S2MfKzkYZqXZhChCokKIzsOWNifoKbqTGlM0vT64KJ6dVEYE/oH+xDy1aXKCNqu1YaqVtAlRVvPQDRfzF9VZk6mIpKDyDDnyWqSjz2fsayXyV0AjXht0puElxDSQkBvsx42EXGE/fuhAL3rP+HzVFcRdKEUu7Nz/TSX3ex0pYwd7/r1KUFjq/oz/Ad4q72Jw+8N+AAAAAElFTkSuQmCC';
                var dataTime = _this4.formatDate();
                var colorPri1 = void 0;
                var colorPri2 = void 0;
                var colorPri3 = void 0;
                var colorSec1 = void 0;
                var colorSec2 = void 0;
                var colorSec3 = void 0;

                // chequear si el total general es el local o moneda extrangera
                var totalAsignacion = void 0;
                var totalDeduccion = void 0;
                if (selecCurrency1 == 1) {
                    totalAsignacion = objPrePayrollDetail[5];
                    totalDeduccion = objPrePayrollDetail[6];
                } else {
                    totalAsignacion = objPrePayrollDetail[11];
                    totalDeduccion = objPrePayrollDetail[12];
                }
                // plantilla de colores
                switch (color) {
                    case 'YELLOW':
                        colorPri1 = 230;
                        colorPri2 = 219;
                        colorPri3 = 153;
                        colorSec1 = 242;
                        colorSec2 = 237;
                        colorSec3 = 209;
                        break;
                    case 'BLUE':
                        colorPri1 = 113;
                        colorPri2 = 160;
                        colorPri3 = 228;
                        colorSec1 = 160;
                        colorSec2 = 229;
                        colorSec3 = 251;
                        break;

                    default:
                        colorPri1 = 255;
                        colorPri2 = 255;
                        colorPri3 = 255;
                        colorSec1 = 255;
                        colorSec2 = 255;
                        colorSec3 = 255;
                        break;
                }
                // white

                // funcion para centrado de texto en company
                function centerText(text) {
                    var numCenter = 220;
                    // console.log(text)
                    // si es jdrivero CA o jd rivero INC
                    if (text.length < 20) {

                        // console.log('entro: ' + numCenter)
                        numCenter = numCenter + 30;
                        return numCenter;
                    } else {
                        // si es rivero visual group o otras con nombres largos
                        return numCenter;
                    }
                }

                var imgLogoURL = window.location.origin + '/' + logo;

                // funcion para combertir imagen a Base64 a partir de la url de la imagen
                function toDataUrl(src, callback) {
                    var xhttp = new XMLHttpRequest();
                    xhttp.onload = function () {
                        var fileReader = new FileReader();
                        fileReader.onloadend = function () {
                            callback(fileReader.result);
                        };
                        fileReader.readAsDataURL(xhttp.response);
                    };
                    xhttp.responseType = 'blob';
                    xhttp.open('GET', src, true);
                    xhttp.send();
                    // console.log(xhttp)
                }

                // funcion para crear pdf
                function crearPDF(imgData) {

                    var doc = new jsPDF('p', 'pt', 'letter');

                    // determino la cantidad de paginas en el documento
                    var numPage = 1;
                    var cont = 155;
                    for (var i = 0; i < objPrePayrollDetail.length; i++) {
                        var element = objPrePayrollDetail;
                        // condiciono que comienze a leer los datos a partir de la posicion 11 del array
                        if (i > 13) {
                            var name = true;
                            element[i].forEach(function (element2) {
                                // doc.text( 'text test11', 220, cont ); //######### only test
                                cont += 15; //18 es el tamaño aproximado de separacion entre lineas de palabras
                                if (cont > 720) {
                                    //720 es el tamaño establecido de contenido dento de la hoja letter
                                    numPage = numPage + 1;
                                    // doc.addPage(); //######### only test
                                    cont = 155; // 155 es el espacion definido para la cabecera
                                }
                                // doc.text( 'text test2', 220, cont ); //######### only test
                            });
                            cont += 20;
                        }
                    }

                    // doc.text( 'izquierda?.', eje X, eje Y );
                    //  console.log(colorPri1,colorPri2,colorPri3)
                    //  Encabezado
                    doc.setDrawColor(0);
                    doc.setFillColor(colorPri1, colorPri2, colorPri3); // color de los rectangulos
                    doc.rect(30, 25, 550, 20, 'F');
                    doc.addImage(imgData, 'JPEG', 35, 50, 85, 60);
                    doc.setFont("helvetica");
                    doc.setFontType("bold");
                    doc.setFontSize(14);
                    doc.text('VACACIONES', 260, 40);
                    // doc.setFontType("courier");

                    doc.setFontType("bold");
                    doc.text(company, centerText(company), 70);
                    // doc.setFontType("courier");

                    doc.setFontSize(8.5);
                    doc.text('Rif: ' + companyNumber, 265, 80);
                    doc.setFontType("normal");
                    // console.log('conpany: ' + company)
                    if (companyId == 4) {
                        doc.addImage(icoPhone, 'JPEG', 260, 92, 9, 9);
                        doc.addImage(icoGlobe, 'JPEG', 304, 103, 9, 9);
                        doc.addImage(icoMail, 'JPEG', 179, 103, 9, 8);
                        doc.text('+58 (247) 342-9544', 270, 100);
                        doc.text('info@riverovisualgroup.com', 190, 110);
                        doc.text('www.riverovisualgroup.com', 315, 110);
                        // pie de pagina
                        doc.setFontSize(7.5);
                        doc.setFontType("italic");
                        var _dataTime5 = new Date();
                        var yearYYYY = _dataTime5.getFullYear();
                        doc.text('\xA9 Copyright ' + yearYYYY + ' Rivero Visual Group - All rights reserved ', 210, 760);
                        doc.setFontType("normal");
                    }
                    if (companyId == 5) {
                        doc.addImage(icoPhone, 'JPEG', 260, 92, 9, 9);
                        doc.addImage(icoGlobe, 'JPEG', 304, 103, 9, 9);
                        doc.addImage(icoMail, 'JPEG', 219, 103, 9, 7);
                        doc.text('+58 (247) 342-9544', 270, 100);
                        doc.text('info@jdrivero.com       www.jdrivero.com', 230, 110);
                        // pie de pagina
                        doc.setFontType("italic");
                        doc.setFontSize(7.5);
                        var _dataTime6 = new Date();
                        var _yearYYYY4 = _dataTime6.getFullYear();
                        doc.text('\xA9 Copyright ' + _yearYYYY4 + ' JD Rivero Global - All rights reserved ', 215, 760);
                        doc.setFontType("normal");
                    }
                    doc.addImage(icoMap, 'JPEG', 181, 82, 11, 9);
                    doc.text(companyAddress, 195, 90);
                    // pie de pagina
                    doc.setFontSize(7.5);
                    doc.text('Pagina:', 515, 760);
                    doc.text('1/' + numPage, 545, 760);
                    doc.setFontType("italic");
                    doc.text('Designed By Rivero Visual Group', 250, 775);
                    doc.setFontType("normal");

                    doc.setFontSize(7.5);
                    doc.setFontType("bold");
                    // doc.setFontSize(12);
                    doc.text('Fecha: ', 435, 80);
                    doc.text('Periodo: ', 435, 90);
                    doc.text('Tipo De Nomina:', 435, 100);
                    doc.text('Pais:', 435, 110);
                    doc.text('Generado Por:', 435, 70);
                    doc.text('Pagina:', 435, 60);
                    doc.setFontType("normal");
                    doc.text('1/' + numPage, 465, 60);
                    doc.text(userProcess, 489, 70);
                    doc.text(dataTime, 462, 80);
                    doc.text(period, 468, 90);
                    doc.text(payrollTypeName, 500, 100);
                    doc.text(country, 455, 110);
                    doc.setFontSize(12);
                    doc.setFontType("normal");

                    // // titulos tablas
                    doc.setDrawColor(0);
                    doc.setFillColor(colorSec1, colorSec2, colorSec3);
                    doc.rect(30, 117, 550, 20, 'F');
                    // doc.line(30, 115, 580, 115);
                    doc.setFontSize(8);
                    doc.setFontType("bold");
                    doc.text('CODIGO', 30, 130);
                    doc.text('NOMBRE', 76, 130);
                    doc.text('CONCEPTO', 195, 130);
                    doc.text('CANTIDAD', 315, 130);
                    doc.text('ASIGNACION', 385, 130);
                    doc.text('DEDUCCION', 453, 130);
                    doc.text('NETO', 545, 130);
                    // doc.line(30, 138, 580, 138);
                    doc.setFontSize(7.5);
                    doc.setFontType("normal");
                    var n = 155;
                    var nRectangulo = 2;
                    var nunIniRectangulo = 145;
                    var page = 1;

                    function formatNumber(number) {
                        var currencyCurrent = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;

                        number = parseFloat(number);
                        number = number.toFixed(2);
                        if (currencyCurrent) {
                            var montoNuevo = number.toString().replace(/\D/g, "").replace(/([0-9])([0-9]{2})$/, '$1.$2').replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
                            return '$' + montoNuevo;
                        } else {
                            var _montoNuevo2 = number.toString().replace(/\D/g, "").replace(/([0-9])([0-9]{2})$/, '$1,$2').replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
                            return 'Bs' + _montoNuevo2;
                        }

                        // let num = parseFloat(number).toFixed(2);
                        // return num
                    }

                    for (var _i = 0; _i < objPrePayrollDetail.length; _i++) {
                        var _element = objPrePayrollDetail;
                        //  console.log( element[i]) 
                        //  console.log('numero de pagina3: ' + numPage) 

                        // condiciono que comienze a leer los datos a partir de la posicion 11 del array
                        if (_i > 13) {
                            (function () {

                                var name = true;

                                _element[_i].forEach(function (element2) {
                                    // console.log('Numero pagina2: ' + numPage)
                                    // indica si imprime linea amarilla
                                    if (nRectangulo % 2 == 0) {
                                        doc.setDrawColor(0);
                                        doc.setFillColor(colorSec1, colorSec2, colorSec3);
                                        doc.rect(30, nunIniRectangulo, 550, 15, 'F');
                                    }

                                    if (name) {
                                        doc.line(30, n - 10, 580, n - 10); //horizontal line
                                        doc.setFontType("bold");
                                        // doc.line(30, n - 10, 580, n - 10);
                                        // doc.text(`n es: ${n}`, 150, n);
                                        doc.text(element2.staffCode, 30, n);
                                        doc.text(element2.staffName, 76, n);
                                        name = false;
                                        doc.setFontType("normal");
                                    }
                                    doc.line(193, n - 10, 193, n + 5); // vertical line
                                    doc.line(309, n - 10, 309, n + 5); // vertical line
                                    doc.line(365, n - 10, 365, n + 5); // vertical line
                                    doc.line(448, n - 10, 448, n + 5); // vertical line
                                    doc.line(510, n - 10, 510, n + 5); // vertical line
                                    doc.text(element2.transactionTypeName, 195, n);
                                    doc.text(element2.quantity, 361, n, 'right');
                                    // validacion de moneda
                                    var amount = element2.amount;
                                    if (selecCurrency1 === false) {
                                        amount = element2.localAmount;
                                    }
                                    if (element2.isIncome == 1) {
                                        if (amount == null) {
                                            //  console.log('entro')
                                            // doc.text('0', 436, n, 'right' );
                                        } else {
                                            doc.text(formatNumber(amount, selecCurrency1), 445, n, 'right');
                                        }
                                    }
                                    if (element2.isIncome == 0) {
                                        if (amount == null) {
                                            // console.log('entro')
                                            // doc.text('0', 502, n, 'right' );
                                        } else {
                                            doc.text(formatNumber(amount, selecCurrency1), 508, n, 'right');
                                        }

                                        // doc.text( '2.07', 502, 155, 'right' );
                                    }
                                    // doc.text(element2.staffCode);
                                    n += 15;

                                    nunIniRectangulo += 15;
                                    nRectangulo += 1;
                                    if (n > 720) {
                                        page += 1;
                                        doc.addPage();

                                        //  Encabezado
                                        doc.setDrawColor(0);
                                        doc.setFillColor(colorPri1, colorPri2, colorPri3); // color de los rectangulos
                                        doc.rect(30, 25, 550, 20, 'F');
                                        doc.addImage(imgData, 'JPEG', 35, 50, 95, 60);
                                        doc.setFont("helvetica");
                                        doc.setFontType("bold");
                                        doc.setFontSize(14);
                                        doc.text('VACACIONES', 260, 40);
                                        // doc.setFontType("courier");


                                        // doc.text( 'PAIS:', 30, 74 );
                                        // doc.text( country, 63, 74 );
                                        // doc.text( 'EMPRESA:', 30, 84 );
                                        doc.setFontType("bold");
                                        doc.text(company, centerText(company), 70);
                                        // doc.setFontType("courier");

                                        doc.setFontSize(8.5);
                                        doc.text('Rif: ' + companyNumber, 265, 80);
                                        doc.setFontType("normal");
                                        // console.log('conpany: ' + company)
                                        if (companyId == 4) {
                                            doc.addImage(icoPhone, 'JPEG', 260, 92, 9, 9);
                                            doc.addImage(icoGlobe, 'JPEG', 304, 103, 9, 9);
                                            doc.addImage(icoMail, 'JPEG', 179, 103, 9, 8);
                                            doc.text('+58 (247) 342-9544', 270, 100);
                                            doc.text('info@riverovisualgroup.com', 190, 110);
                                            doc.text('www.riverovisualgroup.com', 315, 110);
                                            // pie de pagina
                                            doc.setFontSize(7.5);
                                            doc.setFontType("italic");
                                            var _dataTime7 = new Date();
                                            var _yearYYYY5 = _dataTime7.getFullYear();
                                            doc.text('\xA9 Copyright ' + _yearYYYY5 + ' Rivero Visual Group - All rights reserved ', 210, 760);
                                            doc.setFontType("normal");
                                        }
                                        if (companyId == 5) {
                                            doc.addImage(icoPhone, 'JPEG', 260, 92, 9, 9);
                                            doc.addImage(icoGlobe, 'JPEG', 304, 103, 9, 9);
                                            doc.addImage(icoMail, 'JPEG', 219, 103, 9, 7);
                                            doc.text('+58 (247) 342-9544', 270, 100);
                                            doc.text('info@jdrivero.com       www.jdrivero.com', 230, 110);
                                            // pie de pagina
                                            doc.setFontType("italic");
                                            doc.setFontSize(7.5);
                                            var _dataTime8 = new Date();
                                            var _yearYYYY6 = _dataTime8.getFullYear();
                                            doc.text('\xA9 Copyright ' + _yearYYYY6 + ' JD Rivero Global - All rights reserved ', 215, 760);
                                            doc.setFontType("normal");
                                        }
                                        doc.addImage(icoMap, 'JPEG', 181, 82, 11, 9);
                                        doc.text(companyAddress, 195, 90);
                                        // pie de pagina
                                        doc.setFontSize(7.5);
                                        doc.text('Pagina:', 515, 760);
                                        doc.text(page + '/' + numPage, 545, 760);
                                        doc.setFontType("italic");
                                        doc.text('Designed By Rivero Visual Group', 250, 775);
                                        doc.setFontType("normal");

                                        doc.setFontSize(7.5);
                                        doc.setFontType("bold");
                                        // doc.setFontSize(12);
                                        doc.text('Fecha: ', 435, 80);
                                        doc.text('Periodo: ', 435, 90);
                                        doc.text('Tipo De Nomina:', 435, 100);
                                        doc.text('Pais:', 435, 110);
                                        doc.text('Generado Por:', 435, 70);
                                        doc.text('Pagina:', 435, 60);
                                        doc.setFontType("normal");
                                        doc.text(page + '/' + numPage, 465, 60);
                                        doc.text(userProcess, 489, 70);
                                        doc.text(dataTime, 462, 80);
                                        doc.text(period, 468, 90);
                                        doc.text(payrollTypeName, 500, 100);
                                        doc.text(country, 455, 110);
                                        doc.setFontSize(12);
                                        doc.setFontType("normal");

                                        // // titulos tablas
                                        doc.setDrawColor(0);
                                        doc.setFillColor(colorSec1, colorSec2, colorSec3);
                                        doc.rect(30, 117, 550, 20, 'F');
                                        // doc.line(30, 115, 580, 115);
                                        doc.setFontSize(8);
                                        doc.setFontType("bold");
                                        doc.text('CODIGO', 30, 130);
                                        doc.text('NOMBRE', 76, 130);
                                        doc.text('CONCEPTO', 195, 130);
                                        doc.text('CANTIDAD', 315, 130);
                                        doc.text('ASIGNACION', 385, 130);
                                        doc.text('DEDUCCION', 453, 130);
                                        doc.text('NETO', 545, 130);
                                        // doc.line(30, 138, 580, 138);

                                        doc.setFontSize(7.5);
                                        doc.setFontType("normal");

                                        n = 155;
                                        nunIniRectangulo = 145;
                                        // nRectangulo = 2
                                    }
                                });
                                // indica si imprime linea amarilla
                                if (nRectangulo % 2 == 0) {
                                    doc.setDrawColor(0);
                                    doc.setFillColor(colorSec1, colorSec2, colorSec3);
                                    doc.rect(30, nunIniRectangulo, 550, 15, 'F');
                                }
                                doc.setFontSize(7.5);
                                // doc.line(193, n-10, 193, n+5); // vertical line
                                // doc.line(309, n-10, 309, n+5); // vertical line
                                doc.line(365, n - 10, 365, n + 5); // vertical line
                                doc.line(448, n - 10, 448, n + 5); // vertical line
                                doc.line(510, n - 10, 510, n + 5); // vertical line
                                doc.setFontType("bold");
                                doc.text('TOTALES', 215, n);

                                // asignacion para los montos
                                var asignacion = void 0;
                                var deduccion = void 0;
                                if (selecCurrency1 === false) {
                                    asignacion = _element[_i][0].asignacionLocal;
                                    deduccion = _element[_i][0].deduccionLocal;
                                } else {
                                    asignacion = _element[_i][0].asignacion;
                                    deduccion = _element[_i][0].deduccion;
                                }

                                if (asignacion === null) {
                                    asignacion = 0;
                                    // doc.text(`${asignacion}`, 436, n, 'right' );
                                } else {
                                    doc.text('' + formatNumber(asignacion, selecCurrency1), 445, n, 'right');
                                }
                                if (deduccion === null) {
                                    deduccion = 0;
                                    // doc.text(`${deduccion}`, 502, n, 'right' );
                                } else {
                                    doc.text('' + formatNumber(deduccion, selecCurrency1), 508, n, 'right');
                                }

                                var total = asignacion - deduccion; // calculo para el total
                                // console.log('total: ');
                                // console.log(total);
                                if (total < 0) {
                                    doc.text('( ' + formatNumber(total, selecCurrency1) + ' )', 578, n, 'right');
                                } else {
                                    doc.text('' + formatNumber(total, selecCurrency1), 578, n, 'right');
                                }
                                // doc.text(total, 574, n, 'right' );

                                doc.setFontType("normal");
                                n += 20;
                                nunIniRectangulo += 20;
                                nRectangulo += 1;
                            })();
                        }

                        // return
                    }
                    doc.setFontType("bold");

                    totalAsignacion;
                    totalDeduccion;
                    var totalNeto = totalAsignacion - totalDeduccion;
                    n = n + 5;
                    doc.text('TOTAL GENERAL:', 215, n);
                    doc.text(' ' + formatNumber(totalAsignacion, selecCurrency1), 438, n, 'right');
                    doc.text(' ' + formatNumber(totalDeduccion, selecCurrency1), 508, n, 'right');
                    doc.text(' ' + formatNumber(totalNeto, selecCurrency1), 578, n, 'right');

                    doc.save(company + '-' + period + '.pdf');
                    // console.log(res.data.print)
                    // this.$emit("prePayrollDetail", objPrePayrollDetail)
                }

                // llamo la funcion para combertir imagen a base64 y le paso por parametro la variable ' imgLogoURL' con la URL
                toDataUrl(imgLogoURL, function (dataURL) {
                    function closeFrame() {}
                    // como callback llamo una funcion para crear el pdf y le para por varible 'dataURL' la imagen convertida en base64
                    crearPDF(dataURL);
                });
            });
        }
    }
});

/***/ }),

<<<<<<< HEAD
/***/ 752:
=======
/***/ 731:
>>>>>>> module-rrhh
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "col-md-12" }, [
    _c("h2", { staticClass: "text-uppercase" }, [_vm._v("Vacaciones")]),
    _vm._v(" "),
    _c("div", { staticClass: "panel panel-default" }, [
      _c("div", { staticClass: "container" }, [
        _c("div", { staticClass: "row" }, [
          _vm._m(0),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-2" }, [
            _c("label", {
              staticClass: "form-group",
              attrs: { for: "currency" },
              domProps: { textContent: _vm._s("Moneda") }
            }),
            _vm._v("   \n                        "),
            _c("label", [
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.currency,
                    expression: "currency"
                  }
                ],
                attrs: { type: "radio", value: "1", id: "currency1" },
                domProps: { checked: _vm._q(_vm.currency, "1") },
                on: {
                  change: function($event) {
                    _vm.currency = "1"
                  }
                }
              }),
              _vm._v(" USD   \n                        ")
            ]),
            _vm._v(" "),
            _c("label", [
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.currency,
                    expression: "currency"
                  }
                ],
                attrs: { type: "radio", value: "2", id: "currency2" },
                domProps: { checked: _vm._q(_vm.currency, "2") },
                on: {
                  change: function($event) {
                    _vm.currency = "2"
                  }
                }
              }),
              _vm._v(" VEF \n                        ")
            ])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-1" }, [
            _c("label", [
              _c(
                "button",
                {
                  staticClass: "btn btn-sm btn-info",
                  on: {
                    click: function($event) {
                      return _vm.getListVacation()
                    }
                  }
                },
                [_c("i", { staticClass: "fas fa-sync-alt" })]
              )
            ])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-3 col-md-offset-1" }, [
            _c("label", { attrs: { for: "" } }, [
              _vm._v(
                "\n                            Seleccionar Empleado\n                            "
              ),
              _c(
                "select",
                {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.selectStaff,
                      expression: "selectStaff"
                    }
                  ],
                  staticClass: "form-control",
                  attrs: {
                    required: "required",
                    autocomplete: "off",
                    id: "selectStaff"
                  },
                  on: {
                    change: function($event) {
                      var $$selectedVal = Array.prototype.filter
                        .call($event.target.options, function(o) {
                          return o.selected
                        })
                        .map(function(o) {
                          var val = "_value" in o ? o._value : o.value
                          return val
                        })
                      _vm.selectStaff = $event.target.multiple
                        ? $$selectedVal
                        : $$selectedVal[0]
                    }
                  }
                },
                [
                  _c("option", { attrs: { value: "", selected: "" } }),
                  _vm._v(" "),
                  _vm._l(_vm.objSelectStaffs, function(item) {
                    return _c(
                      "option",
                      {
                        key: item.staffCode,
                        attrs: {
                          countryId: item.countryId,
                          companyId: item.companyId
                        },
                        domProps: { value: item.staffCode }
                      },
                      [
                        _vm._v(
                          _vm._s(item.staffCode) + " " + _vm._s(item.shortName)
                        )
                      ]
                    )
                  })
                ],
                2
              )
            ])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-2" }, [
            _c("div", [
              _c("label", { attrs: { for: "" } }, [
                _vm._v("\n                                Periodo Desde: "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.fromDate,
                      expression: "fromDate"
                    }
                  ],
                  staticClass: "form-control",
                  attrs: { type: "date", required: "required" },
                  domProps: { value: _vm.fromDate },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.fromDate = $event.target.value
                    }
                  }
                })
              ])
            ])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-2" }, [
            _c("div", [
              _c("label", { attrs: { for: "" } }, [
                _vm._v("\n                                Periodo Hasta: "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.toDate,
                      expression: "toDate"
                    }
                  ],
                  staticClass: "form-control",
                  attrs: { type: "date", required: "required" },
                  domProps: { value: _vm.toDate },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.toDate = $event.target.value
                    }
                  }
                })
              ])
            ])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-1" }, [
            _c("label", { attrs: { for: "" } }, [_vm._v("  ")]),
            _vm._v(" "),
            _c(
              "button",
              {
                staticClass: "btn btn-sm btn-info",
                attrs: { type: "button" },
                on: {
                  click: function($event) {
                    return _vm.printVacationByEmployee()
                  }
                }
              },
              [_c("i", { staticClass: "fa fa-print" }), _vm._v(" Imprimir")]
            )
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-2 col-md-offset-4" }, [
            _c("div", [
              _c("label", { attrs: { for: "" } }, [
                _vm._v("\n                                Fecha Salida vac.: "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.startVacation,
                      expression: "startVacation"
                    }
                  ],
                  staticClass: "form-control",
                  attrs: { type: "date", required: "required" },
                  domProps: { value: _vm.startVacation },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.startVacation = $event.target.value
                    }
                  }
                })
              ])
            ])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-2" }, [
            _c("div", [
              _c("label", { attrs: { for: "" } }, [
                _vm._v(
                  "\n                                Fecha retorno vac.: "
                ),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.endVacation,
                      expression: "endVacation"
                    }
                  ],
                  staticClass: "form-control",
                  attrs: { type: "date", required: "required" },
                  domProps: { value: _vm.endVacation },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.endVacation = $event.target.value
                    }
                  }
                })
              ])
            ])
          ])
        ])
      ])
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "panel panel-default" }, [
      _c("div", { staticClass: "table-responsive text-center" }, [
        _c(
          "table",
          { staticClass: "table table-striped table-bordered text-center" },
          [
            _vm._m(1),
            _vm._v(" "),
            _vm.objVacation.length > 0
              ? _c(
                  "tbody",
                  _vm._l(_vm.objVacation, function(vacation, index) {
                    return _c("tr", { key: vacation.hrpayrollControlId }, [
                      _c("td", [_vm._v(_vm._s(index + 1))]),
                      _vm._v(" "),
                      _c("td", { staticClass: "form-inline" }, [
                        _c("p", { staticClass: "text-left" }, [
                          _vm._v(
                            "\n                                    " +
                              _vm._s(vacation.countryName) +
                              "\n                                "
                          )
                        ])
                      ]),
                      _vm._v(" "),
                      _c("td", [
                        _c("p", { staticClass: "text-left" }, [
                          _vm._v(
                            "\n                                    " +
                              _vm._s(vacation.companyName) +
                              " \n                                "
                          )
                        ])
                      ]),
                      _vm._v(" "),
                      _c("td", [
                        _c("p", { staticClass: "text-left" }, [
                          _vm._v(
                            "\n                                    " +
                              _vm._s(vacation.payrollTypeName) +
                              "\n                                "
                          )
                        ])
                      ]),
                      _vm._v(" "),
                      _c("td", [
                        _vm._v(
                          "\n                                " +
                            _vm._s(vacation.year) +
                            "\n                            "
                        )
                      ]),
                      _vm._v(" "),
                      _c("td", [
                        _c("p", { staticClass: "text-left" }, [
                          _vm._v(
                            "\n                                    " +
                              _vm._s(vacation.payrollName) +
                              " \n                                "
                          )
                        ])
                      ]),
                      _vm._v(" "),
                      _c("td", [
                        _c(
                          "button",
                          {
                            staticClass: "btn btn-sm btn-info",
                            attrs: { type: "button" },
                            on: {
                              click: function($event) {
                                return _vm.printVacation(
                                  vacation.year,
                                  vacation.payrollNumber,
                                  vacation.payrollTypeId
                                )
                              }
                            }
                          },
                          [
                            _c("i", { staticClass: "fa fa-print" }),
                            _vm._v(" Imprimir")
                          ]
                        )
                      ])
                    ])
                  }),
                  0
                )
              : _c("tbody", [
                  _c("tr", [
                    this.lengths
                      ? _c("td", { attrs: { colspan: "9" } }, [
                          _vm._v(
                            "\n                                No hay datos registrados\n                            "
                          )
                        ])
                      : _c(
                          "td",
                          { attrs: { colspan: "9" } },
                          [_c("loading")],
                          1
                        )
                  ])
                ])
          ]
        )
      ])
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "form-group col-md-12" }, [
      _c("h4", { staticClass: "text-uppercase" }, [
        _vm._v("Opciones de Filtrado")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", [_vm._v("N.")]),
        _vm._v(" "),
        _c("th", [_vm._v("PAIS")]),
        _vm._v(" "),
        _c("th", [_vm._v("EMPRESA")]),
        _vm._v(" "),
        _c("th", [_vm._v("TIPO DE NOMINA")]),
        _vm._v(" "),
        _c("th", [_vm._v("AÑO")]),
        _vm._v(" "),
        _c("th", [_vm._v("PEROÍDO")]),
        _vm._v(" "),
        _c("th", [_vm._v("Acciones")])
      ])
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-8c602448", module.exports)
  }
}

/***/ }),

<<<<<<< HEAD
/***/ 753:
=======
/***/ 732:
>>>>>>> module-rrhh
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c(_vm.currentTabComponent, { tag: "component" }),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "form-group col-ms-12 col-md-12 col-lg-12 text-center" },
        [
          _vm.currentComponent === "LisPreVacation"
            ? _c(
                "button",
                {
                  staticClass: "btn btn-success",
                  attrs: { type: "button" },
                  on: {
                    click: function($event) {
                      _vm.currentComponent = "AddPreVacation"
                    }
                  }
                },
                [_c("span", { staticClass: "fa fa-plus" }), _vm._v(" Agregar")]
              )
            : _vm._e(),
          _vm._v(" "),
          _vm.currentComponent === "AddPreVacation"
            ? _c(
                "button",
                {
                  staticClass: "btn btn-warning",
                  attrs: { type: "button" },
                  on: {
                    click: function($event) {
                      _vm.currentComponent = "LisPreVacation"
                    }
                  }
                },
                [_c("span", { staticClass: "fa fa-plus" }), _vm._v(" Regresar")]
              )
            : _vm._e()
        ]
      ),
      _vm._v(" "),
      _c(_vm.currentComponentVacation, { tag: "component" })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-77894614", module.exports)
  }
}

/***/ })

<<<<<<< HEAD
});
=======
webpackJsonp([1],{703:function(t,e,o){var a=o(704);"string"==typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);o(3)("54c446db",a,!0,{})},704:function(t,e,o){(t.exports=o(2)(!1)).push([t.i,"",""])},705:function(t,e,o){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var a=o(706),r=o.n(a),n=o(709),s=o.n(n),i=o(712),l=o.n(i);e.default={components:{LisPreVacation:r.a,AddPreVacation:s.a,ListVacation:l.a},data:function(){return{currentComponent:"LisPreVacation",currentCompVacatio:"ListVacation"}},mounted:function(){},computed:{currentTabComponent:function(){return this.currentComponent},currentComponentVacation:function(){return this.currentCompVacatio}},methods:{}}},706:function(t,e,o){var a=o(1)(o(707),o(708),!1,null,null,null);t.exports=a.exports},707:function(t,e,o){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={name:"LisPreVacation",components:{},data:function(){return{objPreVacation:{},lengths:!1,loading:!1,currency:1}},mounted:function(){this.getListPreVacation()},computed:{},methods:{getListPreVacation:function(){var t=this;axios.get("pre-vacations/list").then(function(e){e.data.length>0?t.lengths=!1:t.lengths=!0,t.objPreVacation=e.data})},deletePreVacation:function(t){var e=this;confirm("Delete?")&&axios.delete("pre-vacations/"+t).then(function(t){e.getListPreVacation()}).catch(function(t){alert("Error"),console.log(t)})},process:function(t){var e=this;this.loading=!0;var o="pre-vacations/"+t;axios.get(o).then(function(t){var o=t.data.transProcessed;"OK"===t.statusText?(o>0?alert("Transacciones registradas: "+o):alert("No se registraron transacciones para este periodo.."),e.loading=!1):204===t.status?(alert("No se registraron transacciones para este periodo.."),e.loading=!1):(alert("Error al calcular"),e.loading=!1)})},upgradeVacation:function(t,e,o){var a=this;this.loading=!0;var r="vacations/upgrade/"+t+"/"+e+"/"+o;axios.get(r).then(function(t){"OK"===t.statusText?(alert("Vacaciones Actualizadas"),a.getListPreVacation()):204===t.status&&(alert("Sin Contenido..."),a.getListPreVacation(),a.loading=!1)})},formatDate:function(){function t(t){return t<10?t="0"+t:t}var e=new Date,o=e.getDate(),a=e.getMonth()+1,r=e.getFullYear();return(o=t(o))+"/"+(a=t(a))+"/"+r},printPreVacation:function(t,e,o){var a=this,r="pre-vacations/print/"+t+"/"+e+"/"+o,n=this.currency;axios.get(r).then(function(t){if(204===t.status)return alert("Sin contenido");var e=t.data.print,o=e[0],r=e[1],s=e[2],i=e[3],l=e[4],c=e[7],d=e[8],A=e[9],p=e[10],u=e[13],v="data:image/png;base64,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",m="data:image/png;base64,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",g="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAzCAYAAADVY1sUAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAL7SURBVHgB7VqLcdswDH3JdQB1AnODaAR1g25QdgNvEHcCuxM4nSDdQO4ETieQO4HTCVLBthoEESVApBKdz+8Od7QNgHgU+BFoYDzktZS17Gt5quW+FoeJIqvltpYv4nv63BCQInX9yYfDO6DAcbQpsApHQg1ytBPgUjD97OSDvl/jjQhlp854UB7tQXWJJO/F76MSakuXSujcop9EIwthW7X49kiMZSAYz3Qc9CRIaFD4U1kE9JZIAOqo7AjGMd05bETkU8kQXiC2eEnaTGLbEcRPoV/BTmQvfHQN2mAy254gPNMtYCfRSMH8+B7dLYxYKgJwTH+t0A/JivnJFPrqOeMVzuTIVAobbXr1ZQLJHD1wyqBWwuYpUmbM30pJ3vHAr1/yUB8VNqxdIB6fWPtBoU8pGEwxB/0I5sxOM4JjPeGihYd6wlqWTK3IObdX2pWNwQdm/OskfXgUn7/X8gNxkD6/ImIDvGAKuMJxcnmDDR1NmpWFJv1npEGM38NiQQaWick7GHJQDAnf5LzR1tM+UsAGPjFTTkjuawcbciJyg+FISWTG2o+wwRERBxsq1h5ribQSuRlCZIrIrnEeOBsih9OvNR8niXMhsiMimvM/x0eMg7+sbV0ND0T+wIaYjasLMRvt7yFPxKG981jEEHmg9xE6rDmLEWtvavmGNNiw9s7od4MLJoYr1vbQgXKZl0vpWB975orxeSe/oBf5IcUHTUFNXUQ4QVt8kPXnAwpDxzNml7oclBvs/pel+FlrE2LYAmtBrQ/ch4MOd+jo20H3WFOXTHPmb1DJtA2a9/CURexK+CoVNnMooRmVzKgfkjXzo7lWWMGIs7joIfRdvZVCX7tkdqXVfQ+J0e4RNbeyXcKvBtxYJDhCc2DBdLpuZUPimL1HojnRB4/Xq5Pc5RfQk5ABtvlWr05WOBw3otCkt/yFwzE7L35/s38SOTwToqB4/hboJ5ILfw35Emmu8sxwOKaITAGPMAnforvAhC92HJ6XU8p3Gu0cF3TjH2L2H0VgekrQAAAAAElFTkSuQmCC",x="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAmCAYAAACGeMg8AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAG6SURBVHgB7VnbcYMwEFwnDVCCPvPpEijBHYQO4s/84Q5MB6YDpwPSgd0BdIA7IJyRJhiONzIS4505PDDotCstOpCBf/h5xHlklsQlDw8VnA0l2yeIO96lqm/Yi488NhsUU7SF3UhISIYV4A0rwaqE/MJ+XOkgYFf94OqJUIqcPALDCXMRSu417A0k2xR7dEDAbKsRN7bunVHyWElMCCxOuhrEtWqlrbzeOlWmWC1t4PdVuuehwYlRLLCs1WLUreRIrlmTENVQMA2XWNUC8FaKmXsbk/iow0MxzboFpGC+NfBopd5ClNVEJZmAXqtdwDsi6mjXmZhIu6jjoEFEwPTjot/A9e7En9DJ2ME6DsgxedrpfMqncgR+pYwG5hk1eh7qOIzIxdWGHcYtKKNH8oj+S2MfKzkYZqXZhChCokKIzsOWNifoKbqTGlM0vT64KJ6dVEYE/oH+xDy1aXKCNqu1YaqVtAlRVvPQDRfzF9VZk6mIpKDyDDnyWqSjz2fsayXyV0AjXht0puElxDSQkBvsx42EXGE/fuhAL3rP+HzVFcRdKEUu7Nz/TSX3ex0pYwd7/r1KUFjq/oz/Ad4q72Jw+8N+AAAAAElFTkSuQmCC",f=a.formatDate(),y=void 0,C=void 0,h=void 0,F=void 0,D=void 0,E=void 0,I=void 0,b=void 0;switch(1==n?(I=e[5],b=e[6]):(I=e[11],b=e[12]),p){case"YELLOW":y=230,C=219,h=153,F=242,D=237,E=209;break;case"BLUE":y=113,C=160,h=228,F=160,D=229,E=251;break;default:y=255,C=255,h=255,F=255,D=255,E=255}function T(t){var e=220;return t.length<20?e+=30:e}var w,G,P,N=window.location.origin+"/"+i;w=N,G=function(t){!function(t){for(var a=new jsPDF("p","pt","letter"),i=1,p=155,w=0;w<e.length;w++)w>13&&(e[w].forEach(function(t){(p+=15)>720&&(i+=1,p=155)}),p+=20);if(a.setDrawColor(0),a.setFillColor(y,C,h),a.rect(30,25,550,20,"F"),a.addImage(t,"JPEG",35,50,85,60),a.setFont("helvetica"),a.setFontType("bold"),a.setFontSize(14),a.text("PRE-VACACIONES",240,40),a.setFontType("bold"),a.text(s,T(s),70),a.setFontSize(8.5),a.text("Rif: "+d,265,80),a.setFontType("normal"),4==A){a.addImage(m,"JPEG",260,92,9,9),a.addImage(g,"JPEG",304,103,9,9),a.addImage(x,"JPEG",179,103,9,8),a.text("+58 (247) 342-9544",270,100),a.text("info@riverovisualgroup.com",190,110),a.text("www.riverovisualgroup.com",315,110),a.setFontSize(7.5),a.setFontType("italic");var G=(new Date).getFullYear();a.text("© Copyright "+G+" Rivero Visual Group - All rights reserved ",210,760),a.setFontType("normal")}if(5==A){a.addImage(m,"JPEG",260,92,9,9),a.addImage(g,"JPEG",304,103,9,9),a.addImage(x,"JPEG",219,103,9,7),a.text("+58 (247) 342-9544",270,100),a.text("info@jdrivero.com       www.jdrivero.com",230,110),a.setFontType("italic"),a.setFontSize(7.5);var P=(new Date).getFullYear();a.text("© Copyright "+P+" JD Rivero Global - All rights reserved ",215,760),a.setFontType("normal")}a.addImage(v,"JPEG",181,82,11,9),a.text(c,195,90),a.setFontSize(7.5),a.text("Pagina:",515,760),a.text("1/"+i,545,760),a.setFontType("italic"),a.text("Designed By Rivero Visual Group",250,775),a.setFontType("normal"),a.setFontSize(7.5),a.setFontType("bold"),a.text("Fecha: ",435,80),a.text("Periodo: ",435,90),a.text("Tipo De Nomina:",435,100),a.text("Pais:",435,110),a.text("Generado Por:",435,70),a.text("Pagina:",435,60),a.setFontType("normal"),a.text("1/"+i,465,60),a.text(u,489,70),a.text(f,462,80),a.text(o,468,90),a.text(l,500,100),a.text(r,455,110),a.setFontSize(12),a.setFontType("normal"),a.setDrawColor(0),a.setFillColor(F,D,E),a.rect(30,117,550,20,"F"),a.setFontSize(8),a.setFontType("bold"),a.text("CODIGO",30,130),a.text("NOMBRE",76,130),a.text("CONCEPTO",195,130),a.text("CANTIDAD",315,130),a.text("ASIGNACION",385,130),a.text("DEDUCCION",453,130),a.text("NETO",545,130),a.setFontSize(7.5),a.setFontType("normal");var N=155,S=2,V=145,R=1;function O(t){var e=!(arguments.length>1&&void 0!==arguments[1])||arguments[1];return t=(t=parseFloat(t)).toFixed(2),e?"$"+t.toString().replace(/\D/g,"").replace(/([0-9])([0-9]{2})$/,"$1.$2").replace(/\B(?=(\d{3})+(?!\d)\.?)/g,","):"Bs"+t.toString().replace(/\D/g,"").replace(/([0-9])([0-9]{2})$/,"$1,$2").replace(/\B(?=(\d{3})+(?!\d)\.?)/g,".")}for(var Q=0;Q<e.length;Q++){var U=e;Q>13&&function(){var e=!0;U[Q].forEach(function(p){S%2==0&&(a.setDrawColor(0),a.setFillColor(F,D,E),a.rect(30,V,550,15,"F")),e&&(a.line(30,N-10,580,N-10),a.setFontType("bold"),a.text(p.staffCode,30,N),a.text(p.staffName,76,N),e=!1,a.setFontType("normal")),a.line(193,N-10,193,N+5),a.line(309,N-10,309,N+5),a.line(365,N-10,365,N+5),a.line(448,N-10,448,N+5),a.line(510,N-10,510,N+5),a.text(p.transactionTypeName,195,N),a.text(p.quantity,361,N,"right");var I=p.amount;if(!1===n&&(I=p.localAmount),1==p.isIncome&&(null==I||a.text(O(I,n),445,N,"right")),0==p.isIncome&&(null==I||a.text(O(I,n),508,N,"right")),V+=15,S+=1,(N+=15)>720){if(R+=1,a.addPage(),a.setDrawColor(0),a.setFillColor(y,C,h),a.rect(30,25,550,20,"F"),a.addImage(t,"JPEG",35,50,95,60),a.setFont("helvetica"),a.setFontType("bold"),a.setFontSize(14),a.text("PRE-VACACIONES",240,40),a.setFontType("bold"),a.text(s,T(s),70),a.setFontSize(8.5),a.text("Rif: "+d,265,80),a.setFontType("normal"),4==A){a.addImage(m,"JPEG",260,92,9,9),a.addImage(g,"JPEG",304,103,9,9),a.addImage(x,"JPEG",179,103,9,8),a.text("+58 (247) 342-9544",270,100),a.text("info@riverovisualgroup.com",190,110),a.text("www.riverovisualgroup.com",315,110),a.setFontSize(7.5),a.setFontType("italic");var b=(new Date).getFullYear();a.text("© Copyright "+b+" Rivero Visual Group - All rights reserved ",210,760),a.setFontType("normal")}if(5==A){a.addImage(m,"JPEG",260,92,9,9),a.addImage(g,"JPEG",304,103,9,9),a.addImage(x,"JPEG",219,103,9,7),a.text("+58 (247) 342-9544",270,100),a.text("info@jdrivero.com       www.jdrivero.com",230,110),a.setFontType("italic"),a.setFontSize(7.5);var w=(new Date).getFullYear();a.text("© Copyright "+w+" JD Rivero Global - All rights reserved ",215,760),a.setFontType("normal")}a.addImage(v,"JPEG",181,82,11,9),a.text(c,195,90),a.setFontSize(7.5),a.text("Pagina:",515,760),a.text(R+"/"+i,545,760),a.setFontType("italic"),a.text("Designed By Rivero Visual Group",250,775),a.setFontType("normal"),a.setFontSize(7.5),a.setFontType("bold"),a.text("Fecha: ",435,80),a.text("Periodo: ",435,90),a.text("Tipo De Nomina:",435,100),a.text("Pais:",435,110),a.text("Generado Por:",435,70),a.text("Pagina:",435,60),a.setFontType("normal"),a.text(R+"/"+i,465,60),a.text(u,489,70),a.text(f,462,80),a.text(o,468,90),a.text(l,500,100),a.text(r,455,110),a.setFontSize(12),a.setFontType("normal"),a.setDrawColor(0),a.setFillColor(F,D,E),a.rect(30,117,550,20,"F"),a.setFontSize(8),a.setFontType("bold"),a.text("CODIGO",30,130),a.text("NOMBRE",76,130),a.text("CONCEPTO",195,130),a.text("CANTIDAD",315,130),a.text("ASIGNACION",385,130),a.text("DEDUCCION",453,130),a.text("NETO",545,130),a.setFontSize(7.5),a.setFontType("normal"),N=155,V=145}}),S%2==0&&(a.setDrawColor(0),a.setFillColor(F,D,E),a.rect(30,V,550,15,"F")),a.setFontSize(7.5),a.line(365,N-10,365,N+5),a.line(448,N-10,448,N+5),a.line(510,N-10,510,N+5),a.setFontType("bold"),a.text("TOTALES",215,N);var p=void 0,I=void 0;!1===n?(p=U[Q][0].asignacionLocal,I=U[Q][0].deduccionLocal):(p=U[Q][0].asignacion,I=U[Q][0].deduccion),null===p?p=0:a.text(""+O(p,n),445,N,"right"),null===I?I=0:a.text(""+O(I,n),508,N,"right");var b=p-I;b<0?a.text("( "+O(b,n)+" )",578,N,"right"):a.text(""+O(b,n),578,N,"right"),a.setFontType("normal"),N+=20,V+=20,S+=1}()}a.setFontType("bold");var B=I-b;N+=5,a.text("TOTAL GENERAL:",215,N),a.text(" "+O(I,n),438,N,"right"),a.text(" "+O(b,n),508,N,"right"),a.text(" "+O(B,n),578,N,"right"),a.save(s+"-"+o+".pdf")}(t)},(P=new XMLHttpRequest).onload=function(){var t=new FileReader;t.onloadend=function(){G(t.result)},t.readAsDataURL(P.response)},P.responseType="blob",P.open("GET",w,!0),P.send()})}}}},708:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("div",{staticClass:"col-md-12"},[o("h2",{staticClass:"text-uppercase"},[t._v("Pre vacaciones")]),t._v(" "),o("div",{staticClass:"panel panel-default"},[o("div",{staticClass:"container"},[o("div",{staticClass:"row"},[t._m(0),t._v(" "),o("div",{staticClass:"col-md-3 col-md-offset-6"},[o("label",{staticClass:"form-group",attrs:{for:"currency"},domProps:{textContent:t._s("Moneda")}}),t._v("   \n                        "),o("label",[o("input",{directives:[{name:"model",rawName:"v-model",value:t.currency,expression:"currency"}],attrs:{type:"radio",value:"1",id:"currency1"},domProps:{checked:t._q(t.currency,"1")},on:{change:function(e){t.currency="1"}}}),t._v(" USD   \n                        ")]),t._v(" "),o("label",[o("input",{directives:[{name:"model",rawName:"v-model",value:t.currency,expression:"currency"}],attrs:{type:"radio",value:"2",id:"currency2"},domProps:{checked:t._q(t.currency,"2")},on:{change:function(e){t.currency="2"}}}),t._v(" VEF \n                        ")])])])])]),t._v(" "),o("div",{staticClass:"panel panel-default"},[o("div",{staticClass:"table-responsive text-center"},[o("table",{staticClass:"table table-striped table-bordered text-center"},[t._m(1),t._v(" "),t.objPreVacation.length>0?o("tbody",t._l(t.objPreVacation,function(e,a){return o("tr",{key:e.hrpayrollControlId},[o("td",[t._v(t._s(a+1))]),t._v(" "),o("td",{staticClass:"form-inline"},[o("p",{staticClass:"text-left"},[t._v("\n                                    "+t._s(e.countryName)+"\n                                ")])]),t._v(" "),o("td",[o("p",{staticClass:"text-left"},[t._v("\n                                    "+t._s(e.companyName)+" \n                                ")])]),t._v(" "),o("td",[o("p",{staticClass:"text-left"},[t._v("\n                                    "+t._s(e.payrollTypeName)+"\n                                ")])]),t._v(" "),o("td",[t._v("\n                                "+t._s(e.year)+"\n                            ")]),t._v(" "),o("td",[o("p",{staticClass:"text-left"},[t._v("\n                                    "+t._s(e.payrollName)+" \n                                ")])]),t._v(" "),o("td",[!1===t.loading?o("button",{staticClass:"btn btn-sm btn-primary",on:{click:function(o){return t.process(e.hrpayrollControlId)}}},[o("i",{staticClass:"fa fa-edit"}),t._v("Calcular")]):o("button",{staticClass:"btn btn-sm btn-primary",attrs:{disabled:"disabled"}},[o("i",{staticClass:"fa fa-edit"}),t._v("Calcular")]),t._v(" "),o("button",{staticClass:"btn btn-sm btn-info",on:{click:function(o){return t.printPreVacation(e.year,e.payrollNumber,e.payrollTypeId)}}},[o("i",{staticClass:"fa fa-print"}),t._v(" Imprimir")]),t._v(" "),o("button",{staticClass:"btn btn-sm btn-warning",on:{click:function(o){return t.upgradeVacation(e.year,e.payrollNumber,e.payrollTypeId)}}},[o("i",{staticClass:"fa fa-edit"}),t._v("Actualizar")]),t._v(" "),o("button",{staticClass:"btn btn-sm btn-danger",on:{click:function(o){return t.deletePreVacation(e.hrpayrollControlId)}}},[o("i",{staticClass:"fa fa-times-circle"})])])])}),0):o("tbody",[o("tr",[this.lengths?o("td",{attrs:{colspan:"9"}},[t._v("\n                                No hay datos registrados\n                            ")]):o("td",{attrs:{colspan:"9"}},[o("loading")],1)])])])])])])},staticRenderFns:[function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"form-group col-md-12"},[e("h4",{staticClass:"text-uppercase"},[this._v("Opciones de Filtrado")])])},function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("thead",[o("tr",[o("th",[t._v("N.")]),t._v(" "),o("th",[t._v("PAIS")]),t._v(" "),o("th",[t._v("EMPRESA")]),t._v(" "),o("th",[t._v("TIPO DE NOMINA")]),t._v(" "),o("th",[t._v("AÑO")]),t._v(" "),o("th",[t._v("PEROÍDO")]),t._v(" "),o("th",[t._v("Acciones")])])])}]}},709:function(t,e,o){var a=o(1)(o(710),o(711),!1,null,null,null);t.exports=a.exports},710:function(t,e,o){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={name:"AddPreVacation",components:{},data:function(){return{selectPayrollNumber:{},selectPayrollType:{},selectProcessCode:{},payrollTypeId:"",payrollNumber:0,processCode:0,thereIs:!1,regData:"",year:"",years:0,editId:0,nameField1:"Tipo de nomina",nameField2:"Año",nameField3:"Periodo",nameField4:"Proceso"}},mounted:function(){this.getYears(),this.getPayrollType()},computed:{addSuccess:function(){return{background:"#dff0d8"}},ediPrimary:function(){return{background:"#d9edf7"}}},methods:{getYears:function(){var t=new Date;this.years=t.getFullYear()-3},getPayrollType:function(){var t=this;axios.get("payrolltypes/list").then(function(e){e.data.length>0?t.selectPayrollType=e.data.map(function(t){return{id:t.payrollTypeId,vText:t.payrollTypeName}}):t.regData="No hay registros para la empresa"})},getPayrollNumber:function(){var t=this;""!==this.payrollTypeId&&""!==this.year?(axios.get("payrollcontrol/payrollNumber/vacation/"+this.payrollTypeId+"/"+this.year).then(function(e){console.log(e),e.data.length>0?(payrollNumberId.disabled=!1,t.selectPayrollNumber=e.data.map(function(t){return{id:t.payrollNumber,periodId:t.periodId,vText:t.periodName}})):(alert("No hay registros"),payrollNumberId.disabled=!0)}),axios.get("payrollcontrol/process/0/0").then(function(e){e.data.length>0?(processCodeId.disabled=!1,t.selectProcessCode=e.data.map(function(t){return{id:t.processCode,vText:t.processName}}),t.thereIs=!0):(t.thereIs=!1,processCodeId.disabled=!0)})):alert("Debe seleccionar tipo de nomina y año")},newUpForm:function(){if(0===this.editId){var t=this.payrollNumber.split("-"),e=parseInt(t[0]),o=parseInt(t[2]),a={countryId:this.selectCountry,companyId:this.companyId,payrollTypeId:this.payrollTypeId,payrollNumber:e,periodId:o,year:this.year,payrollName:t[1],processCode:this.processCode};axios.post("pre-vacations/",a).then(function(t){"OK"==t.statusText?(document.querySelector("#newUpForm").reset(),alert("Success")):alert("Error")}).catch(function(t){console.log(t)})}}}}},711:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("div",{staticClass:"container"},[o("div",{staticClass:"row"},[o("div",{staticClass:"col-md-6 col-md-offset-3"},[o("div",{staticClass:"panel panel-default"},[o("div",{staticClass:"panel-heading",style:t.addSuccess},[o("h4",{staticClass:"text-uppercase"},[t._v("Agregar Pre Vacacion")])]),t._v(" "),o("div",{staticClass:"panel-body"},[o("form",{staticClass:"form",attrs:{role:"form",autocomplete:"off",id:"newUpForm"},on:{submit:function(e){return e.preventDefault(),t.newUpForm()}}},[o("div",{staticClass:"row"},[o("div",{staticClass:"form-group col-md-6"},[o("label",{staticClass:"form-group",attrs:{for:"payrollTypeId"},domProps:{textContent:t._s(t.nameField1)}}),t._v(" "),o("select",{directives:[{name:"model",rawName:"v-model",value:t.payrollTypeId,expression:"payrollTypeId"}],staticClass:"form-control",attrs:{id:"payrollTypeId",autocomplete:"off",required:"required"},on:{change:function(e){var o=Array.prototype.filter.call(e.target.options,function(t){return t.selected}).map(function(t){return"_value"in t?t._value:t.value});t.payrollTypeId=e.target.multiple?o:o[0]}}},[o("option",{attrs:{value:""}},[t._v(t._s(t.regData))]),t._v(" "),t._l(t.selectPayrollType,function(e){return o("option",{key:e.id,domProps:{value:e.id}},[t._v(t._s(e.vText))])})],2)])]),t._v(" "),o("div",{staticClass:"row"},[o("div",{staticClass:"form-group col-md-8 form-inline"},[o("label",{staticClass:"form-group",attrs:{for:"year"},domProps:{textContent:t._s(t.nameField2)}}),t._v(" "),o("div",{staticClass:"form-inline"},[0===t.editId?o("select",{directives:[{name:"model",rawName:"v-model",value:t.year,expression:"year"}],staticClass:"form-control",attrs:{id:"year",autocomplete:"off",required:"required"},on:{change:function(e){var o=Array.prototype.filter.call(e.target.options,function(t){return t.selected}).map(function(t){return"_value"in t?t._value:t.value});t.year=e.target.multiple?o:o[0]}}},[o("option",{attrs:{value:""}}),t._v(" "),t._l(5,function(e){return o("option",{key:e,domProps:{value:e+t.years}},[t._v(t._s(e+t.years))])})],2):t._e()])])]),t._v(" "),o("div",{staticClass:"row"},[o("div",{staticClass:"form-group col-md-6"},[o("label",{staticClass:"form-group",attrs:{for:"payrollNumber"},domProps:{textContent:t._s(t.nameField3)}}),t._v(" "),0===t.editId?o("button",{staticClass:"btn btn-sm btn-success",attrs:{type:"button",title:"Obtener periodo","data-original-title":"Obtener periodo"},on:{click:function(e){return t.getPayrollNumber()}}},[o("i",{staticClass:"glyphicon glyphicon-search"})]):t._e(),t._v(" "),0===t.editId?o("select",{directives:[{name:"model",rawName:"v-model",value:t.payrollNumber,expression:"payrollNumber"}],staticClass:"form-control",attrs:{id:"payrollNumberId",autocomplete:"off",disabled:"disabled",required:"required"},on:{change:function(e){var o=Array.prototype.filter.call(e.target.options,function(t){return t.selected}).map(function(t){return"_value"in t?t._value:t.value});t.payrollNumber=e.target.multiple?o:o[0]}}},[o("option",{attrs:{value:""}}),t._v(" "),t._l(t.selectPayrollNumber,function(e){return o("option",{key:e.id,domProps:{value:e.id+"-"+e.vText+"-"+e.periodId}},[t._v(t._s(e.vText))])})],2):t._e()])]),t._v(" "),o("div",{staticClass:"row"},[o("div",{staticClass:"form-group col-md-6"},[o("label",{staticClass:"form-group",attrs:{for:"processCode"},domProps:{textContent:t._s(t.nameField4)}}),t._v(" "),0===t.editId?o("select",{directives:[{name:"model",rawName:"v-model",value:t.processCode,expression:"processCode"}],staticClass:"form-control",attrs:{id:"processCodeId",autocomplete:"off",disabled:"disabled",required:"required"},on:{change:function(e){var o=Array.prototype.filter.call(e.target.options,function(t){return t.selected}).map(function(t){return"_value"in t?t._value:t.value});t.processCode=e.target.multiple?o:o[0]}}},t._l(t.selectProcessCode,function(e){return o("option",{key:e.id,domProps:{value:e.id}},[t._v(t._s(e.vText))])}),0):t._e(),t._v(" "),!1===t.thereIs?o("span",[t._v(" No hay procesos para esta empresa")]):t._e()])]),t._v(" "),0===t.editId?o("div",[t._m(0)]):t._e()])])])])])])},staticRenderFns:[function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"form-group col-ms-12 col-md-12 col-lg-12 text-center"},[e("button",{staticClass:"btn btn-success",attrs:{type:"submit"}},[e("span",{staticClass:"fa fa-check"}),this._v(" Guardar")])])}]}},712:function(t,e,o){var a=o(1)(o(713),o(714),!1,null,null,null);t.exports=a.exports},713:function(t,e,o){"use strict";function a(t,e,o){return e in t?Object.defineProperty(t,e,{value:o,enumerable:!0,configurable:!0,writable:!0}):t[e]=o,t}Object.defineProperty(e,"__esModule",{value:!0}),e.default={name:"ListVacation",components:{},data:function(){var t;return a(t={objVacation:{},lengths:!1},"lengths",!1),a(t,"fromDate",""),a(t,"toDate",""),a(t,"startVacation",""),a(t,"endVacation",""),a(t,"currency",1),a(t,"selectStaff",""),a(t,"objSelectStaffs",{}),t},mounted:function(){this.getListVacation(),this.getComboEmployees()},computed:{},methods:{getListVacation:function(){var t=this;axios.get("vacations/list").then(function(e){e.data.payrollHistory.length>0?t.lengths=!1:t.lengths=!0,t.objVacation=e.data.payrollHistory,console.log(t.objVacation)})},getComboEmployees:function(){var t=this;axios.get("combo-staff/0/0").then(function(e){t.objSelectStaffs=e.data})},printVacationByEmployee:function(){var t=this,e="get-payroll-number-vacation/"+this.fromDate+"/"+this.toDate;axios.get(e).then(function(e){if(204!==e.status){var o=e.data.year,a=e.data.payrollNumber,r=e.data.payrollTypeId,n=e.data.payrollCategory,s=t.currency,i="vacations-employees/print/"+o+"/"+a+"/"+r+"/"+n+"/"+t.selectStaff;axios.get(i).then(function(e){if(console.log(e),204!==e.status){var o=e.data.print,a=o[0],r=o[1],n=o[2],i=o[3],l=o[4],c=o[7],d=o[8],A=o[9],p=o[10],u=o[13],v=o[14][0].staffName,m=o[14][0].employmentDate,g=o[14][0].positionName,x=o[14][0].idDocument,f=t.formatDate2(t.startVacation),y=t.formatDate2(t.endVacation),C="data:image/png;base64,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",h="data:image/png;base64,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",F="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAzCAYAAADVY1sUAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAL7SURBVHgB7VqLcdswDH3JdQB1AnODaAR1g25QdgNvEHcCuxM4nSDdQO4ETieQO4HTCVLBthoEESVApBKdz+8Od7QNgHgU+BFoYDzktZS17Gt5quW+FoeJIqvltpYv4nv63BCQInX9yYfDO6DAcbQpsApHQg1ytBPgUjD97OSDvl/jjQhlp854UB7tQXWJJO/F76MSakuXSujcop9EIwthW7X49kiMZSAYz3Qc9CRIaFD4U1kE9JZIAOqo7AjGMd05bETkU8kQXiC2eEnaTGLbEcRPoV/BTmQvfHQN2mAy254gPNMtYCfRSMH8+B7dLYxYKgJwTH+t0A/JivnJFPrqOeMVzuTIVAobbXr1ZQLJHD1wyqBWwuYpUmbM30pJ3vHAr1/yUB8VNqxdIB6fWPtBoU8pGEwxB/0I5sxOM4JjPeGihYd6wlqWTK3IObdX2pWNwQdm/OskfXgUn7/X8gNxkD6/ImIDvGAKuMJxcnmDDR1NmpWFJv1npEGM38NiQQaWick7GHJQDAnf5LzR1tM+UsAGPjFTTkjuawcbciJyg+FISWTG2o+wwRERBxsq1h5ribQSuRlCZIrIrnEeOBsih9OvNR8niXMhsiMimvM/x0eMg7+sbV0ND0T+wIaYjasLMRvt7yFPxKG981jEEHmg9xE6rDmLEWtvavmGNNiw9s7od4MLJoYr1vbQgXKZl0vpWB975orxeSe/oBf5IcUHTUFNXUQ4QVt8kPXnAwpDxzNml7oclBvs/pel+FlrE2LYAmtBrQ/ch4MOd+jo20H3WFOXTHPmb1DJtA2a9/CURexK+CoVNnMooRmVzKgfkjXzo7lWWMGIs7joIfRdvZVCX7tkdqXVfQ+J0e4RNbeyXcKvBtxYJDhCc2DBdLpuZUPimL1HojnRB4/Xq5Pc5RfQk5ABtvlWr05WOBw3otCkt/yFwzE7L35/s38SOTwToqB4/hboJ5ILfw35Emmu8sxwOKaITAGPMAnforvAhC92HJ6XU8p3Gu0cF3TjH2L2H0VgekrQAAAAAElFTkSuQmCC",D="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAmCAYAAACGeMg8AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAG6SURBVHgB7VnbcYMwEFwnDVCCPvPpEijBHYQO4s/84Q5MB6YDpwPSgd0BdIA7IJyRJhiONzIS4505PDDotCstOpCBf/h5xHlklsQlDw8VnA0l2yeIO96lqm/Yi488NhsUU7SF3UhISIYV4A0rwaqE/MJ+XOkgYFf94OqJUIqcPALDCXMRSu417A0k2xR7dEDAbKsRN7bunVHyWElMCCxOuhrEtWqlrbzeOlWmWC1t4PdVuuehwYlRLLCs1WLUreRIrlmTENVQMA2XWNUC8FaKmXsbk/iow0MxzboFpGC+NfBopd5ClNVEJZmAXqtdwDsi6mjXmZhIu6jjoEFEwPTjot/A9e7En9DJ2ME6DsgxedrpfMqncgR+pYwG5hk1eh7qOIzIxdWGHcYtKKNH8oj+S2MfKzkYZqXZhChCokKIzsOWNifoKbqTGlM0vT64KJ6dVEYE/oH+xDy1aXKCNqu1YaqVtAlRVvPQDRfzF9VZk6mIpKDyDDnyWqSjz2fsayXyV0AjXht0puElxDSQkBvsx42EXGE/fuhAL3rP+HzVFcRdKEUu7Nz/TSX3ex0pYwd7/r1KUFjq/oz/Ad4q72Jw+8N+AAAAAElFTkSuQmCC",E=t.formatDate(),I=void 0,b=void 0,T=void 0,w=void 0,G=void 0,P=void 0;m=t.formatDate2(m);var N=void 0,S=void 0;switch(1==s?(N=o[5],S=o[6]):(N=o[11],S=o[12]),p){case"YELLOW":I=230,b=219,T=153,w=242,G=237,P=209;break;case"BLUE":I=113,b=160,T=228,w=160,G=229,P=251;break;default:I=255,b=255,T=255,w=255,G=255,P=255}var V,R,O,Q=window.location.origin+"/"+i;V=Q,R=function(t){!function(t){var e=new jsPDF("p","pt","letter");if(e.setDrawColor(0),e.setFillColor(I,b,T),e.rect(30,25,550,20,"F"),e.addImage(t,"JPEG",35,50,85,60),e.setFont("helvetica"),e.setFontType("bold"),e.setFontSize(14),e.text("VACACIONES",260,40),e.setFontType("bold"),e.text(n,U(n),70),e.setFontSize(8.5),e.text("Rif: "+d,265,80),e.setFontType("normal"),4==A){e.addImage(h,"JPEG",260,92,9,9),e.addImage(F,"JPEG",304,103,9,9),e.addImage(D,"JPEG",179,103,9,8),e.text("+58 (247) 342-9544",270,100),e.text("info@riverovisualgroup.com",190,110),e.text("www.riverovisualgroup.com",315,110),e.setFontSize(7.5),e.setFontType("italic");var i=(new Date).getFullYear();e.text("© Copyright "+i+" Rivero Visual Group - All rights reserved ",210,760),e.setFontType("normal")}if(5==A){e.addImage(h,"JPEG",260,92,9,9),e.addImage(F,"JPEG",304,103,9,9),e.addImage(D,"JPEG",219,103,9,7),e.text("+58 (247) 342-9544",270,100),e.text("info@jdrivero.com       www.jdrivero.com",230,110),e.setFontType("italic"),e.setFontSize(7.5);var p=(new Date).getFullYear();e.text("© Copyright "+p+" JD Rivero Global - All rights reserved ",215,760),e.setFontType("normal")}e.addImage(C,"JPEG",181,82,11,9),e.text(c,195,90),e.setFontSize(7.5),e.text("Pagina:",515,760),e.text("1/1",545,760),e.setFontType("italic"),e.text("Designed By Rivero Visual Group",250,775),e.setFontType("normal"),e.setFontSize(7.5),e.setFontType("bold"),e.text("Fecha: ",435,80),e.text("Periodo: ",435,90),e.text("Tipo De Nomina:",435,100),e.text("Pais:",435,110),e.text("Generado Por:",435,70),e.text("Pagina:",435,60),e.setFontType("normal"),e.text("1/1",465,60),e.text(u,489,70),e.text(E,462,80),e.text(a,468,90),e.text(l,500,100),e.text(r,455,110),e.setFontSize(12),e.setFontType("normal"),e.setDrawColor(0),e.setFillColor(w,G,P),e.rect(30,117,550,20,"F"),e.setFontSize(8),e.setFontType("bold"),e.text("CODIGO",30,130),e.text("CONCEPTO",76,130),e.text(" ",195,130),e.text("CANTIDAD",315,130),e.text("ASIGNACION",385,130),e.text("DEDUCCION",453,130),e.text("NETO",545,130),e.setFontSize(7.5),e.setFontType("normal");var V=155,R=2,O=145,Q=1;function B(t){var e=!(arguments.length>1&&void 0!==arguments[1])||arguments[1];return t=(t=parseFloat(t)).toFixed(2),e?"$"+t.toString().replace(/\D/g,"").replace(/([0-9])([0-9]{2})$/,"$1.$2").replace(/\B(?=(\d{3})+(?!\d)\.?)/g,","):"Bs"+t.toString().replace(/\D/g,"").replace(/([0-9])([0-9]{2})$/,"$1,$2").replace(/\B(?=(\d{3})+(?!\d)\.?)/g,".")}for(var Y=0;Y<o.length;Y++){var M=o;Y>13&&function(){var o=!0;M[Y].forEach(function(i){R%2==0&&(e.setDrawColor(0),e.setFillColor(w,G,P),e.rect(30,O,550,15,"F")),o&&(e.line(30,V-10,580,V-10),e.setFontType("bold"),e.text(i.staffCode,30,V),o=!1,e.setFontType("normal")),e.line(213,V-10,213,V+5),e.line(309,V-10,309,V+5),e.line(365,V-10,365,V+5),e.line(448,V-10,448,V+5),e.line(510,V-10,510,V+5),e.text(i.transactionTypeName,76,V),e.text(i.comment,218,V),e.text(i.quantity,361,V,"right");var p=i.amount;if(!1===s&&(p=i.localAmount),1==i.isIncome&&(null==p||e.text(B(p,s),445,V,"right")),0==i.isIncome&&(null==p||e.text(B(p,s),508,V,"right")),O+=15,R+=1,(V+=15)>720){if(Q+=1,e.addPage(),e.setDrawColor(0),e.setFillColor(I,b,T),e.rect(30,25,550,20,"F"),e.addImage(t,"JPEG",35,50,95,60),e.setFont("helvetica"),e.setFontType("bold"),e.setFontSize(14),e.text("VACACIONES",260,40),e.setFontType("bold"),e.text(n,U(n),70),e.setFontSize(8.5),e.text("Rif: "+d,265,80),e.setFontType("normal"),4==A){e.addImage(h,"JPEG",260,92,9,9),e.addImage(F,"JPEG",304,103,9,9),e.addImage(D,"JPEG",179,103,9,8),e.text("+58 (247) 342-9544",270,100),e.text("info@riverovisualgroup.com",190,110),e.text("www.riverovisualgroup.com",315,110),e.setFontSize(7.5),e.setFontType("italic");var v=(new Date).getFullYear();e.text("© Copyright "+v+" Rivero Visual Group - All rights reserved ",210,760),e.setFontType("normal")}if(5==A){e.addImage(h,"JPEG",260,92,9,9),e.addImage(F,"JPEG",304,103,9,9),e.addImage(D,"JPEG",219,103,9,7),e.text("+58 (247) 342-9544",270,100),e.text("info@jdrivero.com       www.jdrivero.com",230,110),e.setFontType("italic"),e.setFontSize(7.5);var m=(new Date).getFullYear();e.text("© Copyright "+m+" JD Rivero Global - All rights reserved ",215,760),e.setFontType("normal")}e.addImage(C,"JPEG",181,82,11,9),e.text(c,195,90),e.setFontSize(7.5),e.text("Pagina:",515,760),e.text(Q+"/1",545,760),e.setFontType("italic"),e.text("Designed By Rivero Visual Group",250,775),e.setFontType("normal"),e.setFontSize(7.5),e.setFontType("bold"),e.text("Fecha: ",435,80),e.text("Periodo: ",435,90),e.text("Tipo De Nomina:",435,100),e.text("Pais:",435,110),e.text("Generado Por:",435,70),e.text("Pagina:",435,60),e.setFontType("normal"),e.text(Q+"/1",465,60),e.text(u,489,70),e.text(E,462,80),e.text(a,468,90),e.text(l,500,100),e.text(r,455,110),e.setFontSize(12),e.setFontType("normal"),e.setDrawColor(0),e.setFillColor(w,G,P),e.rect(30,117,550,20,"F"),e.setFontSize(8),e.setFontType("bold"),e.text("CODIGO",30,130),e.text("NOMBRE",76,130),e.text("CONCEPTO",195,130),e.text("CANTIDAD",315,130),e.text("ASIGNACION",385,130),e.text("DEDUCCION",453,130),e.text("NETO",545,130),e.setFontSize(7.5),e.setFontType("normal"),V=155,O=145}}),R%2==0&&(e.setDrawColor(0),e.setFillColor(w,G,P),e.rect(30,O,550,15,"F")),e.setFontSize(7.5),e.line(365,V-10,365,V+5),e.line(448,V-10,448,V+5),e.line(510,V-10,510,V+5),e.setFontType("bold"),e.text("TOTALES",215,V);var i=void 0,p=void 0;!1===s?(i=M[Y][0].asignacionLocal,p=M[Y][0].deduccionLocal):(i=M[Y][0].asignacion,p=M[Y][0].deduccion),null===i?i=0:e.text(""+B(i,s),445,V,"right"),null===p?p=0:e.text(""+B(p,s),508,V,"right");var v=i-p;v<0?e.text("( "+B(v,s)+" )",578,V,"right"):e.text(""+B(v,s),578,V,"right"),e.setFontType("normal"),V+=20,O+=20,R+=1}()}e.setFontType("bold");var W=N-S;V+=5,e.text("TOTAL GENERAL:",215,V),e.text(" "+B(N,s),445,V,"right"),e.text(" "+B(S,s),508,V,"right"),e.text(" "+B(W,s),578,V,"right"),e.setFontType("bold"),e.text("Empleado:",30,V+30),e.text("Cedula:",30,V+40),e.text("Cargo:",30,V+50),e.text("Fecha de ingreso:",30,V+60),e.text("Fecha salida vacaiones:",30,V+70),e.text("Fecha retorno vacaciones:",30,V+80),e.setFontType("normal"),e.text(v,76,V+30),e.text(x,65,V+40),e.text(g,65,V+50),e.text(m,100,V+60),e.text(f,124,V+70),e.text(y,130,V+80),e.text("Con el pago de estos montos la empresa cancela todo lo relacionado con vacaciones del período que se menciona en este mismo recibo y por tal razón nada",30,V+100),e.text("tendré que reclamar a futuro por este concepto.",30,V+110),e.text("_________________________________________",215,V+190),e.text("FIRMA EMPLEADO",270,V+205),e.save(n+"-"+a+".pdf")}(t)},(O=new XMLHttpRequest).onload=function(){var t=new FileReader;t.onloadend=function(){R(t.result)},t.readAsDataURL(O.response)},O.responseType="blob",O.open("GET",V,!0),O.send()}else alert("sin contenido para este periodo");function U(t){var e=220;return t.length<20?e+=30:e}})}else alert("sin contenido para este periodo")})},formatDate:function(){function t(t){return t<10?t="0"+t:t}var e=new Date,o=e.getDate(),a=e.getMonth()+1,r=e.getFullYear();return(o=t(o))+"/"+(a=t(a))+"/"+r},formatDate2:function(t){function e(t){return t<10?t="0"+t:t}var o=new Date(t),a=o.getDate(),r=o.getMonth()+1,n=o.getFullYear();return(a=e(a))+"/"+(r=e(r))+"/"+n},printVacation:function(t,e,o){var a=this,r="vacations/print/"+t+"/"+e+"/"+o+"/vacation",n=this.currency;axios.get(r).then(function(t){if(204===t.status)return alert("Sin contenido");var e=t.data.print,o=e[0],r=e[1],s=e[2],i=e[3],l=e[4],c=e[7],d=e[8],A=e[9],p=e[10],u=e[13],v="data:image/png;base64,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",m="data:image/png;base64,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",g="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAzCAYAAADVY1sUAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAL7SURBVHgB7VqLcdswDH3JdQB1AnODaAR1g25QdgNvEHcCuxM4nSDdQO4ETieQO4HTCVLBthoEESVApBKdz+8Od7QNgHgU+BFoYDzktZS17Gt5quW+FoeJIqvltpYv4nv63BCQInX9yYfDO6DAcbQpsApHQg1ytBPgUjD97OSDvl/jjQhlp854UB7tQXWJJO/F76MSakuXSujcop9EIwthW7X49kiMZSAYz3Qc9CRIaFD4U1kE9JZIAOqo7AjGMd05bETkU8kQXiC2eEnaTGLbEcRPoV/BTmQvfHQN2mAy254gPNMtYCfRSMH8+B7dLYxYKgJwTH+t0A/JivnJFPrqOeMVzuTIVAobbXr1ZQLJHD1wyqBWwuYpUmbM30pJ3vHAr1/yUB8VNqxdIB6fWPtBoU8pGEwxB/0I5sxOM4JjPeGihYd6wlqWTK3IObdX2pWNwQdm/OskfXgUn7/X8gNxkD6/ImIDvGAKuMJxcnmDDR1NmpWFJv1npEGM38NiQQaWick7GHJQDAnf5LzR1tM+UsAGPjFTTkjuawcbciJyg+FISWTG2o+wwRERBxsq1h5ribQSuRlCZIrIrnEeOBsih9OvNR8niXMhsiMimvM/x0eMg7+sbV0ND0T+wIaYjasLMRvt7yFPxKG981jEEHmg9xE6rDmLEWtvavmGNNiw9s7od4MLJoYr1vbQgXKZl0vpWB975orxeSe/oBf5IcUHTUFNXUQ4QVt8kPXnAwpDxzNml7oclBvs/pel+FlrE2LYAmtBrQ/ch4MOd+jo20H3WFOXTHPmb1DJtA2a9/CURexK+CoVNnMooRmVzKgfkjXzo7lWWMGIs7joIfRdvZVCX7tkdqXVfQ+J0e4RNbeyXcKvBtxYJDhCc2DBdLpuZUPimL1HojnRB4/Xq5Pc5RfQk5ABtvlWr05WOBw3otCkt/yFwzE7L35/s38SOTwToqB4/hboJ5ILfw35Emmu8sxwOKaITAGPMAnforvAhC92HJ6XU8p3Gu0cF3TjH2L2H0VgekrQAAAAAElFTkSuQmCC",x="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAmCAYAAACGeMg8AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAG6SURBVHgB7VnbcYMwEFwnDVCCPvPpEijBHYQO4s/84Q5MB6YDpwPSgd0BdIA7IJyRJhiONzIS4505PDDotCstOpCBf/h5xHlklsQlDw8VnA0l2yeIO96lqm/Yi488NhsUU7SF3UhISIYV4A0rwaqE/MJ+XOkgYFf94OqJUIqcPALDCXMRSu417A0k2xR7dEDAbKsRN7bunVHyWElMCCxOuhrEtWqlrbzeOlWmWC1t4PdVuuehwYlRLLCs1WLUreRIrlmTENVQMA2XWNUC8FaKmXsbk/iow0MxzboFpGC+NfBopd5ClNVEJZmAXqtdwDsi6mjXmZhIu6jjoEFEwPTjot/A9e7En9DJ2ME6DsgxedrpfMqncgR+pYwG5hk1eh7qOIzIxdWGHcYtKKNH8oj+S2MfKzkYZqXZhChCokKIzsOWNifoKbqTGlM0vT64KJ6dVEYE/oH+xDy1aXKCNqu1YaqVtAlRVvPQDRfzF9VZk6mIpKDyDDnyWqSjz2fsayXyV0AjXht0puElxDSQkBvsx42EXGE/fuhAL3rP+HzVFcRdKEUu7Nz/TSX3ex0pYwd7/r1KUFjq/oz/Ad4q72Jw+8N+AAAAAElFTkSuQmCC",f=a.formatDate(),y=void 0,C=void 0,h=void 0,F=void 0,D=void 0,E=void 0,I=void 0,b=void 0;switch(1==n?(I=e[5],b=e[6]):(I=e[11],b=e[12]),p){case"YELLOW":y=230,C=219,h=153,F=242,D=237,E=209;break;case"BLUE":y=113,C=160,h=228,F=160,D=229,E=251;break;default:y=255,C=255,h=255,F=255,D=255,E=255}function T(t){var e=220;return t.length<20?e+=30:e}var w,G,P,N=window.location.origin+"/"+i;w=N,G=function(t){!function(t){for(var a=new jsPDF("p","pt","letter"),i=1,p=155,w=0;w<e.length;w++)w>13&&(e[w].forEach(function(t){(p+=15)>720&&(i+=1,p=155)}),p+=20);if(a.setDrawColor(0),a.setFillColor(y,C,h),a.rect(30,25,550,20,"F"),a.addImage(t,"JPEG",35,50,85,60),a.setFont("helvetica"),a.setFontType("bold"),a.setFontSize(14),a.text("VACACIONES",260,40),a.setFontType("bold"),a.text(s,T(s),70),a.setFontSize(8.5),a.text("Rif: "+d,265,80),a.setFontType("normal"),4==A){a.addImage(m,"JPEG",260,92,9,9),a.addImage(g,"JPEG",304,103,9,9),a.addImage(x,"JPEG",179,103,9,8),a.text("+58 (247) 342-9544",270,100),a.text("info@riverovisualgroup.com",190,110),a.text("www.riverovisualgroup.com",315,110),a.setFontSize(7.5),a.setFontType("italic");var G=(new Date).getFullYear();a.text("© Copyright "+G+" Rivero Visual Group - All rights reserved ",210,760),a.setFontType("normal")}if(5==A){a.addImage(m,"JPEG",260,92,9,9),a.addImage(g,"JPEG",304,103,9,9),a.addImage(x,"JPEG",219,103,9,7),a.text("+58 (247) 342-9544",270,100),a.text("info@jdrivero.com       www.jdrivero.com",230,110),a.setFontType("italic"),a.setFontSize(7.5);var P=(new Date).getFullYear();a.text("© Copyright "+P+" JD Rivero Global - All rights reserved ",215,760),a.setFontType("normal")}a.addImage(v,"JPEG",181,82,11,9),a.text(c,195,90),a.setFontSize(7.5),a.text("Pagina:",515,760),a.text("1/"+i,545,760),a.setFontType("italic"),a.text("Designed By Rivero Visual Group",250,775),a.setFontType("normal"),a.setFontSize(7.5),a.setFontType("bold"),a.text("Fecha: ",435,80),a.text("Periodo: ",435,90),a.text("Tipo De Nomina:",435,100),a.text("Pais:",435,110),a.text("Generado Por:",435,70),a.text("Pagina:",435,60),a.setFontType("normal"),a.text("1/"+i,465,60),a.text(u,489,70),a.text(f,462,80),a.text(o,468,90),a.text(l,500,100),a.text(r,455,110),a.setFontSize(12),a.setFontType("normal"),a.setDrawColor(0),a.setFillColor(F,D,E),a.rect(30,117,550,20,"F"),a.setFontSize(8),a.setFontType("bold"),a.text("CODIGO",30,130),a.text("NOMBRE",76,130),a.text("CONCEPTO",195,130),a.text("CANTIDAD",315,130),a.text("ASIGNACION",385,130),a.text("DEDUCCION",453,130),a.text("NETO",545,130),a.setFontSize(7.5),a.setFontType("normal");var N=155,S=2,V=145,R=1;function O(t){var e=!(arguments.length>1&&void 0!==arguments[1])||arguments[1];return t=(t=parseFloat(t)).toFixed(2),e?"$"+t.toString().replace(/\D/g,"").replace(/([0-9])([0-9]{2})$/,"$1.$2").replace(/\B(?=(\d{3})+(?!\d)\.?)/g,","):"Bs"+t.toString().replace(/\D/g,"").replace(/([0-9])([0-9]{2})$/,"$1,$2").replace(/\B(?=(\d{3})+(?!\d)\.?)/g,".")}for(var Q=0;Q<e.length;Q++){var U=e;Q>13&&function(){var e=!0;U[Q].forEach(function(p){S%2==0&&(a.setDrawColor(0),a.setFillColor(F,D,E),a.rect(30,V,550,15,"F")),e&&(a.line(30,N-10,580,N-10),a.setFontType("bold"),a.text(p.staffCode,30,N),a.text(p.staffName,76,N),e=!1,a.setFontType("normal")),a.line(193,N-10,193,N+5),a.line(309,N-10,309,N+5),a.line(365,N-10,365,N+5),a.line(448,N-10,448,N+5),a.line(510,N-10,510,N+5),a.text(p.transactionTypeName,195,N),a.text(p.quantity,361,N,"right");var I=p.amount;if(!1===n&&(I=p.localAmount),1==p.isIncome&&(null==I||a.text(O(I,n),445,N,"right")),0==p.isIncome&&(null==I||a.text(O(I,n),508,N,"right")),V+=15,S+=1,(N+=15)>720){if(R+=1,a.addPage(),a.setDrawColor(0),a.setFillColor(y,C,h),a.rect(30,25,550,20,"F"),a.addImage(t,"JPEG",35,50,95,60),a.setFont("helvetica"),a.setFontType("bold"),a.setFontSize(14),a.text("VACACIONES",260,40),a.setFontType("bold"),a.text(s,T(s),70),a.setFontSize(8.5),a.text("Rif: "+d,265,80),a.setFontType("normal"),4==A){a.addImage(m,"JPEG",260,92,9,9),a.addImage(g,"JPEG",304,103,9,9),a.addImage(x,"JPEG",179,103,9,8),a.text("+58 (247) 342-9544",270,100),a.text("info@riverovisualgroup.com",190,110),a.text("www.riverovisualgroup.com",315,110),a.setFontSize(7.5),a.setFontType("italic");var b=(new Date).getFullYear();a.text("© Copyright "+b+" Rivero Visual Group - All rights reserved ",210,760),a.setFontType("normal")}if(5==A){a.addImage(m,"JPEG",260,92,9,9),a.addImage(g,"JPEG",304,103,9,9),a.addImage(x,"JPEG",219,103,9,7),a.text("+58 (247) 342-9544",270,100),a.text("info@jdrivero.com       www.jdrivero.com",230,110),a.setFontType("italic"),a.setFontSize(7.5);var w=(new Date).getFullYear();a.text("© Copyright "+w+" JD Rivero Global - All rights reserved ",215,760),a.setFontType("normal")}a.addImage(v,"JPEG",181,82,11,9),a.text(c,195,90),a.setFontSize(7.5),a.text("Pagina:",515,760),a.text(R+"/"+i,545,760),a.setFontType("italic"),a.text("Designed By Rivero Visual Group",250,775),a.setFontType("normal"),a.setFontSize(7.5),a.setFontType("bold"),a.text("Fecha: ",435,80),a.text("Periodo: ",435,90),a.text("Tipo De Nomina:",435,100),a.text("Pais:",435,110),a.text("Generado Por:",435,70),a.text("Pagina:",435,60),a.setFontType("normal"),a.text(R+"/"+i,465,60),a.text(u,489,70),a.text(f,462,80),a.text(o,468,90),a.text(l,500,100),a.text(r,455,110),a.setFontSize(12),a.setFontType("normal"),a.setDrawColor(0),a.setFillColor(F,D,E),a.rect(30,117,550,20,"F"),a.setFontSize(8),a.setFontType("bold"),a.text("CODIGO",30,130),a.text("NOMBRE",76,130),a.text("CONCEPTO",195,130),a.text("CANTIDAD",315,130),a.text("ASIGNACION",385,130),a.text("DEDUCCION",453,130),a.text("NETO",545,130),a.setFontSize(7.5),a.setFontType("normal"),N=155,V=145}}),S%2==0&&(a.setDrawColor(0),a.setFillColor(F,D,E),a.rect(30,V,550,15,"F")),a.setFontSize(7.5),a.line(365,N-10,365,N+5),a.line(448,N-10,448,N+5),a.line(510,N-10,510,N+5),a.setFontType("bold"),a.text("TOTALES",215,N);var p=void 0,I=void 0;!1===n?(p=U[Q][0].asignacionLocal,I=U[Q][0].deduccionLocal):(p=U[Q][0].asignacion,I=U[Q][0].deduccion),null===p?p=0:a.text(""+O(p,n),445,N,"right"),null===I?I=0:a.text(""+O(I,n),508,N,"right");var b=p-I;b<0?a.text("( "+O(b,n)+" )",578,N,"right"):a.text(""+O(b,n),578,N,"right"),a.setFontType("normal"),N+=20,V+=20,S+=1}()}a.setFontType("bold");var B=I-b;N+=5,a.text("TOTAL GENERAL:",215,N),a.text(" "+O(I,n),438,N,"right"),a.text(" "+O(b,n),508,N,"right"),a.text(" "+O(B,n),578,N,"right"),a.save(s+"-"+o+".pdf")}(t)},(P=new XMLHttpRequest).onload=function(){var t=new FileReader;t.onloadend=function(){G(t.result)},t.readAsDataURL(P.response)},P.responseType="blob",P.open("GET",w,!0),P.send()})}}}},714:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("div",{staticClass:"col-md-12"},[o("h2",{staticClass:"text-uppercase"},[t._v("Vacaciones")]),t._v(" "),o("div",{staticClass:"panel panel-default"},[o("div",{staticClass:"container"},[o("div",{staticClass:"row"},[t._m(0),t._v(" "),o("div",{staticClass:"col-md-2"},[o("label",{staticClass:"form-group",attrs:{for:"currency"},domProps:{textContent:t._s("Moneda")}}),t._v("   \n                        "),o("label",[o("input",{directives:[{name:"model",rawName:"v-model",value:t.currency,expression:"currency"}],attrs:{type:"radio",value:"1",id:"currency1"},domProps:{checked:t._q(t.currency,"1")},on:{change:function(e){t.currency="1"}}}),t._v(" USD   \n                        ")]),t._v(" "),o("label",[o("input",{directives:[{name:"model",rawName:"v-model",value:t.currency,expression:"currency"}],attrs:{type:"radio",value:"2",id:"currency2"},domProps:{checked:t._q(t.currency,"2")},on:{change:function(e){t.currency="2"}}}),t._v(" VEF \n                        ")])]),t._v(" "),o("div",{staticClass:"col-md-1"},[o("label",[o("button",{staticClass:"btn btn-sm btn-info",on:{click:function(e){return t.getListVacation()}}},[o("i",{staticClass:"fas fa-sync-alt"})])])]),t._v(" "),o("div",{staticClass:"col-md-3 col-md-offset-1"},[o("label",{attrs:{for:""}},[t._v("\n                            Seleccionar Empleado\n                            "),o("select",{directives:[{name:"model",rawName:"v-model",value:t.selectStaff,expression:"selectStaff"}],staticClass:"form-control",attrs:{required:"required",autocomplete:"off",id:"selectStaff"},on:{change:function(e){var o=Array.prototype.filter.call(e.target.options,function(t){return t.selected}).map(function(t){return"_value"in t?t._value:t.value});t.selectStaff=e.target.multiple?o:o[0]}}},[o("option",{attrs:{value:"",selected:""}}),t._v(" "),t._l(t.objSelectStaffs,function(e){return o("option",{key:e.staffCode,attrs:{countryId:e.countryId,companyId:e.companyId},domProps:{value:e.staffCode}},[t._v(t._s(e.staffCode)+" "+t._s(e.shortName))])})],2)])]),t._v(" "),o("div",{staticClass:"col-md-2"},[o("div",[o("label",{attrs:{for:""}},[t._v("\n                                Periodo Desde: "),o("input",{directives:[{name:"model",rawName:"v-model",value:t.fromDate,expression:"fromDate"}],staticClass:"form-control",attrs:{type:"date",required:"required"},domProps:{value:t.fromDate},on:{input:function(e){e.target.composing||(t.fromDate=e.target.value)}}})])])]),t._v(" "),o("div",{staticClass:"col-md-2"},[o("div",[o("label",{attrs:{for:""}},[t._v("\n                                Periodo Hasta: "),o("input",{directives:[{name:"model",rawName:"v-model",value:t.toDate,expression:"toDate"}],staticClass:"form-control",attrs:{type:"date",required:"required"},domProps:{value:t.toDate},on:{input:function(e){e.target.composing||(t.toDate=e.target.value)}}})])])]),t._v(" "),o("div",{staticClass:"col-md-1"},[o("label",{attrs:{for:""}},[t._v("  ")]),t._v(" "),o("button",{staticClass:"btn btn-sm btn-info",attrs:{type:"button"},on:{click:function(e){return t.printVacationByEmployee()}}},[o("i",{staticClass:"fa fa-print"}),t._v(" Imprimir")])]),t._v(" "),o("div",{staticClass:"col-md-2 col-md-offset-4"},[o("div",[o("label",{attrs:{for:""}},[t._v("\n                                Fecha Salida vac.: "),o("input",{directives:[{name:"model",rawName:"v-model",value:t.startVacation,expression:"startVacation"}],staticClass:"form-control",attrs:{type:"date",required:"required"},domProps:{value:t.startVacation},on:{input:function(e){e.target.composing||(t.startVacation=e.target.value)}}})])])]),t._v(" "),o("div",{staticClass:"col-md-2"},[o("div",[o("label",{attrs:{for:""}},[t._v("\n                                Fecha retorno vac.: "),o("input",{directives:[{name:"model",rawName:"v-model",value:t.endVacation,expression:"endVacation"}],staticClass:"form-control",attrs:{type:"date",required:"required"},domProps:{value:t.endVacation},on:{input:function(e){e.target.composing||(t.endVacation=e.target.value)}}})])])])])])]),t._v(" "),o("div",{staticClass:"panel panel-default"},[o("div",{staticClass:"table-responsive text-center"},[o("table",{staticClass:"table table-striped table-bordered text-center"},[t._m(1),t._v(" "),t.objVacation.length>0?o("tbody",t._l(t.objVacation,function(e,a){return o("tr",{key:e.hrpayrollControlId},[o("td",[t._v(t._s(a+1))]),t._v(" "),o("td",{staticClass:"form-inline"},[o("p",{staticClass:"text-left"},[t._v("\n                                    "+t._s(e.countryName)+"\n                                ")])]),t._v(" "),o("td",[o("p",{staticClass:"text-left"},[t._v("\n                                    "+t._s(e.companyName)+" \n                                ")])]),t._v(" "),o("td",[o("p",{staticClass:"text-left"},[t._v("\n                                    "+t._s(e.payrollTypeName)+"\n                                ")])]),t._v(" "),o("td",[t._v("\n                                "+t._s(e.year)+"\n                            ")]),t._v(" "),o("td",[o("p",{staticClass:"text-left"},[t._v("\n                                    "+t._s(e.payrollName)+" \n                                ")])]),t._v(" "),o("td",[o("button",{staticClass:"btn btn-sm btn-info",attrs:{type:"button"},on:{click:function(o){return t.printVacation(e.year,e.payrollNumber,e.payrollTypeId)}}},[o("i",{staticClass:"fa fa-print"}),t._v(" Imprimir")])])])}),0):o("tbody",[o("tr",[this.lengths?o("td",{attrs:{colspan:"9"}},[t._v("\n                                No hay datos registrados\n                            ")]):o("td",{attrs:{colspan:"9"}},[o("loading")],1)])])])])])])},staticRenderFns:[function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"form-group col-md-12"},[e("h4",{staticClass:"text-uppercase"},[this._v("Opciones de Filtrado")])])},function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("thead",[o("tr",[o("th",[t._v("N.")]),t._v(" "),o("th",[t._v("PAIS")]),t._v(" "),o("th",[t._v("EMPRESA")]),t._v(" "),o("th",[t._v("TIPO DE NOMINA")]),t._v(" "),o("th",[t._v("AÑO")]),t._v(" "),o("th",[t._v("PEROÍDO")]),t._v(" "),o("th",[t._v("Acciones")])])])}]}},715:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("div",[o(t.currentTabComponent,{tag:"component"}),t._v(" "),o("div",{staticClass:"form-group col-ms-12 col-md-12 col-lg-12 text-center"},["LisPreVacation"===t.currentComponent?o("button",{staticClass:"btn btn-success",attrs:{type:"button"},on:{click:function(e){t.currentComponent="AddPreVacation"}}},[o("span",{staticClass:"fa fa-plus"}),t._v(" Agregar")]):t._e(),t._v(" "),"AddPreVacation"===t.currentComponent?o("button",{staticClass:"btn btn-warning",attrs:{type:"button"},on:{click:function(e){t.currentComponent="LisPreVacation"}}},[o("span",{staticClass:"fa fa-plus"}),t._v(" Regresar")]):t._e()]),t._v(" "),o(t.currentComponentVacation,{tag:"component"})],1)},staticRenderFns:[]}},722:function(t,e,o){var a=o(1)(o(705),o(715),!1,function(t){o(703)},"data-v-bce89748",null);t.exports=a.exports}});
>>>>>>> module-rrhh
=======
});
>>>>>>> module-rrhh
