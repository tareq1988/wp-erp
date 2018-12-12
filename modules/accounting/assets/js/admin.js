pluginWebpack([0],[
/* 0 */,
/* 1 */,
/* 2 */,
/* 3 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_axios__ = __webpack_require__(30);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_axios___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_axios__);

/* harmony default export */ __webpack_exports__["a"] = (__WEBPACK_IMPORTED_MODULE_0_axios___default.a.create({
  baseURL: erp_acct_var.site_url + '/wp-json/erp/v1/accounting/v1',
  headers: {
    'X-WP-Nonce': erp_acct_var.rest_nonce
  }
}));

/***/ }),
/* 4 */,
/* 5 */,
/* 6 */,
/* 7 */,
/* 8 */,
/* 9 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_ListTable_vue__ = __webpack_require__(25);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_50f2b730_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_ListTable_vue__ = __webpack_require__(106);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(100)
}
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_ListTable_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_50f2b730_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_ListTable_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/admin/components/list-table/ListTable.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-50f2b730", Component.options)
  } else {
    hotAPI.reload("data-v-50f2b730", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),
/* 10 */,
/* 11 */,
/* 12 */,
/* 13 */,
/* 14 */,
/* 15 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_admin_components_Menu_ERPMenu_vue__ = __webpack_require__(65);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vue_sweetalert2__ = __webpack_require__(18);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__font_flaticon_css__ = __webpack_require__(81);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__font_flaticon_css___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__font_flaticon_css__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__css_master_css__ = __webpack_require__(86);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__css_master_css___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3__css_master_css__);
//
//
//
//
//
//
//




/* harmony default export */ __webpack_exports__["a"] = ({
  name: 'Accounting',
  components: {
    ERPMenu: __WEBPACK_IMPORTED_MODULE_0_admin_components_Menu_ERPMenu_vue__["a" /* default */]
  }
});

/***/ }),
/* 16 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__wordpress_i18n__ = __webpack_require__(17);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["a"] = ({
  name: "ERPMenu",
  props: {},
  data: function data() {
    return {
      menuItems: erp_acct_var.erp_acct_menus,
      dropDownClass: "erp-nav-dropdown",
      primaryNav: "erp-nav -primary",
      dropdownNav: "dropdown-nav",
      module_name: Object(__WEBPACK_IMPORTED_MODULE_0__wordpress_i18n__["__"])("Accounting", "erp"),
      svgData: "M221.9,0H17.1C6.8,0,0,6.8,0,17.1V324.3c0,10.2,6.8,17.1,17.1,17.1H221.9c10.2,0,17.1-6.8,17.1-17.1V17.1C238.9,6.8,232.1,0,221.9,0ZM68.3,307.2H34.1V273.1H68.2v34.1Zm0-68.3H34.1V204.8H68.2v34.1Zm0-68.2H34.1V136.6H68.2v34.1Zm68.2,136.5H102.4V273.1h34.1Zm0-68.3H102.4V204.8h34.1Zm0-68.2H102.4V136.6h34.1Zm68.3,136.5H170.7V273.1h34.1v34.1Zm0-68.3H170.7V204.8h34.1v34.1Zm0-68.2H170.7V136.6h34.1v34.1Zm0-68.3H34.1V34.1H204.8v68.3Zm0,0",
      current_url: window.location.href,
      activeClass: "active"
    };
  },
  created: function created() {
    this.init();
  },
  methods: {
    init: function init() {
      var container = document.querySelector(".erp-nav-container");

      if (container == null) {
        return;
      }

      var primary = container.querySelector(".-primary");
      primaryItems = container.querySelectorAll(".-primary > li:not(.-more)");
      container.classList.add("--jsfied"); // insert "more" button and duplicate the list

      primary.insertAdjacentHTML("beforeend", '<li class="-more"><button type="button" aria-haspopup="true" aria-expanded="false">More <span class="dashicons dashicons-arrow-down-alt2"></span></button><ul class="-secondary">' + primary.innerHTML + "</ul></li>");
      var secondary = container.querySelector(".-secondary");
      secondaryItems = [].slice.call(secondary.children);
      allItems = container.querySelectorAll("li");
      moreLi = primary.querySelector(".-more");
      moreBtn = moreLi.querySelector("button");
      moreBtn.addEventListener("click", function (e) {
        e.preventDefault();
        container.classList.toggle("--show-secondary");
        moreBtn.setAttribute("aria-expanded", container.classList.contains("--show-secondary"));
      }); // adapt tabs

      var doAdapt = function doAdapt() {
        // reveal all items for the calculation
        allItems.forEach(function (item) {
          item.classList.remove("--hidden");
        }); // hide items that won't fit in the Primary

        stopWidth = moreBtn.offsetWidth;
        hiddenItems = [];
        primaryWidth = primary.offsetWidth;
        primaryItems.forEach(function (item, i) {
          if (primaryWidth >= stopWidth + item.offsetWidth) {
            stopWidth += item.offsetWidth;
          } else {
            item.classList.add("--hidden");
            hiddenItems.push(i);
          }
        }); // toggle the visibility of More button and items in Secondary

        if (!hiddenItems.length) {
          moreLi.classList.add("--hidden");
          container.classList.remove("--show-secondary");
          moreBtn.setAttribute("aria-expanded", false);
        } else {
          secondaryItems.forEach(function (item, i) {
            if (!hiddenItems.includes(i)) {
              item.classList.add("--hidden");
            }
          });
        }
      };

      doAdapt(); // adapt immediately on load

      window.addEventListener("resize", doAdapt); // adapt on window resize
      // hide Secondary on the outside click

      document.addEventListener("click", function (e) {
        var el = e.target;

        while (el) {
          if (el === secondary || el === moreBtn) {
            return;
          }

          el = el.parentNode;
        }

        container.classList.remove("--show-secondary");
        moreBtn.setAttribute("aria-expanded", false);
      });
    },
    changeRoute: function changeRoute(slug) {
      this.$router.push(slug);
    }
  }
});

/***/ }),
/* 17 */,
/* 18 */,
/* 19 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__.p + "/Users/wedevs/Local Sites/wp-erp-ac/app/public/wp-content/plugins/wp-erp/modules/accounting/assets/font/Flaticon.eot";

/***/ }),
/* 20 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__.p + "/Users/wedevs/Local Sites/wp-erp-ac/app/public/wp-content/plugins/wp-erp/modules/accounting/assets/font/Flaticon.svg";

/***/ }),
/* 21 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__WP_MetaBox_vue__ = __webpack_require__(92);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["a"] = ({
  name: 'Dashboard',
  components: {
    MetaBox: __WEBPACK_IMPORTED_MODULE_0__WP_MetaBox_vue__["a" /* default */]
  },
  data: function data() {
    return {
      title1: 'Income & Expenses',
      title2: 'Bank Accounts',
      title3: 'Invoices owed to you',
      title4: 'Bills to pay',
      closable: true,
      msg: 'Accounting'
    };
  }
});

/***/ }),
/* 22 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ __webpack_exports__["a"] = ({
  name: 'MetaBox',
  props: {
    title: String,
    closable: Boolean
  },
  data: function data() {
    return {
      closed: false
    };
  },
  computed: {
    classes: function classes() {
      return ['postbox', this.closed ? 'closed' : ''];
    },
    styles: function styles() {
      return 'display: block;';
    }
  },
  methods: {
    handleToggle: function handleToggle(event) {
      this.closed = !this.closed;
      this.$emit('metaboxToggle', event);
    }
  }
});

/***/ }),
/* 23 */
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

/***/ }),
/* 24 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__list_table_ListTable_vue__ = __webpack_require__(9);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__http_js__ = __webpack_require__(3);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ __webpack_exports__["a"] = ({
  name: 'Customers',
  components: {
    ListTable: __WEBPACK_IMPORTED_MODULE_0__list_table_ListTable_vue__["a" /* default */]
  },
  data: function data() {
    return {
      bulkActions: [{
        key: 'trash',
        label: 'Move to Trash',
        img: erp_acct_var.erp_assets + '/images/trash.png'
      }],
      columns: {
        'customer': {
          label: 'Customer Name'
        },
        'company': {
          label: 'Company'
        },
        'email': {
          label: 'Email'
        },
        'phone': {
          label: 'Phone'
        },
        'expense': {
          label: 'Expense'
        },
        'actions': {
          label: 'Actions'
        }
      },
      rows: [],
      paginationData: {
        totalItems: 0,
        totalPages: 0,
        perPage: 10,
        currentPage: this.$route.params.page === undefined ? 1 : parseInt(this.$route.params.page)
      },
      actions: [{
        key: 'edit',
        label: 'Edit'
      }, {
        key: 'trash',
        label: 'Delete'
      }]
    };
  },
  created: function created() {
    this.$on('modal-close', function () {
      this.showModal = false;
    });
    this.fetchItems();
  },
  computed: {
    row_data: function row_data() {
      var items = this.rows;
      items.map(function (item) {
        item.customer = item.first_name + ' ' + item.last_name; //TODO remove after api update for expense

        item.expense = '55555';
      });
      return items;
    }
  },
  methods: {
    fetchItems: function fetchItems() {
      var _this = this;

      this.rows = [];
      __WEBPACK_IMPORTED_MODULE_1__http_js__["a" /* default */].get('customers', {
        params: {
          per_page: this.paginationData.perPage,
          page: this.$route.params.page === undefined ? this.paginationData.currentPage : this.$route.params.page
        }
      }).then(function (response) {
        _this.rows = response.data;
        _this.paginationData.totalItems = parseInt(response.headers['x-wp-total']);
        _this.paginationData.totalPages = parseInt(response.headers['x-wp-totalpages']);
      }).catch(function (error) {
        console.log(error);
      }).then(function () {//ready
      });
    },
    onActionClick: function onActionClick(action, row, index) {
      var _this2 = this;

      switch (action) {
        case 'trash':
          if (confirm('Are you sure to delete?')) {
            __WEBPACK_IMPORTED_MODULE_1__http_js__["a" /* default */].delete('customers/' + row.id).then(function (response) {
              _this2.$delete(_this2.rows, index);
            });
          }

          break;

        case 'edit':
          //TODO
          break;

        default:
      }
    },
    onBulkAction: function onBulkAction(action, items) {
      var _this3 = this;

      if ('trash' === action) {
        if (confirm('Are you sure to delete?')) {
          __WEBPACK_IMPORTED_MODULE_1__http_js__["a" /* default */].delete('customers/delete/' + items.join(',')).then(function (response) {
            var toggleCheckbox = document.getElementsByClassName('column-cb')[0].childNodes[0];

            if (toggleCheckbox.checked) {
              // simulate click event to remove checked state
              toggleCheckbox.click();
            }

            _this3.fetchItems();
          });
        }
      }
    },
    goToPage: function goToPage(page) {
      var queries = Object.assign({}, this.$route.query);
      this.paginationData.currentPage = page;
      this.$router.push({
        name: 'PaginateCustomers',
        params: {
          page: page
        },
        query: queries
      });
      this.fetchItems();
    }
  }
});

/***/ }),
/* 25 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__BulkActionsTpl_vue__ = __webpack_require__(101);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_admin_components_base_Dropdown_vue__ = __webpack_require__(27);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* eslint-disable */


/* harmony default export */ __webpack_exports__["a"] = ({
  name: 'ListTable',
  components: {
    BulkActionsTpl: __WEBPACK_IMPORTED_MODULE_0__BulkActionsTpl_vue__["a" /* default */],
    Dropdown: __WEBPACK_IMPORTED_MODULE_1_admin_components_base_Dropdown_vue__["a" /* default */]
  },
  props: {
    columns: {
      type: Object,
      required: true,
      default: function _default() {}
    },
    rows: {
      type: Array,
      // String, Number, Boolean, Function, Object, Array
      required: true,
      default: function _default() {
        return [];
      }
    },
    index: {
      type: String,
      default: 'id'
    },
    showCb: {
      type: Boolean,
      default: true
    },
    loading: {
      type: Boolean,
      default: false
    },
    actionColumn: {
      type: String,
      default: ''
    },
    actions: {
      type: Array,
      required: false,
      default: function _default() {
        return [];
      }
    },
    bulkActions: {
      type: Array,
      required: false,
      default: function _default() {
        return [];
      }
    },
    tableClass: {
      type: String,
      default: 'wp-list-table widefat fixed striped'
    },
    notFound: {
      type: String,
      default: 'No items found.'
    },
    totalItems: {
      type: Number,
      default: 0
    },
    totalPages: {
      type: Number,
      default: 1
    },
    perPage: {
      type: Number,
      default: 20
    },
    currentPage: {
      type: Number,
      default: 1
    },
    sortBy: {
      type: String,
      default: null
    },
    sortOrder: {
      type: String,
      default: 'asc'
    }
  },
  data: function data() {
    return {
      bulkLocal: '-1',
      checkedItems: []
    };
  },
  computed: {
    hasActions: function hasActions() {
      return this.actions.length > 0;
    },
    itemsTotal: function itemsTotal() {
      return this.totalItems || this.rows.length;
    },
    hasPagination: function hasPagination() {
      return this.itemsTotal > this.perPage;
    },
    disableFirst: function disableFirst() {
      if (this.currentPage === 1 || this.currentPage === 2) {
        return true;
      }

      return false;
    },
    disablePrev: function disablePrev() {
      if (this.currentPage === 1) {
        return true;
      }

      return false;
    },
    disableNext: function disableNext() {
      if (this.currentPage === this.totalPages) {
        return true;
      }

      return false;
    },
    disableLast: function disableLast() {
      if (this.currentPage === this.totalPages || this.currentPage == this.totalPages - 1) {
        return true;
      }

      return false;
    },
    columnsCount: function columnsCount() {
      return Object.keys(this.columns).length;
    },
    colspan: function colspan() {
      var columns = Object.keys(this.columns).length;

      if (this.showCb) {
        columns += 1;
      }

      return columns;
    },
    selectAll: {
      get: function get() {
        if (!this.rows.length) {
          return false;
        }

        return this.rows ? this.checkedItems.length == this.rows.length : false;
      },
      set: function set(value) {
        var selected = [];
        var self = this;

        if (value) {
          this.rows.forEach(function (item) {
            if (item[self.index] !== undefined) {
              selected.push(item[self.index]);
            } else {
              selected.push(item.id);
            }
          });
        }

        this.checkedItems = selected;
      }
    }
  },
  created: function created() {
    var _this = this;

    this.$on('bulk-checkbox', function (e) {
      if (!e) {
        _this.checkedItems = [];
      }
    });
    this.$on('bulk-action-click', function (key) {
      _this.bulkLocal = key;

      _this.handleBulkAction();
    });
  },
  methods: {
    hideActionSeparator: function hideActionSeparator(action) {
      return action === this.actions[this.actions.length - 1].key;
    },
    actionClicked: function actionClicked(action, row, index) {
      this.$emit('action:click', action, row, index);
    },
    goToPage: function goToPage(page) {
      this.$emit('pagination', page);
    },
    goToCustomPage: function goToCustomPage(event) {
      var page = parseInt(event.target.value, 10);

      if (!isNaN(page) && page > 0 && page <= this.totalPages) {
        this.$emit('pagination', page);
      }
    },
    handleBulkAction: function handleBulkAction() {
      if (this.bulkLocal === '-1') {
        return;
      }

      this.$emit('bulk:click', this.bulkLocal, this.checkedItems);
    },
    isSortable: function isSortable(column) {
      if (column.hasOwnProperty('sortable') && column.sortable === true) {
        return true;
      }

      return false;
    },
    isSorted: function isSorted(column) {
      return column === this.sortBy;
    },
    handleSortBy: function handleSortBy(column) {
      var order = this.sortOrder === 'asc' ? 'desc' : 'asc';
      this.$emit('sort', column, order);
    }
  }
});

/***/ }),
/* 26 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ __webpack_exports__["a"] = ({
  name: 'BulkActionsTpl',
  props: {
    bulkActions: {
      type: Array,
      required: false,
      default: function _default() {
        return [];
      }
    },
    showCb: {
      type: Boolean,
      default: true
    },
    columnsCount: {
      type: Number,
      default: 0
    },
    selectAll: {
      type: Boolean,
      default: false
    }
  },
  data: function data() {
    return {
      bulkSelectAll: this.selectAll
    };
  },
  computed: {
    hasBulkActions: function hasBulkActions() {
      return this.bulkActions.length > 0;
    }
  },
  methods: {
    changeBulkCheckbox: function changeBulkCheckbox() {
      this.$parent.$emit('bulk-checkbox', this.bulkSelectAll);
    },
    bulkActionSelect: function bulkActionSelect(key) {
      this.$parent.$emit('bulk-action-click', key);
    }
  }
});

/***/ }),
/* 27 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_Dropdown_vue__ = __webpack_require__(28);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_8264bea2_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_Dropdown_vue__ = __webpack_require__(105);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(104)
}
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_Dropdown_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_8264bea2_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_Dropdown_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/admin/components/base/Dropdown.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-8264bea2", Component.options)
  } else {
    hotAPI.reload("data-v-8264bea2", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),
/* 28 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_popper_js__ = __webpack_require__(29);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* eslint no-underscore-dangle: 0 */
// Vue click outside
// https://jsfiddle.net/Linusborg/Lx49LaL8/

/* harmony default export */ __webpack_exports__["a"] = ({
  name: 'Dropdown',
  props: {
    dropdownClasses: {
      type: String,
      default: ''
    },
    disabled: {
      type: Boolean,
      default: false
    },
    placement: {
      type: String,
      default: 'bottom'
    }
  },
  data: function data() {
    return {
      visible: false
    };
  },
  watch: {
    visible: function visible(newValue, oldValue) {
      if (newValue !== oldValue) {
        if (newValue) {
          this.showMenu();
        } else {
          this.hideMenu();
        }
      }
    }
  },
  created: function created() {
    // Create non-reactive property
    this._popper = null;
  },
  mounted: function mounted() {
    window.addEventListener('click', this.closeDropdown);
  },
  beforeDestroy: function beforeDestroy() {
    this.visible = false;
    this.removePopper();
  },
  destroyed: function destroyed() {
    window.removeEventListener('click', this.closeDropdown);
  },
  methods: {
    toggleDropdown: function toggleDropdown() {
      this.visible = !this.visible;
    },
    showMenu: function showMenu() {
      if (this.disabled) {
        return;
      }

      var element = this.$el;
      this.createPopper(element);
    },
    hideMenu: function hideMenu() {
      this.$root.$emit('hidden');
      this.removePopper();
    },
    createPopper: function createPopper(element) {
      this.removePopper();
      this._popper = new __WEBPACK_IMPORTED_MODULE_0_popper_js__["default"](element, this.$refs.menu, {
        placement: this.placement
      });
    },
    removePopper: function removePopper() {
      if (this._popper) {
        // Ensure popper event listeners are removed cleanly
        this._popper.destroy();
      }

      this._popper = null;
    },
    closeDropdown: function closeDropdown(e) {
      if (!this.$el || this.elementContains(this.$el, e.target) || !this._popper || this.elementContains(this._popper, e.target)) {
        return;
      }

      this.visible = false;
    },
    elementContains: function elementContains(elm, otherElm) {
      if (typeof elm.contains === 'function') {
        return elm.contains(otherElm);
      }

      return false;
    }
  }
});

/***/ }),
/* 29 */,
/* 30 */,
/* 31 */,
/* 32 */,
/* 33 */,
/* 34 */,
/* 35 */,
/* 36 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__list_table_ListTable_vue__ = __webpack_require__(9);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__http_js__ = __webpack_require__(3);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ __webpack_exports__["a"] = ({
  name: 'Vendors',
  components: {
    ListTable: __WEBPACK_IMPORTED_MODULE_0__list_table_ListTable_vue__["a" /* default */]
  },
  data: function data() {
    return {
      bulkActions: [{
        key: 'trash',
        label: 'Move to Trash',
        img: erp_acct_var.erp_assets + '/images/trash.png'
      }],
      columns: {
        'vendor': {
          label: 'Vendor Name'
        },
        'company': {
          label: 'Vendor Owner'
        },
        'email': {
          label: 'Email'
        },
        'phone': {
          label: 'Phone'
        },
        'expense': {
          label: 'Expense'
        },
        'actions': {
          label: 'Actions'
        }
      },
      rows: [],
      paginationData: {
        totalItems: 0,
        totalPages: 0,
        perPage: 10,
        currentPage: this.$route.params.page === undefined ? 1 : parseInt(this.$route.params.page)
      },
      actions: [{
        key: 'edit',
        label: 'Edit'
      }, {
        key: 'trash',
        label: 'Delete'
      }]
    };
  },
  created: function created() {
    this.$on('modal-close', function () {
      this.showModal = false;
    });
    this.fetchItems();
  },
  computed: {
    row_data: function row_data() {
      var items = this.rows;
      items.map(function (item) {
        item.vendor = item.first_name + ' ' + item.last_name; //TODO remove after api update for expense
        // item.expense = '55555';
      });
      return items;
    }
  },
  methods: {
    fetchItems: function fetchItems() {
      var _this = this;

      this.rows = [];
      __WEBPACK_IMPORTED_MODULE_1__http_js__["a" /* default */].get('vendors', {
        params: {
          per_page: this.paginationData.perPage,
          page: this.$route.params.page === undefined ? this.paginationData.currentPage : this.$route.params.page
        }
      }).then(function (response) {
        _this.rows = response.data;
        _this.paginationData.totalItems = parseInt(response.headers['x-wp-total']);
        _this.paginationData.totalPages = parseInt(response.headers['x-wp-totalpages']);
      }).catch(function (error) {
        console.log(error);
      }).then(function () {//ready
      });
    },
    onActionClick: function onActionClick(action, row, index) {
      var _this2 = this;

      switch (action) {
        case 'trash':
          if (confirm('Are you sure to delete?')) {
            __WEBPACK_IMPORTED_MODULE_1__http_js__["a" /* default */].delete('vendors/' + row.id).then(function (response) {
              _this2.$delete(_this2.rows, index);
            });
          }

          break;

        case 'edit':
          //TODO
          break;

        default:
      }
    },
    onBulkAction: function onBulkAction(action, items) {
      var _this3 = this;

      if ('trash' === action) {
        if (confirm('Are you sure to delete?')) {
          __WEBPACK_IMPORTED_MODULE_1__http_js__["a" /* default */].delete('vendors/delete/' + items.join(',')).then(function (response) {
            var toggleCheckbox = document.getElementsByClassName('column-cb')[0].childNodes[0];

            if (toggleCheckbox.checked) {
              // simulate click event to remove checked state
              toggleCheckbox.click();
            }

            _this3.fetchItems();
          });
        }
      }
    },
    goToPage: function goToPage(page) {
      var queries = Object.assign({}, this.$route.query);
      this.paginationData.currentPage = page;
      this.$router.push({
        name: 'PaginateVendors',
        params: {
          page: page
        },
        query: queries
      });
      this.fetchItems();
    }
  }
});

