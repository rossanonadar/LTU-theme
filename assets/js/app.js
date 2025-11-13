/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./src/js/pages/projects.js":
/*!**********************************!*\
  !*** ./src/js/pages/projects.js ***!
  \**********************************/
/***/ (() => {

var _window;
function _regenerator() { /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/babel/babel/blob/main/packages/babel-helpers/LICENSE */ var e, t, r = "function" == typeof Symbol ? Symbol : {}, n = r.iterator || "@@iterator", o = r.toStringTag || "@@toStringTag"; function i(r, n, o, i) { var c = n && n.prototype instanceof Generator ? n : Generator, u = Object.create(c.prototype); return _regeneratorDefine2(u, "_invoke", function (r, n, o) { var i, c, u, f = 0, p = o || [], y = !1, G = { p: 0, n: 0, v: e, a: d, f: d.bind(e, 4), d: function d(t, r) { return i = t, c = 0, u = e, G.n = r, a; } }; function d(r, n) { for (c = r, u = n, t = 0; !y && f && !o && t < p.length; t++) { var o, i = p[t], d = G.p, l = i[2]; r > 3 ? (o = l === n) && (u = i[(c = i[4]) ? 5 : (c = 3, 3)], i[4] = i[5] = e) : i[0] <= d && ((o = r < 2 && d < i[1]) ? (c = 0, G.v = n, G.n = i[1]) : d < l && (o = r < 3 || i[0] > n || n > l) && (i[4] = r, i[5] = n, G.n = l, c = 0)); } if (o || r > 1) return a; throw y = !0, n; } return function (o, p, l) { if (f > 1) throw TypeError("Generator is already running"); for (y && 1 === p && d(p, l), c = p, u = l; (t = c < 2 ? e : u) || !y;) { i || (c ? c < 3 ? (c > 1 && (G.n = -1), d(c, u)) : G.n = u : G.v = u); try { if (f = 2, i) { if (c || (o = "next"), t = i[o]) { if (!(t = t.call(i, u))) throw TypeError("iterator result is not an object"); if (!t.done) return t; u = t.value, c < 2 && (c = 0); } else 1 === c && (t = i.return) && t.call(i), c < 2 && (u = TypeError("The iterator does not provide a '" + o + "' method"), c = 1); i = e; } else if ((t = (y = G.n < 0) ? u : r.call(n, G)) !== a) break; } catch (t) { i = e, c = 1, u = t; } finally { f = 1; } } return { value: t, done: y }; }; }(r, o, i), !0), u; } var a = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} t = Object.getPrototypeOf; var c = [][n] ? t(t([][n]())) : (_regeneratorDefine2(t = {}, n, function () { return this; }), t), u = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(c); function f(e) { return Object.setPrototypeOf ? Object.setPrototypeOf(e, GeneratorFunctionPrototype) : (e.__proto__ = GeneratorFunctionPrototype, _regeneratorDefine2(e, o, "GeneratorFunction")), e.prototype = Object.create(u), e; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, _regeneratorDefine2(u, "constructor", GeneratorFunctionPrototype), _regeneratorDefine2(GeneratorFunctionPrototype, "constructor", GeneratorFunction), GeneratorFunction.displayName = "GeneratorFunction", _regeneratorDefine2(GeneratorFunctionPrototype, o, "GeneratorFunction"), _regeneratorDefine2(u), _regeneratorDefine2(u, o, "Generator"), _regeneratorDefine2(u, n, function () { return this; }), _regeneratorDefine2(u, "toString", function () { return "[object Generator]"; }), (_regenerator = function _regenerator() { return { w: i, m: f }; })(); }
function _regeneratorDefine2(e, r, n, t) { var i = Object.defineProperty; try { i({}, "", {}); } catch (e) { i = 0; } _regeneratorDefine2 = function _regeneratorDefine(e, r, n, t) { function o(r, n) { _regeneratorDefine2(e, r, function (e) { return this._invoke(r, n, e); }); } r ? i ? i(e, r, { value: n, enumerable: !t, configurable: !t, writable: !t }) : e[r] = n : (o("next", 0), o("throw", 1), o("return", 2)); }, _regeneratorDefine2(e, r, n, t); }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }
var apiBase = ((_window = window) === null || _window === void 0 || (_window = _window.ltuTheme) === null || _window === void 0 ? void 0 : _window.restBase) || '/wp-json/ltu/v1/projects';

// Formats a number as currency (USD)
var formatCurrency = function formatCurrency(value) {
  if (!value && value !== 0) {
    return '';
  }
  return new Intl.NumberFormat(undefined, {
    style: 'currency',
    currency: 'USD'
  }).format(value);
};

// `renders` table rows based on the provided projects data
var renderRows = function renderRows(tableBody, projects) {
  if (!tableBody) {
    return;
  }

  // Generate table rows
  tableBody.innerHTML = projects.map(function (project) {
    var _project$client_name;
    var date = project.start_date ? new Date(project.start_date) : null;
    var localizedDate = date ? date.toLocaleDateString(undefined, {
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    }) : '';
    return "\n      <tr>\n        <td data-label=\"Project\">\n          <a class=\"project-link\" href=\"".concat(project.permalink, "\">").concat(project.title, "</a>\n        </td>\n        <td data-label=\"Client\">").concat((_project$client_name = project.client_name) !== null && _project$client_name !== void 0 ? _project$client_name : '', "</td>\n        <td data-label=\"Status\" data-project-status=\"").concat(project.status.slug, "\">").concat(project.status.label, "</td>\n        <td data-label=\"Budget\">").concat(project.budget ? formatCurrency(project.budget) : '', "</td>\n        <td data-label=\"Start Date\">").concat(localizedDate, "</td>\n      </tr>\n    ");
  }).join('');
};

// Updates the summary section with total budget
var updateSummary = function updateSummary(summaryEl, projects) {
  if (!summaryEl) {
    return;
  }
  var total = projects.reduce(function (sum, project) {
    return sum + (project.budget || 0);
  }, 0);
  var totalEl = summaryEl.querySelector('[data-projects-total]');

  // Update total budget display
  if (totalEl) {
    totalEl.textContent = formatCurrency(total);
  }
};

// Sets up event listeners and logic for filtering projects
var setupProjectsFilters = function setupProjectsFilters() {
  var filtersForm = document.querySelector('.projects-filters');
  var tableWrapper = document.querySelector('[data-projects-table]');

  // Ensure necessary elements are present
  if (!filtersForm || !tableWrapper) {
    return;
  }

  // Elements
  var tbody = tableWrapper.querySelector('tbody');
  var summary = tableWrapper.querySelector('[data-projects-summary]');
  var statusField = filtersForm.querySelector('[name="project_status"]');
  var clientField = filtersForm.querySelector('[name="client_query"]');
  var resetLink = filtersForm.querySelector('[data-projects-reset]');

  // Toggles the visibility of the reset link
  var toggleReset = function toggleReset() {
    if (!resetLink) {
      return;
    }

    // Show reset link if any filter is active
    if (((statusField === null || statusField === void 0 ? void 0 : statusField.value) || '').trim() || ((clientField === null || clientField === void 0 ? void 0 : clientField.value) || '').trim()) {
      resetLink.classList.add('is-visible');
    } else {
      resetLink.classList.remove('is-visible');
    }
  };

  // Handles form submission to fetch and render filtered projects
  filtersForm.addEventListener('submit', /*#__PURE__*/function () {
    var _ref = _asyncToGenerator(/*#__PURE__*/_regenerator().m(function _callee(event) {
      var params, endpoint, response, projects, _t;
      return _regenerator().w(function (_context) {
        while (1) switch (_context.p = _context.n) {
          case 0:
            event.preventDefault();

            // Build query parameters
            params = new URLSearchParams(); // Add filters to query parameters
            if (statusField !== null && statusField !== void 0 && statusField.value) {
              params.append('status', statusField.value);
            }

            // Add client query to parameters
            if (clientField !== null && clientField !== void 0 && clientField.value) {
              params.append('client', clientField.value);
            }

            // Construct endpoint URL
            endpoint = params.toString() ? "".concat(apiBase, "?").concat(params.toString()) : apiBase;
            _context.p = 1;
            filtersForm.classList.add('is-loading');
            _context.n = 2;
            return fetch(endpoint);
          case 2:
            response = _context.v;
            if (response.ok) {
              _context.n = 3;
              break;
            }
            throw new Error('Failed to fetch projects.');
          case 3:
            _context.n = 4;
            return response.json();
          case 4:
            projects = _context.v;
            renderRows(tbody, projects);
            updateSummary(summary, projects);
            toggleReset();
            _context.n = 6;
            break;
          case 5:
            _context.p = 5;
            _t = _context.v;
            console.error(_t);
          case 6:
            _context.p = 6;
            filtersForm.classList.remove('is-loading');
            return _context.f(6);
          case 7:
            return _context.a(2);
        }
      }, _callee, null, [[1, 5, 6, 7]]);
    }));
    return function (_x) {
      return _ref.apply(this, arguments);
    };
  }());

  // Handles reset link click to clear filters
  resetLink === null || resetLink === void 0 || resetLink.addEventListener('click', function (event) {
    // Do nothing if no filters are active
    if (!statusField && !clientField) {
      return;
    }
    event.preventDefault();
    if (statusField) {
      statusField.value = '';
    }
    if (clientField) {
      clientField.value = '';
    }
    toggleReset();
    filtersForm.requestSubmit();
  });
  toggleReset();
};

// Initialize the projects filters when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', setupProjectsFilters);

/***/ }),

/***/ "./src/scss/app.scss":
/*!***************************!*\
  !*** ./src/scss/app.scss ***!
  \***************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry needs to be wrapped in an IIFE because it needs to be in strict mode.
(() => {
"use strict";
/*!***********************!*\
  !*** ./src/js/app.js ***!
  \***********************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _scss_app_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../scss/app.scss */ "./src/scss/app.scss");
/* harmony import */ var _pages_projects__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./pages/projects */ "./src/js/pages/projects.js");
/* harmony import */ var _pages_projects__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_pages_projects__WEBPACK_IMPORTED_MODULE_1__);


console.log('App loaded');
})();

/******/ })()
;
//# sourceMappingURL=app.js.map