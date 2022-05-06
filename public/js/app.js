/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/forms.js":
/*!*******************************!*\
  !*** ./resources/js/forms.js ***!
  \*******************************/
/***/ (() => {

var Forms = Forms || {};

window.onload = function (e) {
  document.getElementsByTagName('html')[0].classList.add('formsReady');
};

document.addEventListener('click', function (e) {
  if (e.target.closest('a[data-post]')) {
    e.preventDefault();

    if (e.target.dataset.post == '' || confirm(e.target.dataset.post)) {
      axios.post(e.target.href).then(function (r) {
        Forms.processResponse(r);
      });
    }
  }
});
document.addEventListener('submit', function (e) {
  if (e.target.closest('form[data-ajax]')) {
    e.preventDefault();
    axios.post(e.target.action, new FormData(e.target)).then(Forms.processResponse)["catch"](function (error) {
      Forms.processError(error, e.target);
    });
  }
});

Forms.processError = function (error, form) {
  if (error.response.status == 422) {
    var data = error.response.data;
    var fields = form.querySelectorAll('p[data-error]');
    fields.forEach(function (i) {
      if (i.dataset.error == '__form') {
        i.innerHTML = data.message || '';
      } else {
        i.innerHTML = data.errors[i.dataset.error] || '';
      }
    });
  } else alert('An Error has Occured');
};

Forms.processResponse = function (res, form) {
  if (res.data.redirect) {
    window.location.href = res.data.redirect;
  } // alert/toasts
  // messages
  // calback

};

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
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
__webpack_require__(/*! ./forms */ "./resources/js/forms.js");
})();

/******/ })()
;