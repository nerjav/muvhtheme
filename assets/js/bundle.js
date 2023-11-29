/******/ 
(function(modules) { // webpackBootstrap
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
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
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
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 3);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/*!
 * cookie
 * Copyright(c) 2012-2014 Roman Shtylman
 * Copyright(c) 2015 Douglas Christopher Wilson
 * MIT Licensed
 */



/**
 * Module exports.
 * @public
 */

exports.parse = parse;
exports.serialize = serialize;

/**
 * Module variables.
 * @private
 */

var decode = decodeURIComponent;
var encode = encodeURIComponent;
var pairSplitRegExp = /; */;

/**
 * RegExp to match field-content in RFC 7230 sec 3.2
 *
 * field-content = field-vchar [ 1*( SP / HTAB ) field-vchar ]
 * field-vchar   = VCHAR / obs-text
 * obs-text      = %x80-FF
 */

var fieldContentRegExp = /^[\u0009\u0020-\u007e\u0080-\u00ff]+$/;

/**
 * Parse a cookie header.
 *
 * Parse the given cookie header string into an object
 * The object has the various cookies as keys(names) => values
 *
 * @param {string} str
 * @param {object} [options]
 * @return {object}
 * @public
 */

function parse(str, options) {
  if (typeof str !== 'string') {
    throw new TypeError('argument str must be a string');
  }

  var obj = {}
  var opt = options || {};
  var pairs = str.split(pairSplitRegExp);
  var dec = opt.decode || decode;

  for (var i = 0; i < pairs.length; i++) {
    var pair = pairs[i];
    var eq_idx = pair.indexOf('=');

    // skip things that don't look like key=value
    if (eq_idx < 0) {
      continue;
    }

    var key = pair.substr(0, eq_idx).trim()
    var val = pair.substr(++eq_idx, pair.length).trim();

    // quoted values
    if ('"' == val[0]) {
      val = val.slice(1, -1);
    }

    // only assign once
    if (undefined == obj[key]) {
      obj[key] = tryDecode(val, dec);
    }
  }

  return obj;
}

/**
 * Serialize data into a cookie header.
 *
 * Serialize the a name value pair into a cookie string suitable for
 * http headers. An optional options object specified cookie parameters.
 *
 * serialize('foo', 'bar', { httpOnly: true })
 *   => "foo=bar; httpOnly"
 *
 * @param {string} name
 * @param {string} val
 * @param {object} [options]
 * @return {string}
 * @public
 */

function serialize(name, val, options) {
  var opt = options || {};
  var enc = opt.encode || encode;

  if (typeof enc !== 'function') {
    throw new TypeError('option encode is invalid');
  }

  if (!fieldContentRegExp.test(name)) {
    throw new TypeError('argument name is invalid');
  }

  var value = enc(val);

  if (value && !fieldContentRegExp.test(value)) {
    throw new TypeError('argument val is invalid');
  }

  var str = name + '=' + value;

  if (null != opt.maxAge) {
    var maxAge = opt.maxAge - 0;
    if (isNaN(maxAge)) throw new Error('maxAge should be a Number');
    str += '; Max-Age=' + Math.floor(maxAge);
  }

  if (opt.domain) {
    if (!fieldContentRegExp.test(opt.domain)) {
      throw new TypeError('option domain is invalid');
    }

    str += '; Domain=' + opt.domain;
  }

  if (opt.path) {
    if (!fieldContentRegExp.test(opt.path)) {
      throw new TypeError('option path is invalid');
    }

    str += '; Path=' + opt.path;
  }

  if (opt.expires) {
    if (typeof opt.expires.toUTCString !== 'function') {
      throw new TypeError('option expires is invalid');
    }

    str += '; Expires=' + opt.expires.toUTCString();
  }

  if (opt.httpOnly) {
    str += '; HttpOnly';
  }

  if (opt.secure) {
    str += '; Secure';
  }

  if (opt.sameSite) {
    var sameSite = typeof opt.sameSite === 'string'
      ? opt.sameSite.toLowerCase() : opt.sameSite;

    switch (sameSite) {
      case true:
        str += '; SameSite=Strict';
        break;
      case 'lax':
        str += '; SameSite=Lax';
        break;
      case 'strict':
        str += '; SameSite=Strict';
        break;
      case 'none':
        str += '; SameSite=None';
        break;
      default:
        throw new TypeError('option sameSite is invalid');
    }
  }

  return str;
}

/**
 * Try decoding a string using a decoding function.
 *
 * @param {string} str
 * @param {function} decode
 * @private
 */

function tryDecode(str, decode) {
  try {
    return decode(str);
  } catch (e) {
    return str;
  }
}


/***/ }),
/* 1 */
/***/ (function(module, exports, __webpack_require__) {

// extracted by mini-css-extract-plugin

/***/ }),
/* 2 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/*
object-assign
(c) Sindre Sorhus
@license MIT
*/


