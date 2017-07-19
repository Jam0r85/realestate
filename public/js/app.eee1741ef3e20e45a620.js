/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
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
/******/ 	// identity function for calling harmony imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };
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
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/app.js":
/***/ (function(module, exports) {

$(document).ready(function ($) {

    // Fade flash notifications
    $('.is-flash-message').delay(3000).fadeOut(350);

    // Initiate select2
    $('.select2').select2();

    // Laravel CSRF token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.burger').click(function () {
        var menu = $(this).data('target');
        $(this).toggleClass('is-active');
        $('body').find('#' + menu).toggleClass('is-active');
    });

    (function ($) {

        var o = $({});

        $.subscribe = function () {
            o.on.apply(o, arguments);
        };

        $.unsubscribe = function () {
            o.off.apply(o, arguments);
        };

        $.publish = function () {
            o.trigger.apply(o, arguments);
        };
    })(jQuery);

    (function () {

        // Open modal
        $('.modal-button').click(function () {
            var target = $(this).data('target');
            $('#modal-content').load(target, function (response, status, xhr) {
                if (status == "success") {
                    $('.modal').addClass('is-active');
                    $('html').addClass('is-clipped');
                } else {
                    alert('Error Loading');
                    console.log(response);
                }
            });
        });
    })();

    (function () {

        // Close a modal
        $('.modal-background, .modal-close').click(function () {
            $('html').removeClass('is-clipped');
            $(this).parent().removeClass('is-active');
        });
    })();

    (function () {

        // Click a table row and go to the link
        $(".clickable-row").click(function () {
            window.location = $(this).data("href");
        });
    })();

    (function () {

        // Toggle a radio by clicking on the parent
        $('.toggle-radio').on('click', function () {
            var radio = $(this).find('input[type=radio]');
            radio.prop('checked', !radio.prop('checked'));
        });
    })();

    (function () {

        // Toggle a checkbox by clicking on the parent element
        $('.toggle-checkbox').on('click', function () {
            var checkbox = $(this).find('input[type=checkbox]');
            checkbox.prop('checked', !checkbox.prop('checked'));
        });
    })();

    (function () {

        // Submit a form via AJAX rather than submitting the form
        var submitAjaxRequest = function submitAjaxRequest(e) {
            var form = $(this);
            var method = form.find('input[name="_method"]').val() || 'POST';

            $.ajax({
                type: method,
                url: form.prop('action'),
                data: form.serialize(),
                success: function success(data) {
                    $('html').removeClass('is-clipped');
                    $(this).closest('div.modal').removeClass('is-active');
                }
            });

            e.preventDefault();
        };

        // Forms marked with the "data-remote" attribute will submit via AJAX.
        $('form[data-remote]').on('submit', submitAjaxRequest);

        // The "data-click-submits-form" attribute submits form on change
        $('*[data-click-submits-form]').on('change', function () {
            $(this).closest('form').submit();
        });
    })();
});

/***/ }),

/***/ "./resources/assets/sass/app.scss":
/***/ (function(module, exports) {

throw new Error("Module build failed: ModuleBuildError: Module build failed: \n@import \"node_modules/bulma/bulma\";\n                                  ^\n      Invalid CSS after '...s/bulma/bulma\";': expected 1 selector or at-rule, was \".navbar-header\"\n      in /Users/james/code/laravel55/resources/assets/sass/app.scss (line 7, column 36)\n    at runLoaders (/Users/james/code/laravel55/node_modules/webpack/lib/NormalModule.js:192:19)\n    at /Users/james/code/laravel55/node_modules/loader-runner/lib/LoaderRunner.js:364:11\n    at /Users/james/code/laravel55/node_modules/loader-runner/lib/LoaderRunner.js:230:18\n    at context.callback (/Users/james/code/laravel55/node_modules/loader-runner/lib/LoaderRunner.js:111:13)\n    at Object.asyncSassJobQueue.push [as callback] (/Users/james/code/laravel55/node_modules/sass-loader/lib/loader.js:55:13)\n    at Object.<anonymous> (/Users/james/code/laravel55/node_modules/sass-loader/node_modules/async/dist/async.js:2243:31)\n    at Object.callback (/Users/james/code/laravel55/node_modules/sass-loader/node_modules/async/dist/async.js:906:16)\n    at options.error (/Users/james/code/laravel55/node_modules/node-sass/lib/index.js:294:32)");

/***/ }),

/***/ 0:
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("./resources/assets/js/app.js");
module.exports = __webpack_require__("./resources/assets/sass/app.scss");


/***/ })

/******/ });