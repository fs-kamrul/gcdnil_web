/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./Resources/assets/js/payment.js":
/*!****************************************!*\
  !*** ./Resources/assets/js/payment.js ***!
  \****************************************/
/***/ (() => {



var BPayment = BPayment || {};
BPayment.initResources = function () {
  var paymentMethod = $(document).find('input[name=payment_method]:checked').first();
  if (!paymentMethod.length) {
    paymentMethod = $(document).find('input[name=payment_method]').first();
    paymentMethod.trigger('click').trigger('change');
  }
  if (paymentMethod.length) {
    paymentMethod.closest('.list-group-item').find('.payment_collapse_wrap').addClass('show');
  }
  if ($('.stripe-card-wrapper').length > 0) {
    new Card({
      // a selector or DOM element for the form where users will
      // be entering their information
      form: '.payment-checkout-form',
      // *required*
      // a selector or DOM element for the container
      // where you want the card to appear
      container: '.stripe-card-wrapper',
      // *required*

      formSelectors: {
        numberInput: 'input#stripe-number',
        // optional — default input[name="number"]
        expiryInput: 'input#stripe-exp',
        // optional — default input[name="expiry"]
        cvcInput: 'input#stripe-cvc',
        // optional — default input[name="cvc"]
        nameInput: 'input#stripe-name' // optional - defaults input[name="name"]
      },

      width: 350,
      // optional — default 350px
      formatting: true,
      // optional - default true

      // Strings for translation - optional
      messages: {
        validDate: 'valid\ndate',
        // optional - default 'valid\nthru'
        monthYear: 'mm/yyyy' // optional - default 'month/year'
      },

      // Default placeholders for rendered fields - optional
      placeholders: {
        number: '•••• •••• •••• ••••',
        name: 'Full Name',
        expiry: '••/••',
        cvc: '•••'
      },
      masks: {
        cardNumber: '•' // optional - mask card number
      },

      // if true, will log helpful messages for setting up Card
      debug: false // optional - default false
    });
  }
};

BPayment.init = function () {
  BPayment.initResources();
  $(document).on('change', '.js_payment_method', function () {
    $('.payment_collapse_wrap').removeClass('collapse').removeClass('show').removeClass('active');
  });
  $(document).off('click', '.payment-checkout-btn').on('click', '.payment-checkout-btn', function (event) {
    event.preventDefault();
    var _self = $(this);
    var form = _self.closest('form');
    _self.attr('disabled', 'disabled');
    var submitInitialText = _self.html();
    _self.html('<i class="fa fa-gear fa-spin"></i> ' + _self.data('processing-text'));
    if ($('input[name=payment_method]:checked').val() === 'stripe' && $('.stripe-card-wrapper').length > 0) {
      Stripe.setPublishableKey($('#payment-stripe-key').data('value'));
      Stripe.card.createToken(form, function (status, response) {
        if (response.error) {
          if (typeof kamruldashboard != 'undefined') {
            kamruldashboard.showError(response.error.message, _self.data('error-header'));
          } else {
            alert(response.error.message);
          }
          _self.removeAttr('disabled');
          _self.html(submitInitialText);
        } else {
          form.append($('<input type="hidden" name="stripeToken">').val(response.id));
          form.submit();
        }
      });
    } else {
      form.submit();
    }
  });
};
$(document).ready(function () {
  BPayment.init();
  document.addEventListener('payment-form-reloaded', function () {
    BPayment.initResources();
  });
});

/***/ }),

/***/ "./Resources/assets/sass/payment.scss":
/*!********************************************!*\
  !*** ./Resources/assets/sass/payment.scss ***!
  \********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./Resources/assets/sass/payment-methods.scss":
/*!****************************************************!*\
  !*** ./Resources/assets/sass/payment-methods.scss ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

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
/******/ 			"/public/js/payment": 0,
/******/ 			"public/css/payment-methods": 0,
/******/ 			"public/css/payment": 0
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
/******/ 	__webpack_require__.O(undefined, ["public/css/payment-methods","public/css/payment"], () => (__webpack_require__("./Resources/assets/js/payment.js")))
/******/ 	__webpack_require__.O(undefined, ["public/css/payment-methods","public/css/payment"], () => (__webpack_require__("./Resources/assets/sass/payment.scss")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["public/css/payment-methods","public/css/payment"], () => (__webpack_require__("./Resources/assets/sass/payment-methods.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;