/* eslint-disable no-unused-vars */
var getOwnPropertySymbols = Object.getOwnPropertySymbols;
var hasOwnProperty = Object.prototype.hasOwnProperty;
var propIsEnumerable = Object.prototype.propertyIsEnumerable;

function toObject(val) {
	if (val === null || val === undefined) {
		throw new TypeError('Object.assign cannot be called with null or undefined');
	}

	return Object(val);
}

function shouldUseNative() {
	try {
		if (!Object.assign) {
			return false;
		}

		// Detect buggy property enumeration order in older V8 versions.

		// https://bugs.chromium.org/p/v8/issues/detail?id=4118
		var test1 = new String('abc');  // eslint-disable-line no-new-wrappers
		test1[5] = 'de';
		if (Object.getOwnPropertyNames(test1)[0] === '5') {
			return false;
		}

		// https://bugs.chromium.org/p/v8/issues/detail?id=3056
		var test2 = {};
		for (var i = 0; i < 10; i++) {
			test2['_' + String.fromCharCode(i)] = i;
		}
		var order2 = Object.getOwnPropertyNames(test2).map(function (n) {
			return test2[n];
		});
		if (order2.join('') !== '0123456789') {
			return false;
		}

		// https://bugs.chromium.org/p/v8/issues/detail?id=3056
		var test3 = {};
		'abcdefghijklmnopqrst'.split('').forEach(function (letter) {
			test3[letter] = letter;
		});
		if (Object.keys(Object.assign({}, test3)).join('') !==
				'abcdefghijklmnopqrst') {
			return false;
		}

		return true;
	} catch (err) {
		// We don't expect any of the above to throw, but better to be safe.
		return false;
	}
}

module.exports = shouldUseNative() ? Object.assign : function (target, source) {
	var from;
	var to = toObject(target);
	var symbols;

	for (var s = 1; s < arguments.length; s++) {
		from = Object(arguments[s]);

		for (var key in from) {
			if (hasOwnProperty.call(from, key)) {
				to[key] = from[key];
			}
		}

		if (getOwnPropertySymbols) {
			symbols = getOwnPropertySymbols(from);
			for (var i = 0; i < symbols.length; i++) {
				if (propIsEnumerable.call(from, symbols[i])) {
					to[symbols[i]] = from[symbols[i]];
				}
			}
		}
	}

	return to;
};


