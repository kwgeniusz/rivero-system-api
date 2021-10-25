<<<<<<< HEAD
webpackJsonp([4],{

/***/ 724:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(736)
/* template */
var __vue_template__ = __webpack_require__(737)
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
Component.options.__file = "resources/assets/js/components/rrhh/payrolltype/AddUpPayrollType.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-3ae92ffb", Component.options)
  } else {
    hotAPI.reload("data-v-3ae92ffb", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 736:
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

/* harmony default export */ __webpack_exports__["default"] = ({
    mounted: function mounted() {
        if (this.editId > 0) {
            this.payrollTypeName = this.objEdit.payrollTypeName;
            this.payrollTypeDescription = this.objEdit.payrollTypeDescription;
            this.payrollCategory = this.objEdit.payrollCategory;
        }

        console.log('Component mounted.');
    },
    data: function data() {
        return {
            payrollTypeName: '',
            payrollTypeDescription: '',
            payrollCategory: 'payroll'
        };
    },

    props: {
        namePanel: {
            type: String,
            default: 'Name Defauld'
        },
        namePanel2: {
            type: String,
            default: 'Name Defauld'
        },
        editId: {
            type: Number,
            default: 0
        },
        nameField1: {
            type: String,
            default: 'Name Defauld'
        },
        nameField2: {
            type: String,
            default: 'Name Defauld'
        },
        nameField3: {
            type: String,
            default: 'Name Defauld'
        },
        nameField4: {
            type: String,
            default: 'Usado Para calcular'
        },
        objEdit: {}

    },
    methods: {
        newPayrollType: function newPayrollType() {

            if (this.editId === 0) {

                var params = {
                    payrollTypeName: this.payrollTypeName,
                    payrollTypeDescription: this.payrollTypeDescription,
                    payrollCategory: this.payrollCategory
                    // document.querySelector("#form-payroll-type").reset()

                };axios.post('payrolltypes/post', params).then(function (response) {
                    if (response.statusText == "OK") {
                        alert("Success");
                    } else {
                        alert("Error");
                    }
                }).catch(function (error) {
                    // alert("Faile")
                    console.log(error);
                });
            } else {
                var _params = {
                    payrollTypeName: this.payrollTypeName,
                    payrollTypeDescription: this.payrollTypeDescription,
                    payrollCategory: this.payrollCategory
                    // document.querySelector("#form-payroll-type").reset()

                };var url = 'payrolltypes/put/' + this.objEdit.payrollTypeId;
                axios.put(url, _params).then(function (response) {
                    if (response.statusText == "OK") {
                        alert("Success");
                    } else {
                        alert("Error");
                    }
                }).catch(function (error) {
                    // alert("Faile")
                    console.log(error);
                });
            }
        },
        cancf: function cancf() {
            this.$emit('showlist', 0);
        }
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

    }
});

/***/ }),

