/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./modules/Auth/Resources/assets/js/app.js":
/*!*************************************************!*\
  !*** ./modules/Auth/Resources/assets/js/app.js ***!
  \*************************************************/
/***/ (() => {

$(function () {
  /*
   * handling login with press enter
   */
  $(window).on("keypress", function (e) {
    if (e.keyCode == 13 && $(e.target).hasClass('form-control')) {
      /*
       * handling enter onkeypress
       */
      var username = $('#form-login input[name="username"]').val();
      var password = $('#form-login input[name="password"]').val();
      var captcha = $('#form-login input[name="captcha"]').val();

      if (username !== '' && password !== '' && captcha !== '') {
        /*
         * if all form insert
         */
        e.preventDefault();
        $('.do-login').click();
      }
    }
  });
  /**
   * for refresh captcha
   */

  $('.captcha-refresh a').click(function () {
    var img = $('.captcha-image img');
    axios.get('/auth/refresh-captcha').then(function (response) {
      /* replace src img */
      img.attr('src', response.data);
    })["catch"](function (error) {
      pop_alert.msg_error('Failed To Load Captcha!');
    });
  });
  /**
   * for do login process
   */

  $('.do-login').click(function () {
    var username = $('#form-login input[name="username"]').val();
    var password = $('#form-login input[name="password"]').val();
    var captcha = $('#form-login input[name="captcha"]').val();
    var all_input = $('input');
    var loading = $('.loading');
    var submit = $('.do-login');
    var post = {};
    /* define post data */

    post.username = username;
    post.password = password;
    post.captcha = captcha;
    /* init process */

    submit.attr('disabled', true);
    all_input.attr('disabled', true);
    loading.css('display', 'inline-block');

    if (username === '' || password === '' || captcha === '') {
      pop_alert.msg_error('All Fields Must Be Filled!', function () {
        /* return to default condition form */
        submit.attr('disabled', false);
        all_input.attr('disabled', false);
        loading.css('display', 'none');
        /*  refresh captcha */

        $('.captcha-refresh a').click();
      });
      return;
    }

    axios.post('/api/auth/do-login', post).then(function (response) {
      /* if curl success */

      /* check response data */
      if (!!response.data.data.success_login) {
        /* if login success */

        /* show aller error */
        pop_alert.msg_success(response.data.data.message, function () {
          return window.location.href = '/';
        });
      } else {
        /* if login failed */

        /* show aller error */
        pop_alert.msg_error(response.data.data.message);
      }
    })["catch"](function (error) {
      var _error$response$data$, _error$response$data$2;

      /* if curl failed */

      /* define error message */
      var error_message = ((_error$response$data$ = error.response.data.error) === null || _error$response$data$ === void 0 ? void 0 : _error$response$data$.error_message) === undefined ? error : (_error$response$data$2 = error.response.data.error) === null || _error$response$data$2 === void 0 ? void 0 : _error$response$data$2.error_message;
      /* show aller error */

      pop_alert.msg_error(error_message);
      /* return to default condition form */

      submit.attr('disabled', false);
      all_input.attr('disabled', false);
      loading.css('display', 'none');
      /*  refresh captcha */

      $('.captcha-refresh a').click();
    })["finally"](function () {
      // submit.attr('disabled',true)
      all_input.attr('disabled', false);
      loading.css('display', 'none');
      /*  refresh captcha */

      $('.captcha-refresh a').click();
      return window.location.href = '/';
    });
  });
});

/***/ }),

/***/ "./modules/Auth/Resources/assets/sass/app.scss":
/*!*****************************************************!*\
  !*** ./modules/Auth/Resources/assets/sass/app.scss ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./modules/Home/Resources/assets/sass/app.scss":
/*!*****************************************************!*\
  !*** ./modules/Home/Resources/assets/sass/app.scss ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./modules/Modules/Resources/assets/sass/app.scss":
/*!********************************************************!*\
  !*** ./modules/Modules/Resources/assets/sass/app.scss ***!
  \********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./modules/Operator/Resources/assets/sass/app.scss":
/*!*********************************************************!*\
  !*** ./modules/Operator/Resources/assets/sass/app.scss ***!
  \*********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./modules/OperatorGroup/Resources/assets/sass/app.scss":
/*!**************************************************************!*\
  !*** ./modules/OperatorGroup/Resources/assets/sass/app.scss ***!
  \**************************************************************/
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
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
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
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/module/js/auth": 0,
/******/ 			"module/css/operatorgroup": 0,
/******/ 			"module/css/operator": 0,
/******/ 			"module/css/modules": 0,
/******/ 			"module/css/home": 0,
/******/ 			"module/css/auth": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["module/css/operatorgroup","module/css/operator","module/css/modules","module/css/home","module/css/auth"], () => (__webpack_require__("./modules/Auth/Resources/assets/js/app.js")))
/******/ 	__webpack_require__.O(undefined, ["module/css/operatorgroup","module/css/operator","module/css/modules","module/css/home","module/css/auth"], () => (__webpack_require__("./modules/Auth/Resources/assets/sass/app.scss")))
/******/ 	__webpack_require__.O(undefined, ["module/css/operatorgroup","module/css/operator","module/css/modules","module/css/home","module/css/auth"], () => (__webpack_require__("./modules/Home/Resources/assets/sass/app.scss")))
/******/ 	__webpack_require__.O(undefined, ["module/css/operatorgroup","module/css/operator","module/css/modules","module/css/home","module/css/auth"], () => (__webpack_require__("./modules/Modules/Resources/assets/sass/app.scss")))
/******/ 	__webpack_require__.O(undefined, ["module/css/operatorgroup","module/css/operator","module/css/modules","module/css/home","module/css/auth"], () => (__webpack_require__("./modules/Operator/Resources/assets/sass/app.scss")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["module/css/operatorgroup","module/css/operator","module/css/modules","module/css/home","module/css/auth"], () => (__webpack_require__("./modules/OperatorGroup/Resources/assets/sass/app.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;