/***/ }),
/* 3 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
// ESM COMPAT FLAG
__webpack_require__.r(__webpack_exports__);

// EXTERNAL MODULE: ./src/scss/main.scss
var main = __webpack_require__(1);

// CONCATENATED MODULE: ./src/js/keyboard-mapping.js
var ESCAPE = 27;
var TAB = 9;
var ENTER = 13;
var KEY_F = 70;
var KEY_G = 71;
var KEY_H = 72;
var KEY_M = 77;
var KEY_N = 78;
var KEY_R = 82;
var KEY_Y = 89;
var KEY_PLUS = 61;
var KEY_MINUS = 163;
var KEY_0 = 48;
// CONCATENATED MODULE: ./src/js/keyboard-trap.js


var trapKeyboard = function trapKeyboard(el) {
  el.classList.add('trap-active');
  var focusableElements = el.querySelectorAll("\n        a:not(.send-focus), \n        input[type=\"text\"]:not([name=\"hp\"]), \n        input[type=\"email\"], \n        input[type=\"number\"], \n        input[type=\"checkbox\"], \n        button, \n        select, \n        textarea\n    ");

  if (!el.querySelectorAll('.send-focus--last').length) {
    var hiddenFirst = document.createElement('button'); // using a button instead of anchor makes this focusable by tab in safari

    hiddenFirst.classList.add('send-focus');
    hiddenFirst.classList.add('send-focus--last');
    hiddenFirst.setAttribute('aria-hidden', 'true');
    el.prepend(hiddenFirst);
  }

  if (!el.querySelectorAll('.send-focus--first').length) {
    var hiddenLast = document.createElement('button');
    hiddenLast.classList.add('send-focus');
    hiddenLast.classList.add('send-focus--first');
    hiddenLast.setAttribute('aria-hidden', 'true');
    el.append(hiddenLast);
  }

  var firstFocus = focusableElements[0];
  firstFocus.focus();

  var sendFocusToLast = function sendFocusToLast() {
    for (var c = focusableElements.length - 1; c >= 0; c--) {
      focusableElements[c].focus();

      if (document.activeElement == focusableElements[c]) {
        break;
      }

      if (c == 0) {
        el.focus();
      }
    }
  };

  var sendFocusToFirst = function sendFocusToFirst() {
    for (var i = 0; i < focusableElements.length; i++) {
      focusableElements[i].focus();

      if (document.activeElement == focusableElements[i]) {
        break;
      }

      if (i == focusableElements.length - 1) {
        el.focus();
      }
    }
  };

  el.querySelector('.send-focus--first').addEventListener("focus", sendFocusToFirst, true);
  el.querySelector('.send-focus--last').addEventListener("focus", sendFocusToLast, true);
};

var removeTrap = function removeTrap(element) {
  element.classList.remove('trap-active');
  var senders = element.querySelectorAll('.send-focus');

  for (var i = 0; i < senders.length; i++) {
    senders[i].remove();
  }

  document.removeEventListener("keydown", keyboard_trap_removeTrapShortcut, true);
};

var keyboard_trap_removeTrapShortcut = function removeTrapShortcut(event) {
  if (event.keyCode == ESCAPE) {
    var element = document.getElementsByClassName('trap-active')[0];
    removeTrap(element);
  }
};

var showToolbarBtn = document.getElementById('show-toolbar');
var hideToolbarBtn = document.getElementById('hide-toolbar');
var showNavbarBtn = document.getElementById('navbar-trigger');
var hideNavbarBtn = document.getElementById('dismiss');
showToolbarBtn.addEventListener('click', function () {
  trapKeyboard(document.getElementById('toolbar'));
  document.addEventListener('keydown', keyboard_trap_removeTrapShortcut, true);
});
showNavbarBtn.addEventListener('click', function () {
  trapKeyboard(document.getElementById('sidebar'));
});
hideToolbarBtn.addEventListener('click', function (event) {
  return removeTrap(event);
});
hideNavbarBtn.addEventListener('click', function (event) {
  return removeTrap(event);
});
// EXTERNAL MODULE: ./node_modules/cookie/index.js
var cookie = __webpack_require__(0);

// CONCATENATED MODULE: ./node_modules/universal-cookie/es6/utils.js

function hasDocumentCookie() {
    // Can we get/set cookies on document.cookie?
    return typeof document === 'object' && typeof document.cookie === 'string';
}
function cleanCookies() {
    document.cookie.split(';').forEach(function (c) {
        document.cookie = c
            .replace(/^ +/, '')
            .replace(/=.*/, '=;expires=' + new Date().toUTCString() + ';path=/');
    });
}
function parseCookies(cookies, options) {
    if (typeof cookies === 'string') {
        return cookie["parse"](cookies, options);
    }
    else if (typeof cookies === 'object' && cookies !== null) {
        return cookies;
    }
    else {
        return {};
    }
}
function isParsingCookie(value, doNotParse) {
    if (typeof doNotParse === 'undefined') {
        // We guess if the cookie start with { or [, it has been serialized
        doNotParse =
            !value || (value[0] !== '{' && value[0] !== '[' && value[0] !== '"');
    }
    return !doNotParse;
}
function readCookie(value, options) {
    if (options === void 0) { options = {}; }
    var cleanValue = cleanupCookieValue(value);
    if (isParsingCookie(cleanValue, options.doNotParse)) {
        try {
            return JSON.parse(cleanValue);
        }
        catch (e) {
            // At least we tried
        }
    }
    // Ignore clean value if we failed the deserialization
    // It is not relevant anymore to trim those values
    return value;
}
function cleanupCookieValue(value) {
    // express prepend j: before serializing a cookie
    if (value && value[0] === 'j' && value[1] === ':') {
        return value.substr(2);
    }
    return value;
}