/***/ }),
/* 37 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__list_table_ListTable_vue__ = __webpack_require__(9);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__http_js__ = __webpack_require__(3);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ __webpack_exports__["a"] = ({
  name: 'employees',
  components: {
    ListTable: __WEBPACK_IMPORTED_MODULE_0__list_table_ListTable_vue__["a" /* default */]
  },
  data: function data() {
    return {
      bulkActions: [{
        key: 'trash',
        label: 'Move to Trash',
        img: erp_acct_var.erp_assets + '/images/trash.png'
      }],
      columns: {
        'employee': {
          label: 'Name'
        },
        'designation': {
          label: 'Designation'
        },
        'email': {
          label: 'Email'
        },
        'phone': {
          label: 'Phone'
        },
        'actions': {
          label: 'Actions'
        }
      },
      rows: [],
      paginationData: {
        totalItems: 0,
        totalPages: 0,
        perPage: 10,
        currentPage: this.$route.params.page === undefined ? 1 : parseInt(this.$route.params.page)
      },
      actions: [{
        key: 'edit',
        label: 'Edit'
      }, {
        key: 'trash',
        label: 'Delete'
      }]
    };
  },
  created: function created() {
    this.$on('modal-close', function () {
      this.showModal = false;
    });
    this.fetchItems();
  },
  computed: {
    row_data: function row_data() {
      var items = this.rows;
      items.map(function (item) {
        item.employee = item.full_name;
        item.email = item.user_email;
        item.designation = item.designation.title;
      });
      return items;
    }
  },
  methods: {
    fetchItems: function fetchItems() {
      var _this = this;

      this.rows = [];
      __WEBPACK_IMPORTED_MODULE_1__http_js__["a" /* default */].get('employees', {
        params: {
          per_page: this.paginationData.perPage,
          page: this.$route.params.page === undefined ? this.paginationData.currentPage : this.$route.params.page,
          include: 'designation'
        }
      }).then(function (response) {
        _this.rows = response.data;
        _this.paginationData.totalItems = parseInt(response.headers['x-wp-total']);
        _this.paginationData.totalPages = parseInt(response.headers['x-wp-totalpages']);
      }).catch(function (error) {
        console.log(error);
      }).then(function () {//ready
      });
    },
    onActionClick: function onActionClick(action, row, index) {
      var _this2 = this;

      switch (action) {
        case 'trash':
          if (confirm('Are you sure to delete?')) {
            __WEBPACK_IMPORTED_MODULE_1__http_js__["a" /* default */].delete('employees/' + row.id).then(function (response) {
              _this2.$delete(_this2.rows, index);
            });
          }

          break;

        case 'edit':
          //TODO
          break;

        default:
      }
    },
    onBulkAction: function onBulkAction(action, items) {
      var _this3 = this;

      if ('trash' === action) {
        if (confirm('Are you sure to delete?')) {
          __WEBPACK_IMPORTED_MODULE_1__http_js__["a" /* default */].delete('employees/delete/' + items.join(',')).then(function (response) {
            var toggleCheckbox = document.getElementsByClassName('column-cb')[0].childNodes[0];

            if (toggleCheckbox.checked) {
              // simulate click event to remove checked state
              toggleCheckbox.click();
            }

            _this3.fetchItems();
          });
        }
      }
    },
    goToPage: function goToPage(page) {
      var queries = Object.assign({}, this.$route.query);
      this.paginationData.currentPage = page;
      this.$router.push({
        name: 'PaginateEmployees',
        params: {
          page: page
        },
        query: queries
      });
      this.fetchItems();
    }
  }
});

/***/ }),
/* 38 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
//
//
//
/* harmony default export */ __webpack_exports__["a"] = ({
  name: 'DummyComponent',
  data: function data() {
    return {
      title: this.$route.name
    };
  }
});

/***/ }),
/* 39 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_admin_http__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_admin_components_base_Datepicker_vue__ = __webpack_require__(137);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_admin_components_base_FileUpload_vue__ = __webpack_require__(142);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_admin_components_base_SubmitButton_vue__ = __webpack_require__(182);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_admin_components_invoice_TransactionRow_vue__ = __webpack_require__(145);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_admin_components_invoice_InvoiceCustomers_vue__ = __webpack_require__(153);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//






/* harmony default export */ __webpack_exports__["a"] = ({
  name: 'InvoiceCreate',
  components: {
    HTTP: __WEBPACK_IMPORTED_MODULE_0_admin_http__["a" /* default */],
    Datepicker: __WEBPACK_IMPORTED_MODULE_1_admin_components_base_Datepicker_vue__["a" /* default */],
    FileUpload: __WEBPACK_IMPORTED_MODULE_2_admin_components_base_FileUpload_vue__["a" /* default */],
    SubmitButton: __WEBPACK_IMPORTED_MODULE_3_admin_components_base_SubmitButton_vue__["a" /* default */],
    TransactionRow: __WEBPACK_IMPORTED_MODULE_4_admin_components_invoice_TransactionRow_vue__["a" /* default */],
    InvoiceCustomers: __WEBPACK_IMPORTED_MODULE_5_admin_components_invoice_InvoiceCustomers_vue__["a" /* default */]
  },
  data: function data() {
    return {
      basic_fields: {
        customer: '',
        trans_date: '',
        due_date: '',
        billing_address: ''
      },
      products: [],
      attachments: [],
      transactionLines: [{}],
      finalTotalAmount: 0,
      isWorking: false,
      acct_var: erp_acct_var
    };
  },
  watch: {
    'basic_fields.customer': function basic_fieldsCustomer() {
      this.getCustomerAddress();
    }
  },
  created: function created() {
    var _this = this;

    this.getProducts();
    this.$root.$on('remove-row', function (index) {
      _this.$delete(_this.transactionLines, index);

      _this.updateFinalAmount();
    });
    this.$root.$on('total-updated', function (amount) {
      _this.updateFinalAmount();
    });
  },
  methods: {
    getProducts: function getProducts() {
      var _this2 = this;

      __WEBPACK_IMPORTED_MODULE_0_admin_http__["a" /* default */].get('/products').then(function (response) {
        response.data.forEach(function (element) {
          _this2.products.push({
            id: element.id,
            name: element.name
          });
        });
      });
    },
    getCustomerAddress: function getCustomerAddress() {
      var _this3 = this;

      var customer_id = this.basic_fields.customer.id;
      __WEBPACK_IMPORTED_MODULE_0_admin_http__["a" /* default */].get("/customers/".concat(customer_id)).then(function (response) {
        // add more info
        _this3.basic_fields.billing_address = "\n                    Street: ".concat(response.data.billing.street_1, " ").concat(response.data.billing.street_2, ",\n                    City: ").concat(response.data.billing.city, ",\n                ");
      });
    },
    addLine: function addLine() {
      this.transactionLines.push({});
    },
    updateFinalAmount: function updateFinalAmount() {
      var finalAmount = 0;
      this.transactionLines.forEach(function (element) {
        finalAmount += parseFloat(element.totalAmount);
      });
      this.finalTotalAmount = finalAmount.toFixed(2);
    },
    formatLineItems: function formatLineItems() {
      var lineItems = [];
      this.transactionLines.forEach(function (line) {
        lineItems.push({
          product_id: line.selectedProduct.id,
          product_type: 'service',
          qty: line.qty,
          unit_price: line.unitPrice,
          tax: line.taxAmount,
          discount: line.discount,
          item_total: line.totalAmount,
          tax_percent: 0
        });
      });
      return lineItems;
    },
    SubmitForApproval: function SubmitForApproval() {
      var _this4 = this;

      this.isWorking = true;
      __WEBPACK_IMPORTED_MODULE_0_admin_http__["a" /* default */].post('/invoices', {
        customer_id: this.basic_fields.customer.id,
        date: this.basic_fields.trans_date,
        due_date: this.basic_fields.due_date,
        billing_address: this.basic_fields.billing_address,
        line_items: this.formatLineItems(),
        attachments: this.attachments,
        type: 'invoice',
        status: 'awaiting_payment',
        trn_by: 1
      }).then(function (res) {
        console.log(res.data);
      }).then(function () {
        _this4.isWorking = false;
      });
      this.finalTotalAmount = parseFloat(finalAmount).toFixed(2);
    }
  }
});

/***/ }),
/* 40 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_admin_components_base_Dropdown_vue__ = __webpack_require__(27);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_v_calendar__ = __webpack_require__(41);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_v_calendar___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_v_calendar__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_v_calendar_lib_v_calendar_min_css__ = __webpack_require__(139);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_v_calendar_lib_v_calendar_min_css___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_v_calendar_lib_v_calendar_min_css__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//



Object(__WEBPACK_IMPORTED_MODULE_1_v_calendar__["setupCalendar"])({
  firstDayOfWeek: 2
});
/* harmony default export */ __webpack_exports__["a"] = ({
  name: 'Datepicker',
  components: {
    Dropdown: __WEBPACK_IMPORTED_MODULE_0_admin_components_base_Dropdown_vue__["a" /* default */],
    Calendar: __WEBPACK_IMPORTED_MODULE_1_v_calendar__["Calendar"]
  },
  data: function data() {
    return {
      pickerAttrs: [{
        key: 'today',
        highlight: {
          backgroundColor: '#1A9ED4'
        },
        contentStyle: {
          color: '#fff'
        },
        dates: new Date()
      }],
      selectedDate: ''
    };
  },
  methods: {
    pickerSelect: function pickerSelect(day) {
      var formattedDate = day.day + '-' + day.month + '-' + day.year; // e.g. 08-10-2018

      this.selectedDate = formattedDate;
      this.$refs.datePicker.click();
      this.$emit('input', this.selectedDate);
    }
  }
});

/***/ }),
/* 41 */,
/* 42 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_admin_http__ = __webpack_require__(3);
//
//
//
//
//
//
//
//
//
//
//
//
//
//

var STATUS_INITIAL = 0,
    STATUS_SAVING = 1,
    STATUS_SUCCESS = 2,
    STATUS_FAILED = 3;
/* harmony default export */ __webpack_exports__["a"] = ({
  name: 'FileUpload',
  data: function data() {
    return {
      fileCount: 0,
      isUploaded: false,
      uploadedFiles: [],
      uploadError: null,
      currentStatus: null,
      uploadFieldName: 'attachments[]'
    };
  },
  props: {
    url: {
      type: String,
      required: true
    }
  },
  computed: {
    isInitial: function isInitial() {
      return this.currentStatus === STATUS_INITIAL;
    },
    isSaving: function isSaving() {
      return this.currentStatus === STATUS_SAVING;
    },
    isSuccess: function isSuccess() {
      return this.currentStatus === STATUS_SUCCESS;
    },
    isFailed: function isFailed() {
      return this.currentStatus === STATUS_FAILED;
    }
  },
  methods: {
    reset: function reset() {
      this.currentStatus = STATUS_INITIAL;
      this.uploadedFiles = [];
      this.uploadError = null;
    },
    filesChange: function filesChange(event) {
      var formData = new FormData();
      var fieldName = event.target.name;
      var fileList = event.target.files;
      if (!fileList.length) return;
      this.currentStatus = STATUS_SAVING;
      this.fileCount = fileList.length; // append the files to FormData

      Array.from(Array(fileList.length).keys()).map(function (x) {
        formData.append(fieldName, fileList[x], fileList[x].name);
      });
      this.upload(formData);
    },
    upload: function upload(formData) {
      var _this = this;

      var BASE_URL = erp_acct_var.site_url;
      var url = "".concat(BASE_URL, "/wp-json/erp/v1/accounting/v1").concat(this.url);
      return __WEBPACK_IMPORTED_MODULE_0_admin_http__["a" /* default */].post(url, formData).then(function (res) {
        res.data.map(function (img) {
          _this.uploadedFiles.push(img.url);
        });

        _this.$emit('input', _this.uploadedFiles);

        _this.currentStatus = STATUS_SUCCESS;
        _this.isUploaded = true;
      });
    }
  },
  mounted: function mounted() {
    this.reset();
  }
});

/***/ }),
/* 43 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_admin_http__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_admin_components_Select_MultiSelect_vue__ = __webpack_require__(44);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ __webpack_exports__["a"] = ({
  name: 'TransactionRow',
  props: {
    products: {
      type: Array,
      default: function _default() {
        return [];
      }
    },
    line: {
      type: Object,
      default: function _default() {
        return {
          qty: 0,
          selectedProduct: [],
          unitPrice: 0,
          discount: 0,
          taxAmount: 0,
          totalAmount: 0
        };
      }
    }
  },
  components: {
    MultiSelect: __WEBPACK_IMPORTED_MODULE_1_admin_components_Select_MultiSelect_vue__["a" /* default */]
  },
  watch: {
    'line.selectedProduct': function lineSelectedProduct() {
      this.getSalePrice();
    }
  },
  methods: {
    calculateAmount: function calculateAmount() {
      var field = this.line;
      var amount = parseFloat(field.qty) * parseFloat(field.unitPrice);
      var discount = parseFloat(field.discount);
      var taxAmount = parseFloat(field.taxAmount);
      field.totalAmount = amount;

      if (isNaN(amount)) {
        field.totalAmount = 0;
        return;
      }

      if (discount) {
        discount = amount * discount / 100;
        amount = amount - discount;
      }

      if (taxAmount) {
        amount = amount - taxAmount;
      }

      field.totalAmount = amount.toFixed(2);
      this.$root.$emit('total-updated', field.totalAmount);
      this.$forceUpdate();
    },
    getSalePrice: function getSalePrice() {
      var _this = this;

      var product_id = this.line.selectedProduct.id;
      if (!product_id) return;
      __WEBPACK_IMPORTED_MODULE_0_admin_http__["a" /* default */].get("/products/".concat(product_id)).then(function (response) {
        _this.unitPrice = response.data.sale_price;
      });
    },
    removeRow: function removeRow() {
      this.$root.$emit('remove-row', this.$vnode.key);
    }
  }
});

/***/ }),
/* 44 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_MultiSelect_vue__ = __webpack_require__(45);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_57da95b2_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_MultiSelect_vue__ = __webpack_require__(151);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(147)
}
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_MultiSelect_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_57da95b2_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_MultiSelect_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/admin/components/Select/MultiSelect.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-57da95b2", Component.options)
  } else {
    hotAPI.reload("data-v-57da95b2", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),
/* 45 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue_multiselect__ = __webpack_require__(46);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue_multiselect___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_vue_multiselect__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__debounce__ = __webpack_require__(148);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_vue_multiselect_dist_vue_multiselect_min_css__ = __webpack_require__(149);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_vue_multiselect_dist_vue_multiselect_min_css___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_vue_multiselect_dist_vue_multiselect_min_css__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* eslint func-names: ["error", "never"] */



/* harmony default export */ __webpack_exports__["a"] = ({
  name: 'MultiSelect',
  components: {
    Multiselect: __WEBPACK_IMPORTED_MODULE_0_vue_multiselect___default.a
  },
  props: {
    value: {
      type: null,
      required: true
    },
    options: {
      type: Array,
      default: function _default() {
        return [];
      }
    },
    multiple: {
      type: Boolean,
      default: false
    }
  },
  data: function data() {
    return {
      noResult: false,
      isLoading: false,
      results: []
    };
  },
  watch: {
    options: function options() {
      this.results = [];
      this.isLoading = false;
    }
  },
  methods: {
    onSelect: function onSelect(selected) {
      if (this.multiple) {
        this.results.push(selected);
        this.$emit('input', this.results);
      } else {
        this.$emit('input', selected);
      }
    },
    onRemove: function onRemove(removed) {
      this.results = this.results.filter(function (element) {
        return element.id !== removed.id;
      });
      this.$emit('input', this.results);
    },
    asyncFind: Object(__WEBPACK_IMPORTED_MODULE_1__debounce__["a" /* default */])(function (query) {
      this.isLoading = true;
      this.$root.$emit('options-query', query);
    }, 300)
  }
});

/***/ }),
/* 46 */,
/* 47 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_admin_http__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_admin_components_Select_MultiSelect_vue__ = __webpack_require__(44);
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ __webpack_exports__["a"] = ({
  name: 'InvoiceCustomers',
  components: {
    MultiSelect: __WEBPACK_IMPORTED_MODULE_1_admin_components_Select_MultiSelect_vue__["a" /* default */]
  },
  data: function data() {
    return {
      selected: [],
      options: []
    };
  },
  created: function created() {
    var _this = this;

    this.$root.$on('options-query', function (query) {
      _this.options = [];

      if (query) {
        _this.getCustomers(query);
      }
    });
  },
  watch: {
    selected: function selected() {
      this.$emit('input', this.selected);
    }
  },
  methods: {
    getCustomers: function getCustomers(query) {
      var _this2 = this;

      __WEBPACK_IMPORTED_MODULE_0_admin_http__["a" /* default */].get('/customers', {
        params: {
          search: query
        }
      }).then(function (response) {
        response.data.forEach(function (item) {
          _this2.options.push({
            id: item.id,
            name: item.first_name + ' ' + item.last_name
          });
        });
      });
    }
  }
});

/***/ }),
/* 48 */,
/* 49 */,
/* 50 */,
/* 51 */,
/* 52 */,
/* 53 */,
/* 54 */,
/* 55 */,
/* 56 */,
/* 57 */,
/* 58 */,
/* 59 */,
/* 60 */,
/* 61 */,
/* 62 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue__ = __webpack_require__(4);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vee_validate__ = __webpack_require__(14);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__App_vue__ = __webpack_require__(63);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__router__ = __webpack_require__(89);
 // import Vuex from 'vuex'




__WEBPACK_IMPORTED_MODULE_0_vue__["default"].config.productionTip = false;
__WEBPACK_IMPORTED_MODULE_0_vue__["default"].use(__WEBPACK_IMPORTED_MODULE_1_vee_validate__["default"]);
/* eslint-disable no-new */

new __WEBPACK_IMPORTED_MODULE_0_vue__["default"]({
  el: '#erp-accounting',
  router: __WEBPACK_IMPORTED_MODULE_3__router__["a" /* default */],
  render: function render(h) {
    return h(__WEBPACK_IMPORTED_MODULE_2__App_vue__["a" /* default */]);
  }
});

/***/ }),
/* 63 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_App_vue__ = __webpack_require__(15);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_6bc4b6d8_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_App_vue__ = __webpack_require__(88);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(64)
}
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_App_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_6bc4b6d8_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_App_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/admin/App.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-6bc4b6d8", Component.options)
  } else {
    hotAPI.reload("data-v-6bc4b6d8", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),
/* 64 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 65 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_ERPMenu_vue__ = __webpack_require__(16);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_77b17d3c_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_ERPMenu_vue__ = __webpack_require__(76);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(66)
}
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_ERPMenu_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_77b17d3c_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_ERPMenu_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/admin/components/Menu/ERPMenu.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-77b17d3c", Component.options)
  } else {
    hotAPI.reload("data-v-77b17d3c", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),
/* 66 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 67 */,
/* 68 */,
/* 69 */,
/* 70 */,
/* 71 */,
/* 72 */,
/* 73 */,
/* 74 */,
/* 75 */,
/* 76 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "erp-nav-container" }, [
    _c("div", { staticClass: "erp-page-header" }, [
      _c("div", { staticClass: "module-icon" }, [
        _c(
          "svg",
          {
            attrs: {
              id: "Group_235",
              "data-name": "Group 235",
              xmlns: "http://www.w3.org/2000/svg",
              viewBox: "0 0 239 341.4"
            }
          },
          [
            _c("path", {
              staticClass: "cls-1",
              attrs: { id: "Path_281", "data-name": "Path 281", d: _vm.svgData }
            })
          ]
        )
      ]),
      _vm._v(" "),
      _c("h2", [_vm._v(_vm._s(_vm.module_name))])
    ]),
    _vm._v(" "),
    _c(
      "ul",
      { class: _vm.primaryNav },
      [
        _vm._l(_vm.menuItems, function(menu, index) {
          return [
            menu.hasOwnProperty("submenu")
              ? _c("li", { key: index, class: _vm.dropdownNav }, [
                  _c("a", { attrs: { href: _vm.current_url + menu.slug } }, [
                    _vm._v(_vm._s(menu.title))
                  ]),
                  _vm._v(" "),
                  _c(
                    "ul",
                    { class: _vm.dropDownClass },
                    _vm._l(menu.submenu, function(item, index) {
                      return _c("li", { key: index }, [
                        _c(
                          "a",
                          { attrs: { href: _vm.current_url + item.slug } },
                          [_vm._v(_vm._s(item.title))]
                        )
                      ])
                    })
                  )
                ])
              : _c("li", { key: index }, [
                  _c("a", { attrs: { href: _vm.current_url + menu.slug } }, [
                    _vm._v(_vm._s(menu.title))
                  ])
                ])
          ]
        })
      ],
      2
    )
  ])
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-77b17d3c", esExports)
  }
}

/***/ }),
/* 77 */,
/* 78 */,
/* 79 */,
/* 80 */,
/* 81 */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(82);

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(6)(content, options);

if(content.locals) module.exports = content.locals;

if(false) {
	module.hot.accept("!!../../node_modules/css-loader/index.js!./flaticon.css", function() {
		var newContent = require("!!../../node_modules/css-loader/index.js!./flaticon.css");

		if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];

		var locals = (function(a, b) {
			var key, idx = 0;

			for(key in a) {
				if(!b || a[key] !== b[key]) return false;
				idx++;
			}

			for(key in b) idx--;

			return idx === 0;
		}(content.locals, newContent.locals));

		if(!locals) throw new Error('Aborting CSS HMR due to changed css-modules locals.');

		update(newContent);
	});

	module.hot.dispose(function() { update(); });
}

/***/ }),
/* 82 */
/***/ (function(module, exports, __webpack_require__) {

var escape = __webpack_require__(83);
exports = module.exports = __webpack_require__(5)(false);
// imports


// module
exports.push([module.i, "\t/*\n  \tFlaticon icon font: Flaticon\n  \tCreation date: 05/12/2018 09:12\n  \t*/\n\n@font-face {\n  font-family: \"Flaticon\";\n  src: url(" + escape(__webpack_require__(19)) + ");\n  src: url(" + escape(__webpack_require__(19)) + "?#iefix) format(\"embedded-opentype\"),\n       url(" + escape(__webpack_require__(84)) + ") format(\"woff\"),\n       url(" + escape(__webpack_require__(85)) + ") format(\"truetype\"),\n       url(" + escape(__webpack_require__(20)) + "#Flaticon) format(\"svg\");\n  font-weight: normal;\n  font-style: normal;\n}\n\n@media screen and (-webkit-min-device-pixel-ratio:0) {\n  @font-face {\n    font-family: \"Flaticon\";\n    src: url(" + escape(__webpack_require__(20)) + "#Flaticon) format(\"svg\");\n  }\n}\n\n[class^=\"flaticon-\"]:before, [class*=\" flaticon-\"]:before,\n[class^=\"flaticon-\"]:after, [class*=\" flaticon-\"]:after {   \n  font-family: Flaticon;\n  font-size: 20px;\n  font-style: normal;\n  margin-left: 20px;\n}\n\n.flaticon-menu:before { content: \"\\F100\"; }\n.flaticon-arrow-down-sign-to-navigate:before { content: \"\\F101\"; }\n.flaticon-magnifying-glass:before { content: \"\\F102\"; }\n.flaticon-arrow-point-to-right:before { content: \"\\F103\"; }\n.flaticon-search-segment:before { content: \"\\F104\"; }\n.flaticon-edit:before { content: \"\\F105\"; }\n.flaticon-quick-edit:before { content: \"\\F106\"; }\n.flaticon-user:before { content: \"\\F107\"; }\n.flaticon-download:before { content: \"\\F108\"; }\n.flaticon-import:before { content: \"\\F109\"; }\n.flaticon-add-plus-button:before { content: \"\\F10A\"; }\n.flaticon-move:before { content: \"\\F10B\"; }\n.flaticon-arrow-right:before { content: \"\\F10C\"; }\n.flaticon-arrow-up:before { content: \"\\F10D\"; }\n.flaticon-trash:before { content: \"\\F10E\"; }\n.flaticon-leader:before { content: \"\\F10F\"; }\n.flaticon-opportunity:before { content: \"\\F110\"; }\n.flaticon-check:before { content: \"\\F111\"; }\n.flaticon-eye-close-up:before { content: \"\\F112\"; }\n.flaticon-printer:before { content: \"\\F113\"; }\n.flaticon-sent-mail:before { content: \"\\F114\"; }\n.flaticon-alarm-clock:before { content: \"\\F115\"; }\n.flaticon-share:before { content: \"\\F116\"; }\n.flaticon-link-symbol:before { content: \"\\F117\"; }\n.flaticon-copy-content:before { content: \"\\F118\"; }\n.flaticon-delete:before { content: \"\\F119\"; }\n.flaticon-filter-tool-black-shape:before { content: \"\\F11A\"; }\n.flaticon-calendar:before { content: \"\\F11B\"; }\n.flaticon-printer-1:before { content: \"\\F11C\"; }\n.flaticon-settings-work-tool:before { content: \"\\F11D\"; }", ""]);

// exports


/***/ }),
/* 83 */,
/* 84 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__.p + "/Users/wedevs/Local Sites/wp-erp-ac/app/public/wp-content/plugins/wp-erp/modules/accounting/assets/font/Flaticon.woff";

/***/ }),
/* 85 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__.p + "/Users/wedevs/Local Sites/wp-erp-ac/app/public/wp-content/plugins/wp-erp/modules/accounting/assets/font/Flaticon.ttf";

/***/ }),
/* 86 */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(87);

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(6)(content, options);

