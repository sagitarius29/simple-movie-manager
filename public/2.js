(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[2],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/inputs/DynamicSelect.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/inputs/DynamicSelect.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue_select__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-select */ "./node_modules/vue-select/dist/vue-select.js");
/* harmony import */ var vue_select__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_select__WEBPACK_IMPORTED_MODULE_0__);
//
//
//
//
//
//
//
//
//
//
//
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
  name: "DynamicSelect",
  components: {
    vSelect: vue_select__WEBPACK_IMPORTED_MODULE_0___default.a
  },
  props: {
    value: {
      "default": null
    },
    loadResourceOnSelect: {
      "default": true
    },
    placeholder: {
      "default": ''
    },
    config: {
      "default": function _default() {
        return {};
      }
    }
  },
  data: function data() {
    return {
      defaultConfig: {
        endpoint: null,
        valueField: 'value',
        nameField: 'name',
        multiple: false,
        loadIfSelect: true
      },
      selected: '',
      selectedObject: null,
      options: []
    };
  },
  mounted: function mounted() {
    this.defaultConfig = _.defaults(this.config, this.defaultConfig);

    if (this.defaultConfig.multiple) {
      this.defaultConfig.loadIfSelect = false;
    }

    if (this.value !== null && this.selected === '') {
      this.getDocumentInfo(this.value);
    }

    this.loadOptions();
  },
  watch: {
    value: function value(val) {
      if (val === null) {
        this.selected = '';
      } else {
        this.getDocumentInfo(val);
      }
    }
  },
  methods: {
    onSearch: function onSearch(search, loading) {
      loading(true);
      this.search(loading, search, this);
    },
    search: _.debounce(function (loading, search, vm) {
      axios.get(vm.defaultConfig.endpoint + '?search=' + search, {
        noloading: true
      }).then(function (_ref) {
        var data = _ref.data;
        vm.options = data.data;
        loading(false);
      });
    }, 350),
    loadOptions: function loadOptions() {
      var _this = this;

      axios.get(this.defaultConfig.endpoint).then(function (r) {
        _this.options = r.data.data;
      });
    },
    setSelected: function setSelected(object) {
      console.log('select ', object);

      if (object !== null) {
        var val;

        if (!this.defaultConfig.multiple) {
          val = object[this.defaultConfig.valueField];
          this.selected = object[this.defaultConfig.nameField];
          this.selectedObject = object;
        } else {
          val = object;
          this.selected = object;
          this.selectedObject = object;
        }

        this.$emit('input', val);
        this.$emit('onSelected', object);
      } else {
        this.$emit('onReset', this.selectedObject);
        this.$emit('input', '');
        this.selected = '';
        this.selectedObject = null;
      }
    },
    getDocumentInfo: function getDocumentInfo(id) {
      var _this2 = this;

      if (id === '' || id === null) {
        return false;
      }

      if (this.defaultConfig.loadIfSelect !== undefined && !this.defaultConfig.loadIfSelect) {
        return false;
      }

      axios.get(this.defaultConfig.endpoint + '/' + id).then(function (r) {
        _this2.selected = r.data[_this2.defaultConfig.nameField];
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/series/SeriesPage.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/series/SeriesPage.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _components_FormDynamicComponent__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../components/FormDynamicComponent */ "./resources/js/components/FormDynamicComponent.vue");
/* harmony import */ var _components_ListPageComponent__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../components/ListPageComponent */ "./resources/js/components/ListPageComponent.vue");
/* harmony import */ var _components_inputs_DynamicSelect__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../components/inputs/DynamicSelect */ "./resources/js/components/inputs/DynamicSelect.vue");
/* harmony import */ var _components_inputs_ImageUploadInput__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../components/inputs/ImageUploadInput */ "./resources/js/components/inputs/ImageUploadInput.vue");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  name: "SeriesPage",
  components: {
    ImageUploadInput: _components_inputs_ImageUploadInput__WEBPACK_IMPORTED_MODULE_3__["default"],
    DynamicSelect: _components_inputs_DynamicSelect__WEBPACK_IMPORTED_MODULE_2__["default"],
    FormDynamicComponent: _components_FormDynamicComponent__WEBPACK_IMPORTED_MODULE_0__["default"],
    ListPageComponent: _components_ListPageComponent__WEBPACK_IMPORTED_MODULE_1__["default"]
  },
  data: function data() {
    return {
      categoryName: null,
      documentDefault: {
        name: null,
        url: null,
        cover: null
      },
      tableFields: [{
        title: 'Cover',
        name: 'cover',
        callback: function callback(value) {
          return '<img src="' + value + '" style="max-width: 150px;">';
        }
      }, {
        title: 'Nombre',
        name: 'name'
      }, {
        title: 'Acciones',
        name: '__slot:actions'
      }]
    };
  },
  mounted: function mounted() {
    this.loadCategory();
  },
  methods: {
    loadCategory: function loadCategory() {
      var _this = this;

      axios.get('/categories-series/' + this.$route.params.id).then(function (_ref) {
        var data = _ref.data;
        _this.categoryName = data.name;
      });
    },
    selectSerie: function selectSerie(document, serie) {
      document.cover = serie.cover;
      document.name = serie.name;
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/inputs/DynamicSelect.vue?vue&type=template&id=450e0ac0&scoped=true&":
/*!***********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/inputs/DynamicSelect.vue?vue&type=template&id=450e0ac0&scoped=true& ***!
  \***********************************************************************************************************************************************************************************************************************************/
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
  return _c(
    "div",
    [
      _c(
        "v-select",
        {
          attrs: {
            value: _vm.selected,
            multiple: _vm.config.multiple,
            options: _vm.options,
            label: _vm.config.nameField,
            placeholder: _vm.placeholder,
            filterable: false
          },
          on: { input: _vm.setSelected, search: _vm.onSearch },
          scopedSlots: _vm._u(
            [
              {
                key: "option",
                fn: function(option) {
                  return [
                    _vm._t(
                      "option",
                      [
                        _vm._v(
                          "\n                " +
                            _vm._s(option[_vm.config.nameField]) +
                            "\n            "
                        )
                      ],
                      { option: option }
                    )
                  ]
                }
              }
            ],
            null,
            true
          )
        },
        [
          _vm._v(" "),
          _c("div", { attrs: { slot: "no-options" }, slot: "no-options" }, [
            _vm._v("No se han encontrado resultados.")
          ])
        ]
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/series/SeriesPage.vue?vue&type=template&id=a4f4c976&scoped=true&":
/*!***************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/series/SeriesPage.vue?vue&type=template&id=a4f4c976&scoped=true& ***!
  \***************************************************************************************************************************************************************************************************************************/
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
              "header-title": "Lista de Series: " + _vm.categoryName,
              endpoint: "categories-series/" + _vm.$route.params.id + "/series",
              "element-name": "Serie",
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
                    _c(
                      "div",
                      { staticClass: "form-group" },
                      [
                        _c("label", [_vm._v("Serie existente (Opcional)")]),
                        _vm._v(" "),
                        _c("dynamic-select", {
                          attrs: {
                            config: {
                              endpoint: "series",
                              nameField: "name",
                              valueField: "id"
                            }
                          },
                          on: {
                            onSelected: function($event) {
                              return _vm.selectSerie(document, $event)
                            }
                          },
                          model: {
                            value: document.id,
                            callback: function($$v) {
                              _vm.$set(document, "id", $$v)
                            },
                            expression: "document.id"
                          }
                        })
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c("div", { staticClass: "form-group" }, [
                      _c("label", [_vm._v("Cover URL")]),
                      _vm._v(" "),
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: document.cover,
                            expression: "document.cover"
                          }
                        ],
                        staticClass: "form-control",
                        attrs: { type: "text" },
                        domProps: { value: document.cover },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(document, "cover", $event.target.value)
                          }
                        }
                      })
                    ]),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "form-group" },
                      [
                        _c("label", [_vm._v("Cover Imagen")]),
                        _vm._v(" "),
                        _c("image-upload-input", {
                          attrs: { private: 0 },
                          model: {
                            value: document.cover,
                            callback: function($$v) {
                              _vm.$set(document, "cover", $$v)
                            },
                            expression: "document.cover"
                          }
                        })
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c("div", { staticClass: "form-group" }, [
                      _c("label", [_vm._v("Nombre")]),
                      _vm._v(" "),
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: document.name,
                            expression: "document.name"
                          }
                        ],
                        staticClass: "form-control",
                        attrs: { type: "text" },
                        domProps: { value: document.name },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(document, "name", $event.target.value)
                          }
                        }
                      })
                    ])
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
                            name: "series.seasons",
                            params: {
                              id: rowData.id,
                              cat_id: _vm.$route.params.id
                            }
                          },
                          title: "Lista de Temporadas"
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

