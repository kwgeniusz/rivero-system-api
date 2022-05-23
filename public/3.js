webpackJsonp([3],{

/***/ 759:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(0)
/* script */
var __vue_script__ = __webpack_require__(770)
/* template */
var __vue_template__ = __webpack_require__(771)
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
Component.options.__file = "resources/assets/js/components/rrhh/payrolltype/listPayrollType.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-1a68cb19", Component.options)
  } else {
    hotAPI.reload("data-v-1a68cb19", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 770:
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

/* harmony default export */ __webpack_exports__["default"] = ({
    mounted: function mounted() {
        console.log('Component mounted.');
    },
    data: function data() {
        return {};
    },

    props: {
        namePanel: {
            type: String,
            default: 'Listado tipo de Nomina'
        },
        objPayRollType: {}
    },
    methods: {
        editPayrollType: function editPayrollType(index, id) {
            // paso solamente el index para pasar al formulario el objeto del indice seleccionado,
            // de esta manera no tengo que buscar los datos en la DB nuevamente
            this.$emit("indexEdit", index);
            // console.log('enviado')
        },
        deletePayrollType: function deletePayrollType(index, id) {
            var _this = this;

            // console.log(index)
            // const indexIs = this.objPayRollType[index]

            if (confirm("Delete?")) {
                axios.delete('payrolltypes/delete/' + id).then(function () {

                    _this.$emit("delPayrollType", [index, id]);
                }).catch(function (error) {
                    alert("Error");
                    console.log(error);
                });
            }

            // console.log('enviado')
        }
    }
});

/***/ }),

/***/ 771:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "col-md-8 col-md-offset-2" }, [
    _c("div", { staticClass: "panel panel-default" }, [
      _c("div", { staticClass: "table-responsive text-center" }, [
        _c(
          "table",
          { staticClass: "table table-striped table-bordered text-center" },
          [
            _vm._m(0),
            _vm._v(" "),
            _vm.objPayRollType.length > 0
              ? _c(
                  "tbody",
                  _vm._l(_vm.objPayRollType, function(payrollType, index) {
                    return _c("tr", { key: payrollType.payrollTypeId }, [
                      _c("td", [_vm._v(_vm._s(index + 1))]),
                      _vm._v(" "),
                      _c("td", { staticClass: "form-inline" }, [
                        _c("p", { staticClass: "text-left" }, [
                          _vm._v(
                            "\n                                " +
                              _vm._s(payrollType.payrollTypeName) +
                              " \n                            \n                            "
                          )
                        ])
                      ]),
                      _vm._v(" "),
                      _c("td", [
                        _c("p", { staticClass: "text-left" }, [
                          _vm._v(
                            "\n                                " +
                              _vm._s(payrollType.payrollTypeDescription) +
                              "\n                            "
                          )
                        ])
                      ]),
                      _vm._v(" "),
                      _c("td", [
                        _c("p", { staticClass: "text-left" }, [
                          _vm._v(
                            "\n                                " +
                              _vm._s(payrollType.countryName) +
                              "\n                            "
                          )
                        ])
                      ]),
                      _vm._v(" "),
                      _c("td", [
                        _c("p", { staticClass: "text-left" }, [
                          _vm._v(
                            "\n                                " +
                              _vm._s(payrollType.payrollCategory) +
                              "\n                            "
                          )
                        ])
                      ]),
                      _vm._v(" "),
                      _c("td", [
                        _c(
                          "button",
                          {
                            staticClass: "btn btn-sm btn-primary",
                            attrs: { title: "Editar" },
                            on: {
                              click: function($event) {
                                return _vm.editPayrollType(
                                  index,
                                  payrollType.payrollTypeId
                                )
                              }
                            }
                          },
                          [_c("i", { staticClass: "fa fa-edit" })]
                        ),
                        _vm._v(" "),
                        _c(
                          "button",
                          {
                            staticClass: "btn btn-sm btn-danger",
                            attrs: { title: "Eliminar" },
                            on: {
                              click: function($event) {
                                return _vm.deletePayrollType(
                                  index,
                                  payrollType.payrollTypeId
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
                    _c("td", { attrs: { colspan: "5" } }, [_c("loading")], 1)
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
    return _c("thead", [
      _c("tr", [
        _c("th", [_vm._v("N")]),
        _vm._v(" "),
        _c("th", [_vm._v("Nombre del tipo de nomina")]),
        _vm._v(" "),
        _c("th", [_vm._v("Descripcion del tipo de nomina")]),
        _vm._v(" "),
        _c("th", [_vm._v("Pais")]),
        _vm._v(" "),
        _c("th", [_vm._v("Categoria")]),
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
    require("vue-hot-reload-api")      .rerender("data-v-1a68cb19", module.exports)
  }
}

/***/ })

});