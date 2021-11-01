<<<<<<< HEAD
webpackJsonp([5],{

/***/ 724:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(731)
/* template */
var __vue_template__ = __webpack_require__(732)
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

/***/ 731:
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

/***/ 732:
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
=======
webpackJsonp([5],{693:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={mounted:function(){console.log("Component mounted.")},props:{companys:{},parents:{}},data:function(){return{editMode:-1,num:1,parent:""}},methods:{deleteDepartment:function(t,e){var n=this;confirm("Delete?")&&axios.delete("departments/"+e).then(function(){n.$emit("delete",t)})},editDataDepartment:function(t,e){this.$emit("editData",e)},editDepartment:function(t){this.editMode=t},updateDepartment:function(t,e){var n=this,a={departmentName:e.departmentName},s="/departments/"+e.departmentId;axios.put(s,a).then(function(e){n.editMode=-1;var a=e.data;n.$emit("update",[t,a])}).catch(function(t){console.log(t)})}}}},694:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"col-md-10 col-md-offset-1"},[n("div",{staticClass:"panel panel-default"},[n("div",{staticClass:"table-responsive text-center"},[n("table",{staticClass:"table table-striped table-bordered text-center"},[t._m(0),t._v(" "),n("tbody",t._l(t.companys,function(e,a){return n("tr",{key:e.departmentId},[n("td",[t._v(t._s(a+1))]),t._v(" "),n("td",{staticClass:"form-inline"},[n("p",{staticClass:"text-left"},[t._v(" \n                                "+t._s(e.companyName)+"\n                            ")])]),t._v(" "),n("td",{staticClass:"form-inline"},[n("p",{staticClass:"text-left"},[t.editMode===a?n("button",{staticClass:"btn btn-sm btn-success",on:{click:function(n){return t.updateDepartment(a,e)}}},[n("i",{staticClass:"glyphicon glyphicon-ok"})]):t._e(),t._v("  \n                                "),t.editMode===a?n("input",{directives:[{name:"model",rawName:"v-model",value:e.departmentName,expression:"company.departmentName"}],staticClass:"form-control",attrs:{type:"text"},domProps:{value:e.departmentName},on:{input:function(n){n.target.composing||t.$set(e,"departmentName",n.target.value)}}}):n("a",{on:{click:function(e){return t.editDepartment(a)}}},[t._v(t._s(e.departmentName))])])]),t._v(" "),n("td",[n("p",{staticClass:"text-left"},[t._v("\n                                "+t._s(e.dpParentName)+"\n                            ")])]),t._v(" "),n("td",[n("button",{staticClass:"btn btn-sm btn-primary",attrs:{title:"Editar"},on:{click:function(n){return t.editDataDepartment(a,e.departmentId)}}},[n("i",{staticClass:"fa fa-edit"})]),t._v(" "),n("button",{staticClass:"btn btn-sm btn-danger",attrs:{title:"Eliminar"},on:{click:function(n){return t.deleteDepartment(a,e.departmentId)}}},[n("i",{staticClass:"fa fa-times-circle"})])])])}),0)])])])])},staticRenderFns:[function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("thead",[n("tr",[n("th",[t._v("N.")]),t._v(" "),n("th",[t._v("Empresa")]),t._v(" "),n("th",[t._v("Departamento")]),t._v(" "),n("th",[t._v("Departamento Padre")]),t._v(" "),n("th",[t._v("Acciones")])])])}]}},717:function(t,e,n){var a=n(1)(n(693),n(694),!1,null,null,null);t.exports=a.exports}});
>>>>>>> module-rrhh
