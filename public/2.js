webpackJsonp([2],{

/***/ 722:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(732)
/* template */
var __vue_template__ = __webpack_require__(733)
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
Component.options.__file = "resources/assets/js/components/rrhh/payrolltype/mainPayrollType.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-53763c9e", Component.options)
  } else {
    hotAPI.reload("data-v-53763c9e", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 732:
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

/* harmony default export */ __webpack_exports__["default"] = ({
    mounted: function mounted() {
        var _this = this;

        axios.get('payrolltypes/').then(function (response) {
            _this.objPayRollType = response.data;
            console.log(_this.objPayRollType);
        });

        console.log('Component mounted.');
    },
    data: function data() {
        return {
            objPayRollType: [],
            objEdit: [],
            formStatus: 0,
            namePanel: "AGREGAR TIPO DE NÓMINA",
            namePanel2: "EDITAR TIPO DE NÓMINA",
            nameField1: "PAÍS",
            nameField2: "NOMBRE EL TIPO DE NÓMINA",
            nameField3: "DESCRIPCIÓN DEL TIPO DE NÓMINA"

        };
    },

    methods: {
        addFormStatus: function addFormStatus() {
            this.formStatus = 1;
        },
        showlist: function showlist() {
            var _this2 = this;

            this.formStatus = 0;
            axios.get('payrolltypes/').then(function (response) {
                _this2.objPayRollType = response.data;
                // console.log(this.objPayRollType)
            });
        },
        newObj: function newObj(payrollType) {
            // console.log(payrollType)
            this.objPayRollType.push(payrollType);
        },
        indexEdit: function indexEdit(index) {
            this.formStatus = 2;
            // console.log('recibido')
            this.objEdit = this.objPayRollType[index];
            // console.log( this.objEdit)
        },
        delPayrollType: function delPayrollType(indexId) {
            this.objPayRollType.splice(indexId[0], 1);

            // console.log(indexId)
        }
    }
});

/***/ }),

/***/ 733:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _vm.formStatus === 0
      ? _c(
          "div",
          [
            _vm._m(0),
            _vm._v(" "),
            _c("button-form", {
              attrs: { buttonType: 0, btn4: 0 },
              on: { addf: _vm.addFormStatus }
            }),
            _vm._v(" "),
            _c("listpayroll-type", {
              attrs: { objPayRollType: _vm.objPayRollType },
              on: {
                indexEdit: _vm.indexEdit,
                delPayrollType: _vm.delPayrollType
              }
            })
          ],
          1
        )
      : _vm._e(),
    _vm._v(" "),
    _vm.formStatus === 1
      ? _c(
          "div",
          [
            _c("AddUp-Payroll-Type", {
              attrs: {
                namePanel: _vm.namePanel,
                nameField1: _vm.nameField1,
                nameField2: _vm.nameField2,
                nameField3: _vm.nameField3
              },
              on: { showlist: _vm.showlist, newObj: _vm.newObj }
            })
          ],
          1
        )
      : _vm._e(),
    _vm._v(" "),
    _vm.formStatus === 2
      ? _c(
          "div",
          [
            _c("AddUp-Payroll-Type", {
              attrs: {
                namePanel2: _vm.namePanel2,
                nameField1: _vm.nameField1,
                nameField2: _vm.nameField2,
                nameField3: _vm.nameField3,
                objEdit: _vm.objEdit,
                editId: 1
              },
              on: { showlist: _vm.showlist, newObj: _vm.newObj }
            })
          ],
          1
        )
      : _vm._e()
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("h3", [_c("b", [_vm._v("TIPO DE NOMINA")])])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-53763c9e", module.exports)
  }
}

/***/ })

});