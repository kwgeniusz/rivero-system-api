webpackJsonp([8],{

/***/ 646:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(876)
}
var normalizeComponent = __webpack_require__(0)
/* script */
var __vue_script__ = __webpack_require__(647)
/* template */
var __vue_template__ = __webpack_require__(878)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-4ce48cac"
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
Component.options.__file = "resources/assets/js/components/accounting/auxiliaryBook/main.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-4ce48cac", Component.options)
  } else {
    hotAPI.reload("data-v-4ce48cac", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 647:
/***/ (function(module, exports) {

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

//     export default {
//         mounted() {
//             axios.get(`/accounting/general-ledgers/${this.generalLedgerId}/auxiliaries`).then((response) => {
//                 this.auxiliaryList = response.data
//                 console.log(this.auxiliaryList)
//             })
//         },
//         props: {
//             generalLedgerId: { type: Number},
//         }, 
//         data() {
//             return{
//                 auxiliaryList: [],
//                 // parents: [],
//                 formStatus: 0,
//                 editId: '',
//             }
//         },
//         methods: {
//             addFormStatus(){
//                 this.formStatus = 1
//             },
//             editData(id){
//                 // console.log('el id es: ' + id)
//                 this.editId = id
//                 this.formStatus = 2
//             }, 
//             showlist(n){
//                 this.formStatus = 0
//                 axios.get('/accounting/auxiliary-books').then((response) => {
//                     this.auxiliaryList = response.data
//                     // console.log(this.auxiliaryList)
//                 })


//             },
//         }
//     }

//

/***/ }),

/***/ 876:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(877);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(3)("20006b03", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../../node_modules/css-loader/index.js!../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-4ce48cac\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./main.vue", function() {
     var newContent = require("!!../../../../../../node_modules/css-loader/index.js!../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-4ce48cac\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./main.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 877:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(2)(false);
// imports


// module
exports.push([module.i, "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n", ""]);

// exports


/***/ }),

/***/ 878:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "main" }, [
    _c(
      "div",
      [
        _c(
          "div",
          {
            staticClass: "form-group col-ms-12 col-md-12 col-lg-12 text-center"
          },
          [
            _vm.currentComponent === "TableAuxiliary"
              ? _c(
                  "button",
                  {
                    staticClass: "btn btn-success",
                    attrs: { type: "button" },
                    on: {
                      click: function($event) {
                        _vm.currentComponent = "AddUpAuxiliary"
                      }
                    }
                  },
                  [
                    _c("span", { staticClass: "fa fa-plus" }),
                    _vm._v(" Agregar")
                  ]
                )
              : _vm._e(),
            _vm._v(" "),
            _vm.currentComponent === "AddUpAuxiliary"
              ? _c(
                  "button",
                  {
                    staticClass: "btn btn-warning",
                    attrs: { type: "button" },
                    on: {
                      click: function($event) {
                        _vm.currentComponent = "TableAuxiliary"
                      }
                    }
                  },
                  [
                    _c("span", { staticClass: "fa fa-plus" }),
                    _vm._v(" Regresar")
                  ]
                )
              : _vm._e()
          ]
        ),
        _vm._v(" "),
        _c(_vm.currentTabComponent, { tag: "component" })
      ],
      1
    )
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-4ce48cac", module.exports)
  }
}

/***/ })

});