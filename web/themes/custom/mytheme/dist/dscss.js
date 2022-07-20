/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./src/scss/article.scss":
/*!*******************************!*\
  !*** ./src/scss/article.scss ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n// extracted by mini-css-extract-plugin\n\n\n//# sourceURL=webpack://newspaper11/./src/scss/article.scss?");

/***/ }),

/***/ "./src/scss/pubdate.scss":
/*!*******************************!*\
  !*** ./src/scss/pubdate.scss ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n// extracted by mini-css-extract-plugin\n\n\n//# sourceURL=webpack://newspaper11/./src/scss/pubdate.scss?");

/***/ }),

/***/ "./src/index.js":
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _js_scroll__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./js/scroll */ \"./src/js/scroll.js\");\n/* harmony import */ var _js_scroll__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_js_scroll__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var _scss_article_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./scss/article.scss */ \"./src/scss/article.scss\");\n/* harmony import */ var _scss_pubdate_scss__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./scss/pubdate.scss */ \"./src/scss/pubdate.scss\");\n/*\nscss\n */\n//import './scss/Global.scss';\n//import './scss/Header.scss';\n//import './scss/sidebar.scss';\n//import './scss/FeaturedTop.scss';\n//import './scss/front_views.scss';\n//import './scss/Footer.scss';\n//import './scss/scrollToTop.scss';\n/*\njs\n */\n\n/*\nmodule css\n */\n\n\n\n\n//# sourceURL=webpack://newspaper11/./src/index.js?");

/***/ }),

/***/ "./src/js/scroll.js":
/*!**************************!*\
  !*** ./src/js/scroll.js ***!
  \**************************/
/***/ (() => {

eval("(function ($, Drupal) {\n  // I want some code to run on page load, so I use Drupal.behaviors\n  Drupal.behaviors.scroll = {\n    attach: function (context, settings) {\n      window.onscroll = function() {\n        var e = document.getElementById(\"scrolltop\");\n        if (!e) {\n          e = document.createElement(\"a\");\n          e.id = \"scrolltop\";\n          e.href = \"#\";\n          document.body.appendChild(e);\n        }\n        e.style.display = document.documentElement.scrollTop > 300 ? \"block\" : \"none\";\n        e.onclick = (ev) => {\n          ev.preventDefault();\n          document.documentElement.scrollTop = 0;\n        };\n      };\n    }\n  };\n}(jQuery, Drupal));\n\n\n//# sourceURL=webpack://newspaper11/./src/js/scroll.js?");

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
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = __webpack_require__("./src/index.js");
/******/ 	
/******/ })()
;