// CONCATENATED MODULE: ./node_modules/universal-cookie/es6/Cookies.js


// We can't please Rollup and TypeScript at the same time
// Only way to make both of them work
var objectAssign = __webpack_require__(2);
var Cookies_Cookies = /** @class */ (function () {
    function Cookies(cookies, options) {
        var _this = this;
        this.changeListeners = [];
        this.HAS_DOCUMENT_COOKIE = false;
        this.cookies = parseCookies(cookies, options);
        new Promise(function () {
            _this.HAS_DOCUMENT_COOKIE = hasDocumentCookie();
        }).catch(function () { });
    }
    Cookies.prototype._updateBrowserValues = function (parseOptions) {
        if (!this.HAS_DOCUMENT_COOKIE) {
            return;
        }
        this.cookies = cookie["parse"](document.cookie, parseOptions);
    };
    Cookies.prototype._emitChange = function (params) {
        for (var i = 0; i < this.changeListeners.length; ++i) {
            this.changeListeners[i](params);
        }
    };
    Cookies.prototype.get = function (name, options, parseOptions) {
        if (options === void 0) { options = {}; }
        this._updateBrowserValues(parseOptions);
        return readCookie(this.cookies[name], options);
    };
    Cookies.prototype.getAll = function (options, parseOptions) {
        if (options === void 0) { options = {}; }
        this._updateBrowserValues(parseOptions);
        var result = {};
        for (var name_1 in this.cookies) {
            result[name_1] = readCookie(this.cookies[name_1], options);
        }
        return result;
    };
    Cookies.prototype.set = function (name, value, options) {
        var _a;
        if (typeof value === 'object') {
            value = JSON.stringify(value);
        }
        this.cookies = objectAssign({}, this.cookies, (_a = {}, _a[name] = value, _a));
        if (this.HAS_DOCUMENT_COOKIE) {
            document.cookie = cookie["serialize"](name, value, options);
        }
        this._emitChange({ name: name, value: value, options: options });
    };
    Cookies.prototype.remove = function (name, options) {
        var finalOptions = (options = objectAssign({}, options, {
            expires: new Date(1970, 1, 1, 0, 0, 1),
            maxAge: 0
        }));
        this.cookies = objectAssign({}, this.cookies);
        delete this.cookies[name];
        if (this.HAS_DOCUMENT_COOKIE) {
            document.cookie = cookie["serialize"](name, '', finalOptions);
        }
        this._emitChange({ name: name, value: undefined, options: options });
    };
    Cookies.prototype.addChangeListener = function (callback) {
        this.changeListeners.push(callback);
    };
    Cookies.prototype.removeChangeListener = function (callback) {
        var idx = this.changeListeners.indexOf(callback);
        if (idx >= 0) {
            this.changeListeners.splice(idx, 1);
        }
    };
    return Cookies;
}());
/* harmony default export */ var es6_Cookies = (Cookies_Cookies);