if(content.locals) module.exports = content.locals;

if(false) {
	module.hot.accept("!!../../node_modules/css-loader/index.js!./master.css", function() {
		var newContent = require("!!../../node_modules/css-loader/index.js!./master.css");

		if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];

		var locals = (function(a, b) {
			var key, idx = 0;

			for(key in a) {
				if(!b || a[key] !== b[key]) return false;
				idx++;
			}

			for(key in b) idx--;

			return idx === 0;
		}(content.locals, newContent.locals));

		if(!locals) throw new Error('Aborting CSS HMR due to changed css-modules locals.');

		update(newContent);
	});

	module.hot.dispose(function() { update(); });
}

/***/ }),
/* 87 */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(5)(false);
// imports


// module
exports.push([module.i, "*,*::before,*::after{-webkit-box-sizing:border-box;box-sizing:border-box}html{font-family:sans-serif;line-height:1.15;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;-ms-overflow-style:scrollbar;-webkit-tap-highlight-color:rgba(0,0,0,0)}@at-root{@-ms-viewport{width:device-width}}article,aside,figcaption,figure,footer,header,hgroup,main,nav,section{display:block}body{margin:0;font-family:-apple-system,BlinkMacSystemFont,\"Segoe UI\",Roboto,\"Helvetica Neue\",Arial,sans-serif,\"Apple Color Emoji\",\"Segoe UI Emoji\",\"Segoe UI Symbol\",\"Noto Color Emoji\";font-size:13px;font-weight:400;line-height:1.5;color:#72777c;text-align:left;background-color:#f1f1f1}[tabindex=\"-1\"]:focus{outline:0 !important}hr{-webkit-box-sizing:content-box;box-sizing:content-box;height:0;overflow:visible}h1,h2,h3,h4,h5,h6,.h1,.h2,.h3,.h4,.h5,.h6{margin-top:0;margin-bottom:.5rem;font-family:inherit;font-weight:700;line-height:1.2;color:#23282d}h1,.h1{font-size:23.01px}h2,.h2{font-size:18.005px}h3,.h3{font-size:16.003px}h4,.h4{font-size:14.001px}h5,.h5{font-size:13px}h6,.h6{font-size:11.999px}p{font-size:1.2em;line-height:1.61em;font-weight:300;margin-top:0;margin-bottom:1rem}abbr[title],abbr[data-original-title]{text-decoration:underline;-webkit-text-decoration:underline dotted;text-decoration:underline dotted;cursor:help;border-bottom:0}address{margin-bottom:1rem;font-style:normal;line-height:inherit}ol,ul,dl{margin-top:0;margin-bottom:1rem}ol ol,ul ul,ol ul,ul ol{margin-bottom:0}dt{font-weight:700}dd{margin-bottom:.5rem;margin-left:0}blockquote{margin:0 0 1rem}dfn{font-style:italic}b,strong{font-weight:bolder}small{font-size:80%}sub,sup{position:relative;font-size:75%;line-height:0;vertical-align:baseline}sub{bottom:-0.25em}sup{top:-0.5em}a{color:#1a9ed4;text-decoration:none;background-color:transparent;-webkit-text-decoration-skip:objects}a:hover,a:focus{color:#126b90;text-decoration:none}a:not([href]):not([tabindex]){color:inherit;text-decoration:none}a:not([href]):not([tabindex]):hover,a:not([href]):not([tabindex]):focus{color:inherit;text-decoration:none}a:not([href]):not([tabindex]):focus{outline:0}pre,code,kbd,samp{font-family:SFMono-Regular,Menlo,Monaco,Consolas,\"Liberation Mono\",\"Courier New\",monospace;font-size:1em}pre{margin-top:0;margin-bottom:1rem;overflow:auto;-ms-overflow-style:scrollbar}figure{margin:0 0 1rem}img{vertical-align:middle;border-style:none}svg{overflow:hidden;vertical-align:middle}table{border-collapse:collapse}caption{padding-top:18px 10px;padding-bottom:18px 10px;color:#ccc;text-align:left;caption-side:bottom}th{text-align:inherit}label{display:inline-block;margin-bottom:.5rem}button{border-radius:0}button:focus{outline:1px dotted;outline:5px auto -webkit-focus-ring-color}input,button,select,optgroup,textarea{margin:0;font-family:inherit;font-size:inherit;line-height:inherit}button,input{overflow:visible}button,select{text-transform:none}button,html [type=\"button\"],[type=\"reset\"],[type=\"submit\"]{-webkit-appearance:button}button::-moz-focus-inner,[type=\"button\"]::-moz-focus-inner,[type=\"reset\"]::-moz-focus-inner,[type=\"submit\"]::-moz-focus-inner{padding:0;border-style:none}input[type=\"radio\"],input[type=\"checkbox\"]{-webkit-box-sizing:border-box;box-sizing:border-box;padding:0}input[type=\"date\"],input[type=\"time\"],input[type=\"datetime-local\"],input[type=\"month\"]{-webkit-appearance:listbox}textarea{overflow:auto;resize:vertical}fieldset{min-width:0;padding:0;margin:0;border:0}legend{display:block;width:100%;max-width:100%;padding:0;margin-bottom:.5rem;font-size:1.5rem;line-height:inherit;color:inherit;white-space:normal}progress{vertical-align:baseline}[type=\"number\"]::-webkit-inner-spin-button,[type=\"number\"]::-webkit-outer-spin-button{height:auto}[type=\"search\"]{outline-offset:-2px;-webkit-appearance:none}[type=\"search\"]::-webkit-search-cancel-button,[type=\"search\"]::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{font:inherit;-webkit-appearance:button}output{display:inline-block}summary{display:list-item;cursor:pointer}template{display:none}[hidden]{display:none !important}.display-none{display:none !important}.display-inline{display:inline !important}.display-inline-block{display:inline-block !important}.display-block{display:block !important}.display-table{display:table !important}.display-table-row{display:table-row !important}.display-table-cell{display:table-cell !important}.display-flex{display:-webkit-box !important;display:-ms-flexbox !important;display:flex !important}.display-inline-flex{display:-webkit-inline-box !important;display:-ms-inline-flexbox !important;display:inline-flex !important}@media (max-width:782px){.wperp-hidden-sm{display:none}}@media (min-width:783px){.wperp-hidden-lg{display:none}}.wperp-container-fluid,.wperp-container{margin-right:auto;margin-left:auto}.wperp-container-fluid{padding-right:2rem;padding-left:2rem}.wperp-row{-webkit-box-sizing:border-box;box-sizing:border-box;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-flex:0;-ms-flex:0 1 auto;flex:0 1 auto;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-ms-flex-direction:row;flex-direction:row;-ms-flex-wrap:wrap;flex-wrap:wrap;margin-right:-0.5rem;margin-left:-0.5rem}.wperp-row.wperp-reverse{-webkit-box-orient:horizontal;-webkit-box-direction:reverse;-ms-flex-direction:row-reverse;flex-direction:row-reverse}.wperp-col.wperp-reverse{-webkit-box-orient:vertical;-webkit-box-direction:reverse;-ms-flex-direction:column-reverse;flex-direction:column-reverse}.wperp-col-xs,.wperp-col-xs-1,.wperp-col-xs-2,.wperp-col-xs-3,.wperp-col-xs-4,.wperp-col-xs-5,.wperp-col-xs-6,.wperp-col-xs-7,.wperp-col-xs-8,.wperp-col-xs-9,.wperp-col-xs-10,.wperp-col-xs-11,.wperp-col-xs-12,.wperp-col-xs-offset-0,.wperp-col-xs-offset-1,.wperp-col-xs-offset-2,.wperp-col-xs-offset-3,.wperp-col-xs-offset-4,.wperp-col-xs-offset-5,.wperp-col-xs-offset-6,.wperp-col-xs-offset-7,.wperp-col-xs-offset-8,.wperp-col-xs-offset-9,.wperp-col-xs-offset-10,.wperp-col-xs-offset-11,.wperp-col-xs-offset-12{-webkit-box-sizing:border-box;box-sizing:border-box;-webkit-box-flex:0;-ms-flex:0 0 auto;flex:0 0 auto;padding-right:.5rem;padding-left:.5rem}.wperp-col-xs{-webkit-box-flex:1;-ms-flex-positive:1;flex-grow:1;-ms-flex-preferred-size:0;flex-basis:0;max-width:100%}.wperp-col-xs-1{-ms-flex-preferred-size:8.33333333%;flex-basis:8.33333333%;max-width:8.33333333%}.wperp-col-xs-2{-ms-flex-preferred-size:16.66666667%;flex-basis:16.66666667%;max-width:16.66666667%}.wperp-col-xs-3{-ms-flex-preferred-size:25%;flex-basis:25%;max-width:25%}.wperp-col-xs-4{-ms-flex-preferred-size:33.33333333%;flex-basis:33.33333333%;max-width:33.33333333%}.wperp-col-xs-5{-ms-flex-preferred-size:41.66666667%;flex-basis:41.66666667%;max-width:41.66666667%}.wperp-col-xs-6{-ms-flex-preferred-size:50%;flex-basis:50%;max-width:50%}.wperp-col-xs-7{-ms-flex-preferred-size:58.33333333%;flex-basis:58.33333333%;max-width:58.33333333%}.wperp-col-xs-8{-ms-flex-preferred-size:66.66666667%;flex-basis:66.66666667%;max-width:66.66666667%}.wperp-col-xs-9{-ms-flex-preferred-size:75%;flex-basis:75%;max-width:75%}.wperp-col-xs-10{-ms-flex-preferred-size:83.33333333%;flex-basis:83.33333333%;max-width:83.33333333%}.wperp-col-xs-11{-ms-flex-preferred-size:91.66666667%;flex-basis:91.66666667%;max-width:91.66666667%}.wperp-col-xs-12{-ms-flex-preferred-size:100%;flex-basis:100%;max-width:100%}.wperp-col-xs-offset-0{margin-left:0}.wperp-col-xs-offset-1{margin-left:8.33333333%}.wperp-col-xs-offset-2{margin-left:16.66666667%}.wperp-col-xs-offset-3{margin-left:25%}.wperp-col-xs-offset-4{margin-left:33.33333333%}.wperp-col-xs-offset-5{margin-left:41.66666667%}.wperp-col-xs-offset-6{margin-left:50%}.wperp-col-xs-offset-7{margin-left:58.33333333%}.wperp-col-xs-offset-8{margin-left:66.66666667%}.wperp-col-xs-offset-9{margin-left:75%}.wperp-col-xs-offset-10{margin-left:83.33333333%}.wperp-col-xs-offset-11{margin-left:91.66666667%}.wperp-start-xs{-webkit-box-pack:start;-ms-flex-pack:start;justify-content:flex-start;text-align:start}.wperp-center-xs{-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;text-align:center}.wperp-end-xs{-webkit-box-pack:end;-ms-flex-pack:end;justify-content:flex-end;text-align:end}.wperp-top-xs{-webkit-box-align:start;-ms-flex-align:start;align-items:flex-start}.wperp-middle-xs{-webkit-box-align:center;-ms-flex-align:center;align-items:center}.wperp-bottom-xs{-webkit-box-align:end;-ms-flex-align:end;align-items:flex-end}.wperp-around-xs{-ms-flex-pack:distribute;justify-content:space-around}.wperp-between-xs{-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between}.wperp-first-xs{-webkit-box-ordinal-group:0;-ms-flex-order:-1;order:-1}.wperp-last-xs{-webkit-box-ordinal-group:2;-ms-flex-order:1;order:1}@media only screen and (max-width:48em){.wperp-container{margin:0 15px}}@media only screen and (min-width:48em){.wperp-container{width:46rem}.wperp-col-sm,.wperp-col-sm-1,.wperp-col-sm-2,.wperp-col-sm-3,.wperp-col-sm-4,.wperp-col-sm-5,.wperp-col-sm-6,.wperp-col-sm-7,.wperp-col-sm-8,.wperp-col-sm-9,.wperp-col-sm-10,.wperp-col-sm-11,.wperp-col-sm-12,.wperp-col-sm-offset-0,.wperp-col-sm-offset-1,.wperp-col-sm-offset-2,.wperp-col-sm-offset-3,.wperp-col-sm-offset-4,.wperp-col-sm-offset-5,.wperp-col-sm-offset-6,.wperp-col-sm-offset-7,.wperp-col-sm-offset-8,.wperp-col-sm-offset-9,.wperp-col-sm-offset-10,.wperp-col-sm-offset-11,.wperp-col-sm-offset-12{-webkit-box-sizing:border-box;box-sizing:border-box;-webkit-box-flex:0;-ms-flex:0 0 auto;flex:0 0 auto;padding-right:.5rem;padding-left:.5rem}.wperp-col-sm{-webkit-box-flex:1;-ms-flex-positive:1;flex-grow:1;-ms-flex-preferred-size:0;flex-basis:0;max-width:100%}.wperp-col-sm-1{-ms-flex-preferred-size:8.33333333%;flex-basis:8.33333333%;max-width:8.33333333%}.wperp-col-sm-2{-ms-flex-preferred-size:16.66666667%;flex-basis:16.66666667%;max-width:16.66666667%}.wperp-col-sm-3{-ms-flex-preferred-size:25%;flex-basis:25%;max-width:25%}.wperp-col-sm-4{-ms-flex-preferred-size:33.33333333%;flex-basis:33.33333333%;max-width:33.33333333%}.wperp-col-sm-5{-ms-flex-preferred-size:41.66666667%;flex-basis:41.66666667%;max-width:41.66666667%}.wperp-col-sm-6{-ms-flex-preferred-size:50%;flex-basis:50%;max-width:50%}.wperp-col-sm-7{-ms-flex-preferred-size:58.33333333%;flex-basis:58.33333333%;max-width:58.33333333%}.wperp-col-sm-8{-ms-flex-preferred-size:66.66666667%;flex-basis:66.66666667%;max-width:66.66666667%}.wperp-col-sm-9{-ms-flex-preferred-size:75%;flex-basis:75%;max-width:75%}.wperp-col-sm-10{-ms-flex-preferred-size:83.33333333%;flex-basis:83.33333333%;max-width:83.33333333%}.wperp-col-sm-11{-ms-flex-preferred-size:91.66666667%;flex-basis:91.66666667%;max-width:91.66666667%}.wperp-col-sm-12{-ms-flex-preferred-size:100%;flex-basis:100%;max-width:100%}.wperp-col-sm-offset-0{margin-left:0}.wperp-col-sm-offset-1{margin-left:8.33333333%}.wperp-col-sm-offset-2{margin-left:16.66666667%}.wperp-col-sm-offset-3{margin-left:25%}.wperp-col-sm-offset-4{margin-left:33.33333333%}.wperp-col-sm-offset-5{margin-left:41.66666667%}.wperp-col-sm-offset-6{margin-left:50%}.wperp-col-sm-offset-7{margin-left:58.33333333%}.wperp-col-sm-offset-8{margin-left:66.66666667%}.wperp-col-sm-offset-9{margin-left:75%}.wperp-col-sm-offset-10{margin-left:83.33333333%}.wperp-col-sm-offset-11{margin-left:91.66666667%}.wperp-start-sm{-webkit-box-pack:start;-ms-flex-pack:start;justify-content:flex-start;text-align:start}.wperp-center-sm{-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;text-align:center}.wperp-end-sm{-webkit-box-pack:end;-ms-flex-pack:end;justify-content:flex-end;text-align:end}.wperp-top-sm{-webkit-box-align:start;-ms-flex-align:start;align-items:flex-start}.wperp-middle-sm{-webkit-box-align:center;-ms-flex-align:center;align-items:center}.wperp-bottom-sm{-webkit-box-align:end;-ms-flex-align:end;align-items:flex-end}.wperp-around-sm{-ms-flex-pack:distribute;justify-content:space-around}.wperp-between-sm{-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between}.wperp-first-sm{-webkit-box-ordinal-group:0;-ms-flex-order:-1;order:-1}.wperp-last-sm{-webkit-box-ordinal-group:2;-ms-flex-order:1;order:1}}@media only screen and (min-width:64em){.wperp-container{width:63rem}.wperp-col-md,.wperp-col-md-1,.wperp-col-md-2,.wperp-col-md-3,.wperp-col-md-4,.wperp-col-md-5,.wperp-col-md-6,.wperp-col-md-7,.wperp-col-md-8,.wperp-col-md-9,.wperp-col-md-10,.wperp-col-md-11,.wperp-col-md-12,.wperp-col-md-offset-0,.wperp-col-md-offset-1,.wperp-col-md-offset-2,.wperp-col-md-offset-3,.wperp-col-md-offset-4,.wperp-col-md-offset-5,.wperp-col-md-offset-6,.wperp-col-md-offset-7,.wperp-col-md-offset-8,.wperp-col-md-offset-9,.wperp-col-md-offset-10,.wperp-col-md-offset-11,.wperp-col-md-offset-12{-webkit-box-sizing:border-box;box-sizing:border-box;-webkit-box-flex:0;-ms-flex:0 0 auto;flex:0 0 auto;padding-right:.5rem;padding-left:.5rem}.wperp-col-md{-webkit-box-flex:1;-ms-flex-positive:1;flex-grow:1;-ms-flex-preferred-size:0;flex-basis:0;max-width:100%}.wperp-col-md-1{-ms-flex-preferred-size:8.33333333%;flex-basis:8.33333333%;max-width:8.33333333%}.wperp-col-md-2{-ms-flex-preferred-size:16.66666667%;flex-basis:16.66666667%;max-width:16.66666667%}.wperp-col-md-3{-ms-flex-preferred-size:25%;flex-basis:25%;max-width:25%}.wperp-col-md-4{-ms-flex-preferred-size:33.33333333%;flex-basis:33.33333333%;max-width:33.33333333%}.wperp-col-md-5{-ms-flex-preferred-size:41.66666667%;flex-basis:41.66666667%;max-width:41.66666667%}.wperp-col-md-6{-ms-flex-preferred-size:50%;flex-basis:50%;max-width:50%}.wperp-col-md-7{-ms-flex-preferred-size:58.33333333%;flex-basis:58.33333333%;max-width:58.33333333%}.wperp-col-md-8{-ms-flex-preferred-size:66.66666667%;flex-basis:66.66666667%;max-width:66.66666667%}.wperp-col-md-9{-ms-flex-preferred-size:75%;flex-basis:75%;max-width:75%}.wperp-col-md-10{-ms-flex-preferred-size:83.33333333%;flex-basis:83.33333333%;max-width:83.33333333%}.wperp-col-md-11{-ms-flex-preferred-size:91.66666667%;flex-basis:91.66666667%;max-width:91.66666667%}.wperp-col-md-12{-ms-flex-preferred-size:100%;flex-basis:100%;max-width:100%}.wperp-col-md-offset-0{margin-left:0}.wperp-col-md-offset-1{margin-left:8.33333333%}.wperp-col-md-offset-2{margin-left:16.66666667%}.wperp-col-md-offset-3{margin-left:25%}.wperp-col-md-offset-4{margin-left:33.33333333%}.wperp-col-md-offset-5{margin-left:41.66666667%}.wperp-col-md-offset-6{margin-left:50%}.wperp-col-md-offset-7{margin-left:58.33333333%}.wperp-col-md-offset-8{margin-left:66.66666667%}.wperp-col-md-offset-9{margin-left:75%}.wperp-col-md-offset-10{margin-left:83.33333333%}.wperp-col-md-offset-11{margin-left:91.66666667%}.wperp-start-md{-webkit-box-pack:start;-ms-flex-pack:start;justify-content:flex-start;text-align:start}.wperp-center-md{-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;text-align:center}.wperp-end-md{-webkit-box-pack:end;-ms-flex-pack:end;justify-content:flex-end;text-align:end}.wperp-top-md{-webkit-box-align:start;-ms-flex-align:start;align-items:flex-start}.wperp-middle-md{-webkit-box-align:center;-ms-flex-align:center;align-items:center}.wperp-bottom-md{-webkit-box-align:end;-ms-flex-align:end;align-items:flex-end}.wperp-around-md{-ms-flex-pack:distribute;justify-content:space-around}.wperp-between-md{-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between}.wperp-first-md{-webkit-box-ordinal-group:0;-ms-flex-order:-1;order:-1}.wperp-last-md{-webkit-box-ordinal-group:2;-ms-flex-order:1;order:1}}@media only screen and (min-width:75em){.wperp-container{width:74rem}.wperp-col-lg,.wperp-col-lg-1,.wperp-col-lg-2,.wperp-col-lg-3,.wperp-col-lg-4,.wperp-col-lg-5,.wperp-col-lg-6,.wperp-col-lg-7,.wperp-col-lg-8,.wperp-col-lg-9,.wperp-col-lg-10,.wperp-col-lg-11,.wperp-col-lg-12,.wperp-col-lg-offset-0,.wperp-col-lg-offset-1,.wperp-col-lg-offset-2,.wperp-col-lg-offset-3,.wperp-col-lg-offset-4,.wperp-col-lg-offset-5,.wperp-col-lg-offset-6,.wperp-col-lg-offset-7,.wperp-col-lg-offset-8,.wperp-col-lg-offset-9,.wperp-col-lg-offset-10,.wperp-col-lg-offset-11,.wperp-col-lg-offset-12{-webkit-box-sizing:border-box;box-sizing:border-box;-webkit-box-flex:0;-ms-flex:0 0 auto;flex:0 0 auto;padding-right:.5rem;padding-left:.5rem}.wperp-col-lg{-webkit-box-flex:1;-ms-flex-positive:1;flex-grow:1;-ms-flex-preferred-size:0;flex-basis:0;max-width:100%}.wperp-col-lg-1{-ms-flex-preferred-size:8.33333333%;flex-basis:8.33333333%;max-width:8.33333333%}.wperp-col-lg-2{-ms-flex-preferred-size:16.66666667%;flex-basis:16.66666667%;max-width:16.66666667%}.wperp-col-lg-3{-ms-flex-preferred-size:25%;flex-basis:25%;max-width:25%}.wperp-col-lg-4{-ms-flex-preferred-size:33.33333333%;flex-basis:33.33333333%;max-width:33.33333333%}.wperp-col-lg-5{-ms-flex-preferred-size:41.66666667%;flex-basis:41.66666667%;max-width:41.66666667%}.wperp-col-lg-6{-ms-flex-preferred-size:50%;flex-basis:50%;max-width:50%}.wperp-col-lg-7{-ms-flex-preferred-size:58.33333333%;flex-basis:58.33333333%;max-width:58.33333333%}.wperp-col-lg-8{-ms-flex-preferred-size:66.66666667%;flex-basis:66.66666667%;max-width:66.66666667%}.wperp-col-lg-9{-ms-flex-preferred-size:75%;flex-basis:75%;max-width:75%}.wperp-col-lg-10{-ms-flex-preferred-size:83.33333333%;flex-basis:83.33333333%;max-width:83.33333333%}.wperp-col-lg-11{-ms-flex-preferred-size:91.66666667%;flex-basis:91.66666667%;max-width:91.66666667%}.wperp-col-lg-12{-ms-flex-preferred-size:100%;flex-basis:100%;max-width:100%}.wperp-col-lg-offset-0{margin-left:0}.wperp-col-lg-offset-1{margin-left:8.33333333%}.wperp-col-lg-offset-2{margin-left:16.66666667%}.wperp-col-lg-offset-3{margin-left:25%}.wperp-col-lg-offset-4{margin-left:33.33333333%}.wperp-col-lg-offset-5{margin-left:41.66666667%}.wperp-col-lg-offset-6{margin-left:50%}.wperp-col-lg-offset-7{margin-left:58.33333333%}.wperp-col-lg-offset-8{margin-left:66.66666667%}.wperp-col-lg-offset-9{margin-left:75%}.wperp-col-lg-offset-10{margin-left:83.33333333%}.wperp-col-lg-offset-11{margin-left:91.66666667%}.wperp-start-lg{-webkit-box-pack:start;-ms-flex-pack:start;justify-content:flex-start;text-align:start}.wperp-center-lg{-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;text-align:center}.wperp-end-lg{-webkit-box-pack:end;-ms-flex-pack:end;justify-content:flex-end;text-align:end}.wperp-top-lg{-webkit-box-align:start;-ms-flex-align:start;align-items:flex-start}.wperp-middle-lg{-webkit-box-align:center;-ms-flex-align:center;align-items:center}.wperp-bottom-lg{-webkit-box-align:end;-ms-flex-align:end;align-items:flex-end}.wperp-around-lg{-ms-flex-pack:distribute;justify-content:space-around}.wperp-between-lg{-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between}.wperp-first-lg{-webkit-box-ordinal-group:0;-ms-flex-order:-1;order:-1}.wperp-last-lg{-webkit-box-ordinal-group:2;-ms-flex-order:1;order:1}}body{background:#f5f5f5}[class*='flaticon']:before{margin-left:0;font-size:inherit;color:#d7dee2}.dismiss-bulk-action:hover i:before{color:#f96332}.screen-reader-text{border:0;clip:rect(1px, 1px, 1px, 1px);-webkit-clip-path:inset(50%);clip-path:inset(50%);height:1px;margin:-1px;overflow:hidden;padding:0;position:absolute;width:1px;word-wrap:normal !important}.text-right{text-align:right}.text-left{text-align:left}.text-justify{text-align:justify}.text-center{text-align:center}.wperp-has-border-top{border-top:1px solid #e5e5e5;padding-top:20px}.separator{margin:20px 0}.separator-top{margin-top:20px}.separator-bottom{margin-bottom:20px}.flaticon-import{color:#d7dee2 !important;font-size:12px}.content-header-section .wperp-row{margin-left:0;margin-right:0}.content-header-section .wperp-row .wperp-col{display:-webkit-box;display:-ms-flexbox;display:flex}.content-header-section .wperp-row .wperp-col .content-header__title{margin-bottom:0}.content-header-section .wperp-row .wperp-col .wperp-btn{display:inline-table}@media (max-width:767px){.content-header-section .wperp-row .wperp-col{display:-webkit-box;display:-ms-flexbox;display:flex;width:100%}.content-header-section .wperp-row .wperp-col:not(:last-child){margin-bottom:20px}}.content-header-section .content-header__title{margin-right:20px;display:inline-block;font-size:23px;font-weight:400}@media (max-width:480px){.content-header-section .crm-contact-search{display:block}.content-header-section .crm-contact-search>div{width:100% !important;margin:0 0 10px}}.content-header-section .crm-contact-search .input-icon{width:180px;margin-right:12px}.subsubsub-all:before{content:\"\\F10C\";font-family:'Flaticon'}.import-export-box{border:1px solid #e2e2e2;display:inline-block;border-radius:3px}.import-export-box a{padding:3.5px 7px;display:inline-block;font-size:14px;color:#b8c1c1;-webkit-transition:all .2s;transition:all .2s}.import-export-box a:last-child{border-left:1px solid #e2e2e2}.import-export-box a:hover{color:#1a9ed4}.import-export-box a i.flaticon-download{font-size:16px}.edit-badge{width:26px;height:26px;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;border-radius:50%;background:#d7dee2;cursor:pointer}.edit-badge i:before{color:#fff}.edit-badge:hover{background:rgba(0,0,0,0.5)}.mb-50{margin-bottom:50px !important}.mb-40{margin-bottom:40px !important}.mb-30{margin-bottom:30px !important}.mb-20{margin-bottom:20px !important}.mb-10{margin-bottom:10px !important}.mb-0{margin-bottom:0 !important}.mt-50{margin-top:50px !important}.mt-40{margin-top:40px !important}.mt-30{margin-top:30px !important}.mt-20{margin-top:20px !important}.mt-10{margin-top:10px !important}.mt-0{margin-top:0 !important}.pt-50{padding-top:50px !important}.pt-40{padding-top:40px !important}.pt-30{padding-top:30px !important}.pt-20{padding-top:20px !important}.pt-10{padding-top:10px !important}.pt-5{padding-top:5 !important}.pt-0{padding-top:0 !important}.pb-50{padding-bottom:50px !important}.pb-40{padding-bottom:40px !important}.pb-30{padding-bottom:30px !important}.pb-20{padding-bottom:20px !important}.pb-10{padding-bottom:10px !important}.pb-5{padding-bottom:5 !important}.pb-0{padding-bottom:0 !important}.pl-0{padding-left:0 !important}.pl-5{padding-left:5 !important}.pl-10{padding-left:10px !important}.pl-20{padding-left:20px !important}.pl-30{padding-left:30px !important}.pl-40{padding-left:40px !important}.pl-50{padding-left:50px !important}.pr-50{padding-right:50px !important}.pr-50{padding-right:50px !important}.pr-40{padding-right:40px !important}.pr-30{padding-right:30px !important}.pr-20{padding-right:20px !important}.pr-10{padding-right:10px !important}.pr-5{padding-right:5px !important}.pr-0{padding-right:0 !important}.margin-0{margin:0 !important}.padding-0{padding:0 !important}.form-check{padding-left:0;display:table-row;height:20px;width:20px}.form-check .form-check-label{display:block;position:relative;cursor:pointer;line-height:20px;margin:0 0 0 7px;-webkit-transition:color .3s linear;transition:color .3s linear}.radio .form-check-sign{padding-left:28px}.form-check .form-check-sign::before,.form-check .form-check-sign::after{content:\" \";display:inline-block;position:absolute;width:20px;height:20px;left:0;cursor:pointer;border-radius:3px;top:0;background-color:#fff;border:1px solid #e2e2e2;-webkit-transition:opacity .3s linear;transition:opacity .3s linear}.form-check .form-check-sign::after{font-family:\"Flaticon\";content:\"\\F111\";top:1px;text-align:center;font-size:9px;opacity:0;color:#fff;border:0;background-color:inherit}.form-check.disabled .form-check-label,.form-check.disabled .form-check-label{color:#9a9a9a;opacity:.5;cursor:not-allowed}.form-check input[type=\"checkbox\"],.radio input[type=\"radio\"]{opacity:0;position:absolute;visibility:hidden}.form-check input[type=\"checkbox\"]:checked+.form-check-sign::before{background-color:#1abc9c;border-color:transparent}.form-check input[type=\"checkbox\"]:checked+.form-check-sign::after{opacity:1}.form-control input[type=\"checkbox\"]:disabled+.form-check-sign::before,.checkbox input[type=\"checkbox\"]:disabled+.form-check-sign::after{cursor:not-allowed}.form-check input[type=\"checkbox\"]:disabled+.form-check-sign,.form-check input[type=\"radio\"]:disabled+.form-check-sign{pointer-events:none}.form-check-radio .form-check-sign::before,.form-check-radio .form-check-sign::after{content:\" \";width:20px;height:20px;border-radius:50%;border:1px solid #e2e2e2;display:inline-block;position:absolute;left:3px;top:3px;padding:1px;-webkit-transition:opacity .3s linear;transition:opacity .3s linear}.form-check-radio input[type=\"radio\"]+.form-check-sign:after,.form-check-radio input[type=\"radio\"]{opacity:0}.form-check-radio input[type=\"radio\"]:checked+.form-check-sign::after{width:4px;height:4px;background-color:#555;border-color:#555;top:11px;left:11px;opacity:1}.form-check-radio input[type=\"radio\"]:checked+.form-check-sign::after{opacity:1}.form-check-radio input[type=\"radio\"]:disabled+.form-check-sign{color:#9a9a9a}.form-check-radio input[type=\"radio\"]:disabled+.form-check-sign::before,.form-check-radio input[type=\"radio\"]:disabled+.form-check-sign::after{color:#9a9a9a}.wperp-list-unstyled{list-style:none;padding:0;margin:0}.wperp-btn{display:-webkit-inline-box;display:-ms-inline-flexbox;display:inline-flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;font-weight:400;text-align:center;white-space:nowrap;vertical-align:middle;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;border:1px solid transparent;padding:.313rem .7rem;font-size:12px;line-height:1.5;border-radius:3px;-webkit-transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;-webkit-transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-box-shadow .15s ease-in-out}.wperp-btn .hover-focus{text-decoration:none}.wperp-btn:focus,.wperp-btn.focus{outline:0;-webkit-box-shadow:0 0 0 .2rem rgba(26,158,212,0.0025);box-shadow:0 0 0 .2rem rgba(26,158,212,0.0025)}.wperp-btn.disabled,.wperp-btn:disabled{opacity:.65;-webkit-box-shadow:none;-o-box-shadow:none;box-shadow:none}.wperp-btn:not(:disabled):not(.disabled){cursor:pointer}.wperp-btn:not(:disabled):not(.disabled):active,.wperp-btn:not(:disabled):not(.disabled).active{-webkit-box-shadow:inset 0 3px 5px rgba(0,0,0,0.00125);-o-box-shadow:inset 0 3px 5px rgba(0,0,0,0.00125);box-shadow:inset 0 3px 5px rgba(0,0,0,0.00125)}.wperp-btn:not(:disabled):not(.disabled):active:focus,.wperp-btn:not(:disabled):not(.disabled).active:focus{-webkit-box-shadow:0 0 0 .2rem rgba(26,158,212,0.0025),inset 0 3px 5px rgba(0,0,0,0.00125);box-shadow:0 0 0 .2rem rgba(26,158,212,0.0025),inset 0 3px 5px rgba(0,0,0,0.00125)}.wperp-btn.btn--primary{background-color:#1a9ed4;color:#fff}.wperp-btn.btn--primary:hover{background-color:rgba(26,158,212,0.8)}.wperp-btn.btn--default{background-color:#fff;color:#000;border:1px solid #e2e2e2;border-radius:3px}.wperp-btn.btn--default:hover{background-color:#f2f2f2}.wperp-btn.btn--outline{border-color:inherit;background-color:transparent}.wperp-btn.btn--outline.btn--primary{color:#1a9ed4}.wperp-btn.btn--lg{padding:.5rem 1rem;font-size:1em;line-height:54px;border-radius:.3rem}.wperp-btn.btn--sm{padding:.25rem .5rem;font-size:.8571em;line-height:1.5;border-radius:.2rem}.wperp-btn i{-webkit-box-align:center;-ms-flex-align:center;align-items:center;display:-webkit-inline-box;display:-ms-inline-flexbox;display:inline-flex;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;height:1rem;width:1rem}.wperp-btn i:first-child:not(:last-child){margin-right:5px}.wperp-btn i:last-child:not(:first-child){margin-left:5px}.wperp-btn i:before{font-size:10px}a.btn.disabled,fieldset:disabled a.btn{pointer-events:none}.btn-link{font-weight:400;color:#1a9ed4;background-color:transparent}.btn-link .hover{color:#126b90;text-decoration:none;background-color:transparent;border-color:transparent}.btn-link:focus,.btn-link.focus{text-decoration:none;border-color:transparent;-webkit-box-shadow:none;box-shadow:none}.btn-link:disabled,.btn-link.disabled{color:#ccc;pointer-events:none}.btn-block{display:block;width:100%}.btn-block+.btn-block{margin-top:.5rem}input[type=\"submit\"].btn-block,input[type=\"reset\"].btn-block,input[type=\"button\"].btn-block{width:100%}.buttons-wrapper .wperp-btn{margin-left:15px}.buttons-wrapper .wperp-btn.ml-0{margin-left:0 !important}.col--actions .dropdown .dropdown-menu{left:auto;right:35px;top:-4px}.col--actions .dropdown .dropdown-menu:after,.col--actions .dropdown .dropdown-menu:before{left:100%;border:solid transparent;content:\" \";height:0;width:0;pointer-events:none}.col--actions .dropdown .dropdown-menu:after{top:14px;border-left-color:#fff;border-width:6px 9px}.col--actions .dropdown .dropdown-menu:before{top:13px;border-left-color:#e2e2e2;border-width:7px 10px}.dropdown-menu{position:absolute;top:100%;left:0;z-index:1000;min-width:160px;padding:5px 0;font-size:14px;text-align:left;list-style:none;background-color:#fff;background-clip:padding-box;border:1px solid #e2e2e2;border-radius:3px;-webkit-box-shadow:0 6px 12px rgba(0,0,0,0.175);-o-box-shadow:0 6px 12px rgba(0,0,0,0.175);box-shadow:0 6px 12px rgba(0,0,0,0.175);-webkit-transition:all .3s ease;transition:all .3s ease;opacity:0;visibility:hidden}.dropdown-menu.dropdown-menu-right{left:inherit;right:0}.dropdown-menu a{display:block;padding:7px 18px;color:#23282d;white-space:nowrap}.dropdown-menu a:hover{color:#1a9ed4;background:#f2f2f2}.dropdown-menu a:hover i{color:inherit}.dropdown-menu a i{font-size:14px;color:#d7dee2;margin-right:9px}.dropdown-menu:before,.dropdown-menu:after{position:absolute;z-index:999;border-width:8px;border-style:solid;border-color:transparent;right:15px;content:\"\"}.dropdown-menu:before{top:-16px;border-bottom-color:#e2e2e2}.dropdown-menu:after{top:-14px;border-bottom-color:#fff}.wperp-has-dropdown{position:relative;display:inline-block}.wperp-has-dropdown .dropdown-trigger *{pointer-events:none}.wperp-has-dropdown.dropdown-opened .dropdown-menu{-webkit-transform:translate(0 0);transform:translate(0 0);opacity:1;visibility:visible}.option-dropdown{width:150px;margin-right:13px;display:inline-block;border-radius:3px;-webkit-transition:all .5s ease;transition:all .5s ease;position:relative;font-size:14px;color:#474747;height:100%;text-align:left;background-color:#fff;border:1px solid #e2e2e2}.option-dropdown:hover{-webkit-box-shadow:0 0 4px #ccc;box-shadow:0 0 4px #ccc}.option-dropdown:active{background-color:#f8f8f8}.option-dropdown.active .select>i{-webkit-transform:rotate(-180deg);transform:rotate(-180deg)}.option-dropdown .select{cursor:pointer;display:block;padding:5px 10px}.option-dropdown .select span{color:#a5acb1;font-size:12px}.option-dropdown .select span i{font-size:inherit;margin-right:9px}.option-dropdown .select>i{font-size:9px;color:#d7dee2;cursor:pointer;-webkit-transition:all .3s ease-in-out;transition:all .3s ease-in-out;float:right;line-height:20px}.option-dropdown .dropdown-content{position:absolute;background-color:#fff;width:100%;left:0;top:100%;margin-top:-1px;border:1px solid #e2e2e2;-webkit-box-shadow:0 4px 10px 0 rgba(0,0,0,0.09);-o-box-shadow:0 4px 10px 0 rgba(0,0,0,0.09);box-shadow:0 4px 10px 0 rgba(0,0,0,0.09);border-radius:0 0 3px 3px;z-index:9;list-style:none;min-width:100%;padding:5px 0;font-size:14px;visibility:hidden;opacity:0;-webkit-transform:translateY(-10px);transform:translateY(-10px);-webkit-transition:all .3s ease-in-out;transition:all .3s ease-in-out}.option-dropdown .dropdown-content.dropdown-content-opened{visibility:visible;opacity:1;-webkit-transform:translateY(0);transform:translateY(0)}.option-dropdown .dropdown-content li a{display:block;padding:5px 20px;-webkit-transition:all .2s ease-in-out;transition:all .2s ease-in-out;cursor:pointer;color:#23282d}.option-dropdown .dropdown-content li a:hover,.option-dropdown .dropdown-content li a:active{color:#1a9ed4;background-color:#f5f8fa}.option-dropdown .dropdown-content li a:hover i,.option-dropdown .dropdown-content li a:active i{color:#1a9ed4}.option-dropdown .dropdown-content li a i{font-size:13px;color:#d7dee2;margin-right:9px}.wperp-form.form--inline{display:-webkit-inline-box;display:-ms-inline-flexbox;display:inline-flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center}@media (max-width:480px){.wperp-form.form--inline{display:block}}.wperp-input{display:block;width:100%;height:33px;padding:.313rem .7rem;font-size:13px;line-height:1.5;color:#ccc;background-color:#fff;background-clip:padding-box;border:1px solid #ececec;border-radius:3px}.wperp-input::-webkit-input-placeholder{color:#a5acb1;opacity:1}.wperp-input:-ms-input-placeholder{color:#a5acb1;opacity:1}.wperp-input::-ms-input-placeholder{color:#a5acb1;opacity:1}.wperp-input::placeholder{color:#a5acb1;opacity:1}.wperp-input:disabled,.wperp-input[readonly]{background-color:#ccc;opacity:1}.input-icon{position:relative}.input-icon i{font-size:inherit;position:absolute;right:0;width:2rem;height:100%;color:#d7dee2}.input-icon i:before{position:absolute;top:50%;left:50%;-webkit-transform:translate(-50%, -50%);transform:translate(-50%, -50%)}::-webkit-input-placeholder{color:#acacac}::-moz-placeholder{color:#acacac}:-ms-input-placeholder{color:#acacac}:-moz-placeholder{color:#acacac}.wperp-form-group{margin-bottom:20px}.wperp-form-horizontal .wperp-row{margin-bottom:17px}.wperp-form-horizontal .wperp-row label{margin-bottom:0;margin-top:8px}.wperp-form-horizontal .wperp-panel-body .wperp-row:last-child{margin-bottom:0}label{display:block;font-size:13px;margin-bottom:10px;color:#000}input,select,textarea{font-size:12px;color:#000}.wperp-required-sign{color:#e9485e}.wperp-custom-select{position:relative;border:1px solid #ececec;border-radius:3px}.wperp-custom-select select{border:0;-webkit-appearance:none;-moz-appearance:none;appearance:none}.wperp-custom-select i{position:absolute;right:0;top:0;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;height:100%;background:#fff;width:20px;pointer-events:none;z-index:2}.wperp-custom-select i:before{color:inherit;font-size:7px}.select2-container .select2-selection--single{min-height:35px;border-color:#ececec}.select2-container .select2-selection--single .select2-selection__rendered{padding-left:15px}.select2-container--default .select2-selection--single .select2-selection__rendered{line-height:30px;color:#5c5c6f}.select2-container--default .select2-selection--single .select2-selection__arrow{height:30px}.select2-dropdown,.select2-container--default .select2-search--dropdown .select2-search__field{border-color:#ececec;color:inherit}.select2-search--dropdown{padding:10px}.select2-results__option{padding:5px 10px}.select2-container{max-width:100%}input[type=\"number\"]::-webkit-outer-spin-button,input[type=\"number\"]::-webkit-inner-spin-button{-webkit-appearance:none;margin:0;text-align:center}input[type=\"number\"]{-moz-appearance:textfield}.wperp-form-field,input:not(.wperp-btn){width:100%;border-radius:3px;border:1px solid #ececec;padding:7.5px 15px}.wperp-form-field:focus,input:not(.wperp-btn):focus{outline:0;border-color:#208df8}input{color:#5c5c6f}input.inline{width:auto}select.wperp-form-field{height:35px;background:transparent}.wperp-has-addon{position:relative}.wperp-has-addon .wperp-field-addon{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;-webkit-box-align:center;-ms-flex-align:center;align-items:center;position:relative}.wperp-has-addon .wperp-field-addon .wperp-icon{position:absolute;left:0;top:0;height:100%;width:50px;background:#f5f5f7;border:1px solid #ecf1f5;border-right:0;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;border-radius:3px 0 0 3px}.wperp-has-addon .wperp-field-addon .wperp-form-field{margin-left:50px;max-width:calc(50%);border-radius:0 3px 3px 0;border-left-color:#ecf1f5}.wperp-has-addon .wperp-field-addon .wperp-form-field:focus{border-left-color:#208df8}.attachment-container{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-ms-flex-wrap:wrap;flex-wrap:wrap}.attachment-container label{font-size:13px;margin-bottom:0}.attachment-container label.col--attachement{margin-right:20px}.attachment-container.attachment-style2{padding:20px;margin:0 -20px;background:#f9f9f9;border-top:1px solid #f1f1f1;border-bottom:1px solid #f1f1f1}.attachment-container .attachment-preview{display:-webkit-box;display:-ms-flexbox;display:flex;width:auto;max-height:100px;border:1px solid #f1f1f1;padding:10px;border-radius:3px;position:relative;display:none;background:#fff}.attachment-container .attachment-preview.show{display:block}.attachment-container .attachment-preview img{max-width:100%;max-height:100%}.attachment-container .attachment-preview .remove-attachment{position:absolute;right:0;top:0;padding:7px 10px;border-radius:0 3px 0 3px;background:rgba(0,0,0,0.7);font-size:10px;cursor:pointer}.attachment-container .attachment-preview .remove-attachment:hover{background:#000}.attachment-container .attachment-placeholder{padding:20px;width:100%;max-width:390px;border:1px solid #f1f1f1;border-radius:3px;text-align:center;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;background:#fff}.attachment-container .attachment-placeholder.hide{display:none}.attachment-container .attachment-placeholder label{color:#1a9ed4;text-decoration:underline;padding:0 7px;cursor:pointer}.attachment-container .attachment-placeholder label:hover{text-decoration:none}.wperp-has-datepicker{position:relative}.wperp-has-datepicker .datepicker-icon{position:absolute;right:15px;top:50%;-webkit-transform:translateY(-50%);transform:translateY(-50%);pointer-events:none;z-index:9}.wperp-table{position:relative;width:100%;margin-bottom:1rem;background-color:#fff;border-radius:3px}.wperp-table.table-justified{table-layout:fixed}.wperp-table.table-justified td:last-child,.wperp-table.table-justified th:last-child{width:17%;text-align:left}@media (min-width:783px){.wperp-table.table-justified td:first-child,.wperp-table.table-justified th:first-child{padding-left:32px}}@media screen and (max-width:782px){.wperp-table thead .col--check{padding:15px 5px}.wperp-table tr th.col--check{display:table-cell;width:45px;vertical-align:top;padding:15px 5px}.wperp-table tr:not(.inline-edit-row):not(.no-items) td:not(.col--check){position:relative;clear:both;display:block;width:auto !important}.wperp-table th.column-primary~th,.wperp-table td.column-primary~td,.wperp-table tr:not(.inline-edit-row):not(.no-items) td.column-primary~td:not(.col--check){display:none;border:none}.wperp-table tr:not(.inline-edit-row):not(.no-items) td:not(.column-primary)::before{position:absolute;left:10px;display:block;overflow:hidden;width:32%;content:attr(data-colname);white-space:nowrap;text-overflow:ellipsis;color:#23282d}.wperp-table tbody tr:not(.inline-edit-row):not(.no-items) td{padding:10px 10px 10px 35%}.wperp-table tbody tr:not(.inline-edit-row):not(.no-items) td.col--actions,.wperp-table tbody tr:not(.inline-edit-row):not(.no-items) td.column-primary{padding-left:10px}.wperp-table tbody tr:not(.inline-edit-row):not(.no-items) td.col--actions .dropdown-menu{visibility:visible;opacity:1;position:static;margin:0;-webkit-transform:translate(0, 0);transform:translate(0, 0);display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;max-width:100%}.wperp-table tbody tr:not(.inline-edit-row):not(.no-items) td.col--actions .dropdown-menu li a{padding:5px 10px;background:rgba(0,0,0,0.05);border-radius:3px;margin:0 10px 10px 0}.wperp-table tbody tr:not(.inline-edit-row):not(.no-items) td.col--actions .dropdown-menu li a i{display:inline-block}.wperp-table tbody tr th{border-right:1px solid #e5e5e5}.wperp-table tbody tr td{border-top:1px solid #e5e5e5 !important}}.wperp-table th,.wperp-table td{color:#525252;padding:18px 10px;vertical-align:middle;border-top:2px solid #f6f6f6}.wperp-table thead tr{-webkit-box-shadow:0 5px 12px 0 rgba(0,100,235,0.06);box-shadow:0 5px 12px 0 rgba(0,100,235,0.06);-webkit-transform:translateY(-0.1px);transform:translateY(-0.1px)}.wperp-table thead tr th{font-weight:300}.wperp-table thead th,.wperp-table thead td{vertical-align:bottom;border:none;color:#1a9ed4;font-size:1.077em}@media (min-width:783px){.wperp-table thead th:first-child,.wperp-table thead td:first-child{padding-left:20px}.wperp-table thead th:last-child,.wperp-table thead td:last-child{padding-right:20px}}.wperp-table tbody tr:last-child{-webkit-box-shadow:0 6px 30px 0 rgba(204,204,204,0.16);box-shadow:0 6px 30px 0 rgba(204,204,204,0.16)}@media (min-width:783px){.wperp-table tbody tr th:first-child,.wperp-table tbody tr td:first-child{padding-left:20px}.wperp-table tbody tr th:last-child,.wperp-table tbody tr td:last-child{padding-right:20px;text-align:right}}.wperp-table tbody+tbody{border-top:4px solid #f6f6f6}.wperp-table .table{background-color:#f1f1f1}.wperp-table.table-striped tbody tr:nth-of-type( odd){background-color:#f9f9f9}.wperp-table.table-hover tbody tr:hover{background-color:rgba(0,0,0,0.00075)}.wperp-table .is-row-expanded td:not(.hidden){display:block !important;overflow:hidden}.wperp-table .is-row-expanded .wperp-toggle-row:before{content:\"\\F103\"}.wperp-table .wperp-toggle-row{position:absolute;right:8px;top:15px;display:none;padding:0;width:40px;height:40px;border:none;outline:none;background:transparent}@media screen and (max-width:782px){.wperp-table .wperp-toggle-row{display:block}}.wperp-table .wperp-toggle-row:hover{cursor:pointer}.wperp-table .wperp-toggle-row:focus:before{-webkit-box-shadow:0 0 0 1px #5b9dd9,0 0 2px 1px rgba(30,140,190,0.8);box-shadow:0 0 0 1px #5b9dd9,0 0 2px 1px rgba(30,140,190,0.8)}.wperp-table .wperp-toggle-row:active{-webkit-box-shadow:none;box-shadow:none}.wperp-table .wperp-toggle-row:before{position:absolute;top:-5px;left:10px;border-radius:50%;display:block;padding:5px;color:#444;content:\"\\F101\";font-family:\"Flaticon\";font-size:10px;line-height:1;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale;speak:none}.wperp-table.wperp-form-table{border:1px solid #e2e2e2;border-collapse:inherit;border-spacing:0}.wperp-table.wperp-form-table thead tr{background:#1a9ed4}.wperp-table.wperp-form-table thead tr td,.wperp-table.wperp-form-table thead tr th{color:#fff;font-weight:normal;padding:15px 10px}.wperp-table.wperp-form-table thead tr td:first-child,.wperp-table.wperp-form-table thead tr th:first-child{padding-left:20px}.wperp-table.wperp-form-table thead tr th.col--actions{padding-left:0;width:35px}.wperp-table.wperp-form-table tbody tr:first-child td,.wperp-table.wperp-form-table tbody tr.add-new-line td,.wperp-table.wperp-form-table tbody tr.add-attachment-row td{padding-top:20px}.wperp-table.wperp-form-table tbody tr:last-child td,.wperp-table.wperp-form-table tbody tr.add-new-line td,.wperp-table.wperp-form-table tbody tr.add-attachment-row td{padding-bottom:20px}.wperp-table.wperp-form-table tbody tr td.col--actions{padding-right:20px}.wperp-table.wperp-form-table tbody tr td.col--description{width:30%}.wperp-table.wperp-form-table tbody td,.wperp-table.wperp-form-table tfoot td,.wperp-table.wperp-form-table tbody th,.wperp-table.wperp-form-table tfoot th{border:0;padding:10px 10px}.wperp-table.wperp-form-table tbody td:first-child,.wperp-table.wperp-form-table tfoot td:first-child,.wperp-table.wperp-form-table tbody th:first-child,.wperp-table.wperp-form-table tfoot th:first-child{padding-left:20px}.wperp-table.wperp-form-table tbody tr,.wperp-table.wperp-form-table tfoot tr{-webkit-box-shadow:none;box-shadow:none}.wperp-table.wperp-form-table tfoot td{padding:20px}.add-attachment-row{background:#f9f9f9}.add-attachment-row td{border-top:1px solid #f1f1f1 !important;border-bottom:1px solid #f1f1f1 !important}td input[type=\"text\"]{width:100%}.col--qty input{width:56px;text-align:center}.col--discount{width:100px}.col--discount .wperp-has-addon{display:-webkit-box;display:-ms-flexbox;display:flex;border:1px solid #e2e2e2;border-radius:3px}.col--discount .wperp-has-addon input{text-align:center;border:0;border-right:1px solid #e2e2e2;border-radius:0}.col--discount .wperp-has-addon .wperp-addon{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;width:60px}.col--amount input{width:100% !important}.col--actions a:hover i:before,.col--actions a:focus i:before{color:#1a9ed4 !important}.delete-row a:hover i:before{color:#f96332 !important}.col--name img{border-radius:50%;margin-right:10px}.col--name a{color:#23282d;font-size:1.154em;font-weight:600}.col--name a:hover,.col--name a:focus{color:#1a9ed4}.col--actions .flaticon-menu{color:#cbcbcb}.col--actions .wperp-has-dropdown .dropdown-menu{margin-right:-20px}.col--actions .wperp-has-dropdown .dropdown-menu:after{top:8px !important}.col--actions .wperp-has-dropdown .dropdown-menu:before{top:7px !important}.col--actions .wperp-has-dropdown.dropdown-opened .dropdown-menu{top:-4px;right:100%;margin-right:10px}@media screen and (max-width:782px){.col--actions{padding-left:5px}.col--actions .dropdown>a{display:none}.col--actions .dropdown .dropdown-menu{display:block;position:relative;padding:0;background-color:transparent;-webkit-box-shadow:none;box-shadow:none;border:none}.col--actions .dropdown .dropdown-menu:before,.col--actions .dropdown .dropdown-menu:after{content:none}.col--actions .dropdown .dropdown-menu li{display:inline}.col--actions .dropdown .dropdown-menu li a{display:inline-block;padding:10px 5px}.col--actions .dropdown .dropdown-menu li a i{display:none}}.col--actions .dropdown>a{color:#72777c}.col--actions .dropdown>a:hover{color:#1a9ed4}.col--actions .dropdown>a i{font-size:15px}.ie8 .wperp-table .wperp-toggle-row:focus:before{outline:#5b9dd9 solid 1px}.table-container{position:relative}.table-container.bulk-actions .wperp-table thead th{display:none}.table-container.bulk-actions a .flaticon-trash:before{color:#f96332 !important}.table-container.bulk-actions a:hover{color:#f96332 !important}.bulk-action{position:absolute;z-index:1;background-color:#fff;display:none;left:46px;top:12px}.bulk-action a{display:inline-block;color:#23282d;font-size:12px;margin:0 10px;padding:8px 10px}.bulk-action a i{color:#d7dee2;margin-right:5px}.bulk-action a:hover{color:#1a9ed4}.wperp-invoice-table{table-layout:fixed}.wperp-invoice-table th:last-child,.wperp-invoice-table td:last-child{width:50px}.wperp-modal{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;position:fixed;top:0;left:0;width:100%;height:100%;z-index:9999;background:rgba(0,0,0,0.5);opacity:0;visibility:hidden;-webkit-transition:all .3s ease-in-out;transition:all .3s ease-in-out}.wperp-modal .wperp-modal-dialog{position:relative;width:800px;max-width:100%;max-height:100%;margin-top:-100px;-webkit-transition:all .3s ease-in-out;transition:all .3s ease-in-out}.wperp-modal .wperp-modal-content{background-color:#f5f5f5;border:1px solid #707070;border-radius:4px;-webkit-box-shadow:0 3px 9px rgba(0,0,0,0.5);box-shadow:0 3px 9px rgba(0,0,0,0.5);background-clip:padding-box;outline:0;max-height:90vh;overflow-y:auto}.wperp-modal.wperp-modal-open{opacity:1;visibility:visible}.wperp-modal.wperp-modal-open .wperp-modal-dialog{margin-top:0}.wperp-modal.wperp-printable-modal .wperp-modal-header{border-bottom:0}.wperp-modal.wperp-printable-modal .wperp-modal-body{padding:0;margin:0 20px;border-radius:4px;border:1px solid #f1f1f1}.wperp-modal.wperp-printable-modal .wperp-modal-body .wperp-invoice-panel{background:transparent}.wperp-modal.wperp-printable-modal .modal-subtitle{margin-bottom:15px}.wperp-modal.wperp-printable-modal .invoice-table thead tr th{padding-right:20px;padding-left:20px}.wperp-modal.wperp-printable-modal .invoice-table thead tr th:first-child{padding-left:30px}.wperp-modal.wperp-printable-modal .invoice-table thead tr th:last-child{padding-right:30px}.wperp-modal.wperp-printable-modal .invoice-table tbody tr td,.wperp-modal.wperp-printable-modal .invoice-table tfoot tr td,.wperp-modal.wperp-printable-modal .invoice-table tbody tr th,.wperp-modal.wperp-printable-modal .invoice-table tfoot tr th{padding:20px}.wperp-modal.wperp-printable-modal .invoice-table tbody tr td:first-child,.wperp-modal.wperp-printable-modal .invoice-table tfoot tr td:first-child,.wperp-modal.wperp-printable-modal .invoice-table tbody tr th:first-child,.wperp-modal.wperp-printable-modal .invoice-table tfoot tr th:first-child{padding-left:30px}.wperp-modal.wperp-printable-modal .invoice-table tbody tr td:last-child,.wperp-modal.wperp-printable-modal .invoice-table tfoot tr td:last-child,.wperp-modal.wperp-printable-modal .invoice-table tbody tr th:last-child,.wperp-modal.wperp-printable-modal .invoice-table tfoot tr th:last-child{padding-right:30px}.wperp-modal-header{background:#f5f5f5;padding:20px;border-bottom:1px solid #707070;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;-webkit-box-align:center;-ms-flex-align:center;align-items:center;border-radius:3px 3px 0 0;font-weight:400;color:#000}.wperp-modal-header h2,.wperp-modal-header h3,.wperp-modal-header h4,.wperp-modal-header h5{margin:0;font-size:23px;font-weight:400}.wperp-modal-header .wperp-close{color:#cec9cb;font-size:16px;padding:5px;margin-right:-5px;cursor:pointer}.wperp-modal-header .wperp-close:hover{color:#ccc}.wperp-modal-header .wperp-icon{color:#ccc;margin-right:10px;vertical-align:text-top}.wperp-modal-header .wperp-icon:before{font-size:20px}.wperp-modal-body{position:relative;padding:20px;background:#fff}.wperp-modal-footer{padding:20px;text-align:right;border-top:1px solid #707070}.wperp-modal-footer:before,.wperp-modal-footer:after{content:\" \";display:table}.wperp-modal-footer:after{clear:both}.wperp-modal-footer .wperp-btn+.wperp-btn{margin-left:5px;margin-bottom:0}.wperp-modal-footer .wperp-btn-group .wperp-btn+.wperp-btn{margin-left:-1px}.wperp-modal-footer .wperp-btn-block+.wperp-btn-block{margin-left:0}.wperp-modal-scrollbar-measure{position:absolute;top:-9999px;width:50px;height:50px;overflow:scroll}.modal-title{margin-bottom:20px}.modal-title *{margin:0;font-size:18px;font-weight:400}.wperp-panel-group{margin-bottom:20px}.wperp-panel{margin-bottom:20px;border-radius:3px;background:#fff;border:1px solid #e2e2e2}.wperp-panel .wperp-table{margin-bottom:0}.wperp-panel.wperp-panel-orders .wperp-table th:first-child,.wperp-panel.wperp-panel-orders .wperp-table td:first-child{padding-left:0 !important}.wperp-panel.wperp-panel-orders .wperp-table th:last-child,.wperp-panel.wperp-panel-orders .wperp-table td:last-child{padding-right:0 !important}.wperp-panel+.wperp-panel{margin-top:5px}.wperp-panel .wperp-panel-heading{border-bottom:1px solid #e2e2e2;border-radius:3px 3px 0 0;color:#000;padding:12px 20px;background:#f9f9f9;font-size:14px;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center}.wperp-panel .wperp-panel-heading .panel-badge{width:18px;height:18px;border-radius:50%;margin-right:13px}.wperp-panel .wperp-panel-heading .panel-badge.panel-badge-primary{background-image:-webkit-linear-gradient(125deg, #6eacff 10%, #907cff 100%)}.wperp-panel .wperp-panel-heading .panel-badge.panel-badge-info{background-image:-webkit-linear-gradient(125deg, #ff8359 10%, #ffcf08 100%)}.wperp-panel .wperp-panel-heading .panel-badge.panel-badge-secondary{background-image:-webkit-linear-gradient(125deg, #08d0ff 10%, #10f8b1 100%)}.wperp-panel .wperp-panel-body{padding:20px}.wperp-panel .wperp-panel-body.wperp-no-padding{padding:0}.wperp-panel .wperp-panel-footer{border-top:0;border-radius:0 0 3px 3px}.wperp-stats .wperp-panel{padding-bottom:0}.wperp-stats .wperp-chart-block{position:relative;padding-right:30px;margin-right:20px;display:block}.wperp-stats .wperp-chart-block.has-separator:after{content:'';width:1px;height:50%;background:#d8d8d8;position:absolute;top:50%;-webkit-transform:translateY(-50%);transform:translateY(-50%);right:0;z-index:99}.wperp-stats .wperp-chart-block h3{color:#23282d;font-size:14px;font-weight:400;margin-bottom:20px}.wperp-stats .wperp-chart-block .wperp-total{display:-webkit-box;display:-ms-flexbox;display:flex;min-height:50px;-webkit-box-align:center;-ms-flex-align:center;align-items:center}.wperp-stats .wperp-chart-block .wperp-total h2{color:#23282d;font-weight:400;font-size:26px;margin-bottom:0}.wperp-stats .wperp-chart-block .payment-chart{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-ms-flex-direction:row;flex-direction:row;-ms-flex-wrap:wrap;flex-wrap:wrap}.wperp-stats .wperp-chart-block .payment-chart .chart-container{max-width:168px;-ms-flex-preferred-size:84px;flex-basis:84px;margin-left:-42px;margin-right:-42px}.wperp-stats .wperp-chart-block .chart-labels-list{list-style:none;font-size:14px;margin-bottom:0}@media (max-width:1200px){.wperp-stats .wperp-chart-block .chart-labels-list{padding-left:20px}}.wperp-stats .wperp-chart-block .chart-labels-list li{padding-bottom:7px;display:-webkit-box;display:-ms-flexbox;display:flex}.wperp-stats .wperp-chart-block .chart-labels-list li:last-child{padding-bottom:0}.wperp-stats .wperp-chart-block .chart-labels-list .chart-label-icon{width:12px;height:12px;border-radius:100%;display:inline-block;margin-right:12px}.wperp-stats .wperp-chart-block .chart-labels-list .chart-value{color:#000}.wperp-stats .wperp-chart-block .chart-labels-list .chart-label{color:#72777c}@media (max-width:767px){.wperp-col-sm-4{-ms-flex-preferred-size:100%;flex-basis:100%}.wperp-col-sm-4 .has-separator:after{content:none !important}.wperp-col-sm-4 .wperp-chart-block{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;-webkit-box-align:center;-ms-flex-align:center;align-items:center;margin-bottom:30px;margin-right:0 !important;padding-right:0 !important}.wperp-col-sm-4 .wperp-total{min-height:inherit !important}}.wperp-invoice-modal .wperp-modal-body{padding-top:0;padding-bottom:0}.add-new-customer{color:#1a9ed4;cursor:pointer;display:inline-block;margin-top:10px}.add-new-customer i{margin-right:5px}.add-new-customer i:before{font-size:7px;color:inherit}.wperp-invoice-panel{padding-top:20px;background:#fff;color:#72777c;font-weight:300}.wperp-invoice-panel h3,.wperp-invoice-panel h4,.wperp-invoice-panel h5,.wperp-invoice-panel h6,.wperp-invoice-panel th,.wperp-invoice-panel strong{color:#23282d;font-weight:400}.wperp-invoice-panel table,.wperp-invoice-panel ul{margin-bottom:0}.wperp-invoice-panel .invoice-header{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;-ms-flex-wrap:wrap;flex-wrap:wrap;-webkit-box-align:center;-ms-flex-align:center;align-items:center;padding:0 30px;border-bottom:1px solid #ecf0f1}.wperp-invoice-panel .invoice-body{padding:20px 30px}.wperp-invoice-panel .invoice-body h4{font-size:18px}.wperp-invoice-panel .invoice-body .invoice-info{float:right}.wperp-invoice-panel .invoice-address{text-align:right}.wperp-invoice-panel .invoice-table{border:0}.wperp-invoice-panel .invoice-table tbody tr th,.wperp-invoice-panel .invoice-table tbody tr td{border-bottom:1px solid #f1f1f1}.wperp-invoice-panel .invoice-table tfoot ul li{padding:4px 10px}.wperp-invoice-panel .invoice-table tfoot ul li span{color:#72777c;padding-right:10px}.wperp-invoice-panel tfoot ul{list-style:none;float:right;text-align:right}.invoice-attachments{margin:20px 0}.invoice-attachments h4{font-size:15px;margin-bottom:10px;font-weight:600}.invoice-attachments .attachment-item{padding:10px 15px;border:1px solid #e2e2e2;border-radius:3px;display:-webkit-inline-box;display:-ms-inline-flexbox;display:inline-flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;margin-bottom:15px;margin-right:15px;color:inherit}.invoice-attachments .attachment-item:hover{background:#fff}.invoice-attachments .attachment-meta{margin-left:10px}@media print{.d-print-none{display:none}.invoice-body .wperp-row{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between}.wperp-modal-content{max-height:initial !important}}.wperp-customer-panel{position:relative}.wperp-customer-panel .edit-badge{position:absolute;right:30px}.wperp-customer-panel .customer-identity{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center}.wperp-customer-panel .customer-identity img{margin-right:20px}.wperp-customer-panel .customer-identity h3{color:#23282d;font-weight:400}.wperp-customer-panel .customer-meta{list-style:none;padding-left:0;margin-bottom:0;-webkit-column-count:3;column-count:3;margin-top:10px}@media (max-width:1024px){.wperp-customer-panel .customer-meta{-webkit-column-count:2;column-count:2}}@media (max-width:520px){.wperp-customer-panel .customer-meta{-webkit-column-count:1;column-count:1}}.wperp-customer-panel .customer-meta li{display:-webkit-box;display:-ms-flexbox;display:flex;line-height:19px;margin-bottom:10px}.wperp-customer-panel .customer-meta li strong{display:-webkit-inline-box;display:-ms-inline-flexbox;display:inline-flex;min-width:65px;color:#000;font-weight:500}.wperp-customer-panel .customer-meta li span{color:#525252}.content-header-section .wperp-import-wrapper{margin-left:10px}.content-header-section .dropdown-menu{margin-top:0}.content-header-section .dropdown-opened .dropdown-menu{margin-top:10px}.content-header-section .filter-button [class*='flaticon']{vertical-align:middle;margin:0 5px}.wperp-filter-container{padding:0;border:0}.wperp-filter-container h3{font-size:13px;margin-top:0}.wperp-filter-container .wperp-panel{padding:15px;width:320px;margin-bottom:0}.wperp-filter-container .wperp-panel .wperp-panel-body{padding:15px;border:1px solid #ddd;border-radius:3px;margin-bottom:15px}.wperp-filter-container .wperp-panel .wperp-panel-body *{font-size:12px;color:#525252}.wperp-filter-container .wperp-panel .wperp-panel-body .form-fields{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center}.wperp-filter-container .wperp-panel .wperp-panel-body .form-fields .label-to{margin:0 10px}.wperp-filter-container .wperp-panel .wperp-panel-body .form-fields .has-addons{position:relative}.wperp-filter-container .wperp-panel .wperp-panel-body .form-fields .has-addons [class*=\"flaticon\"]{position:absolute;right:7px;top:50%;-webkit-transform:translateY(-50%);transform:translateY(-50%);pointer-events:none;z-index:0}.wperp-filter-container .wperp-panel .wperp-panel-body .form-field{width:100%;max-width:110px;border-radius:3px;border:1px solid #ddd;padding:5px}.wperp-filter-container .wperp-panel .wperp-panel-footer{text-align:right}.wperp-filter-container .wperp-panel .wperp-panel-footer .wperp-btn{margin-left:10px}#status_legend ul li{padding:0 2px}@media (max-width:767px){.wperp-filter-container{right:inherit !important;left:0 !important}.wperp-filter-container .wperp-panel{width:290px !important;padding:15px 10px}.wperp-filter-container .wperp-panel .wperp-panel-body{padding:15px 10px}.wperp-filter-container .wperp-panel .wperp-panel-body .form-fields .label-to{margin:0 5px}.wperp-filter-container:after,.wperp-filter-container:before{right:inherit !important;left:10px}}", ""]);

