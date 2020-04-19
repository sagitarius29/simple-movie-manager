(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[10],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/series/CategoriesSeriesPage.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/series/CategoriesSeriesPage.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _components_FormDynamicComponent__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../components/FormDynamicComponent */ "./resources/js/components/FormDynamicComponent.vue");
/* harmony import */ var _components_ListPageComponent__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../components/ListPageComponent */ "./resources/js/components/ListPageComponent.vue");
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  name: "CategoriesSeriesPage",
  components: {
    FormDynamicComponent: _components_FormDynamicComponent__WEBPACK_IMPORTED_MODULE_0__["default"],
    ListPageComponent: _components_ListPageComponent__WEBPACK_IMPORTED_MODULE_1__["default"]
  },
  data: function data() {
    return {
      documentDefault: {
        name: null,
        order: null
      },
      tableFields: [{
        title: 'Orden',
        name: 'order'
      }, {
        title: 'Nombre',
        name: 'name'
      }, {
        title: 'Acciones',
        name: '__slot:actions'
      }]
    };
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/series/CategoriesSeriesPage.vue?vue&type=template&id=74a52fc1&scoped=true&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/series/CategoriesSeriesPage.vue?vue&type=template&id=74a52fc1&scoped=true& ***!
  \*************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "container" }, [
    _c("div", { staticClass: "row justify-content-center" }, [
      _c(
        "div",
        { staticClass: "col-md-8" },
        [
          _c("list-page-component", {
            ref: "listPage",
            attrs: {
              "header-title": "Lista de Categorias de Series",
              endpoint: "categories-series",
              "element-name": "Categoría",
              "element-default": _vm.documentDefault,
              "table-fields": _vm.tableFields
            },
            scopedSlots: _vm._u([
              {
                key: "storeupdate",
                fn: function(ref) {
                  var document = ref.document
                  var errors = ref.errors
                  return [
                    _c("form-dynamic-component", {
                      attrs: {
                        endpoint: "categories-series/form-schema",
                        document: document,
                        errors: errors
                      }
                    })
                  ]
                }
              },
              {
                key: "actionicon",
                fn: function(ref) {
                  var rowData = ref.rowData
                  return [
                    _c(
                      "router-link",
                      {
                        staticClass: "btn btn-outline-primary",
                        attrs: {
                          to: {
                            name: "categories.series",
                            params: { id: rowData.id }
                          },
                          title: "Lista de Series"
                        }
                      },
                      [_c("i", { staticClass: "fas fa-film" })]
                    )
                  ]
                }
              }
            ])
          })
        ],
        1
      )
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/pages/series/CategoriesSeriesPage.vue":
/*!************************************************************!*\
  !*** ./resources/js/pages/series/CategoriesSeriesPage.vue ***!
  \************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _CategoriesSeriesPage_vue_vue_type_template_id_74a52fc1_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CategoriesSeriesPage.vue?vue&type=template&id=74a52fc1&scoped=true& */ "./resources/js/pages/series/CategoriesSeriesPage.vue?vue&type=template&id=74a52fc1&scoped=true&");
/* harmony import */ var _CategoriesSeriesPage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CategoriesSeriesPage.vue?vue&type=script&lang=js& */ "./resources/js/pages/series/CategoriesSeriesPage.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _CategoriesSeriesPage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _CategoriesSeriesPage_vue_vue_type_template_id_74a52fc1_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _CategoriesSeriesPage_vue_vue_type_template_id_74a52fc1_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "74a52fc1",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/series/CategoriesSeriesPage.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/pages/series/CategoriesSeriesPage.vue?vue&type=script&lang=js&":
/*!*************************************************************************************!*\
  !*** ./resources/js/pages/series/CategoriesSeriesPage.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CategoriesSeriesPage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./CategoriesSeriesPage.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/series/CategoriesSeriesPage.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CategoriesSeriesPage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/series/CategoriesSeriesPage.vue?vue&type=template&id=74a52fc1&scoped=true&":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/pages/series/CategoriesSeriesPage.vue?vue&type=template&id=74a52fc1&scoped=true& ***!
  \*******************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CategoriesSeriesPage_vue_vue_type_template_id_74a52fc1_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./CategoriesSeriesPage.vue?vue&type=template&id=74a52fc1&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/series/CategoriesSeriesPage.vue?vue&type=template&id=74a52fc1&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CategoriesSeriesPage_vue_vue_type_template_id_74a52fc1_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CategoriesSeriesPage_vue_vue_type_template_id_74a52fc1_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);