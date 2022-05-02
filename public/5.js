webpackJsonp([5],{

/***/ 748:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(0)
/* script */
var __vue_script__ = __webpack_require__(755)
/* template */
var __vue_template__ = __webpack_require__(756)
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
Component.options.__file = "resources/assets/js/components/rrhh/department/rrhhTableDepartaments.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-31137201", Component.options)
  } else {
    hotAPI.reload("data-v-31137201", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 755:
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

/* harmony default export */ __webpack_exports__["default"] = ({
    mounted: function mounted() {

        console.log('Component mounted.');
    },

    props: {
        companys: {},
        parents: {}
    },
    data: function data() {
        return {
            editMode: -1,
            num: 1,
            parent: ''
        };
    },

    methods: {
        deleteDepartment: function deleteDepartment(index, id) {
            var _this = this;

            // console.log('index 1: ' + index)
            if (confirm("Delete?")) {
                axios.delete('departments/' + id).then(function () {
                    _this.$emit('delete', index);
                });
            }
        },
        editDataDepartment: function editDataDepartment(index, id) {
            // console.log('index: '+index + ' id: '+ id)
            this.$emit('editData', id);
        },
        editDepartment: function editDepartment(index) {
            // console.log(id)
            this.editMode = index;
            // this.$emit('delete',index)
        },
        updateDepartment: function updateDepartment(index, company) {
            var _this2 = this;

            // console.log(company) companyId departmentId departmentName parentDepartmentId
            var params = {

                departmentName: company.departmentName
            };
            var url = '/departments/' + company.departmentId;

            axios.put(url, params).then(function (response) {
                // console.log(response)
                _this2.editMode = -1;
                // console.log(response)
                var company = response.data;
                _this2.$emit('update', [index, company]);
            }).catch(function (error) {
                console.log(error);
            });
        }
    }
});

/***/ }),

/***/ 756:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "col-md-10 col-md-offset-1" }, [
    _c("div", { staticClass: "panel panel-default" }, [
      _c("div", { staticClass: "table-responsive text-center" }, [
        _c(
          "table",
          { staticClass: "table table-striped table-bordered text-center" },
          [
            _vm._m(0),
            _vm._v(" "),
            _c(
              "tbody",
              _vm._l(_vm.companys, function(company, index) {
                return _c("tr", { key: company.departmentId }, [
                  _c("td", [_vm._v(_vm._s(index + 1))]),
                  _vm._v(" "),
                  _c("td", { staticClass: "form-inline" }, [
                    _c("p", { staticClass: "text-left" }, [
                      _vm._v(
                        " \n                                " +
                          _vm._s(company.companyName) +
                          "\n                            "
                      )
                    ])
                  ]),
                  _vm._v(" "),
                  _c("td", { staticClass: "form-inline" }, [
                    _c("p", { staticClass: "text-left" }, [
                      _vm.editMode === index
                        ? _c(
                            "button",
                            {
                              staticClass: "btn btn-sm btn-success",
                              on: {
                                click: function($event) {
                                  return _vm.updateDepartment(index, company)
                                }
                              }
                            },
                            [_c("i", { staticClass: "glyphicon glyphicon-ok" })]
                          )
                        : _vm._e(),
                      _vm._v("  \n                                "),
                      _vm.editMode === index
                        ? _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: company.departmentName,
                                expression: "company.departmentName"
                              }
                            ],
                            staticClass: "form-control",
                            attrs: { type: "text" },
                            domProps: { value: company.departmentName },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.$set(
                                  company,
                                  "departmentName",
                                  $event.target.value
                                )
                              }
                            }
                          })
                        : _c(
                            "a",
                            {
                              on: {
                                click: function($event) {
                                  return _vm.editDepartment(index)
                                }
                              }
                            },
                            [_vm._v(_vm._s(company.departmentName))]
                          )
                    ])
                  ]),
                  _vm._v(" "),
                  _c("td", [
                    _c("p", { staticClass: "text-left" }, [
                      _vm._v(
                        "\n                                " +
                          _vm._s(company.dpParentName) +
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
                            return _vm.editDataDepartment(
                              index,
                              company.departmentId
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
                            return _vm.deleteDepartment(
                              index,
                              company.departmentId
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
        _c("th", [_vm._v("N.")]),
        _vm._v(" "),
        _c("th", [_vm._v("Empresa")]),
        _vm._v(" "),
        _c("th", [_vm._v("Departamento")]),
        _vm._v(" "),
        _c("th", [_vm._v("Departamento Padre")]),
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
    require("vue-hot-reload-api")      .rerender("data-v-31137201", module.exports)
  }
}

/***/ })

});