// exports


/***/ }),
/* 88 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { attrs: { id: "erp-accounting" } },
    [_c("ERPMenu"), _vm._v(" "), _c("router-view")],
    1
  )
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-6bc4b6d8", esExports)
  }
}

/***/ }),
/* 89 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue__ = __webpack_require__(4);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vue_router__ = __webpack_require__(8);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_admin_components_Dashboard_vue__ = __webpack_require__(90);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_admin_components_ChartOfAccounts_vue__ = __webpack_require__(96);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_admin_components_Peoples_Customers_vue__ = __webpack_require__(98);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_admin_components_Peoples_Vendors_vue__ = __webpack_require__(126);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6_admin_components_Peoples_Employees_vue__ = __webpack_require__(129);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7_admin_components_Peoples_Customer_details_vue__ = __webpack_require__(188);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8_admin_components_DummyComponent_vue__ = __webpack_require__(132);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9_admin_components_invoice_InvoiceCreate_vue__ = __webpack_require__(135);










__WEBPACK_IMPORTED_MODULE_0_vue__["default"].use(__WEBPACK_IMPORTED_MODULE_1_vue_router__["default"]);
/* harmony default export */ __webpack_exports__["a"] = (new __WEBPACK_IMPORTED_MODULE_1_vue_router__["default"]({
  routes: [{
    path: '/',
    name: 'Dashboard',
    component: __WEBPACK_IMPORTED_MODULE_2_admin_components_Dashboard_vue__["a" /* default */]
  }, {
    path: '/customers',
    component: {
      render: function render(c) {
        return c('router-view');
      }
    },
    children: [{
      path: '',
      name: 'Customers',
      component: __WEBPACK_IMPORTED_MODULE_4_admin_components_Peoples_Customers_vue__["a" /* default */]
    }, {
      path: 'page/:page',
      name: 'PaginateCustomers',
      component: __WEBPACK_IMPORTED_MODULE_4_admin_components_Peoples_Customers_vue__["a" /* default */]
    }, {
      path: 'view/:id',
      name: 'CustomerDetails',
      component: __WEBPACK_IMPORTED_MODULE_7_admin_components_Peoples_Customer_details_vue__["a" /* default */]
    }]
  }, {
    path: '/vendors',
    component: {
      render: function render(c) {
        return c('router-view');
      }
    },
    children: [{
      path: '',
      name: 'Vendors',
      component: __WEBPACK_IMPORTED_MODULE_5_admin_components_Peoples_Vendors_vue__["a" /* default */]
    }, {
      path: 'page/:page',
      name: 'PaginateVendors',
      component: __WEBPACK_IMPORTED_MODULE_5_admin_components_Peoples_Vendors_vue__["a" /* default */]
    }]
  }, {
    path: '/employees',
    component: {
      render: function render(c) {
        return c('router-view');
      }
    },
    children: [{
      path: '',
      name: 'Employees',
      component: __WEBPACK_IMPORTED_MODULE_6_admin_components_Peoples_Employees_vue__["a" /* default */]
    }, {
      path: 'page/:page',
      name: 'PaginateEmployees',
      component: __WEBPACK_IMPORTED_MODULE_6_admin_components_Peoples_Employees_vue__["a" /* default */]
    }]
  }, {
    path: '/sales',
    name: 'Sales',
    component: __WEBPACK_IMPORTED_MODULE_8_admin_components_DummyComponent_vue__["a" /* default */]
  }, {
    path: '/expense',
    name: 'Expenses',
    component: __WEBPACK_IMPORTED_MODULE_8_admin_components_DummyComponent_vue__["a" /* default */]
  }, {
    path: '/charts',
    name: 'Chart Of Accounts',
    component: __WEBPACK_IMPORTED_MODULE_3_admin_components_ChartOfAccounts_vue__["default"]
  }, {
    path: '/bank',
    name: 'Bank Accounts',
    component: __WEBPACK_IMPORTED_MODULE_8_admin_components_DummyComponent_vue__["a" /* default */]
  }, {
    path: '/journal',
    name: 'Journal Entries',
    component: __WEBPACK_IMPORTED_MODULE_8_admin_components_DummyComponent_vue__["a" /* default */]
  }, {
    path: '/invoices/new',
    name: 'InvoiceCreate',
    component: __WEBPACK_IMPORTED_MODULE_9_admin_components_invoice_InvoiceCreate_vue__["a" /* default */]
  }]
}));