/***/ 737:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "container" }, [
    _c("div", { staticClass: "row" }, [
      _c("div", { staticClass: "col-md-6 col-md-offset-3" }, [
        _c("div", { staticClass: "panel panel-default" }, [
          _vm.editId === 0
            ? _c(
                "div",
                { staticClass: "panel-heading", style: _vm.addSuccess },
                [
                  _c("h4", { staticClass: "text-uppercase" }, [
                    _vm._v(_vm._s(_vm.namePanel))
                  ])
                ]
              )
            : _c(
                "div",
                { staticClass: "panel-heading", style: _vm.ediPrimary },
                [
                  _c("h4", { staticClass: "text-uppercase" }, [
                    _vm._v(_vm._s(_vm.namePanel2))
                  ])
                ]
              ),
          _vm._v(" "),
          _c("div", { staticClass: "panel-body" }, [
            _c(
              "form",
              {
                staticClass: "form",
                attrs: { role: "form", id: "form-payroll-type" },
                on: {
                  submit: function($event) {
                    $event.preventDefault()
                    return _vm.newPayrollType()
                  }
                }
              },
              [
                _c("div", { staticClass: "form-group col-md-8" }, [
                  _c("label", {
                    staticClass: "form-group",
                    attrs: { for: "payrollTypeName" },
                    domProps: { textContent: _vm._s(_vm.nameField2) }
                  }),
                  _vm._v(" "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.payrollTypeName,
                        expression: "payrollTypeName"
                      }
                    ],
                    staticClass: "form-control",
                    attrs: {
                      type: "text",
                      id: "payrollTypeName",
                      placeholder: _vm.nameField2,
                      required: "required"
                    },
                    domProps: { value: _vm.payrollTypeName },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.payrollTypeName = $event.target.value
                      }
                    }
                  })
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "form-group col-md-9" }, [
                  _c("label", {
                    staticClass: "form-group",
                    attrs: { for: "payrollTypeDescription" },
                    domProps: { textContent: _vm._s(_vm.nameField3) }
                  }),
                  _c("br"),
                  _vm._v(" "),
                  _c("textarea", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.payrollTypeDescription,
                        expression: "payrollTypeDescription"
                      }
                    ],
                    staticClass: "form-control",
                    attrs: {
                      rows: "1",
                      id: "payrollTypeDescription",
                      required: "required"
                    },
                    domProps: { value: _vm.payrollTypeDescription },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.payrollTypeDescription = $event.target.value
                      }
                    }
                  })
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
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-3ae92ffb", module.exports)
  }
}

/***/ })

});
=======
webpackJsonp([4],{701:function(e,t,a){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default={mounted:function(){this.editId>0&&(this.payrollTypeName=this.objEdit.payrollTypeName,this.payrollTypeDescription=this.objEdit.payrollTypeDescription,this.payrollCategory=this.objEdit.payrollCategory),console.log("Component mounted.")},data:function(){return{payrollTypeName:"",payrollTypeDescription:"",payrollCategory:"payroll"}},props:{namePanel:{type:String,default:"Name Defauld"},namePanel2:{type:String,default:"Name Defauld"},editId:{type:Number,default:0},nameField1:{type:String,default:"Name Defauld"},nameField2:{type:String,default:"Name Defauld"},nameField3:{type:String,default:"Name Defauld"},nameField4:{type:String,default:"Usado Para calcular"},objEdit:{}},methods:{newPayrollType:function(){if(0===this.editId){var e={payrollTypeName:this.payrollTypeName,payrollTypeDescription:this.payrollTypeDescription,payrollCategory:this.payrollCategory};axios.post("payrolltypes/post",e).then(function(e){"OK"==e.statusText?alert("Success"):alert("Error")}).catch(function(e){console.log(e)})}else{var t={payrollTypeName:this.payrollTypeName,payrollTypeDescription:this.payrollTypeDescription,payrollCategory:this.payrollCategory},a="payrolltypes/put/"+this.objEdit.payrollTypeId;axios.put(a,t).then(function(e){"OK"==e.statusText?alert("Success"):alert("Error")}).catch(function(e){console.log(e)})}},cancf:function(){this.$emit("showlist",0)}},computed:{addSuccess:function(){return{background:"#dff0d8"}},ediPrimary:function(){return{background:"#d9edf7"}}}}},702:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"container"},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-6 col-md-offset-3"},[a("div",{staticClass:"panel panel-default"},[0===e.editId?a("div",{staticClass:"panel-heading",style:e.addSuccess},[a("h4",{staticClass:"text-uppercase"},[e._v(e._s(e.namePanel))])]):a("div",{staticClass:"panel-heading",style:e.ediPrimary},[a("h4",{staticClass:"text-uppercase"},[e._v(e._s(e.namePanel2))])]),e._v(" "),a("div",{staticClass:"panel-body"},[a("form",{staticClass:"form",attrs:{role:"form",id:"form-payroll-type"},on:{submit:function(t){return t.preventDefault(),e.newPayrollType()}}},[a("div",{staticClass:"form-group col-md-8"},[a("label",{staticClass:"form-group",attrs:{for:"payrollTypeName"},domProps:{textContent:e._s(e.nameField2)}}),e._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:e.payrollTypeName,expression:"payrollTypeName"}],staticClass:"form-control",attrs:{type:"text",id:"payrollTypeName",placeholder:e.nameField2,required:"required"},domProps:{value:e.payrollTypeName},on:{input:function(t){t.target.composing||(e.payrollTypeName=t.target.value)}}})]),e._v(" "),a("div",{staticClass:"form-group col-md-9"},[a("label",{staticClass:"form-group",attrs:{for:"payrollTypeDescription"},domProps:{textContent:e._s(e.nameField3)}}),a("br"),e._v(" "),a("textarea",{directives:[{name:"model",rawName:"v-model",value:e.payrollTypeDescription,expression:"payrollTypeDescription"}],staticClass:"form-control",attrs:{rows:"1",id:"payrollTypeDescription",required:"required"},domProps:{value:e.payrollTypeDescription},on:{input:function(t){t.target.composing||(e.payrollTypeDescription=t.target.value)}}})]),e._v(" "),0===e.editId?a("div",[a("button-form",{attrs:{buttonType:1},on:{cancf:e.cancf}})],1):e._e(),e._v(" "),e.editId>0?a("div",[a("button-form",{attrs:{buttonType:2},on:{cancf:e.cancf}})],1):e._e()])])])])])])},staticRenderFns:[]}},721:function(e,t,a){var l=a(1)(a(701),a(702),!1,null,null,null);e.exports=l.exports}});
>>>>>>> module-rrhh
