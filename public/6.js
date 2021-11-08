<<<<<<< HEAD
<<<<<<< HEAD
webpackJsonp([6],{

/***/ 723:
=======
webpackJsonp([6],{

/***/ 702:
>>>>>>> module-rrhh
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
<<<<<<< HEAD
var __vue_script__ = __webpack_require__(729)
/* template */
var __vue_template__ = __webpack_require__(730)
=======
var __vue_script__ = __webpack_require__(708)
/* template */
var __vue_template__ = __webpack_require__(709)
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

<<<<<<< HEAD
/***/ 729:
=======
/***/ 708:
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

<<<<<<< HEAD
/***/ 730:
=======
/***/ 709:
>>>>>>> module-rrhh
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

<<<<<<< HEAD
});
=======
webpackJsonp([6],{691:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={mounted:function(){var t=this;axios.get("departments").then(function(e){t.objCompanys=e.data})},data:function(){return{objCompanys:[],parents:[],formStatus:0,editId:"",nameField1:"EMPRESA",nameField2:"DEPARTAMENTO",nameField3:"DEPARTAMENTO PADRE"}},methods:{addFormStatus:function(){this.formStatus=1},addPepartment:function(t){},delDepartment:function(t){this.objCompanys.splice(t,1)},upDepartment:function(t){},carga:function(){XMLHttpRequest.onprogress=function(t){t.loaded,t.total}},editData:function(t){this.editId=t,this.formStatus=2},showlist:function(t){var e=this;this.formStatus=0,axios.get("departments").then(function(t){e.objCompanys=t.data})}}}},692:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"container"},[1===t.formStatus?n("div",[n("add-Departements",{attrs:{nameField1:t.nameField1,nameField2:t.nameField2,nameField3:t.nameField3,editId:0},on:{new:t.addPepartment,showlist:t.showlist}})],1):t._e(),t._v(" "),2===t.formStatus?n("div",[n("add-Departements",{attrs:{nameField1:t.nameField1,nameField2:t.nameField2,nameField3:t.nameField3,editId:t.editId},on:{new:t.addPepartment,showlist:t.showlist}})],1):t._e(),t._v(" "),0===t.formStatus?n("div",[t._m(0),t._v(" "),n("button-form",{attrs:{buttonType:0,btn4:0},on:{addf:t.addFormStatus}}),t._v(" "),n("rrhh-table-departments",{attrs:{companys:t.objCompanys,parents:t.parents},on:{update:function(e){return t.upDepartment.apply(void 0,arguments)},editData:t.editData,delete:t.delDepartment}})],1):t._e()])},staticRenderFns:[function(){var t=this.$createElement,e=this._self._c||t;return e("h3",[e("b",[this._v("DEPARTAMENTOS")])])}]}},716:function(t,e,n){var a=n(1)(n(691),n(692),!1,null,null,null);t.exports=a.exports}});
>>>>>>> module-rrhh
=======
});
>>>>>>> module-rrhh