/***/ }),
/* 90 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_Dashboard_vue__ = __webpack_require__(21);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_45a0d6f4_hasScoped_true_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_Dashboard_vue__ = __webpack_require__(95);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(91)
}
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-45a0d6f4"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_Dashboard_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_45a0d6f4_hasScoped_true_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_Dashboard_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/admin/components/Dashboard.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-45a0d6f4", Component.options)
  } else {
    hotAPI.reload("data-v-45a0d6f4", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),
/* 91 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 92 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_MetaBox_vue__ = __webpack_require__(22);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_eca6e040_hasScoped_true_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_MetaBox_vue__ = __webpack_require__(94);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(93)
}
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-eca6e040"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_MetaBox_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_eca6e040_hasScoped_true_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_MetaBox_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/admin/components/WP/MetaBox.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-eca6e040", Component.options)
  } else {
    hotAPI.reload("data-v-eca6e040", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),
/* 93 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 94 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { class: _vm.classes, style: _vm.styles }, [
    _vm.closable
      ? _c(
          "button",
          {
            staticClass: "handlediv",
            attrs: { type: "button" },
            on: { click: _vm.handleToggle }
          },
          [
            _vm.closed
              ? _c("span", { staticClass: "dashicons dashicons-arrow-down" })
              : _c("span", { staticClass: "dashicons dashicons-arrow-up" })
          ]
        )
      : _vm._e(),
    _vm._v(" "),
    _c("h3", { staticClass: "hndle ui-sortable-handle" }, [
      _c("span", { staticClass: "wp-metabox-title" }, [
        _vm._v(_vm._s(_vm.title))
      ])
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "inside" }, [
      _c(
        "div",
        { staticClass: "main" },
        [
          _vm._t("metabox-content"),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "wp-metabox-footer" },
            [_vm._t("metabox-footer")],
            2
          )
        ],
        2
      )
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-eca6e040", esExports)
  }
}

/***/ }),
/* 95 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "home" }, [
    _c("div", { staticClass: "erp accounting-dashboard" }, [
      _c("h2", [_c("span", [_vm._v(_vm._s(_vm.msg))])]),
      _vm._v(" "),
      _c("div", { staticClass: "erp-acc-dashboard-1" }, [
        _c(
          "div",
          { staticClass: "erp-acc-dashboard-1-col" },
          [
            _c("MetaBox", { attrs: { title: _vm.title1, closable: false } }, [
              _c(
                "h1",
                { attrs: { slot: "metabox-content" }, slot: "metabox-content" },
                [_vm._v("Metabox Content")]
              )
            ])
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "erp-acc-dashboard-1-col" },
          [
            _c("MetaBox", { attrs: { title: _vm.title2, closable: false } }, [
              _c(
                "h1",
                { attrs: { slot: "metabox-content" }, slot: "metabox-content" },
                [_vm._v("Metabox Content2")]
              )
            ])
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "erp-acc-dashboard-2" }, [
        _c(
          "div",
          { staticClass: "erp-acc-dashboard-2-col" },
          [
            _c("MetaBox", { attrs: { title: _vm.title3, closable: false } }, [
              _c(
                "h1",
                { attrs: { slot: "metabox-content" }, slot: "metabox-content" },
                [
                  _c("table", [
                    _c("tr", [
                      _c("td", [_vm._v("Coming Due")]),
                      _vm._v(" "),
                      _c("td", { staticClass: "price" }, [_vm._v("$0.00")])
                    ]),
                    _vm._v(" "),
                    _c("tr", [
                      _c("td", [_vm._v("1-30 days overdue")]),
                      _vm._v(" "),
                      _c("td", { staticClass: "price" }, [_vm._v("$0.00")])
                    ]),
                    _vm._v(" "),
                    _c("tr", [
                      _c("td", [_vm._v("31-60 days overdue")]),
                      _vm._v(" "),
                      _c("td", { staticClass: "price" }, [_vm._v("$0.00")])
                    ]),
                    _vm._v(" "),
                    _c("tr", [
                      _c("td", [_vm._v("61-90 days overdue")]),
                      _vm._v(" "),
                      _c("td", { staticClass: "price" }, [_vm._v("$0.00")])
                    ]),
                    _vm._v(" "),
                    _c("tr", [
                      _c("td", [_vm._v("> 90 days overdue")]),
                      _vm._v(" "),
                      _c("td", { staticClass: "price" }, [_vm._v("$0.00")])
                    ])
                  ])
                ]
              )
            ])
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "erp-acc-dashboard-2-col" },
          [
            _c("MetaBox", { attrs: { title: _vm.title4, closable: false } }, [
              _c(
                "div",
                { attrs: { slot: "metabox-content" }, slot: "metabox-content" },
                [
                  _c("table", [
                    _c("tr", [
                      _c("td", [_vm._v("Coming Due")]),
                      _vm._v(" "),
                      _c("td", { staticClass: "price" }, [_vm._v("$0.00")])
                    ]),
                    _vm._v(" "),
                    _c("tr", [
                      _c("td", [_vm._v("1-30 days overdue")]),
                      _vm._v(" "),
                      _c("td", { staticClass: "price" }, [_vm._v("$0.00")])
                    ]),
                    _vm._v(" "),
                    _c("tr", [
                      _c("td", [_vm._v("31-60 days overdue")]),
                      _vm._v(" "),
                      _c("td", { staticClass: "price" }, [_vm._v("$0.00")])
                    ]),
                    _vm._v(" "),
                    _c("tr", [
                      _c("td", [_vm._v("61-90 days overdue")]),
                      _vm._v(" "),
                      _c("td", { staticClass: "price" }, [_vm._v("$0.00")])
                    ]),
                    _vm._v(" "),
                    _c("tr", [
                      _c("td", [_vm._v("> 90 days overdue")]),
                      _vm._v(" "),
                      _c("td", { staticClass: "price" }, [_vm._v("$0.00")])
                    ])
                  ])
                ]
              )
            ])
          ],
          1
        )
      ])
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-45a0d6f4", esExports)
  }
}

/***/ }),
/* 96 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_ChartOfAccounts_vue__ = __webpack_require__(23);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_ChartOfAccounts_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_ChartOfAccounts_vue__);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_02d5983b_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_ChartOfAccounts_vue__ = __webpack_require__(97);
var disposed = false
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_ChartOfAccounts_vue___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_02d5983b_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_ChartOfAccounts_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/admin/components/ChartOfAccounts.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-02d5983b", Component.options)
  } else {
    hotAPI.reload("data-v-02d5983b", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 97 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _vm._m(0)
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "account-chart" }, [
      _c("h3", [_vm._v("Chart of Accounts")]),
      _vm._v(" "),
      _c("table", { staticClass: "table widefat striped ac-chart-table" }, [
        _c("thead", [
          _c("tr", [
            _c("th", { staticClass: "col-code" }, [_vm._v("Code")]),
            _vm._v(" "),
            _c("th", { staticClass: "col-name" }, [_vm._v("Name")]),
            _vm._v(" "),
            _c("th", { staticClass: "col-type" }, [_vm._v("Type")]),
            _vm._v(" "),
            _c("th", { staticClass: "col-transactions" }, [_vm._v("Entries")]),
            _vm._v(" "),
            _c("th", { staticClass: "col-action" }, [_vm._v("Actions")])
          ])
        ]),
        _vm._v(" "),
        _c("tbody", [
          _c("tr", [
            _c("td", { staticClass: "col-code" }, [_vm._v("100")]),
            _vm._v(" "),
            _c("td", { staticClass: "col-name" }, [_vm._v("url")]),
            _vm._v(" "),
            _c("td", { staticClass: "col-type" }, [_vm._v("Type")]),
            _vm._v(" "),
            _c("td", { staticClass: "col-transactions" }, [_vm._v("100")]),
            _vm._v(" "),
            _c("td", { staticClass: "col-action" }, [_vm._v("Action")])
          ])
        ])
      ])
    ])
  }
]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-02d5983b", esExports)
  }
}

/***/ }),
/* 98 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_Customers_vue__ = __webpack_require__(24);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_384dc50a_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_Customers_vue__ = __webpack_require__(125);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(99)
}
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_Customers_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_384dc50a_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_Customers_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/admin/components/Peoples/Customers.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-384dc50a", Component.options)
  } else {
    hotAPI.reload("data-v-384dc50a", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),
/* 99 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 100 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 101 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_BulkActionsTpl_vue__ = __webpack_require__(26);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_66769835_hasScoped_true_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_BulkActionsTpl_vue__ = __webpack_require__(103);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(102)
}
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-66769835"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_BulkActionsTpl_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_66769835_hasScoped_true_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_BulkActionsTpl_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/admin/components/list-table/BulkActionsTpl.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-66769835", Component.options)
  } else {
    hotAPI.reload("data-v-66769835", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),
/* 102 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 103 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("tr", [
    _vm.showCb
      ? _c("td", { staticClass: "manage-column column-cb check-column" }, [
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.bulkSelectAll,
                expression: "bulkSelectAll"
              }
            ],
            attrs: { type: "checkbox" },
            domProps: {
              checked: Array.isArray(_vm.bulkSelectAll)
                ? _vm._i(_vm.bulkSelectAll, null) > -1
                : _vm.bulkSelectAll
            },
            on: {
              change: [
                function($event) {
                  var $$a = _vm.bulkSelectAll,
                    $$el = $event.target,
                    $$c = $$el.checked ? true : false
                  if (Array.isArray($$a)) {
                    var $$v = null,
                      $$i = _vm._i($$a, $$v)
                    if ($$el.checked) {
                      $$i < 0 && (_vm.bulkSelectAll = $$a.concat([$$v]))
                    } else {
                      $$i > -1 &&
                        (_vm.bulkSelectAll = $$a
                          .slice(0, $$i)
                          .concat($$a.slice($$i + 1)))
                    }
                  } else {
                    _vm.bulkSelectAll = $$c
                  }
                },
                _vm.changeBulkCheckbox
              ]
            }
          })
        ])
      : _vm._e(),
    _vm._v(" "),
    _vm.hasBulkActions
      ? _c("th", { attrs: { colspan: _vm.columnsCount } }, [
          _c(
            "ul",
            _vm._l(_vm.bulkActions, function(bulkAction) {
              return _c(
                "li",
                {
                  key: bulkAction.key,
                  on: {
                    click: function($event) {
                      _vm.bulkActionSelect(bulkAction.key)
                    }
                  }
                },
                [
                  _c("img", {
                    attrs: { src: bulkAction.img, alt: bulkAction.label }
                  }),
                  _vm._v(" "),
                  _c("span", [_vm._v(_vm._s(bulkAction.label))])
                ]
              )
            })
          )
        ])
      : _vm._e()
  ])
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-66769835", esExports)
  }
}

/***/ }),
/* 104 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 105 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      staticClass: "dropdown",
      on: {
        click: function($event) {
          $event.preventDefault()
          return _vm.toggleDropdown($event)
        }
      }
    },
    [
      _vm._t("button", [
        _c(
          "button",
          {
            staticClass: "btn btn-secondary dropdown-toggle",
            attrs: {
              type: "button",
              "data-toggle": "dropdown",
              "aria-haspopup": "true",
              "aria-expanded": "false"
            }
          },
          [_vm._v("\n      Dropdown\n    ")]
        )
      ]),
      _vm._v(" "),
      _c(
        "div",
        {
          ref: "menu",
          class: ["dropdown-menu", _vm.dropdownClasses, { show: _vm.visible }],
          on: {
            click: function($event) {
              $event.stopPropagation()
            }
          }
        },
        [_vm._t("dropdown")],
        2
      )
    ],
    2
  )
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-8264bea2", esExports)
  }
}

/***/ }),
/* 106 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { class: { "table-loading": _vm.loading } }, [
    _vm.loading
      ? _c("div", { staticClass: "table-loader-wrap" }, [_vm._m(0)])
      : _vm._e(),
    _vm._v(" "),
    _c("div", { staticClass: "tablenav top" }, [
      _c("div", { staticClass: "alignleft actions" }, [_vm._t("filters")], 2),
      _vm._v(" "),
      _c("div", { staticClass: "tablenav-pages" }, [
        _c("span", { staticClass: "displaying-num" }, [
          _vm._v(_vm._s(_vm.itemsTotal) + " items")
        ]),
        _vm._v(" "),
        _vm.hasPagination
          ? _c("span", { staticClass: "pagination-links" }, [
              _vm.disableFirst
                ? _c(
                    "span",
                    {
                      staticClass: "tablenav-pages-navspan",
                      attrs: { "aria-hidden": "true" }
                    },
                    [_vm._v("«")]
                  )
                : _c(
                    "a",
                    {
                      staticClass: "first-page",
                      attrs: { href: "#" },
                      on: {
                        click: function($event) {
                          $event.preventDefault()
                          _vm.goToPage(1)
                        }
                      }
                    },
                    [
                      _c("span", { attrs: { "aria-hidden": "true" } }, [
                        _vm._v("«")
                      ])
                    ]
                  ),
              _vm._v(" "),
              _vm.disablePrev
                ? _c(
                    "span",
                    {
                      staticClass: "tablenav-pages-navspan",
                      attrs: { "aria-hidden": "true" }
                    },
                    [_vm._v("‹")]
                  )
                : _c(
                    "a",
                    {
                      staticClass: "prev-page",
                      attrs: { href: "#" },
                      on: {
                        click: function($event) {
                          $event.preventDefault()
                          _vm.goToPage(_vm.currentPage - 1)
                        }
                      }
                    },
                    [
                      _c("span", { attrs: { "aria-hidden": "true" } }, [
                        _vm._v("‹")
                      ])
                    ]
                  ),
              _vm._v(" "),
              _c("span", { staticClass: "paging-input" }, [
                _c("span", { staticClass: "tablenav-paging-text" }, [
                  _c("input", {
                    staticClass: "current-page",
                    attrs: {
                      type: "text",
                      name: "paged",
                      "aria-describedby": "table-paging",
                      size: "1"
                    },
                    domProps: { value: _vm.currentPage },
                    on: {
                      keyup: function($event) {
                        if (
                          !("button" in $event) &&
                          _vm._k(
                            $event.keyCode,
                            "enter",
                            13,
                            $event.key,
                            "Enter"
                          )
                        ) {
                          return null
                        }
                        return _vm.goToCustomPage($event)
                      }
                    }
                  }),
                  _vm._v(" of\n            "),
                  _c("span", { staticClass: "total-pages" }, [
                    _vm._v(_vm._s(_vm.totalPages))
                  ])
                ])
              ]),
              _vm._v(" "),
              _vm.disableNext
                ? _c(
                    "span",
                    {
                      staticClass: "tablenav-pages-navspan",
                      attrs: { "aria-hidden": "true" }
                    },
                    [_vm._v("›")]
                  )
                : _c(
                    "a",
                    {
                      staticClass: "next-page",
                      attrs: { href: "#" },
                      on: {
                        click: function($event) {
                          $event.preventDefault()
                          _vm.goToPage(_vm.currentPage + 1)
                        }
                      }
                    },
                    [
                      _c("span", { attrs: { "aria-hidden": "true" } }, [
                        _vm._v("›")
                      ])
                    ]
                  ),
              _vm._v(" "),
              _vm.disableLast
                ? _c(
                    "span",
                    {
                      staticClass: "tablenav-pages-navspan",
                      attrs: { "aria-hidden": "true" }
                    },
                    [_vm._v("»")]
                  )
                : _c(
                    "a",
                    {
                      staticClass: "last-page",
                      attrs: { href: "#" },
                      on: {
                        click: function($event) {
                          $event.preventDefault()
                          _vm.goToPage(_vm.totalPages)
                        }
                      }
                    },
                    [
                      _c("span", { attrs: { "aria-hidden": "true" } }, [
                        _vm._v("»")
                      ])
                    ]
                  )
            ])
          : _vm._e()
      ])
    ]),
    _vm._v(" "),
    _c("table", { class: _vm.tableClass }, [
      _c(
        "thead",
        [
          _vm.checkedItems.length
            ? _c("bulk-actions-tpl", {
                attrs: {
                  "select-all": _vm.selectAll,
                  "bulk-actions": _vm.bulkActions,
                  "show-cb": _vm.showCb,
                  "columns-count": _vm.columnsCount
                }
              })
            : _c(
                "tr",
                [
                  _vm.showCb
                    ? _c(
                        "td",
                        { staticClass: "manage-column column-cb check-column" },
                        [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.selectAll,
                                expression: "selectAll"
                              }
                            ],
                            attrs: { type: "checkbox" },
                            domProps: {
                              checked: Array.isArray(_vm.selectAll)
                                ? _vm._i(_vm.selectAll, null) > -1
                                : _vm.selectAll
                            },
                            on: {
                              change: function($event) {
                                var $$a = _vm.selectAll,
                                  $$el = $event.target,
                                  $$c = $$el.checked ? true : false
                                if (Array.isArray($$a)) {
                                  var $$v = null,
                                    $$i = _vm._i($$a, $$v)
                                  if ($$el.checked) {
                                    $$i < 0 &&
                                      (_vm.selectAll = $$a.concat([$$v]))
                                  } else {
                                    $$i > -1 &&
                                      (_vm.selectAll = $$a
                                        .slice(0, $$i)
                                        .concat($$a.slice($$i + 1)))
                                  }
                                } else {
                                  _vm.selectAll = $$c
                                }
                              }
                            }
                          })
                        ]
                      )
                    : _vm._e(),
                  _vm._v(" "),
                  _vm._l(_vm.columns, function(value, key) {
                    return _c(
                      "th",
                      {
                        key: key,
                        class: [
                          "column",
                          key,
                          { sortable: _vm.isSortable(value) },
                          { sorted: _vm.isSorted(key) },
                          { asc: _vm.isSorted(key) && _vm.sortOrder === "asc" },
                          {
                            desc: _vm.isSorted(key) && _vm.sortOrder === "desc"
                          }
                        ]
                      },
                      [
                        !_vm.isSortable(value)
                          ? [
                              _vm._v(
                                "\n            " +
                                  _vm._s(value.label) +
                                  "\n          "
                              )
                            ]
                          : _c(
                              "a",
                              {
                                attrs: { href: "#" },
                                on: {
                                  click: function($event) {
                                    $event.preventDefault()
                                    _vm.handleSortBy(key)
                                  }
                                }
                              },
                              [
                                _c("span", [_vm._v(_vm._s(value.label))]),
                                _vm._v(" "),
                                _c("span", { staticClass: "sorting-indicator" })
                              ]
                            )
                      ],
                      2
                    )
                  })
                ],
                2
              )
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "tfoot",
        [
          _vm.checkedItems.length
            ? _c("bulk-actions-tpl", {
                attrs: {
                  "select-all": _vm.selectAll,
                  "bulk-actions": _vm.bulkActions,
                  "show-cb": _vm.showCb,
                  "columns-count": _vm.columnsCount
                }
              })
            : _c(
                "tr",
                [
                  _vm.showCb
                    ? _c(
                        "td",
                        { staticClass: "manage-column column-cb check-column" },
                        [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.selectAll,
                                expression: "selectAll"
                              }
                            ],
                            attrs: { type: "checkbox" },
                            domProps: {
                              checked: Array.isArray(_vm.selectAll)
                                ? _vm._i(_vm.selectAll, null) > -1
                                : _vm.selectAll
                            },
                            on: {
                              change: function($event) {
                                var $$a = _vm.selectAll,
                                  $$el = $event.target,
                                  $$c = $$el.checked ? true : false
                                if (Array.isArray($$a)) {
                                  var $$v = null,
                                    $$i = _vm._i($$a, $$v)
                                  if ($$el.checked) {
                                    $$i < 0 &&
                                      (_vm.selectAll = $$a.concat([$$v]))
                                  } else {
                                    $$i > -1 &&
                                      (_vm.selectAll = $$a
                                        .slice(0, $$i)
                                        .concat($$a.slice($$i + 1)))
                                  }
                                } else {
                                  _vm.selectAll = $$c
                                }
                              }
                            }
                          })
                        ]
                      )
                    : _vm._e(),
                  _vm._v(" "),
                  _vm._l(_vm.columns, function(value, key) {
                    return _c("th", { key: key, class: ["column", key] }, [
                      _vm._v(_vm._s(value.label))
                    ])
                  })
                ],
                2
              )
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "tbody",
        [
          _vm.rows.length
            ? _vm._l(_vm.rows, function(row, i) {
                return _c(
                  "tr",
                  { key: row[_vm.index] },
                  [
                    _vm.showCb
                      ? _c(
                          "th",
                          {
                            staticClass: "check-column",
                            attrs: { scope: "row" }
                          },
                          [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: _vm.checkedItems,
                                  expression: "checkedItems"
                                }
                              ],
                              attrs: { type: "checkbox", name: "item[]" },
                              domProps: {
                                value: row[_vm.index],
                                checked: Array.isArray(_vm.checkedItems)
                                  ? _vm._i(_vm.checkedItems, row[_vm.index]) >
                                    -1
                                  : _vm.checkedItems
                              },
                              on: {
                                change: function($event) {
                                  var $$a = _vm.checkedItems,
                                    $$el = $event.target,
                                    $$c = $$el.checked ? true : false
                                  if (Array.isArray($$a)) {
                                    var $$v = row[_vm.index],
                                      $$i = _vm._i($$a, $$v)
                                    if ($$el.checked) {
                                      $$i < 0 &&
                                        (_vm.checkedItems = $$a.concat([$$v]))
                                    } else {
                                      $$i > -1 &&
                                        (_vm.checkedItems = $$a
                                          .slice(0, $$i)
                                          .concat($$a.slice($$i + 1)))
                                    }
                                  } else {
                                    _vm.checkedItems = $$c
                                  }
                                }
                              }
                            })
                          ]
                        )
                      : _vm._e(),
                    _vm._v(" "),
                    _vm._l(_vm.columns, function(value, key) {
                      return _c(
                        "td",
                        {
                          key: key,
                          class: [
                            "column",
                            key,
                            {
                              selected: _vm.checkedItems.includes(
                                row[_vm.index]
                              )
                            }
                          ]
                        },
                        [
                          _vm._t(
                            key,
                            [
                              _vm._v(
                                "\n              " +
                                  _vm._s(row[key]) +
                                  "\n            "
                              )
                            ],
                            { row: row }
                          ),
                          _vm._v(" "),
                          _vm.actionColumn === key && _vm.hasActions
                            ? _c(
                                "div",
                                { staticClass: "row-actions" },
                                [
                                  _vm._t(
                                    "row-actions",
                                    [
                                      _c(
                                        "dropdown",
                                        { attrs: { placement: "left" } },
                                        [
                                          _c("template", { slot: "button" }, [
                                            _c("span", [_vm._v("⋮")])
                                          ]),
                                          _vm._v(" "),
                                          _c("template", { slot: "dropdown" }, [
                                            _c(
                                              "ul",
                                              {
                                                attrs: { slot: "action-items" },
                                                slot: "action-items"
                                              },
                                              _vm._l(_vm.actions, function(
                                                action
                                              ) {
                                                return _c(
                                                  "li",
                                                  {
                                                    key: action.key,
                                                    class: action.key
                                                  },
                                                  [
                                                    _c(
                                                      "a",
                                                      {
                                                        attrs: { href: "#" },
                                                        on: {
                                                          click: function(
                                                            $event
                                                          ) {
                                                            $event.preventDefault()
                                                            _vm.actionClicked(
                                                              action.key,
                                                              row,
                                                              i
                                                            )
                                                          }
                                                        }
                                                      },
                                                      [
                                                        _vm._v(
                                                          _vm._s(action.label)
                                                        )
                                                      ]
                                                    )
                                                  ]
                                                )
                                              })
                                            )
                                          ])
                                        ],
                                        2
                                      )
                                    ],
                                    { row: row }
                                  )
                                ],
                                2
                              )
                            : _vm._e()
                        ],
                        2
                      )
                    })
                  ],
                  2
                )
              })
            : _c("tr", [
                _c("td", { attrs: { colspan: _vm.colspan } }, [
                  _vm._v(_vm._s(_vm.notFound))
                ])
              ])
        ],
        2
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "tablenav bottom" }, [
      _c("div", { staticClass: "tablenav-pages" }, [
        _c("span", { staticClass: "displaying-num" }, [
          _vm._v(_vm._s(_vm.itemsTotal) + " items")
        ]),
        _vm._v(" "),
        _vm.hasPagination
          ? _c("span", { staticClass: "pagination-links" }, [
              _vm.disableFirst
                ? _c(
                    "span",
                    {
                      staticClass: "tablenav-pages-navspan",
                      attrs: { "aria-hidden": "true" }
                    },
                    [_vm._v("«")]
                  )
                : _c(
                    "a",
                    {
                      staticClass: "first-page",
                      attrs: { href: "#" },
                      on: {
                        click: function($event) {
                          $event.preventDefault()
                          _vm.goToPage(1)
                        }
                      }
                    },
                    [
                      _c("span", { attrs: { "aria-hidden": "true" } }, [
                        _vm._v("«")
                      ])
                    ]
                  ),
              _vm._v(" "),
              _vm.disablePrev
                ? _c(
                    "span",
                    {
                      staticClass: "tablenav-pages-navspan",
                      attrs: { "aria-hidden": "true" }
                    },
                    [_vm._v("‹")]
                  )
                : _c(
                    "a",
                    {
                      staticClass: "prev-page",
                      attrs: { href: "#" },
                      on: {
                        click: function($event) {
                          $event.preventDefault()
                          _vm.goToPage(_vm.currentPage - 1)
                        }
                      }
                    },
                    [
                      _c("span", { attrs: { "aria-hidden": "true" } }, [
                        _vm._v("‹")
                      ])
                    ]
                  ),
              _vm._v(" "),
              _c("span", { staticClass: "paging-input" }, [
                _c("span", { staticClass: "tablenav-paging-text" }, [
                  _vm._v(
                    "\n            " +
                      _vm._s(_vm.currentPage) +
                      " of\n            "
                  ),
                  _c("span", { staticClass: "total-pages" }, [
                    _vm._v(_vm._s(_vm.totalPages))
                  ])
                ])
              ]),
              _vm._v(" "),
              _vm.disableNext
                ? _c(
                    "span",
                    {
                      staticClass: "tablenav-pages-navspan",
                      attrs: { "aria-hidden": "true" }
                    },
                    [_vm._v("›")]
                  )
                : _c(
                    "a",
                    {
                      staticClass: "next-page",
                      attrs: { href: "#" },
                      on: {
                        click: function($event) {
                          $event.preventDefault()
                          _vm.goToPage(_vm.currentPage + 1)
                        }
                      }
                    },
                    [
                      _c("span", { attrs: { "aria-hidden": "true" } }, [
                        _vm._v("›")
                      ])
                    ]
                  ),
              _vm._v(" "),
              _vm.disableLast
                ? _c(
                    "span",
                    {
                      staticClass: "tablenav-pages-navspan",
                      attrs: { "aria-hidden": "true" }
                    },
                    [_vm._v("»")]
                  )
                : _c(
                    "a",
                    {
                      staticClass: "last-page",
                      attrs: { href: "#" },
                      on: {
                        click: function($event) {
                          $event.preventDefault()
                          _vm.goToPage(_vm.totalPages)
                        }
                      }
                    },
                    [
                      _c("span", { attrs: { "aria-hidden": "true" } }, [
                        _vm._v("»")
                      ])
                    ]
                  )
            ])
          : _vm._e()
      ])
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "table-loader-center" }, [
      _c("div", { staticClass: "table-loader" }, [_vm._v("Loading")])
    ])
  }
]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-50f2b730", esExports)
  }
}

/***/ }),
/* 107 */,
/* 108 */,
/* 109 */,
/* 110 */,
/* 111 */,
/* 112 */,
/* 113 */,
/* 114 */,
/* 115 */,
/* 116 */,
/* 117 */,
/* 118 */,
/* 119 */,
/* 120 */,
/* 121 */,
/* 122 */,
/* 123 */,
/* 124 */,
/* 125 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "app-customers" },
    [
      _c("h2", { staticClass: "add-new-customer" }, [
        _c("span", [_vm._v("Customers")]),
        _vm._v(" "),
        _c(
          "a",
          {
            attrs: { href: "#", id: "erp-customer-new" },
            on: {
              click: function($event) {
                _vm.showModal = true
              }
            }
          },
          [_vm._v("+ Add New Customer")]
        )
      ]),
      _vm._v(" "),
      _c("list-table", {
        attrs: {
          tableClass: "wp-ListTable widefat fixed customer-list",
          "action-column": "actions",
          columns: _vm.columns,
          rows: _vm.row_data,
          "bulk-actions": _vm.bulkActions,
          "total-items": _vm.paginationData.totalItems,
          "total-pages": _vm.paginationData.totalPages,
          "per-page": _vm.paginationData.perPage,
          "current-page": _vm.paginationData.currentPage,
          actions: _vm.actions
        },
        on: {
          pagination: _vm.goToPage,
          "action:click": _vm.onActionClick,
          "bulk:click": _vm.onBulkAction
        },
        scopedSlots: _vm._u([
          {
            key: "title",
            fn: function(data) {
              return [
                _c("strong", [
                  _c("a", { attrs: { href: "#" } }, [
                    _vm._v(_vm._s(data.row.title))
                  ])
                ])
              ]
            }
          },
          {
            key: "customer",
            fn: function(data) {
              return [
                _c("strong", [
                  _c("a", { attrs: { href: data.row.id } }, [
                    _vm._v(_vm._s(data.row.customer))
                  ])
                ])
              ]
            }
          }
        ])
      })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-384dc50a", esExports)
  }
}

/***/ }),
/* 126 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_Vendors_vue__ = __webpack_require__(36);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_0984f520_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_Vendors_vue__ = __webpack_require__(128);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(127)
}
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_Vendors_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_0984f520_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_Vendors_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/admin/components/Peoples/Vendors.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-0984f520", Component.options)
  } else {
    hotAPI.reload("data-v-0984f520", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),
/* 127 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 128 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "app-vendors" },
    [
      _c("h2", { staticClass: "add-new-vendor" }, [
        _c("span", [_vm._v("Vendors")]),
        _vm._v(" "),
        _c(
          "a",
          {
            attrs: { href: "#", id: "erp-vendor-new" },
            on: {
              click: function($event) {
                _vm.showModal = true
              }
            }
          },
          [_vm._v("+ Add New Vendor")]
        )
      ]),
      _vm._v(" "),
      _c("list-table", {
        attrs: {
          tableClass: "wp-ListTable widefat fixed vendor-list",
          "action-column": "actions",
          columns: _vm.columns,
          rows: _vm.row_data,
          "bulk-actions": _vm.bulkActions,
          "total-items": _vm.paginationData.totalItems,
          "total-pages": _vm.paginationData.totalPages,
          "per-page": _vm.paginationData.perPage,
          "current-page": _vm.paginationData.currentPage,
          actions: _vm.actions
        },
        on: {
          pagination: _vm.goToPage,
          "action:click": _vm.onActionClick,
          "bulk:click": _vm.onBulkAction
        },
        scopedSlots: _vm._u([
          {
            key: "title",
            fn: function(data) {
              return [
                _c("strong", [
                  _c("a", { attrs: { href: "#" } }, [
                    _vm._v(_vm._s(data.row.title))
                  ])
                ])
              ]
            }
          },
          {
            key: "vendor",
            fn: function(data) {
              return [
                _c("strong", [
                  _c("a", { attrs: { href: data.row.id } }, [
                    _vm._v(_vm._s(data.row.vendor))
                  ])
                ])
              ]
            }
          }
        ])
      })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-0984f520", esExports)
  }
}

/***/ }),
/* 129 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_Employees_vue__ = __webpack_require__(37);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_3f2c203a_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_Employees_vue__ = __webpack_require__(131);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(130)
}
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_Employees_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_3f2c203a_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_Employees_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/admin/components/Peoples/Employees.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-3f2c203a", Component.options)
  } else {
    hotAPI.reload("data-v-3f2c203a", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),
/* 130 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 131 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "app-employees" },
    [
      _vm._m(0),
      _vm._v(" "),
      _c("list-table", {
        attrs: {
          tableClass: "wp-ListTable widefat fixed employee-list",
          "action-column": "actions",
          columns: _vm.columns,
          rows: _vm.row_data,
          "bulk-actions": _vm.bulkActions,
          "total-items": _vm.paginationData.totalItems,
          "total-pages": _vm.paginationData.totalPages,
          "per-page": _vm.paginationData.perPage,
          "current-page": _vm.paginationData.currentPage,
          actions: _vm.actions
        },
        on: {
          pagination: _vm.goToPage,
          "action:click": _vm.onActionClick,
          "bulk:click": _vm.onBulkAction
        },
        scopedSlots: _vm._u([
          {
            key: "title",
            fn: function(data) {
              return [
                _c("strong", [
                  _c("a", { attrs: { href: "#" } }, [
                    _vm._v(_vm._s(data.row.title))
                  ])
                ])
              ]
            }
          },
          {
            key: "employee",
            fn: function(data) {
              return [
                _c("strong", [
                  _c("a", { attrs: { href: data.row.user_url } }, [
                    _vm._v(_vm._s(data.row.employee))
                  ])
                ])
              ]
            }
          }
        ])
      })
    ],
    1
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("h2", { staticClass: "add-new-employee" }, [
      _c("span", [_vm._v("Employees")])
    ])
  }
]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-3f2c203a", esExports)
  }
}

/***/ }),
/* 132 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_DummyComponent_vue__ = __webpack_require__(38);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_41d77e85_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_DummyComponent_vue__ = __webpack_require__(134);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(133)
}
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_DummyComponent_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_41d77e85_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_DummyComponent_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/admin/components/DummyComponent.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-41d77e85", Component.options)
  } else {
    hotAPI.reload("data-v-41d77e85", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),
/* 133 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 134 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("h1", [_vm._v("Page: " + _vm._s(_vm.title))])
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-41d77e85", esExports)
  }
}

/***/ }),
/* 135 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_InvoiceCreate_vue__ = __webpack_require__(39);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_38038e07_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_InvoiceCreate_vue__ = __webpack_require__(156);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(136)
}
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_InvoiceCreate_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_38038e07_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_InvoiceCreate_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/admin/components/invoice/InvoiceCreate.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-38038e07", Component.options)
  } else {
    hotAPI.reload("data-v-38038e07", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),
/* 136 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 137 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_Datepicker_vue__ = __webpack_require__(40);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_722ff94c_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_Datepicker_vue__ = __webpack_require__(141);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(138)
}
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_Datepicker_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_722ff94c_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_Datepicker_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/admin/components/base/Datepicker.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-722ff94c", Component.options)
  } else {
    hotAPI.reload("data-v-722ff94c", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),
/* 138 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 139 */,
/* 140 */,
/* 141 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "dropdown",
    [
      _c("template", { slot: "button" }, [
        _c("input", {
          directives: [
            {
              name: "model",
              rawName: "v-model",
              value: _vm.selectedDate,
              expression: "selectedDate"
            }
          ],
          ref: "datePicker",
          staticClass: "wperp-form-field",
          domProps: { value: _vm.selectedDate },
          on: {
            input: function($event) {
              if ($event.target.composing) {
                return
              }
              _vm.selectedDate = $event.target.value
            }
          }
        })
      ]),
      _vm._v(" "),
      _c(
        "template",
        { slot: "dropdown" },
        [
          _c("calendar", {
            attrs: { backgroundColor: "#fff", attributes: _vm.pickerAttrs },
            on: { dayclick: _vm.pickerSelect }
          })
        ],
        1
      )
    ],
    2
  )
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-722ff94c", esExports)
  }
}

/***/ }),
/* 142 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_FileUpload_vue__ = __webpack_require__(42);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_7e398fbb_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_FileUpload_vue__ = __webpack_require__(144);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(143)
}
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_FileUpload_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_7e398fbb_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_FileUpload_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/admin/components/base/FileUpload.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-7e398fbb", Component.options)
  } else {
    hotAPI.reload("data-v-7e398fbb", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),
/* 143 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 144 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "form",
    { attrs: { enctype: "multipart/form-data", novalidate: "" } },
    [
      _c("div", { staticClass: "attachment-placeholder" }, [
        _vm._v(" To attach\n        "),
        _c("input", {
          staticClass: "display-none",
          attrs: {
            type: "file",
            id: "attachment",
            multiple: "",
            accept: "image/*,.jpg,.png,.doc,.pdf",
            name: _vm.uploadFieldName,
            disabled: _vm.isSaving
          },
          on: {
            change: function($event) {
              _vm.filesChange($event)
            }
          }
        }),
        _vm._v(" "),
        _c("label", { attrs: { for: "attachment" } }, [_vm._v("Select files")]),
        _vm._v(" from your computer\n        "),
        _vm.isSaving
          ? _c("span", { staticClass: "upload-count" }, [
              _vm._v(" (uploading " + _vm._s(_vm.fileCount) + " files...)")
            ])
          : _vm._e(),
        _vm._v(" "),
        _vm.isUploaded
          ? _c("span", { staticClass: "upload-count" }, [
              _vm._v(" (uploaded " + _vm._s(_vm.fileCount) + " files...)")
            ])
          : _vm._e()
      ])
    ]
  )
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-7e398fbb", esExports)
  }
}

/***/ }),
/* 145 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_TransactionRow_vue__ = __webpack_require__(43);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_dd1483e4_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_TransactionRow_vue__ = __webpack_require__(152);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(146)
}
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_TransactionRow_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_dd1483e4_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_TransactionRow_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/admin/components/invoice/TransactionRow.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-dd1483e4", Component.options)
  } else {
    hotAPI.reload("data-v-dd1483e4", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),
/* 146 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 147 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 148 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function (fn, delay) {
  var timeoutID = null;
  return function () {
    clearTimeout(timeoutID);
    var args = arguments;
    var that = this;
    timeoutID = setTimeout(function () {
      fn.apply(that, args);
    }, delay);
  };
});

/***/ }),
/* 149 */,
/* 150 */,
/* 151 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "multiselect",
    {
      attrs: {
        value: _vm.value,
        options: _vm.options,
        multiple: _vm.multiple,
        "close-on-select": !_vm.multiple,
        loading: _vm.isLoading,
        placeholder: "Please select",
        label: "name",
        "track-by": "id"
      },
      on: {
        remove: _vm.onRemove,
        select: _vm.onSelect,
        "search-change": _vm.asyncFind
      },
      scopedSlots: _vm._u([
        {
          key: "tag",
          fn: function(ref) {
            var option = ref.option
            var remove = ref.remove
            return [
              _c("span", { staticClass: "custom__tag" }, [
                _c("span", [_vm._v(_vm._s(option.name))]),
                _c(
                  "span",
                  {
                    staticClass: "custom__remove",
                    on: {
                      click: function($event) {
                        _vm.onRemove(option)
                      }
                    }
                  },
                  [_vm._v("\n        ☓")]
                )
              ])
            ]
          }
        }
      ])
    },
    [
      _c("span", { attrs: { slot: "noResult" }, slot: "noResult" }, [
        _vm._v("Oops! No elements found.")
      ])
    ]
  )
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-57da95b2", esExports)
  }
}

/***/ }),
/* 152 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("tr", [
    _c(
      "th",
      {
        staticClass: "col--check with-multiselect prodcut-select",
        attrs: { scope: "row" }
      },
      [
        _c("multi-select", {
          attrs: { options: _vm.products },
          model: {
            value: _vm.line.selectedProduct,
            callback: function($$v) {
              _vm.$set(_vm.line, "selectedProduct", $$v)
            },
            expression: "line.selectedProduct"
          }
        })
      ],
      1
    ),
    _vm._v(" "),
    _c("td", { staticClass: "col--qty column-primary" }, [
      _c("input", {
        directives: [
          {
            name: "validate",
            rawName: "v-validate",
            value: "required",
            expression: "'required'"
          },
          {
            name: "model",
            rawName: "v-model",
            value: _vm.line.qty,
            expression: "line.qty"
          }
        ],
        staticClass: "wperp-form-field",
        class: { "has-err": _vm.errors.first("qty") },
        attrs: { type: "number", name: "qty" },
        domProps: { value: _vm.line.qty },
        on: {
          keyup: _vm.calculateAmount,
          input: function($event) {
            if ($event.target.composing) {
              return
            }
            _vm.$set(_vm.line, "qty", $event.target.value)
          }
        }
      })
    ]),
    _vm._v(" "),
    _c(
      "td",
      {
        staticClass: "col--uni_price",
        attrs: { "data-colname": "Unit Price" }
      },
      [
        _c("input", {
          directives: [
            {
              name: "model",
              rawName: "v-model",
              value: _vm.line.unitPrice,
              expression: "line.unitPrice"
            }
          ],
          staticClass: "wperp-form-field",
          attrs: { type: "text" },
          domProps: { value: _vm.line.unitPrice },
          on: {
            keyup: _vm.calculateAmount,
            input: function($event) {
              if ($event.target.composing) {
                return
              }
              _vm.$set(_vm.line, "unitPrice", $event.target.value)
            }
          }
        })
      ]
    ),
    _vm._v(" "),
    _c(
      "td",
      { staticClass: "col--discount", attrs: { "data-colname": "Discount" } },
      [
        _c("div", { staticClass: "wperp-has-addon" }, [
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.line.discount,
                expression: "line.discount"
              }
            ],
            staticClass: "wperp-form-field",
            attrs: { type: "text" },
            domProps: { value: _vm.line.discount },
            on: {
              keyup: _vm.calculateAmount,
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.$set(_vm.line, "discount", $event.target.value)
              }
            }
          }),
          _vm._v(" "),
          _c("span", { staticClass: "wperp-addon" }, [_vm._v("%")])
        ])
      ]
    ),
    _vm._v(" "),
    _vm._m(0),
    _vm._v(" "),
    _c(
      "td",
      {
        staticClass: "col--tax-amount",
        attrs: { "data-colname": "Tax Amount" }
      },
      [
        _c("input", {
          directives: [
            {
              name: "model",
              rawName: "v-model",
              value: _vm.line.taxAmount,
              expression: "line.taxAmount"
            }
          ],
          staticClass: "wperp-form-field",
          attrs: { type: "text" },
          domProps: { value: _vm.line.taxAmount },
          on: {
            keyup: _vm.calculateAmount,
            input: function($event) {
              if ($event.target.composing) {
                return
              }
              _vm.$set(_vm.line, "taxAmount", $event.target.value)
            }
          }
        })
      ]
    ),
    _vm._v(" "),
    _c(
      "td",
      { staticClass: "col--amount", attrs: { "data-colname": "Amount" } },
      [
        _c("input", {
          directives: [
            {
              name: "model",
              rawName: "v-model",
              value: _vm.line.totalAmount,
              expression: "line.totalAmount"
            }
          ],
          staticClass: "wperp-form-field",
          attrs: { type: "text", readonly: "" },
          domProps: { value: _vm.line.totalAmount },
          on: {
            input: function($event) {
              if ($event.target.composing) {
                return
              }
              _vm.$set(_vm.line, "totalAmount", $event.target.value)
            }
          }
        })
      ]
    ),
    _vm._v(" "),
    _c(
      "td",
      {
        staticClass: "col--actions delete-row",
        attrs: { "data-colname": "Action" }
      },
      [
        _c("span", { staticClass: "wperp-btn", on: { click: _vm.removeRow } }, [
          _c("i", { staticClass: "flaticon-trash" })
        ])
      ]
    )
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "td",
      { staticClass: "col--penholder", attrs: { "data-colname": "Tax(%)" } },
      [
        _c("div", { staticClass: "wperp-custom-select" }, [
          _c(
            "select",
            { staticClass: "wperp-form-field", attrs: { name: "pen-holder" } },
            [
              _c("option", { attrs: { value: "0" } }, [_vm._v("Select")]),
              _vm._v(" "),
              _c("option", { attrs: { value: "1" } }, [_vm._v("Gov")]),
              _vm._v(" "),
              _c("option", { attrs: { value: "2" } }, [_vm._v("Private")])
            ]
          ),
          _vm._v(" "),
          _c("i", { staticClass: "flaticon-arrow-down-sign-to-navigate" })
        ])
      ]
    )
  }
]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-dd1483e4", esExports)
  }
}

/***/ }),
/* 153 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_InvoiceCustomers_vue__ = __webpack_require__(47);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_72da2b1a_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_InvoiceCustomers_vue__ = __webpack_require__(155);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(154)
}
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_InvoiceCustomers_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_72da2b1a_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_InvoiceCustomers_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/admin/components/invoice/InvoiceCustomers.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-72da2b1a", Component.options)
  } else {
    hotAPI.reload("data-v-72da2b1a", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),
/* 154 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 155 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "wperp-col-sm-4" }, [
    _c(
      "div",
      { staticClass: "wperp-form-group invoice-customers with-multiselect" },
      [
        _vm._m(0),
        _vm._v(" "),
        _c("multi-select", {
          attrs: { options: _vm.options },
          model: {
            value: _vm.selected,
            callback: function($$v) {
              _vm.selected = $$v
            },
            expression: "selected"
          }
        }),
        _vm._v(" "),
        _vm._m(1)
      ],
      1
    )
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { attrs: { for: "customer" } }, [
      _vm._v("Customer"),
      _c("span", { staticClass: "wperp-required-sign" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("a", { staticClass: "add-new-customer", attrs: { href: "#" } }, [
      _c("i", { staticClass: "flaticon-add-plus-button" }),
      _vm._v("Add new")
    ])
  }
]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-72da2b1a", esExports)
  }
}

/***/ }),
/* 156 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "wperp-container" }, [
    _vm._m(0),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass: "wperp-panel wperp-panel-default",
        staticStyle: { "padding-bottom": "0" }
      },
      [
        _c("div", { staticClass: "wperp-panel-body" }, [
          _c(
            "form",
            {
              staticClass: "wperp-form",
              attrs: { action: "#", method: "post" }
            },
            [
              _c(
                "div",
                { staticClass: "wperp-row" },
                [
                  _c("invoice-customers", {
                    model: {
                      value: _vm.basic_fields.customer,
                      callback: function($$v) {
                        _vm.$set(_vm.basic_fields, "customer", $$v)
                      },
                      expression: "basic_fields.customer"
                    }
                  }),
                  _vm._v(" "),
                  _c("div", { staticClass: "wperp-col-sm-4" }, [
                    _c(
                      "div",
                      { staticClass: "wperp-form-group" },
                      [
                        _vm._m(1),
                        _vm._v(" "),
                        _c("datepicker", {
                          model: {
                            value: _vm.basic_fields.trans_date,
                            callback: function($$v) {
                              _vm.$set(_vm.basic_fields, "trans_date", $$v)
                            },
                            expression: "basic_fields.trans_date"
                          }
                        })
                      ],
                      1
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "wperp-col-sm-4" }, [
                    _c(
                      "div",
                      { staticClass: "wperp-form-group" },
                      [
                        _vm._m(2),
                        _vm._v(" "),
                        _c("datepicker", {
                          model: {
                            value: _vm.basic_fields.due_date,
                            callback: function($$v) {
                              _vm.$set(_vm.basic_fields, "due_date", $$v)
                            },
                            expression: "basic_fields.due_date"
                          }
                        })
                      ],
                      1
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "wperp-col-xs-12" }, [
                    _c("label", { attrs: { for: "billing_address" } }, [
                      _vm._v("Billing Address")
                    ]),
                    _vm._v(" "),
                    _c("textarea", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model.trim",
                          value: _vm.basic_fields.billing_address,
                          expression: "basic_fields.billing_address",
                          modifiers: { trim: true }
                        }
                      ],
                      staticClass: "wperp-form-field",
                      attrs: { rows: "4", placeholder: "Type here" },
                      domProps: { value: _vm.basic_fields.billing_address },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(
                            _vm.basic_fields,
                            "billing_address",
                            $event.target.value.trim()
                          )
                        },
                        blur: function($event) {
                          _vm.$forceUpdate()
                        }
                      }
                    })
                  ])
                ],
                1
              )
            ]
          )
        ])
      ]
    ),
    _vm._v(" "),
    _c("div", { staticClass: "wperp-table-responsive" }, [
      _c("div", { staticClass: "table-container" }, [
        _c("table", { staticClass: "wperp-table wperp-form-table" }, [
          _vm._m(3),
          _vm._v(" "),
          _c(
            "tbody",
            { attrs: { id: "test" } },
            [
              _vm._l(_vm.transactionLines, function(line, index) {
                return _c("transaction-row", {
                  key: index,
                  attrs: { line: line, products: _vm.products }
                })
              }),
              _vm._v(" "),
              _c("tr", { staticClass: "total-amount-row" }, [
                _vm._m(4),
                _vm._v(" "),
                _c("td", [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.finalTotalAmount,
                        expression: "finalTotalAmount"
                      }
                    ],
                    attrs: { type: "text", readonly: "" },
                    domProps: { value: _vm.finalTotalAmount },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.finalTotalAmount = $event.target.value
                      }
                    }
                  })
                ]),
                _vm._v(" "),
                _c("td")
              ]),
              _vm._v(" "),
              _c("tr", { staticClass: "add-new-line" }, [
                _c(
                  "td",
                  {
                    staticStyle: { "text-align": "left" },
                    attrs: { colspan: "9" }
                  },
                  [
                    _c(
                      "button",
                      {
                        staticClass: "wperp-btn btn--primary add-line-trigger",
                        on: {
                          click: function($event) {
                            $event.preventDefault()
                            return _vm.addLine($event)
                          }
                        }
                      },
                      [
                        _c("i", { staticClass: "flaticon-add-plus-button" }),
                        _vm._v("Add Line")
                      ]
                    )
                  ]
                )
              ]),
              _vm._v(" "),
              _c("tr", { staticClass: "add-attachment-row" }, [
                _c(
                  "td",
                  {
                    staticStyle: { "text-align": "left" },
                    attrs: { colspan: "9" }
                  },
                  [
                    _c(
                      "div",
                      { staticClass: "attachment-container" },
                      [
                        _c("label", { staticClass: "col--attachement" }, [
                          _vm._v("Attachment")
                        ]),
                        _vm._v(" "),
                        _c("file-upload", {
                          attrs: { url: "/invoices/attachments" },
                          model: {
                            value: _vm.attachments,
                            callback: function($$v) {
                              _vm.attachments = $$v
                            },
                            expression: "attachments"
                          }
                        })
                      ],
                      1
                    )
                  ]
                )
              ])
            ],
            2
          ),
          _vm._v(" "),
          _c("tfoot", [
            _c("tr", [
              _c(
                "td",
                {
                  staticStyle: { "text-align": "right" },
                  attrs: { colspan: "9" }
                },
                [
                  _c("submit-button", {
                    attrs: {
                      text: "Submit for approval",
                      working: _vm.isWorking
                    },
                    nativeOn: {
                      click: function($event) {
                        return _vm.SubmitForApproval($event)
                      }
                    }
                  })
                ],
                1
              )
            ])
          ])
        ])
      ])
    ]),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass: "wperp-modal wperp-invoice-modal wperp-custom-scroll",
        attrs: { id: "wperp-invoice-modal", role: "dialog" }
      },
      [
        _c("div", { staticClass: "wperp-modal-dialog" }, [
          _c("div", { staticClass: "wperp-modal-content" }, [
            _vm._m(5),
            _vm._v(" "),
            _c("div", { staticClass: "wperp-modal-body" }, [
              _c("div", { staticClass: "wperp-invoice-panel" }, [
                _c("div", { staticClass: "invoice-header" }, [
                  _c("div", { staticClass: "invoice-logo" }, [
                    _c("img", {
                      attrs: {
                        src:
                          _vm.acct_var.acc_aaset_url + "/images/dummy-logo.png",
                        alt: "logo name"
                      }
                    })
                  ]),
                  _vm._v(" "),
                  _vm._m(6)
                ]),
                _vm._v(" "),
                _vm._m(7),
                _vm._v(" "),
                _vm._m(8)
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "invoice-attachments d-print-none" }, [
                _c("h4", [_vm._v("Attachments")]),
                _vm._v(" "),
                _c(
                  "a",
                  { staticClass: "attachment-item", attrs: { href: "#" } },
                  [
                    _c("img", {
                      attrs: {
                        src:
                          _vm.acct_var.acc_aaset_url + "/images/img-thumb.png",
                        alt: "image name"
                      }
                    }),
                    _vm._v(" "),
                    _vm._m(9)
                  ]
                ),
                _vm._v(" "),
                _c(
                  "a",
                  { staticClass: "attachment-item", attrs: { href: "#" } },
                  [
                    _c("img", {
                      attrs: {
                        src:
                          _vm.acct_var.acc_aaset_url + "/images/doc-thumb.png",
                        alt: "image name"
                      }
                    }),
                    _vm._v(" "),
                    _vm._m(10)
                  ]
                ),
                _vm._v(" "),
                _c(
                  "a",
                  { staticClass: "attachment-item", attrs: { href: "#" } },
                  [
                    _c("img", {
                      attrs: {
                        src:
                          _vm.acct_var.acc_aaset_url + "/images/pdf-thumb.png",
                        alt: "image name"
                      }
                    }),
                    _vm._v(" "),
                    _vm._m(11)
                  ]
                )
              ])
            ])
          ])
        ])
      ]
    )
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "content-header-section separator" }, [
      _c("div", { staticClass: "wperp-row wperp-between-xs" }, [
        _c("div", { staticClass: "wperp-col" }, [
          _c("h2", { staticClass: "content-header__title" }, [
            _vm._v("New Invoice")
          ])
        ])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { attrs: { for: "trans_date" } }, [
      _vm._v("Transaction Date"),
      _c("span", { staticClass: "wperp-required-sign" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { attrs: { for: "due_date" } }, [
      _vm._v("Due Date"),
      _c("span", { staticClass: "wperp-required-sign" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("td", { staticClass: "col--check", attrs: { scope: "col" } }, [
          _vm._v("Product/Service")
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "column-primary", attrs: { scope: "col" } }, [
          _vm._v("Qty")
        ]),
        _vm._v(" "),
        _c("th", { attrs: { scope: "col" } }, [_vm._v("Unit Price")]),
        _vm._v(" "),
        _c("th", { attrs: { scope: "col" } }, [_vm._v("Discount")]),
        _vm._v(" "),
        _c("th", { attrs: { scope: "col" } }, [_vm._v("Tax(%)")]),
        _vm._v(" "),
        _c("th", { attrs: { scope: "col" } }, [_vm._v("Tax Amount")]),
        _vm._v(" "),
        _c("th", { attrs: { scope: "col" } }, [_vm._v("Amount")]),
        _vm._v(" "),
        _c("th", { staticClass: "col--actions", attrs: { scope: "col" } })
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("td", { staticClass: "text-right", attrs: { colspan: "6" } }, [
      _c("span", [_vm._v("Total Amount = ")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "wperp-modal-header" }, [
      _c("h4", [
        _vm._v(
          "\n                            Invoice\n                        "
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "d-print-none" }, [
        _c(
          "a",
          {
            staticClass: "wperp-btn btn--default print-btn",
            attrs: { href: "#" }
          },
          [
            _c("i", { staticClass: "flaticon-printer-1" }),
            _vm._v(
              "\n                                  Print\n                            "
            )
          ]
        ),
        _vm._v(" "),
        _c(
          "a",
          { staticClass: "wperp-btn btn--default", attrs: { href: "#" } },
          [
            _c("i", { staticClass: "flaticon-settings-work-tool" }),
            _vm._v(
              "\n                                  More Action\n                            "
            )
          ]
        )
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "invoice-address" }, [
      _c("address", [
        _c("strong", [_vm._v("Amazon Limited")]),
        _c("br"),
        _vm._v(
          "\n                                        983 Aiden Roads Suite 062"
        ),
        _c("br"),
        _vm._v("\n                                        Address Line 2"),
        _c("br"),
        _vm._v(
          "\n                                        1483 Theresafort Afyon"
        ),
        _c("br"),
        _vm._v(
          "\n                                        Turkey\n                                    "
        )
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "invoice-body" }, [
      _c("h4", [_vm._v("Invoice")]),
      _vm._v(" "),
      _c("div", { staticClass: "wperp-row" }, [
        _c("div", { staticClass: "wperp-col-sm-6" }, [
          _c("h5", [_vm._v("Bill to:")]),
          _vm._v(" "),
          _c("div", { staticClass: "persons-info" }, [
            _c("strong", [_vm._v("Md Ashraf Hossain")]),
            _c("br"),
            _vm._v(
              "\n                                            983 Aiden Roads Suite 062"
            ),
            _c("br"),
            _vm._v(
              "\n                                            Address Line 2"
            ),
            _c("br"),
            _vm._v(
              "\n                                            1483 Theresafort Afyon"
            ),
            _c("br"),
            _vm._v(
              "\n                                            Turkey\n                                        "
            )
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "wperp-col-sm-6" }, [
          _c("table", { staticClass: "invoice-info" }, [
            _c("tr", [
              _c("th", [_vm._v("Invoice No.")]),
              _vm._v(" "),
              _c("td", [_vm._v("INV-0001")])
            ]),
            _vm._v(" "),
            _c("tr", [
              _c("th", [_vm._v("Invoice Date:")]),
              _vm._v(" "),
              _c("td", [_vm._v("17-10-2018")])
            ]),
            _vm._v(" "),
            _c("tr", [
              _c("th", [_vm._v("Due Date:")]),
              _vm._v(" "),
              _c("td", [_vm._v("17-10-2018")])
            ]),
            _vm._v(" "),
            _c("tr", [
              _c("th", [_vm._v("Amount Due:")]),
              _vm._v(" "),
              _c("td", [_vm._v("17-10-2018")])
            ])
          ])
        ])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "wperp-invoice-table" }, [
      _c(
        "table",
        { staticClass: "wperp-table wperp-form-table invoice-table" },
        [
          _c("thead", [
            _c("tr", [
              _c("th", [_vm._v("Description")]),
              _vm._v(" "),
              _c("th", [_vm._v("City")]),
              _vm._v(" "),
              _c("th", [_vm._v("Unit Price")]),
              _vm._v(" "),
              _c("th", [_vm._v("Discount")]),
              _vm._v(" "),
              _c("th", [_vm._v("Tax")]),
              _vm._v(" "),
              _c("th", [_vm._v("Tax Amount")]),
              _vm._v(" "),
              _c("th", [_vm._v("Amount")])
            ])
          ]),
          _vm._v(" "),
          _c("tbody", [
            _c("tr", [
              _c("th", [_vm._v("Buy Fabrics")]),
              _vm._v(" "),
              _c("td", [_vm._v("10")]),
              _vm._v(" "),
              _c("td", [_vm._v("$1500.00")]),
              _vm._v(" "),
              _c("td", [_vm._v("10%")]),
              _vm._v(" "),
              _c("td", [_vm._v("0%")]),
              _vm._v(" "),
              _c("td", [_vm._v("$0.00")]),
              _vm._v(" "),
              _c("td", [_vm._v("$15,000.00")])
            ]),
            _vm._v(" "),
            _c("tr", [
              _c("th", [_vm._v("Buy Fabrics")]),
              _vm._v(" "),
              _c("td", [_vm._v("10")]),
              _vm._v(" "),
              _c("td", [_vm._v("$1500.00")]),
              _vm._v(" "),
              _c("td", [_vm._v("10%")]),
              _vm._v(" "),
              _c("td", [_vm._v("0%")]),
              _vm._v(" "),
              _c("td", [_vm._v("$0.00")]),
              _vm._v(" "),
              _c("td", [_vm._v("$15,000.00")])
            ]),
            _vm._v(" "),
            _c("tr", [
              _c("th", [_vm._v("Buy Fabrics")]),
              _vm._v(" "),
              _c("td", [_vm._v("10")]),
              _vm._v(" "),
              _c("td", [_vm._v("$1500.00")]),
              _vm._v(" "),
              _c("td", [_vm._v("10%")]),
              _vm._v(" "),
              _c("td", [_vm._v("0%")]),
              _vm._v(" "),
              _c("td", [_vm._v("$0.00")]),
              _vm._v(" "),
              _c("td", [_vm._v("$15,000.00")])
            ]),
            _c("tr", [
              _c("th", [_vm._v("Buy Fabrics")]),
              _vm._v(" "),
              _c("td", [_vm._v("10")]),
              _vm._v(" "),
              _c("td", [_vm._v("$1500.00")]),
              _vm._v(" "),
              _c("td", [_vm._v("10%")]),
              _vm._v(" "),
              _c("td", [_vm._v("0%")]),
              _vm._v(" "),
              _c("td", [_vm._v("$0.00")]),
              _vm._v(" "),
              _c("td", [_vm._v("$15,000.00")])
            ]),
            _c("tr", [
              _c("th", [_vm._v("Buy Fabrics")]),
              _vm._v(" "),
              _c("td", [_vm._v("10")]),
              _vm._v(" "),
              _c("td", [_vm._v("$1500.00")]),
              _vm._v(" "),
              _c("td", [_vm._v("10%")]),
              _vm._v(" "),
              _c("td", [_vm._v("0%")]),
              _vm._v(" "),
              _c("td", [_vm._v("$0.00")]),
              _vm._v(" "),
              _c("td", [_vm._v("$15,000.00")])
            ])
          ]),
          _vm._v(" "),
          _c("tfoot", [
            _c("tr", [
              _c("td", { attrs: { colspan: "7" } }, [
                _c("ul", [
                  _c("li", [
                    _c("span", [_vm._v("Subtotal:")]),
                    _vm._v(" $15,000.00")
                  ]),
                  _vm._v(" "),
                  _c("li", [
                    _c("span", [_vm._v("Total:")]),
                    _vm._v(" $15,000.00")
                  ]),
                  _vm._v(" "),
                  _c("li", [
                    _c("span", [_vm._v("Total Related Payments:")]),
                    _vm._v(" $15,000.00")
                  ])
                ])
              ])
            ])
          ])
        ]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "attachment-meta" }, [
      _c("span", [_vm._v("File name with extension")]),
      _c("br"),
      _vm._v(" "),
      _c("span", { staticClass: "text-muted" }, [_vm._v("file size")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "attachment-meta" }, [
      _c("span", [_vm._v("File name with extension")]),
      _c("br"),
      _vm._v(" "),
      _c("span", { staticClass: "text-muted" }, [_vm._v("file size")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "attachment-meta" }, [
      _c("span", [_vm._v("File name with extension")]),
      _c("br"),
      _vm._v(" "),
      _c("span", { staticClass: "text-muted" }, [_vm._v("file size")])
    ])
  }
]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-38038e07", esExports)
  }
}

/***/ }),
/* 157 */,
/* 158 */,
/* 159 */,
/* 160 */,
/* 161 */,
/* 162 */,
/* 163 */,
/* 164 */,
/* 165 */,
/* 166 */,
/* 167 */,
/* 168 */,
/* 169 */,
/* 170 */,
/* 171 */,
/* 172 */,
/* 173 */,
/* 174 */,
/* 175 */,
/* 176 */,
/* 177 */,
/* 178 */,
/* 179 */,
/* 180 */,
/* 181 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
//
//
//
//
/* harmony default export */ __webpack_exports__["a"] = ({
  name: 'SubmitButton',
  props: {
    text: {
      type: String,
      default: 'Submit'
    },
    working: {
      type: Boolean,
      default: false
    }
  }
});