// CONCATENATED MODULE: ./node_modules/universal-cookie/es6/index.js

/* harmony default export */ var es6 = (es6_Cookies);

// CONCATENATED MODULE: ./src/js/accesibility-tools.js


var accesibility_tools_cookies = new es6();
var setContrast = function setContrast(contrast) {
  var element = document.getElementsByTagName('body')[0];
  element.classList.remove('grayscale');
  element.classList.remove('highcontrast');
  element.classList.remove('black-on-yellow');
  element.classList.add(contrast);
  accesibility_tools_cookies.set('contrast', contrast);
};
var accesibility_tools_magnifyText = function magnifyText() {
  var cookies = new es6();
  var textSize = cookies.get('text-size');
  var element = document.getElementsByTagName('body')[0];

  if (textSize == undefined || textSize == 'text-normal') {
    element.classList.add('text-large');
    cookies.set('text-size', 'text-large');
  } else {
    switch (textSize) {
      case 'text-xxsmall':
        element.classList.remove('text-xxsmall');
        element.classList.add('text-xsmall');
        cookies.set('text-size', 'text-xsmall');
        break;

      case 'text-xsmall':
        element.classList.remove('text-xsmall');
        element.classList.add('text-small');
        cookies.set('text-size', 'text-small');
        break;

      case 'text-small':
        element.classList.remove('text-small');
        cookies.set('text-size', 'text-normal');
        break;

      case 'text-large':
        element.classList.remove('text-large');
        element.classList.add('text-xlarge');
        cookies.set('text-size', 'text-xlarge');
        break;

      case 'text-xlarge':
        element.classList.remove('text-xlarge');
        element.classList.add('text-xxlarge');
        cookies.set('text-size', 'text-xxlarge');
        break;
    }
  }
};
var accesibility_tools_minifyText = function minifyText() {
  var cookies = new es6();
  var textSize = cookies.get('text-size');
  var element = document.getElementsByTagName('body')[0];

  if (textSize == undefined || textSize == 'text-normal') {
    element.classList.add('text-small');
    cookies.set('text-size', 'text-small');
  } else {
    switch (textSize) {
      case 'text-xxlarge':
        element.classList.remove('text-xxlarge');
        element.classList.add('text-xlarge');
        cookies.set('text-size', 'text-xlarge');
        break;

      case 'text-xlarge':
        element.classList.remove('text-xlarge');
        element.classList.add('text-large');
        cookies.set('text-size', 'text-large');
        break;

      case 'text-large':
        element.classList.remove('text-large');
        cookies.set('text-size', 'text-normal');
        break;

      case 'text-small':
        element.classList.remove('text-small');
        element.classList.add('text-xsmall');
        cookies.set('text-size', 'text-xsmall');
        break;

      case 'text-xsmall':
        element.classList.remove('text-xsmall');
        element.classList.add('text-xxsmall');
        cookies.set('text-size', 'text-xxsmall');
        break;
    }
  }
};
var accesibility_tools_reset = function reset() {
  document.getElementsByTagName('body')[0].removeAttribute('class');
};
document.getElementById('grayscale').addEventListener('click', function () {
  setContrast('grayscale');
});
document.getElementById('high-contrast').addEventListener('click', function () {
  setContrast('highcontrast');
});
document.getElementById('black-on-yellow').addEventListener('click', function () {
  setContrast('black-on-yellow');
});
document.getElementById('reset').addEventListener('click', function () {
  accesibility_tools_reset();
});
document.getElementById('magnify-text').addEventListener('click', function () {
  accesibility_tools_magnifyText();
});
document.getElementById('minify-text').addEventListener('click', function () {
  accesibility_tools_minifyText();
});