/***/ "./resources/js/components/inputs/DynamicSelect.vue":
/*!**********************************************************!*\
  !*** ./resources/js/components/inputs/DynamicSelect.vue ***!
  \**********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _DynamicSelect_vue_vue_type_template_id_450e0ac0_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./DynamicSelect.vue?vue&type=template&id=450e0ac0&scoped=true& */ "./resources/js/components/inputs/DynamicSelect.vue?vue&type=template&id=450e0ac0&scoped=true&");
/* harmony import */ var _DynamicSelect_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./DynamicSelect.vue?vue&type=script&lang=js& */ "./resources/js/components/inputs/DynamicSelect.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _DynamicSelect_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _DynamicSelect_vue_vue_type_template_id_450e0ac0_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _DynamicSelect_vue_vue_type_template_id_450e0ac0_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "450e0ac0",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/inputs/DynamicSelect.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/inputs/DynamicSelect.vue?vue&type=script&lang=js&":
/*!***********************************************************************************!*\
  !*** ./resources/js/components/inputs/DynamicSelect.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_DynamicSelect_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./DynamicSelect.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/inputs/DynamicSelect.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_DynamicSelect_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/inputs/DynamicSelect.vue?vue&type=template&id=450e0ac0&scoped=true&":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/components/inputs/DynamicSelect.vue?vue&type=template&id=450e0ac0&scoped=true& ***!
  \*****************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_DynamicSelect_vue_vue_type_template_id_450e0ac0_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./DynamicSelect.vue?vue&type=template&id=450e0ac0&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/inputs/DynamicSelect.vue?vue&type=template&id=450e0ac0&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_DynamicSelect_vue_vue_type_template_id_450e0ac0_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_DynamicSelect_vue_vue_type_template_id_450e0ac0_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/pages/series/SeriesPage.vue":
/*!**************************************************!*\
  !*** ./resources/js/pages/series/SeriesPage.vue ***!
  \**************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _SeriesPage_vue_vue_type_template_id_a4f4c976_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SeriesPage.vue?vue&type=template&id=a4f4c976&scoped=true& */ "./resources/js/pages/series/SeriesPage.vue?vue&type=template&id=a4f4c976&scoped=true&");