/***/ }),
/* 182 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_SubmitButton_vue__ = __webpack_require__(181);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_30ab92f0_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_SubmitButton_vue__ = __webpack_require__(184);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(183)
}
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_SubmitButton_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_30ab92f0_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_SubmitButton_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/admin/components/base/SubmitButton.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-30ab92f0", Component.options)
  } else {
    hotAPI.reload("data-v-30ab92f0", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),
/* 183 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 184 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "button",
    {
      staticClass: "wperp-btn btn--primary acct-button",
      class: { working: _vm.working },
      attrs: { type: "submit" }
    },
    [_vm._v(_vm._s(_vm.text))]
  )
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-30ab92f0", esExports)
  }
}

/***/ }),
/* 185 */,
/* 186 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_admin_components_Userinfo_User_basic_vue__ = __webpack_require__(190);
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["a"] = ({
  name: "Customer-details",
  components: {
    UserBasicInfo: __WEBPACK_IMPORTED_MODULE_0_admin_components_Userinfo_User_basic_vue__["a" /* default */]
  },
  data: function data() {
    return {
      userData: {
        'name': 'Mishu Alam',
        'email': 'mishu@dishkao.com',
        'meta': {
          'phone number': '+ 88101230123',
          'website': 'www.cholejai.com',
          'mobile': '+ 999999999',
          'fax': 'nomail@onlyvago.com',
          'address': 'Ghor nai, Bari nai, Hisab nai re'
        }
      }
    };
  }
});

