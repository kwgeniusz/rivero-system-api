webpackJsonp([0],{

/***/ 177:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(733)
/* template */
var __vue_template__ = __webpack_require__(734)
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
Component.options.__file = "resources/assets/js/components/rrhh/department/addDepartements.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-a9390a20", Component.options)
  } else {
    hotAPI.reload("data-v-a9390a20", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 733:
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

/* harmony default export */ __webpack_exports__["default"] = ({
    mounted: function mounted() {
        var _this = this;

        axios.get('departments/company').then(function (response) {
            _this.selectCompanys = response.data.map(function (item) {
                return { id: item.companyId, vText: item.companyName };
            });

            // console.log(this.selectCompanys)
        });

        axios.get("departments/parent").then(function (response) {
            _this.parents = response.data;

            // console.log(response.data)
        });

        if (this.editId > 0) {
            // departments
            axios.get("departments/edit/" + this.editId).then(function (response) {
                _this.parentsData = response.data;
                // console.log(this.parentsData)
                _this.selectCompany = document.querySelector("#selectCompani").value = _this.parentsData[0].companyId;
                _this.nameCompany = document.querySelector("#department_name").value = _this.parentsData[0].departmentName;
                _this.selectDepartmen = document.querySelector("#selectDepartmen").value = _this.parentsData[0].parentDepartmentId;
                _this.deparmetIds = _this.parentsData[0].departmentId;
                // console.log('deparmetIds ' +this.deparmetIds)
            });
        }
        console.log('Component mounted.');
        // console.log(editId)
        // console.log(this.editId)
    },
    data: function data() {
        var _ref;

        return _ref = {

            parents: [],
            parentsData: [],
            selectCompanys: [],
            selectCompany: 0,
            nameCompany: '',
            selectDepartmen: 0,
            bgcolor: ''
        }, _defineProperty(_ref, "selectCompany", ''), _defineProperty(_ref, "deparmetIds", ''), _defineProperty(_ref, "nameCompany", ''), _defineProperty(_ref, "selectDepartmen", ''), _ref;
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
    props: {
        editId: '',
        nameField1: '',
        nameField2: '',
        nameField3: ''
    },
    methods: {
        newCompany: function newCompany() {
            if (this.editId === 0) {
                var params = {
                    companyId: this.selectCompany,
                    departmentName: this.nameCompany,
                    parentDepartmentId: this.selectDepartmen
                };

                document.querySelector("#formDepartment").reset();

                axios.post('departments', params).then(function (response) {
                    // console.log(response)
                    // const department = response.data
                    alert("Success");

                    // este emit era utilizado para insertar datos en el array de la vista
                    // this.$emit('new', department)
                }).catch(function (error) {
                    alert("Faile");
                    console.log(error);
                });
            } else {
                var _params = {
                    companyId: this.selectCompany,
                    departmentName: this.nameCompany,
                    parentDepartmentId: this.selectDepartmen
                    // console.log(params)
                    // document.querySelector("#formDepartment").reset()
                };var url = 'departments/update/' + this.deparmetIds;
                // console.log( params)
                // console.log('la url es: '+ url)
                axios.put(url, _params).then(function (response) {
                    alert('Success');
                }).catch(function (error) {
                    console.log(error);
                });
            }
        },
        cancf: function cancf(n) {
            console.log('vista a mostrar: ' + n);
            this.$emit('showlist', 0);
        }
    }
});

/***/ }),

/***/ 734:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "row" }, [
    _c("div", { staticClass: "col-md-6 col-md-offset-3" }, [
      _c("div", { staticClass: "panel panel-default" }, [
        _vm.editId === 0
          ? _c("div", { staticClass: "panel-heading", style: _vm.addSuccess }, [
              _c("h4", { staticClass: "text-uppercase" }, [
                _vm._v("Agregar Departamento")
              ])
            ])
          : _c("div", { staticClass: "panel-heading", style: _vm.ediPrimary }, [
              _c("h4", { staticClass: "text-uppercase" }, [
                _vm._v("Actualizar Departamento")
              ])
            ]),
        _vm._v(" "),
        _c("div", { staticClass: "panel-body ", class: [_vm.bgcolor] }, [
          _c(
            "form",
            {
              staticClass: "form",
              attrs: { role: "form", id: "formDepartment" },
              on: {
                submit: function($event) {
                  $event.preventDefault()
                  return _vm.newCompany()
                }
              }
            },
            [
              _c("div", { staticClass: "form-group col-md-7" }, [
                _c("label", {
                  staticClass: "form-group",
                  attrs: { for: "selectCompani" },
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
                        value: _vm.selectCompany,
                        expression: "selectCompany"
                      }
                    ],
                    staticClass: "form-control",
                    attrs: { id: "selectCompani" },
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
                        _vm.selectCompany = $event.target.multiple
                          ? $$selectedVal
                          : $$selectedVal[0]
                      }
                    }
                  },
                  _vm._l(_vm.selectCompanys, function(item) {
                    return _c(
                      "option",
                      { key: item.id, domProps: { value: item.id } },
                      [_vm._v(_vm._s(item.vText))]
                    )
                  }),
                  0
                )
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "form-group col-md-9" }, [
                _c("label", {
                  staticClass: "form-group",
                  attrs: { for: "department_name" },
                  domProps: { textContent: _vm._s(_vm.nameField2) }
                }),
                _vm._v(" "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.nameCompany,
                      expression: "nameCompany"
                    }
                  ],
                  staticClass: "form-control",
                  attrs: {
                    type: "text",
                    id: "department_name",
                    name: "company",
                    placeholder: _vm.nameField2
                  },
                  domProps: { value: _vm.nameCompany },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.nameCompany = $event.target.value
                    }
                  }
                })
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "form-group col-md-7" }, [
                _c("label", {
                  staticClass: "form-group",
                  attrs: { for: "selectDepartmen" },
                  domProps: { textContent: _vm._s(_vm.nameField3) }
                }),
                _vm._v(" "),
                _c(
                  "select",
                  {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.selectDepartmen,
                        expression: "selectDepartmen"
                      }
                    ],
                    staticClass: "form-control",
                    attrs: { id: "selectDepartmen" },
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
                        _vm.selectDepartmen = $event.target.multiple
                          ? $$selectedVal
                          : $$selectedVal[0]
                      }
                    }
                  },
                  [
                    _c("option", { attrs: { value: "0", selected: "" } }, [
                      _vm._v("No")
                    ]),
                    _vm._v(" "),
                    _vm._l(_vm.parents, function(item) {
                      return _c(
                        "option",
                        {
                          key: item.departmentId,
                          domProps: { value: item.departmentId }
                        },
                        [_vm._v(" " + _vm._s(item.departmentName) + " ")]
                      )
                    })
                  ],
                  2
                )
              ]),
              _vm._v(" "),
              _vm.editId === 0
                ? _c(
                    "div",
                    [
                      _c("button-form", {
                        attrs: { buttonType: 1 },
                        on: { cancf: _vm.cancf }
                      })
                    ],
                    1
                  )
                : _vm._e(),
              _vm._v(" "),
              _vm.editId > 0
                ? _c(
                    "div",
                    [
                      _c("button-form", {
                        attrs: { buttonType: 2 },
                        on: { cancf: _vm.cancf }
                      })
                    ],
                    1
                  )
                : _vm._e()
            ]
          )
        ])
      ])
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-a9390a20", module.exports)
  }
}

/***/ })

});