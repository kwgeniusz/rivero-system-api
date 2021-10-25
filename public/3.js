<<<<<<< HEAD
webpackJsonp([3],{

/***/ 723:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(734)
/* template */
var __vue_template__ = __webpack_require__(735)
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

/***/ 734:
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

/***/ 735:
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
=======
webpackJsonp([3],{699:function(t,e,l){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={mounted:function(){console.log("Component mounted.")},data:function(){return{}},props:{namePanel:{type:String,default:"Listado tipo de Nomina"},objPayRollType:{}},methods:{editPayrollType:function(t,e){this.$emit("indexEdit",t)},deletePayrollType:function(t,e){var l=this;confirm("Delete?")&&axios.delete("payrolltypes/delete/"+e).then(function(){l.$emit("delPayrollType",[t,e])}).catch(function(t){alert("Error"),console.log(t)})}}}},700:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,l=t._self._c||e;return l("div",{staticClass:"col-md-8 col-md-offset-2"},[l("div",{staticClass:"panel panel-default"},[l("div",{staticClass:"table-responsive text-center"},[l("table",{staticClass:"table table-striped table-bordered text-center"},[t._m(0),t._v(" "),t.objPayRollType.length>0?l("tbody",t._l(t.objPayRollType,function(e,n){return l("tr",{key:e.payrollTypeId},[l("td",[t._v(t._s(n+1))]),t._v(" "),l("td",{staticClass:"form-inline"},[l("p",{staticClass:"text-left"},[t._v("\n                                "+t._s(e.payrollTypeName)+" \n                            \n                            ")])]),t._v(" "),l("td",[l("p",{staticClass:"text-left"},[t._v("\n                                "+t._s(e.payrollTypeDescription)+"\n                            ")])]),t._v(" "),l("td",[l("p",{staticClass:"text-left"},[t._v("\n                                "+t._s(e.countryName)+"\n                            ")])]),t._v(" "),l("td",[l("p",{staticClass:"text-left"},[t._v("\n                                "+t._s(e.payrollCategory)+"\n                            ")])]),t._v(" "),l("td",[l("button",{staticClass:"btn btn-sm btn-primary",attrs:{title:"Editar"},on:{click:function(l){return t.editPayrollType(n,e.payrollTypeId)}}},[l("i",{staticClass:"fa fa-edit"})]),t._v(" "),l("button",{staticClass:"btn btn-sm btn-danger",attrs:{title:"Eliminar"},on:{click:function(l){return t.deletePayrollType(n,e.payrollTypeId)}}},[l("i",{staticClass:"fa fa-times-circle"})])])])}),0):l("tbody",[l("tr",[l("td",{attrs:{colspan:"5"}},[l("loading")],1)])])])])])])},staticRenderFns:[function(){var t=this,e=t.$createElement,l=t._self._c||e;return l("thead",[l("tr",[l("th",[t._v("N")]),t._v(" "),l("th",[t._v("Nombre del tipo de nomina")]),t._v(" "),l("th",[t._v("Descripcion del tipo de nomina")]),t._v(" "),l("th",[t._v("Pais")]),t._v(" "),l("th",[t._v("Categoria")]),t._v(" "),l("th",[t._v("Acciones")])])])}]}},720:function(t,e,l){var n=l(1)(l(699),l(700),!1,null,null,null);t.exports=n.exports}});
>>>>>>> module-rrhh