/***/ }),
/* 187 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ __webpack_exports__["a"] = ({
  name: "User-basic-info",
  props: {
    userData: {
      type: Object,
      required: true,
      default: function _default() {
        return {
          'id': '',
          'name': 'Full Name',
          'email': 'email@mail.com',
          'img_url': '#',
          'meta': {
            'phone': '+ 88101230123',
            'mobile': '+ 999999999',
            'website': 'www.website.com',
            'fax': '+99898989898',
            'address': 'House#1005, Block#B, Avenue#9, Mirpur DOHS'
          }
        };
      }
    }
  },
  computed: {
    user: function user() {
      return this.userData;
    }
  },
  methods: {
    camelCase: function camelCase(str) {
      return str.toLowerCase().replace(/(?:(^.)|(\s+.))/g, function (match) {
        return match.charAt(match.length - 1).toUpperCase();
      });
    }
  }
});

/***/ }),
/* 188 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_Customer_details_vue__ = __webpack_require__(186);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_20e7b5a4_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_Customer_details_vue__ = __webpack_require__(193);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(189)
}
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_Customer_details_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_20e7b5a4_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_Customer_details_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/admin/components/Peoples/Customer-details.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-20e7b5a4", Component.options)
  } else {
    hotAPI.reload("data-v-20e7b5a4", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),
/* 189 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 190 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_User_basic_vue__ = __webpack_require__(187);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_00488002_hasScoped_true_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_User_basic_vue__ = __webpack_require__(192);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(191)
}
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-00488002"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_User_basic_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_00488002_hasScoped_true_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_User_basic_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/admin/components/Userinfo/User-basic.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-00488002", Component.options)
  } else {
    hotAPI.reload("data-v-00488002", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),
/* 191 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 192 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "wperp-panel wperp-panel-default mt-20" }, [
    _c("div", { staticClass: "wperp-panel-body wperp-customer-panel" }, [
      _vm._m(0),
      _vm._v(" "),
      _c("div", { staticClass: "wperp-row" }, [
        _c(
          "div",
          {
            staticClass:
              "wperp-col-lg-3 wperp-col-md-4 wperp-col-sm-4 wperp-col-xs-12"
          },
          [
            _c("div", { staticClass: "customer-identity" }, [
              _c("img", {
                attrs: { src: _vm.user.img_url, alt: _vm.user.name }
              }),
              _vm._v(" "),
              _c("div", {}, [
                _c("h3", [_vm._v(_vm._s(_vm.user.name))]),
                _vm._v(" "),
                _c("span", [_vm._v(_vm._s(_vm.user.email))])
              ])
            ])
          ]
        ),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass:
              "wperp-col-lg-9 wperp-col-md-8 wperp-col-sm-8 wperp-col-xs-12"
          },
          [
            _c(
              "ul",
              { staticClass: "customer-meta" },
              _vm._l(_vm.user.meta, function(val, key) {
                return _c("li", [
                  _c("strong", [_vm._v(_vm._s(_vm.camelCase(key)) + ":")]),
                  _vm._v(" "),
                  _c("span", [_vm._v(_vm._s(val))])
                ])
              })
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
    return _c(
      "span",
      {
        staticClass: "edit-badge",
        attrs: {
          "data-toggle": "wperp-modal",
          "data-target": "wperp-edit-customer-modal"
        }
      },
      [_c("i", { staticClass: "flaticon-edit" })]
    )
  }
]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-00488002", esExports)
  }
}

/***/ }),
/* 193 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "wperp-container" },
    [_c("UserBasicInfo", { attrs: { userData: _vm.userData } })],
    1
  )
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-20e7b5a4", esExports)
  }
}

/***/ })
],[62]);