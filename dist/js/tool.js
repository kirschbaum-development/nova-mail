/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports) {

/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file.
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

module.exports = function normalizeComponent (
  rawScriptExports,
  compiledTemplate,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier /* server only */
) {
  var esModule
  var scriptExports = rawScriptExports = rawScriptExports || {}

  // ES6 modules interop
  var type = typeof rawScriptExports.default
  if (type === 'object' || type === 'function') {
    esModule = rawScriptExports
    scriptExports = rawScriptExports.default
  }

  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (compiledTemplate) {
    options.render = compiledTemplate.render
    options.staticRenderFns = compiledTemplate.staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = injectStyles
  }

  if (hook) {
    var functional = options.functional
    var existing = functional
      ? options.render
      : options.beforeCreate

    if (!functional) {
      // inject component registration as beforeCreate hook
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    } else {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functioal component in vue file
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return existing(h, context)
      }
    }
  }

  return {
    esModule: esModule,
    exports: scriptExports,
    options: options
  }
}


/***/ }),
/* 1 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(2);
module.exports = __webpack_require__(9);


/***/ }),
/* 2 */
/***/ (function(module, exports, __webpack_require__) {

Nova.booting(function (Vue, router, store) {
    Vue.component('nova-mail', __webpack_require__(3));
});

/***/ }),
/* 3 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(0)
/* script */
var __vue_script__ = __webpack_require__(4)
/* template */
var __vue_template__ = __webpack_require__(8)
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
Component.options.__file = "resources/js/components/Tool.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-68ff5483", Component.options)
  } else {
    hotAPI.reload("data-v-68ff5483", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 4 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__SentMail__ = __webpack_require__(14);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__SentMail___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__SentMail__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ['resourceName', 'resourceId', 'panel'],

  components: {
    SentMail: __WEBPACK_IMPORTED_MODULE_0__SentMail___default.a
  },

  data: function data() {
    return {
      mailTemplates: [],
      selectedTemplate: '',
      templateOverride: '',
      from: '',
      subject: '',
      baseMailUri: '/nova-api/mails',
      mails: {
        next_page_url: '',
        prev_page_url: '',
        resources: {}
      }
    };
  },
  mounted: function mounted() {
    this.getMailTemplates();
    this.getMails(this.mailsUri);
  },


  computed: {
    mailsUri: function mailsUri() {
      return this.baseMailUri + '?page=1';
    },
    hasMails: function hasMails() {
      return Boolean(this.mails.length);
    },
    hasNextLink: function hasNextLink() {
      return Boolean(this.mails.next_page_url);
    },
    hasPrevLink: function hasPrevLink() {
      return Boolean(this.mails.prev_page_url);
    },
    hasPagination: function hasPagination() {
      return this.hasNextLink || this.hasPrevLink;
    },
    mailsQueryParams: function mailsQueryParams() {
      return '&orderBy=created_at&orderByDirection=desc&viaResource=' + this.resourceName + '&viaResourceId=' + this.resourceId + '&viaRelationship=mails&relationshipType=hasMany';
    }
  },

  methods: {
    getMailTemplates: function getMailTemplates() {
      var _this = this;

      axios.get('/nova-mail/templates').then(function (_ref) {
        var data = _ref.data;
        return _this.mailTemplates = data.templates || [];
      });
    },
    paginationClass: function paginationClass(isActive) {
      return isActive ? 'text-primary dim' : 'test-80 opacity-50';
    },
    getMails: function getMails(uri) {
      var _this2 = this;

      axios.get('' + uri + this.mailsQueryParams).then(function (_ref2) {
        var data = _ref2.data;
        return _this2.mails = data;
      });
    },
    handleSendMail: function handleSendMail() {
      var _this3 = this;

      axios.post('/nova-mail/send/' + (this.selectedTemplate.id || ''), {
        model: this.panel.fields[0].model,
        resourceId: this.resourceId,
        content: this.templateOverride,
        from: this.from,
        subject: this.subject
      }).then(function (_ref3) {
        var data = _ref3.data;

        _this3.getMails(_this3.mailsUri);
        _this3.resetForm();
        _this3.$toasted.show('The mail has been sent.', { type: 'success' });
      }).catch(function (response) {
        return _this3.$toasted.show(response, { type: 'error' });
      });
    },
    resetForm: function resetForm() {
      this.templateOverride = '';
      this.selectedTemplate = '';
    }
  },

  watch: {
    selectedTemplate: function selectedTemplate(newValue, oldValue) {
      this.templateOverride = this.selectedTemplate.content;
    }
  }
});

