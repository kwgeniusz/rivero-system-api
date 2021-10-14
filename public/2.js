webpackJsonp([2],{

/***/ 726:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(752)
}
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(754)
/* template */
var __vue_template__ = __webpack_require__(758)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-36e01245"
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
Component.options.__file = "resources/assets/js/components/rrhh/vacations/Vacations.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-36e01245", Component.options)
  } else {
    hotAPI.reload("data-v-36e01245", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 752:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(753);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(3)("2b051618", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../../node_modules/css-loader/index.js!../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-36e01245\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Vacations.vue", function() {
     var newContent = require("!!../../../../../../node_modules/css-loader/index.js!../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-36e01245\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Vacations.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 753:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(2)(false);
// imports


// module
exports.push([module.i, "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n", ""]);

// exports


/***/ }),

/***/ 754:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__LisVacation_vue__ = __webpack_require__(755);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__LisVacation_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__LisVacation_vue__);
//
//
//
//
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
		LisVacation: __WEBPACK_IMPORTED_MODULE_0__LisVacation_vue___default.a
	},
	data: function data() {
		return {
			currentComponent: 'LisVacation'
		};
	},
	mounted: function mounted() {},

	computed: {
		currentTabComponent: function currentTabComponent() {
			return this.currentComponent;
		}
	},
	methods: {}
});

/***/ }),

/***/ 755:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(756)
/* template */
var __vue_template__ = __webpack_require__(757)
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
Component.options.__file = "resources/assets/js/components/rrhh/vacations/LisVacation.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-09421462", Component.options)
  } else {
    hotAPI.reload("data-v-09421462", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 756:
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

/* harmony default export */ __webpack_exports__["default"] = ({
    name: 'LisVacation',
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
                console.log(_this.objPreVacation);
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
                console.log(res);
                if (res.statusText === 'OK') {
                    if (transProcessed > 0) {
                        alert('Transacciones registradas: ' + transProcessed);
                    } else {
                        alert('No se registraron transacciones para este periodo..');
                    }

                    _this3.loading = false;
                } else {
                    alert('Error al calcular');
                    _this3.loading = false;
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
            var _this4 = this;

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

/***/ 757:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "col-md-12" }, [
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
    _vm._m(1)
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
    return _c("div", { staticClass: "panel panel-default" }, [
      _c("div", { staticClass: "table-responsive text-center" }, [
        _c(
          "table",
          { staticClass: "table table-striped table-bordered text-center" },
          [
            _c("thead", [
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
          ]
        )
      ])
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-09421462", module.exports)
  }
}

/***/ }),

/***/ 758:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [_c(_vm.currentTabComponent, { tag: "component" })], 1)
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-36e01245", module.exports)
  }
}

/***/ })

});