var hideToolbar = function hideToolbar() {
  document.getElementById('toolbar-oppener').classList.add('shown');
  document.getElementById('toolbar-oppener').classList.remove('hidden');
  document.getElementById('toolbar').classList.add('hidden');
  document.getElementById('toolbar').classList.remove('shown');
  document.getElementById('show-toolbar').focus();
  document.removeEventListener("keydown", accesibility_tools_hideToolbarShortcut, true);
};

var accesibility_tools_hideToolbarShortcut = function hideToolbarShortcut(event) {
  if (event.keyCode == ESCAPE) {
    hideToolbar();
  }
};

document.getElementById('show-toolbar').addEventListener('click', function () {
  document.getElementById('toolbar-oppener').classList.remove('shown');
  document.getElementById('toolbar-oppener').classList.add('hidden');
  document.getElementById('toolbar').classList.remove('hidden');
  document.getElementById('toolbar').classList.add('shown');
  document.getElementById('hide-toolbar').focus();
  document.addEventListener("keydown", accesibility_tools_hideToolbarShortcut, true);
});
document.getElementById('hide-toolbar').addEventListener('click', function () {
  hideToolbar();
});
// CONCATENATED MODULE: ./src/js/sidebar-menu.js

jQuery.noConflict();
var closeSidebar = function closeSidebar() {
  jQuery('#sidebar').removeClass('active');
  jQuery('.mobile-menu-overlay').removeClass('active');
  jQuery('#navbar-trigger').focus();
  document.removeEventListener('keydown', sidebar_menu_closeSidebarShortcut, true);
};

var sidebar_menu_closeSidebarShortcut = function closeSidebarShortcut(event) {
  if (event.keyCode == ESCAPE) {
    closeSidebar();
  }
};

jQuery.noConflict();
jQuery(document).ready(function () {
  jQuery("#sidebar").mCustomScrollbar({
    theme: "minimal"
  });

  jQuery.noConflict();
  jQuery('#dismiss, .mobile-menu-overlay').on('click', function () {
    closeSidebar();
  });
  jQuery('#navbar-trigger').on('click', function () {
    jQuery('#sidebar').addClass('active');
    jQuery('.mobile-menu-overlay').addClass('active');
    jQuery('.collapse.in').toggleClass('in');
    jQuery('a[aria-expanded=true]').attr('aria-expanded', 'false');
    jQuery('#dismiss').focus();
    document.addEventListener('keydown', sidebar_menu_closeSidebarShortcut, true);
  });
});
// CONCATENATED MODULE: ./src/js/shortcuts.js


document.addEventListener('keydown', function (event) {
  var keyCode = event.keyCode;

  if (event.ctrlKey && event.shiftKey && keyCode == KEY_M) {
    window.location = "#main-content";
  }

  if (event.ctrlKey && event.shiftKey && keyCode == KEY_R) {
    accesibility_tools_reset();
  }

  if (event.ctrlKey && event.shiftKey && keyCode == KEY_PLUS) {
    accesibility_tools_magnifyText();
  }

  if (event.ctrlKey && event.shiftKey && keyCode == KEY_MINUS) {
    accesibility_tools_minifyText();
  }

  if (event.ctrlKey && event.shiftKey && keyCode == KEY_G) {
    setContrast('grayscale');
  }

  if (event.ctrlKey && event.shiftKey && keyCode == KEY_H) {
    setContrast('highcontrast');
  }

  if (event.ctrlKey && event.shiftKey && keyCode == KEY_Y) {
    setContrast('black-on-yellow');
  }
});
// CONCATENATED MODULE: ./src/js/main.js






/***/ })
/******/ ]);