/***/ }),
/* 5 */,
/* 6 */,
/* 7 */,
/* 8 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c("h4", { staticClass: "text-90 font-normal text-2xl mb-3" }, [
      _vm._v("Mail")
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "card mb-6 overflow-hidden" }, [
      _c(
        "div",
        { staticClass: "flex border-b border-40 remove-bottom-border px-8" },
        [
          _c("div", { staticClass: "w-full pt-6 pb-2" }, [
            _c("h3", { staticClass: "text-90 font-bold text-lg mb-4" }, [
              _vm._v("Send Mail")
            ]),
            _vm._v(" "),
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.from,
                  expression: "from"
                }
              ],
              staticClass:
                "w-full form-control form-input form-input-bordered mb-2",
              attrs: {
                name: "from",
                id: "from",
                dusk: "from",
                type: "text",
                placeholder: _vm.panel.fields[0].from
              },
              domProps: { value: _vm.from },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.from = $event.target.value
                }
              }
            }),
            _vm._v(" "),
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.subject,
                  expression: "subject"
                }
              ],
              staticClass:
                "w-full form-control form-input form-input-bordered mb-2",
              attrs: {
                name: "subject",
                id: "subject",
                dusk: "subject",
                type: "text",
                placeholder: _vm.panel.fields[0].subject
              },
              domProps: { value: _vm.subject },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.subject = $event.target.value
                }
              }
            }),
            _vm._v(" "),
            _c(
              "select",
              {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.selectedTemplate,
                    expression: "selectedTemplate"
                  }
                ],
                staticClass: "form-control form-select mb-2",
                attrs: {
                  name: "mail_template_select",
                  id: "mail-template-select",
                  dusk: "mail-template-select"
                },
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
                    _vm.selectedTemplate = $event.target.multiple
                      ? $$selectedVal
                      : $$selectedVal[0]
                  }
                }
              },
              [
                _c("option", { attrs: { value: "", disabled: "disabled" } }, [
                  _vm._v("Select Mail Template")
                ]),
                _vm._v(" "),
                _vm._l(_vm.mailTemplates, function(template, index) {
                  return _c(
                    "option",
                    { key: index, domProps: { value: template } },
                    [_vm._v(_vm._s(template.name))]
                  )
                })
              ],
              2
            ),
            _vm._v(" "),
            _c("textarea", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.templateOverride,
                  expression: "templateOverride"
                }
              ],
              staticClass:
                "w-full form-control form-input form-input-bordered py-3 h-auto",
              attrs: {
                name: "template_override",
                id: "template-override",
                dusk: "template-override",
                rows: "10"
              },
              domProps: { value: _vm.templateOverride },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.templateOverride = $event.target.value
                }
              }
            })
          ])
        ]
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "flex justify-between px-8 pb-4 border-b border-40" },
        [
          _c(
            "button",
            {
              staticClass:
                "btn btn-default btn-primary inline-flex items-center relative mt-4",
              attrs: { type: "submit" },
              on: { click: _vm.handleSendMail }
            },
            [_vm._v("Send Mail")]
          )
        ]
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "flex border-b border-40 remove-bottom-border px-8" },
        [
          _c(
            "div",
            { staticClass: "w-full py-6" },
            [
              _c("h3", { staticClass: "text-90 font-bold text-lg mb-4" }, [
                _vm._v("Mail History")
              ]),
              _vm._v(" "),
              _vm._l(_vm.mails.resources, function(mail, index) {
                return _c("send-mail", {
                  key: index,
                  attrs: { "initial-mail": mail }
                })
              })
            ],
            2
          )
        ]
      ),
      _vm._v(" "),
      _vm.hasPagination
        ? _c("div", { staticClass: "bg-20 rounded-b" }, [
            _c("nav", { staticClass: "flex justify-between items-center" }, [
              _c(
                "button",
                {
                  staticClass: "btn btn-link py-3 px-4",
                  class: _vm.paginationClass(_vm.hasNextLink),
                  attrs: { disabled: !_vm.hasNextLink },
                  on: {
                    click: function($event) {
                      return _vm.getMails(_vm.mails.next_page_url)
                    }
                  }
                },
                [_vm._v("Older")]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "btn btn-link py-3 px-4",
                  class: _vm.paginationClass(_vm.hasPrevLink),
                  attrs: { disabled: !_vm.hasPrevLink },
                  on: {
                    click: function($event) {
                      return _vm.getMails(_vm.mails.prev_page_url)
                    }
                  }
                },
                [_vm._v("Newer")]
              )
            ])
          ])
        : _vm._e()
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-68ff5483", module.exports)
  }
}

/***/ }),
/* 9 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 10 */,
/* 11 */,
/* 12 */,
/* 13 */,
/* 14 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(0)
/* script */
var __vue_script__ = __webpack_require__(15)
/* template */
var __vue_template__ = __webpack_require__(16)
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
Component.options.__file = "resources/js/components/SentMail.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-7705835a", Component.options)
  } else {
    hotAPI.reload("data-v-7705835a", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 15 */
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

/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    initialMail: {
      type: Object,
      require: true
    }
  },

  data: function data() {
    return {
      mail: {}
    };
  },
  mounted: function mounted() {
    var _this = this;

    axios.get('/nova-mail/mail/' + this.initialMail.id.value).then(function (_ref) {
      var data = _ref.data;
      return _this.mail = data.mail;
    });
  },


  computed: {
    date: function date() {
      var now = moment();
      var date = moment.utc(this.mail.created_at).tz(moment.tz.guess());
      if (date.isSame(now, 'minute')) {
        return 'just now';
      }
      if (date.isSame(now, 'day')) {
        return 'at ' + date.format('LT');
      }
      if (date.isSame(now, 'year')) {
        return 'on ' + date.format('MMM D');
      }
      return 'on ' + date.format('ll');
    }
  }
});

/***/ }),
/* 16 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "py-4 border-t border-40" }, [
    _c("div", { staticClass: "text-80 text-sm" }, [
      _vm._v("Sent " + _vm._s(_vm.date))
    ]),
    _vm._v(" "),
    _c("br"),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "italic" },
      [
        _vm.mail.content
          ? [_c("div", { domProps: { innerHTML: _vm._s(_vm.mail.content) } })]
          : [_vm._v("Content not available..")]
      ],
      2
    )
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-7705835a", module.exports)
  }
}

/***/ })
/******/ ]);