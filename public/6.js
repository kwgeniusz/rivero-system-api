webpackJsonp([6],{

/***/ 720:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(726)
/* template */
var __vue_template__ = __webpack_require__(727)
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
Component.options.__file = "resources/assets/js/components/rrhh/department/rrhhDepartments.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-626e472c", Component.options)
  } else {
    hotAPI.reload("data-v-626e472c", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 726:
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

/* harmony default export */ __webpack_exports__["default"] = ({
    mounted: function mounted() {
        var _this = this;

        axios.get('departments').then(function (response) {
            _this.objCompanys = response.data;
            // console.log(this.objCompanys)
        });
    },
    data: function data() {
        return {
            objCompanys: [],
            parents: [],
            formStatus: 0,
            editId: '',
            nameField1: 'EMPRESA',
            nameField2: 'DEPARTAMENTO',
            nameField3: 'DEPARTAMENTO PADRE'
        };
    },

    methods: {
        addFormStatus: function addFormStatus() {
            this.formStatus = 1;
        },
        addPepartment: function addPepartment(department) {
            // console.log(department)
            // this.objCompanys.push(department)
        },
        delDepartment: function delDepartment(index) {
            // console.log(index)
            this.objCompanys.splice(index, 1);
        },
        upDepartment: function upDepartment(company) {
            // console.log(company)
            // this.objCompanys[company[0]] = company[1]
        },
        carga: function carga() {
            XMLHttpRequest.onprogress = function (event) {
                event.loaded;
                event.total;
            };
        },
        editData: function editData(id) {
            // console.log('el id es: ' + id)
            this.editId = id;
            this.formStatus = 2;
        },
        showlist: function showlist(n) {
            var _this2 = this;

            this.formStatus = 0;
            axios.get('departments').then(function (response) {
                _this2.objCompanys = response.data;
                // console.log(this.objCompanys)
            });
        }
    }
});

/***/ }),

/***/ 727:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "container" }, [
    _vm.formStatus === 1
      ? _c(
          "div",
          [
            _c("add-Departements", {
              attrs: {
                nameField1: _vm.nameField1,
                nameField2: _vm.nameField2,
                nameField3: _vm.nameField3,
                editId: 0
              },
              on: { new: _vm.addPepartment, showlist: _vm.showlist }
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
            _c("add-Departements", {
              attrs: {
                nameField1: _vm.nameField1,
                nameField2: _vm.nameField2,
                nameField3: _vm.nameField3,
                editId: _vm.editId
              },
              on: { new: _vm.addPepartment, showlist: _vm.showlist }
            })
          ],
          1
        )
      : _vm._e(),
    _vm._v(" "),
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
            _c("rrhh-table-departments", {
              attrs: { companys: _vm.objCompanys, parents: _vm.parents },
              on: {
                update: function($event) {
                  return _vm.upDepartment.apply(void 0, arguments)
                },
                editData: _vm.editData,
                delete: _vm.delDepartment
              }
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
    return _c("h3", [_c("b", [_vm._v("DEPARTAMENTOS")])])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-626e472c", module.exports)
  }
}

/***/ })

});