/* harmony import */ var _SeriesPage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SeriesPage.vue?vue&type=script&lang=js& */ "./resources/js/pages/series/SeriesPage.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _SeriesPage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _SeriesPage_vue_vue_type_template_id_a4f4c976_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _SeriesPage_vue_vue_type_template_id_a4f4c976_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "a4f4c976",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/series/SeriesPage.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/pages/series/SeriesPage.vue?vue&type=script&lang=js&":
/*!***************************************************************************!*\
  !*** ./resources/js/pages/series/SeriesPage.vue?vue&type=script&lang=js& ***!
  \***************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SeriesPage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./SeriesPage.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/series/SeriesPage.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SeriesPage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/series/SeriesPage.vue?vue&type=template&id=a4f4c976&scoped=true&":
/*!*********************************************************************************************!*\
  !*** ./resources/js/pages/series/SeriesPage.vue?vue&type=template&id=a4f4c976&scoped=true& ***!
  \*********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SeriesPage_vue_vue_type_template_id_a4f4c976_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./SeriesPage.vue?vue&type=template&id=a4f4c976&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/series/SeriesPage.vue?vue&type=template&id=a4f4c976&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SeriesPage_vue_vue_type_template_id_a4f4c976_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SeriesPage_vue_vue_type_template_id_a4f4c976_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);