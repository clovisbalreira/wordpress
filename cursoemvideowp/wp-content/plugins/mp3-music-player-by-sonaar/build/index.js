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
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
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
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/index.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/@babel/runtime/helpers/arrayLikeToArray.js":
/*!*****************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/arrayLikeToArray.js ***!
  \*****************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _arrayLikeToArray(arr, len) {
  if (len == null || len > arr.length) len = arr.length;

  for (var i = 0, arr2 = new Array(len); i < len; i++) {
    arr2[i] = arr[i];
  }

  return arr2;
}

module.exports = _arrayLikeToArray;
module.exports["default"] = module.exports, module.exports.__esModule = true;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/arrayWithHoles.js":
/*!***************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/arrayWithHoles.js ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _arrayWithHoles(arr) {
  if (Array.isArray(arr)) return arr;
}

module.exports = _arrayWithHoles;
module.exports["default"] = module.exports, module.exports.__esModule = true;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/defineProperty.js":
/*!***************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/defineProperty.js ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _defineProperty(obj, key, value) {
  if (key in obj) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
  } else {
    obj[key] = value;
  }

  return obj;
}

module.exports = _defineProperty;
module.exports["default"] = module.exports, module.exports.__esModule = true;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/iterableToArrayLimit.js":
/*!*********************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/iterableToArrayLimit.js ***!
  \*********************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _iterableToArrayLimit(arr, i) {
  var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"];

  if (_i == null) return;
  var _arr = [];
  var _n = true;
  var _d = false;

  var _s, _e;

  try {
    for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) {
      _arr.push(_s.value);

      if (i && _arr.length === i) break;
    }
  } catch (err) {
    _d = true;
    _e = err;
  } finally {
    try {
      if (!_n && _i["return"] != null) _i["return"]();
    } finally {
      if (_d) throw _e;
    }
  }

  return _arr;
}

module.exports = _iterableToArrayLimit;
module.exports["default"] = module.exports, module.exports.__esModule = true;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/nonIterableRest.js":
/*!****************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/nonIterableRest.js ***!
  \****************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _nonIterableRest() {
  throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
}

module.exports = _nonIterableRest;
module.exports["default"] = module.exports, module.exports.__esModule = true;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/slicedToArray.js":
/*!**************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/slicedToArray.js ***!
  \**************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var arrayWithHoles = __webpack_require__(/*! ./arrayWithHoles.js */ "./node_modules/@babel/runtime/helpers/arrayWithHoles.js");

var iterableToArrayLimit = __webpack_require__(/*! ./iterableToArrayLimit.js */ "./node_modules/@babel/runtime/helpers/iterableToArrayLimit.js");

var unsupportedIterableToArray = __webpack_require__(/*! ./unsupportedIterableToArray.js */ "./node_modules/@babel/runtime/helpers/unsupportedIterableToArray.js");

var nonIterableRest = __webpack_require__(/*! ./nonIterableRest.js */ "./node_modules/@babel/runtime/helpers/nonIterableRest.js");

function _slicedToArray(arr, i) {
  return arrayWithHoles(arr) || iterableToArrayLimit(arr, i) || unsupportedIterableToArray(arr, i) || nonIterableRest();
}

module.exports = _slicedToArray;
module.exports["default"] = module.exports, module.exports.__esModule = true;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/unsupportedIterableToArray.js":
/*!***************************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/unsupportedIterableToArray.js ***!
  \***************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var arrayLikeToArray = __webpack_require__(/*! ./arrayLikeToArray.js */ "./node_modules/@babel/runtime/helpers/arrayLikeToArray.js");

function _unsupportedIterableToArray(o, minLen) {
  if (!o) return;
  if (typeof o === "string") return arrayLikeToArray(o, minLen);
  var n = Object.prototype.toString.call(o).slice(8, -1);
  if (n === "Object" && o.constructor) n = o.constructor.name;
  if (n === "Map" || n === "Set") return Array.from(o);
  if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return arrayLikeToArray(o, minLen);
}

module.exports = _unsupportedIterableToArray;
module.exports["default"] = module.exports, module.exports.__esModule = true;

/***/ }),

/***/ "./src/index.js":
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/defineProperty */ "./node_modules/@babel/runtime/helpers/defineProperty.js");
/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime/helpers/slicedToArray */ "./node_modules/@babel/runtime/helpers/slicedToArray.js");
/* harmony import */ var _babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_2__);




(function (wp) {
  var registerBlockType = wp.blocks.registerBlockType; //Blocks API

  var _wp$element = wp.element,
      createElement = _wp$element.createElement,
      useState = _wp$element.useState,
      render = _wp$element.render; //React.createElement

  var __ = wp.i18n.__; //translation functions

  var _wp$components = wp.components,
      PanelBody = _wp$components.PanelBody,
      SelectControl = _wp$components.SelectControl,
      TextControl = _wp$components.TextControl,
      ToggleControl = _wp$components.ToggleControl,
      RangeControl = _wp$components.RangeControl,
      ColorPalette = _wp$components.ColorPalette,
      Button = _wp$components.Button,
      Modal = _wp$components.Modal; //WordPress form inputs and server-side renderer

  var _wp$blockEditor = wp.blockEditor,
      InspectorControls = _wp$blockEditor.InspectorControls,
      RichText = _wp$blockEditor.RichText;
  var serverSideRender = wp.serverSideRender;
  var player_load = '';
  var style_load = false;
  var ironAudioplayersLoaded = false;
  var sonaarIcon = wp.element.createElement('svg', {
    width: 20,
    height: 20,
    viewBox: '0 0 512 512'
  }, wp.element.createElement('path', {
    d: "M250.5,226.77V3.92C114.56,3.92,4.36,114.12,4.36,250.06s110.2,246.13,246.13,246.13V273.34 c11.73,125.01,116.95,222.85,245.03,222.85V3.92C367.44,3.92,262.23,101.76,250.5,226.77z"
  }));
  registerBlockType('sonaar/sonaar-block', {
    // Built-in attributes
    title: 'Sonaar MP3 Audio Player',
    description: __("A stunning audio player.", "sonaar-music"),
    icon: sonaarIcon,
    category: 'embed',
    keywords: ['mp3', 'player', 'audio', 'sonaar', 'podcast', 'music', 'beat', 'sermon', 'episode', 'radio', 'stream', 'sonar', 'sonaar', 'sonnaar', 'track'],
    // Built-in functions
    edit: function edit(props) {
      var _attributes;

      if (player_load === '' || player_load === true) {
        player_load = false;
      }

      var clientId = props.clientId;
      var attributes = props.attributes;
      var setAttributes = props.setAttributes;
      var run_pro = attributes.run_pro;
      var show_pro_badge = run_pro ? '' : 'sonaar-music__pro-badge';
      var wc_enable = attributes.wc_enable;
      var album_id = attributes.album_id;
      var cat_id = attributes.cat_id;
      var playlist_source = attributes.playlist_source;
      var hide_trackdesc = false;
      var strip_html_track_desc = true;
      var trackdesc_fontsize = 0;
      var trackdesc_color = '';
      var metadata_fontsize = 0;
      var metadata_color = '';
      var notrackskip = false;
      var player_layout = attributes.player_layout;
      var player_layout_options = attributes.player_layout_options;
      var trueFalseDefault = attributes.trueFalseDefault;
      var show_track_publish_date = '';
      var show_volume_bt = '';
      var show_speed_bt = '';
      var show_shuffle_bt = '';
      var show_skip_bt = '';
      var post_link = '';
      var show_meta_duration = '';
      var show_publish_date = '';
      var show_tracks_count = '';
      var show_cat_description = attributes.show_cat_description;
      var posts_per_page = attributes.posts_per_page;
      var playlist_sources = attributes.playlist_sources;
      var playlist_list = attributes.playlist_list;
      var playlist_list_cat = attributes.playlist_list_cat;
      var playlist_show_playlist = attributes.playlist_show_playlist;
      var playlist_show_album_market = attributes.playlist_show_album_market;
      var sr_player_on_artwork = attributes.sr_player_on_artwork;
      var playlist_hide_artwork = attributes.playlist_hide_artwork;
      var playlist_show_soundwave = attributes.playlist_show_soundwave;
      var play_current_id = attributes.play_current_id;
      var enable_sticky_player = false;
      var enable_shuffle = false;
      var reverse_tracklist = false;
      var enable_scrollbar = false;
      var scrollbar_height = 200;
      var track_desc_lenght = 55;
      var move_playlist_below_artwork = false;
      var track_artwork_show = false;
      var track_artwork_size = 45;
      var title_html_tag_playlist = 'h3';
      var title_color = '';
      var subtitle_color = '';
      var track_title_color = '';
      var tracklist_hover_color = '';
      var tracklist_active_color = '';
      var track_separator_color = '';
      var tracklist_spacing = 8;
      var duration_color = '';
      var track_publish_date_fontsize = 0;
      var track_publish_date_color = '';
      var tracklist_bg = '';
      var player_bg = '';
      var title_align = 'left';
      var title_indent = 0;
      var title_fontsize = 0;
      var subtitle_fontsize = 0;
      var track_title_fontsize = 0;
      var duration_fontsize = 0;
      var store_title_fontsize = 0;
      var store_button_fontsize = 0;
      var duration_soundwave_fontsize = 0;
      var title_soundwave_fontsize = 0;
      var html_tags = [];
      var sr_alignments = [];
      var sr_text_alignments = [];
      var colors = [];
      var border_types = [];
      var title_btshow = false;
      var subtitle_btshow = false;
      var hide_number_btshow = false;
      var hide_time_duration = false;
      var play_pause_bt_show = false;
      var tracklist_controls_color = '';
      var tracklist_controls_size = 12;
      var hide_track_market = false;
      var wc_bt_show = true;
      var wc_icons_color = '';
      var wc_icons_bg_color = '';
      var view_icons_alltime = true;
      var popover_icons_store = '';
      var tracklist_icons_color = '';
      var tracklist_icons_spacing = 0;
      var tracklist_icons_size = 0;
      var hide_player_title = false;
      var title_html_tag_soundwave = 'div';
      var title_soundwave_color = '';
      var soundwave_show = false;
      var soundWave_progress_bar_color = '';
      var soundWave_bg_bar_color = '';
      var progressbar_inline = false;
      var duration_soundwave_show = false;
      var duration_soundwave_color = '';
      var description_color = '';
      var externalLinkButton_bg = '';
      var audio_player_controls_spacebefore = 0;
      var artwork_width = 300;
      var boxed_artwork_width = 160;
      var artwork_radius = 0;
      var audio_player_artwork_controls_color = '';
      var audio_player_artwork_controls_scale = 1;
      var audio_player_controls_color = '';
      var artwork_padding = 0;
      var playlist_justify = 'center';
      var artwork_align = 'center';
      var playlist_width = 100;
      var playlist_margin = 0;
      var tracklist_margin = 0;
      var store_title_btshow = false;

      var store_title_text = __('Available now on:', 'sonaar-music');

      var store_title_color = '';
      var store_title_align = 'center';
      var album_stores_align = 'center';
      var button_text_color = '';
      var background_color = '';
      var button_hover_color = '';
      var button_background_hover_color = '';
      var button_hover_border_color = '';
      var button_border_style = 'none';
      var button_border_width = 3;
      var button_border_color = 'black';
      var button_border_radius = 0;
      var store_icon_show = false;
      var icon_font_size = 0;
      var icon_indent = 10;
      var album_stores_padding = 22;

      if (run_pro) {
        enable_sticky_player = attributes.enable_sticky_player;
        enable_shuffle = attributes.enable_shuffle;
        reverse_tracklist = attributes.reverse_tracklist;
        enable_scrollbar = attributes.enable_scrollbar;
        scrollbar_height = attributes.scrollbar_height;
        track_desc_lenght = attributes.track_desc_lenght;
        hide_trackdesc = attributes.hide_trackdesc;
        strip_html_track_desc = attributes.strip_html_track_desc;
        trackdesc_fontsize = attributes.trackdesc_fontsize;
        trackdesc_color = attributes.trackdesc_color;
        metadata_fontsize = attributes.metadata_fontsize;
        metadata_color = attributes.metadata_color;
        notrackskip = attributes.notrackskip;
        move_playlist_below_artwork = attributes.move_playlist_below_artwork;
        track_artwork_show = attributes.track_artwork_show;
        track_artwork_size = attributes.track_artwork_size;
        html_tags = attributes.html_tags;
        sr_alignments = attributes.sr_alignments;
        sr_text_alignments = attributes.sr_text_alignments;
        colors = attributes.colors;
        border_types = attributes.border_types;
        title_html_tag_playlist = attributes.title_html_tag_playlist;
        title_color = attributes.title_color;
        subtitle_color = attributes.subtitle_color;
        track_title_color = attributes.track_title_color;
        tracklist_hover_color = attributes.tracklist_hover_color;
        tracklist_active_color = attributes.tracklist_active_color;
        track_separator_color = attributes.track_separator_color;
        tracklist_spacing = attributes.tracklist_spacing;
        duration_color = attributes.duration_color;
        track_publish_date_fontsize = attributes.track_publish_date_fontsize;
        track_publish_date_color = attributes.track_publish_date_color;
        tracklist_bg = attributes.tracklist_bg;
        player_bg = attributes.player_bg;
        title_align = attributes.title_align;
        title_indent = attributes.title_indent;
        title_fontsize = attributes.title_fontsize;
        subtitle_fontsize = attributes.subtitle_fontsize;
        track_title_fontsize = attributes.track_title_fontsize;
        duration_fontsize = attributes.duration_fontsize;
        store_title_fontsize = attributes.store_title_fontsize;
        store_button_fontsize = attributes.store_button_fontsize;
        duration_soundwave_fontsize = attributes.duration_soundwave_fontsize;
        title_soundwave_fontsize = attributes.title_soundwave_fontsize;
        title_btshow = attributes.title_btshow;
        subtitle_btshow = attributes.subtitle_btshow;
        hide_number_btshow = attributes.hide_number_btshow;
        hide_time_duration = attributes.hide_time_duration;
        play_pause_bt_show = attributes.play_pause_bt_show;
        tracklist_controls_color = attributes.tracklist_controls_color;
        tracklist_controls_size = attributes.tracklist_controls_size;
        hide_track_market = attributes.hide_track_market;
        wc_bt_show = attributes.wc_bt_show;
        wc_icons_color = attributes.wc_icons_color;
        wc_icons_bg_color = attributes.wc_icons_bg_color;
        view_icons_alltime = attributes.view_icons_alltime;
        popover_icons_store = attributes.popover_icons_store;
        tracklist_icons_color = attributes.tracklist_icons_color;
        tracklist_icons_spacing = attributes.tracklist_icons_spacing;
        tracklist_icons_size = attributes.tracklist_icons_size;
        hide_player_title = attributes.hide_player_title;
        title_html_tag_soundwave = attributes.title_html_tag_soundwave;
        title_soundwave_color = attributes.title_soundwave_color;
        soundwave_show = attributes.soundwave_show;
        soundWave_progress_bar_color = attributes.soundWave_progress_bar_color;
        soundWave_bg_bar_color = attributes.soundWave_bg_bar_color;
        progressbar_inline = attributes.progressbar_inline;
        duration_soundwave_show = attributes.duration_soundwave_show;
        duration_soundwave_color = attributes.duration_soundwave_color;
        description_color = attributes.description_color;
        externalLinkButton_bg = attributes.externalLinkButton_bg;
        audio_player_controls_spacebefore = attributes.audio_player_controls_spacebefore;
        artwork_width = attributes.artwork_width;
        boxed_artwork_width = attributes.boxed_artwork_width;
        audio_player_artwork_controls_color = attributes.audio_player_artwork_controls_color;
        audio_player_artwork_controls_scale = attributes.audio_player_artwork_controls_scale;
        audio_player_controls_color = attributes.audio_player_controls_color;
        artwork_radius = attributes.artwork_radius;
        artwork_padding = attributes.artwork_padding;
        playlist_justify = attributes.playlist_justify;
        artwork_align = attributes.artwork_align;
        playlist_width = attributes.playlist_width;
        playlist_margin = attributes.playlist_margin;
        tracklist_margin = attributes.tracklist_margin;
        store_title_btshow = attributes.store_title_btshow;
        store_title_text = attributes.store_title_text;
        store_title_color = attributes.store_title_color;
        store_title_align = attributes.store_title_align;
        album_stores_align = attributes.album_stores_align;
        button_text_color = attributes.button_text_color;
        background_color = attributes.background_color;
        button_hover_color = attributes.button_hover_color;
        button_background_hover_color = attributes.button_background_hover_color;
        button_hover_border_color = attributes.button_hover_border_color;
        button_border_style = attributes.button_border_style;
        button_border_width = attributes.button_border_width;
        button_border_color = attributes.button_border_color;
        button_border_radius = attributes.button_border_radius;
        store_icon_show = attributes.store_icon_show;
        icon_font_size = attributes.icon_font_size;
        icon_indent = attributes.icon_indent;
        album_stores_padding = attributes.album_stores_padding;
        show_track_publish_date = attributes.show_track_publish_date;
        show_skip_bt = attributes.show_skip_bt;
        post_link = attributes.post_link;
        show_publish_date = attributes.show_publish_date;
        show_meta_duration = attributes.show_meta_duration;
        show_tracks_count = attributes.show_tracks_count;
        show_shuffle_bt = attributes.show_shuffle_bt;
        show_speed_bt = attributes.show_speed_bt;
        show_volume_bt = attributes.show_volume_bt;
      }

      var _useState = useState(false),
          _useState2 = _babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_1___default()(_useState, 2),
          isOpen = _useState2[0],
          setOpen = _useState2[1];

      var openGoProModal = function openGoProModal() {
        return setOpen(true);
      };

      var closeGoProModal = function closeGoProModal() {
        return setOpen(false);
      };

      var SrpModalGoPro = function SrpModalGoPro() {
        return createElement(_wordpress_element__WEBPACK_IMPORTED_MODULE_2__["Fragment"], null, isOpen && createElement(Modal, {
          title: "Pro Feature",
          onRequestClose: closeGoProModal
        }, createElement("h2", null, "Unlock MP3 Audio Player PRO"), createElement("p", null, "Get this feature and more with the Pro version of MP3 Audio Player Pro by Sonaar!"), createElement(Button, {
          href: "https://sonaar.io/free-mp3-music-player-plugin-for-wordpress/?utm_source=Sonaar+Music+Free+Plugin&utm_medium=plugin#pricing",
          target: "_blank",
          isPrimary: true
        }, "Learn More")));
      };

      if (!run_pro) {
        jQuery("body").append('<div id="sonaar-music-plugin-app"></div>');
        render(createElement(SrpModalGoPro, null), document.getElementById("sonaar-music-plugin-app"));
      }

      var initialPlayerCount = $('.iron-audioplayer').length;
      var setIronAudioplayers = setTimeout(function () {
        var setIronAudioplayerInterval = setInterval(function () {
          if (initialPlayerCount < $('.iron-audioplayer').length) {
            ironAudioplayersLoaded = false;
          }

          if (jQuery('#block-' + clientId + ' .iron-audioplayer').length > 0) {
            if (!ironAudioplayersLoaded) {
              IRON.players = [];
              jQuery('.iron-audioplayer').each(function () {
                var player = Object.create(IRON.audioPlayer);
                player.init(jQuery(this));
                IRON.players.push(player);
              });
              ironAudioplayersLoaded = true;
            }

            clearInterval(setIronAudioplayerInterval);
          }
        }, 500);
      }, 1000);

      var is_style_loaded = function set_style_load() {
        style_load = true;
      };

      setTimeout(function () {
        if (!style_load) {
          style_changes();
        }

        style_load = true;
      }, 2000);

      function setNewValue(variable, newValue) {
        if (newValue && Object.keys(variable)[0] == Object.keys(newValue)[0]) {
          return newValue[Object.keys(newValue)[0]];
        } else {
          return variable[Object.keys(variable)[0]];
        }
      }

      function style_changes() {
        var newValue = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;
        var custom_css = '';

        if (playlist_hide_artwork) {
          custom_css += '#block-' + clientId + ' .iron-audioplayer .sonaar-Artwort-box { display: none; }';
        }

        if (!playlist_hide_artwork) {
          if (player_layout == 'skin_boxed_tracklist') {
            boxed_artwork_width = setNewValue({
              boxed_artwork_width: boxed_artwork_width
            }, newValue);
            custom_css += 'div#block-' + clientId + ' .iron-audioplayer:not(.sonaar-no-artwork) .srp_player_grid { grid-template-columns: ' + boxed_artwork_width + 'px 1fr;}';
            custom_css += 'div#block-' + clientId + ' .srp_player_boxed .album-art { width: ' + boxed_artwork_width + 'px; max-width: ' + boxed_artwork_width + 'px;}';
            custom_css += 'div#block-' + clientId + ' .srp_player_boxed .sonaar-Artwort-box { min-width: ' + boxed_artwork_width + 'px;}';
          } else {
            artwork_width = setNewValue({
              artwork_width: artwork_width
            }, newValue);
            custom_css += 'div#block-' + clientId + ' .iron-audioplayer .album .album-art { max-width: ' + artwork_width + 'px; width: ' + artwork_width + 'px;}';
          }

          artwork_radius = setNewValue({
            artwork_radius: artwork_radius
          }, newValue);
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .album .album-art img { border-radius: ' + artwork_radius + 'px;}';
          artwork_padding = setNewValue({
            artwork_padding: artwork_padding
          }, newValue);
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .sonaar-grid .album { padding: ' + artwork_padding + 'px;}';
        }

        custom_css += ' #block-' + clientId + ' .iron-audioplayer .playlist li .sr_track_cover { width: ' + track_artwork_size + 'px;}';
        custom_css += ' #block-' + clientId + ' .iron-audioplayer .sonaar-grid { justify-content: ' + playlist_justify + '; }';
        custom_css += ' #block-' + clientId + ' .iron-audioplayer .sr_playlist_below_artwork_auto .sonaar-grid { align-items: ' + playlist_justify + '; }';
        custom_css += ' #block-' + clientId + ' .iron-audioplayer .playlist, #block-' + clientId + ' .iron-audioplayer .buttons-block { width: ' + playlist_width + '%; }';
        custom_css += ' #block-' + clientId + ' .iron-audioplayer .playlist { margin: ' + playlist_margin + 'px; }';
        custom_css += ' #block-' + clientId + ' .iron-audioplayer .srp_tracklist { margin: ' + tracklist_margin + 'px; }';
        title_align = setNewValue({
          title_align: title_align
        }, newValue);
        custom_css += ' #block-' + clientId + ' .iron-audioplayer .sr_it-playlist-title, #block-' + clientId + ' .iron-audioplayer .sr_it-playlist-artists, #block-' + clientId + ' .iron-audioplayer .sr_it-playlist-release-date { text-align: ' + title_align + '; }';
        title_indent = setNewValue({
          title_indent: title_indent
        }, newValue);
        custom_css += ' #block-' + clientId + ' .iron-audioplayer .sr_it-playlist-title, #block-' + clientId + ' .iron-audioplayer .sr_it-playlist-artists, #block-' + clientId + ' .iron-audioplayer .sr_it-playlist-release-date { margin-left: ' + title_indent + 'px; }';
        custom_css += ' #block-' + clientId + ' .iron-audioplayer .playlist li { padding-top: ' + tracklist_spacing + 'px; padding-bottom: ' + tracklist_spacing + 'px; }';
        custom_css += ' #block-' + clientId + ' .iron-audioplayer .track-number svg { width: ' + tracklist_controls_size + 'px; height: ' + tracklist_controls_size + 'px; }';
        custom_css += ' #block-' + clientId + ' .iron-audioplayer .track-number { padding-left: calc( ' + tracklist_controls_size + 'px + 12px ); }';
        custom_css += ' #block-' + clientId + ' .iron-audioplayer .ctnButton-block { justify-content: ' + store_title_align + '; align-items: ' + store_title_align + '; }';
        custom_css += ' #block-' + clientId + ' .iron-audioplayer .buttons-block { justify-content: ' + album_stores_align + '; align-items: ' + album_stores_align + '; }';
        custom_css += ' #block-' + clientId + ' .iron-audioplayer .buttons-block .store-list li .button { border-style: ' + button_border_style + '; }';
        custom_css += ' #block-' + clientId + ' .iron-audioplayer .show-playlist .ctnButton-block { margin: ' + album_stores_padding + 'px; }';

        if (!hide_track_market) {
          if (!wc_bt_show) {
            custom_css += ' #block-' + clientId + ' .iron-audioplayer .playlist a.song-store.sr_store_wc_round_bt { display: none; }';
          }

          if (wc_bt_show && wc_icons_color != '' && wc_icons_color != undefined) {
            custom_css += ' #block-' + clientId + ' .iron-audioplayer .playlist a.song-store.sr_store_wc_round_bt { color: ' + wc_icons_color + '; }';
          }

          if (wc_bt_show && wc_icons_bg_color != '' && wc_icons_bg_color != undefined) {
            custom_css += ' #block-' + clientId + ' .iron-audioplayer .playlist a.song-store.sr_store_wc_round_bt { background-color: ' + wc_icons_color + '; }';
          }
        }

        if (progressbar_inline) {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .player .control { top: ' + audio_player_controls_spacebefore + 'px; position: relative; }';
        }

        audio_player_artwork_controls_color = setNewValue({
          audio_player_artwork_controls_color: audio_player_artwork_controls_color
        }, newValue);

        if (sr_player_on_artwork && audio_player_artwork_controls_color != '' && audio_player_artwork_controls_color != undefined) {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer.sr_player_on_artwork .control path, #block-' + clientId + ' .iron-audioplayer.sr_player_on_artwork .control rect, #block-' + clientId + ' .iron-audioplayer.sr_player_on_artwork .control polygon { fill: ' + audio_player_artwork_controls_color + '; }';
          custom_css += ' #block-' + clientId + ' .iron-audioplayer.sr_player_on_artwork .control .play { border-color: ' + audio_player_artwork_controls_color + '; }';
        }

        if (sr_player_on_artwork) {
          audio_player_artwork_controls_scale = setNewValue({
            audio_player_artwork_controls_scale: audio_player_artwork_controls_scale
          }, newValue);
          custom_css += ' #block-' + clientId + ' .iron-audioplayer.sr_player_on_artwork .sonaar-Artwort-box .control { transform:scale(' + audio_player_artwork_controls_scale + '); }';
        }

        button_border_color = setNewValue({
          button_border_color: button_border_color
        }, newValue);

        if (button_border_style != 'none') {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .buttons-block .store-list li .button { border-width: ' + button_border_width + 'px; }';
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .buttons-block .store-list li .button { border-color: ' + button_border_color + '; }';
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .store-list .button { border-radius: ' + button_border_radius + 'px; }';
        }

        if (sr_player_on_artwork && !playlist_hide_artwork && playlist_show_playlist && move_playlist_below_artwork) {
          artwork_align = setNewValue({
            artwork_align: artwork_align
          }, newValue);
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .sonaar-Artwort-box { justify-content: ' + artwork_align + '; }';
        }

        if (title_color != '' && title_color != undefined) {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .playlist .sr_it-playlist-title { color: ' + title_color + '; }';
        }

        if (title_fontsize > 0) {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .playlist .sr_it-playlist-title { font-size: ' + title_fontsize + 'px; }';
        }

        if (subtitle_fontsize > 0) {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .sr_it-playlist-release-date { font-size: ' + subtitle_fontsize + 'px; }';
        }

        track_title_fontsize = setNewValue({
          track_title_fontsize: track_title_fontsize
        }, newValue);

        if (track_title_fontsize > 0) {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .playlist .audio-track, #block-' + clientId + ' .iron-audioplayer .playlist .track-number, #block-' + clientId + ' .iron-audioplayer .track-title { font-size: ' + track_title_fontsize + 'px; }';
        }

        if (!hide_time_duration && duration_fontsize > 0) {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .tracklist-item-time { font-size: ' + duration_fontsize + 'px; }';
        }

        if (!store_title_btshow && store_title_fontsize > 0) {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .available-now { font-size: ' + store_title_fontsize + 'px; }';
        }

        if (store_button_fontsize > 0) {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer a.button { font-size: ' + store_button_fontsize + 'px; }';
        }

        if (!soundwave_show && !duration_soundwave_show && duration_soundwave_fontsize > 0) {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .player { font-size: ' + duration_soundwave_fontsize + 'px; }';
        }

        audio_player_controls_color = setNewValue({
          audio_player_controls_color: audio_player_controls_color
        }, newValue);

        if (audio_player_controls_color != '' && audio_player_controls_color != undefined) {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .control path, #block-' + clientId + ' .iron-audioplayer .control rect, #block-' + clientId + ' .iron-audioplayer .control polygon, #block-' + clientId + ' .srp-play-button path, #block-' + clientId + ' .srp-play-button rect  { fill: ' + audio_player_controls_color + '; }';
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .control .sr_speedRate div { color: ' + audio_player_controls_color + '; border-color: ' + audio_player_controls_color + ';}';
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .control { color: ' + audio_player_controls_color + ';}';
          custom_css += ' #block-' + clientId + ' .srp-play-button circle { stroke: ' + audio_player_controls_color + ';}';
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .srp-play-button-label-container { background: ' + audio_player_controls_color + ';}';
        }

        title_soundwave_fontsize = setNewValue({
          title_soundwave_fontsize: title_soundwave_fontsize
        }, newValue);

        if (!hide_player_title && title_soundwave_fontsize > 0) {
          custom_css += ' div#block-' + clientId + ' .iron-audioplayer .track-title, div#block-' + clientId + ' .srp_player_boxed .album-title { font-size: ' + title_soundwave_fontsize + 'px; }';
        }

        if (subtitle_color != '' && subtitle_color != undefined) {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .sr_it-playlist-release-date { color: ' + subtitle_color + '; }';
        }

        track_title_color = setNewValue({
          track_title_color: track_title_color
        }, newValue);

        if (track_title_color != '' && track_title_color != undefined) {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .playlist .audio-track, #block-' + clientId + ' .iron-audioplayer .playlist .track-number, #block-' + clientId + ' .iron-audioplayer .track-title, #block-' + clientId + ' .iron-audioplayer .player { color: ' + track_title_color + '; }';
        }

        tracklist_hover_color = setNewValue({
          tracklist_hover_color: tracklist_hover_color
        }, newValue);

        if (tracklist_hover_color != '' && tracklist_hover_color != undefined) {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .playlist .audio-track:hover, #block-' + clientId + ' .iron-audioplayer .playlist .audio-track:hover .track-number, #block-' + clientId + ' .iron-audioplayer .playlist a.song-store:not(.sr_store_wc_round_bt):hover, #block-' + clientId + ' .iron-audioplayer .playlist .current a.song-store:not(.sr_store_wc_round_bt):hover { color: ' + tracklist_hover_color + '; }';
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .playlist .audio-track:hover path, #block-' + clientId + ' .iron-audioplayer .playlist .audio-track:hover rect {  fill: ' + tracklist_hover_color + '; }';
        }

        tracklist_active_color = setNewValue({
          tracklist_active_color: tracklist_active_color
        }, newValue);

        if (tracklist_active_color != '' && tracklist_active_color != undefined) {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .playlist .current .audio-track, #block-' + clientId + ' .iron-audioplayer .playlist .current .audio-track .track-number, #block-' + clientId + ' .iron-audioplayer .playlist .current a.song-store { color: ' + tracklist_active_color + '; }';
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .playlist .current .audio-track path, #block-' + clientId + ' .iron-audioplayer .playlist .current .audio-track rect {  fill: ' + tracklist_active_color + '; }';
        }

        if (track_separator_color != '' && track_separator_color != undefined) {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .playlist li { border-bottom: solid 1px ' + track_separator_color + '; }';
        }

        if (duration_color != '' && duration_color != undefined) {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .tracklist-item-time { color: ' + duration_color + '; }';
        }

        trackdesc_fontsize = setNewValue({
          trackdesc_fontsize: trackdesc_fontsize
        }, newValue);

        if (trackdesc_fontsize != '') {
          custom_css += ' #block-' + clientId + ' .srp_track_description { font-size: ' + trackdesc_fontsize + 'px; }';
        }

        trackdesc_color = setNewValue({
          trackdesc_color: trackdesc_color
        }, newValue);

        if (trackdesc_color != '') {
          custom_css += ' #block-' + clientId + ' .srp_track_description { color: ' + trackdesc_color + '; }';
        }

        metadata_fontsize = setNewValue({
          metadata_fontsize: metadata_fontsize
        }, newValue);

        if (metadata_fontsize != '' && metadata_fontsize != undefined) {
          custom_css += ' #block-' + clientId + ' .sr_it-playlist-publish-date, #block-' + clientId + ' .srp_playlist_duration, #block-' + clientId + ' .srp_trackCount { font-size: ' + metadata_fontsize + 'px; }';
        }

        metadata_color = setNewValue({
          metadata_color: metadata_color
        }, newValue);

        if (metadata_color != '' && metadata_color != undefined) {
          custom_css += ' #block-' + clientId + ' .sr_it-playlist-publish-date, #block-' + clientId + ' .srp_playlist_duration, #block-' + clientId + ' .srp_trackCount { color: ' + metadata_color + '; }';
        }

        track_publish_date_fontsize = setNewValue({
          track_publish_date_fontsize: track_publish_date_fontsize
        }, newValue);

        if (track_publish_date_fontsize != '' && track_publish_date_fontsize != undefined) {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .srp_tracklist-item-date { font-size: ' + track_publish_date_fontsize + 'px; }';
        }

        track_publish_date_color = setNewValue({
          track_publish_date_color: track_publish_date_color
        }, newValue);

        if (track_publish_date_color != '') {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .srp_tracklist-item-date { color: ' + track_publish_date_color + '; }';
        }

        tracklist_bg = setNewValue({
          tracklist_bg: tracklist_bg
        }, newValue);

        if (tracklist_bg != '') {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer[data-playertemplate="skin_boxed_tracklist"] .playlist, #block-' + clientId + ' .iron-audioplayer[data-playertemplate="skin_float_tracklist"] .sonaar-grid { background: ' + tracklist_bg + '; }';
        }

        player_bg = setNewValue({
          player_bg: player_bg
        }, newValue);

        if (player_bg != '') {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .srp_player_boxed, #block-' + clientId + ' .iron-audioplayer[data-playertemplate="skin_float_tracklist"] .album-player{ background: ' + player_bg + '; }';
        }

        if (tracklist_controls_color != '' && tracklist_controls_color != undefined) {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .playlist .audio-track path, #block-' + clientId + ' .iron-audioplayer .playlist .audio-track rect { fill: ' + tracklist_controls_color + '; }';
        }

        if (store_title_btshow) {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .available-now { display: none; }';
        }

        if (store_title_color != '' && store_title_color != undefined) {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .available-now { color: ' + store_title_color + '; }';
        }

        button_text_color = setNewValue({
          button_text_color: button_text_color
        }, newValue);

        if (button_text_color != '' && button_text_color != undefined) {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer a.button { color: ' + button_text_color + '; }';
        }

        background_color = setNewValue({
          background_color: background_color
        }, newValue);

        if (background_color != '' && background_color != undefined) {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer a.button { background: ' + background_color + '; }';
        }

        button_hover_color = setNewValue({
          button_hover_color: button_hover_color
        }, newValue);

        if (button_hover_color != '' && button_hover_color != undefined) {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer a.button:hover { color: ' + button_hover_color + '; }';
        }

        button_background_hover_color = setNewValue({
          button_background_hover_color: button_background_hover_color
        }, newValue);

        if (button_background_hover_color != '' && button_background_hover_color != undefined) {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer a.button:hover { background: ' + button_background_hover_color + '; }';
        }

        button_hover_border_color = setNewValue({
          button_hover_border_color: button_hover_border_color
        }, newValue);

        if (button_hover_border_color != '' && button_border_style != 'none') {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer a.button:hover { border-color: ' + button_hover_border_color + ' !important; }';
        }

        if (store_icon_show) {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .store-list .button i { display: none; }';
        }

        if (icon_font_size > 0) {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .buttons-block .store-list i { font-size: ' + icon_font_size + 'px; }';
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .buttons-block .store-list i { margin-right: ' + icon_indent + 'px; }';
        }

        title_soundwave_color = setNewValue({
          title_soundwave_color: title_soundwave_color
        }, newValue);

        if (title_soundwave_color != '' && title_soundwave_color != undefined) {
          custom_css += ' div#block-' + clientId + ' .iron-audioplayer .track-title, div#block-' + clientId + ' .iron-audioplayer .player, div#block-' + clientId + ' .iron-audioplayer .album-player, div#block-' + clientId + ' .srp_player_boxed .album-title { color: ' + title_soundwave_color + '; }';
        }

        if (!soundwave_show && soundWave_progress_bar_color != '' && soundWave_progress_bar_color != undefined) {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .sonaar_wave_cut rect { fill: ' + soundWave_progress_bar_color + '; }';
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .sr_waveform_simplebar .sonaar_wave_cut { background-color: ' + soundWave_progress_bar_color + '; }';
        }

        if (!soundwave_show && soundWave_bg_bar_color != '' && soundWave_bg_bar_color != undefined) {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .sonaar_wave_base rect { fill: ' + soundWave_bg_bar_color + '; }';
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .sr_waveform_simplebar .sonaar_wave_base { background-color: ' + soundWave_bg_bar_color + '; }';
        }

        if (!soundwave_show && !duration_soundwave_show && duration_soundwave_color != '' && duration_soundwave_color != undefined) {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .player { color: ' + duration_soundwave_color + '; }';
        }

        description_color = setNewValue({
          description_color: description_color
        }, newValue);

        if (description_color != '' && description_color != undefined) {
          custom_css += ' #block-' + clientId + ' .srp_podcast_rss_description { color: ' + description_color + '; }';
        }

        externalLinkButton_bg = setNewValue({
          externalLinkButton_bg: externalLinkButton_bg
        }, newValue);

        if (externalLinkButton_bg != '' && externalLinkButton_bg != undefined) {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .album-store { background-color: ' + externalLinkButton_bg + '; }';
        }

        if (!hide_track_market && !view_icons_alltime && popover_icons_store != '') {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .playlist .song-store-list-menu .fa-ellipsis-v { color: ' + popover_icons_store + '; }';
        }

        tracklist_icons_color = setNewValue({
          tracklist_icons_color: tracklist_icons_color
        }, newValue);

        if (!hide_track_market && tracklist_icons_color != '' && tracklist_icons_spacing != undefined) {
          custom_css += ' #block-' + clientId + ' .playlist a.song-store:not(.sr_store_wc_round_bt) { color: ' + tracklist_icons_color + '; }';
        }

        if (!hide_track_market && tracklist_icons_spacing > 0) {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .playlist .store-list .song-store-list-container { column-gap: ' + tracklist_icons_spacing + 'px; }';
        }

        tracklist_icons_size = setNewValue({
          tracklist_icons_size: tracklist_icons_size
        }, newValue);

        if (!hide_track_market && tracklist_icons_size > 0) {
          custom_css += ' #block-' + clientId + ' .playlist .store-list .song-store .fab, #block-' + clientId + ' .playlist .store-list .song-store .fas, #block-' + clientId + ' .playlist .store-list .song-store{ font-size: ' + tracklist_icons_size + 'px; }';
        }

        if (hide_time_duration) {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .tracklist-item-time { display: none; }';
        } else {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .tracklist-item-time { display: block; }';
        }

        if (play_pause_bt_show) {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .track-number { display: none; }';
        } else {
          custom_css += ' #block-' + clientId + ' .iron-audioplayer .track-number { display: block; }';
        }

        if (jQuery('head #' + clientId).length) {
          jQuery('head #' + clientId).remove();
        }

        jQuery('head').append('<style id="' + clientId + '" >' + custom_css + '</style>');

        if (playlist_show_playlist) {
          jQuery('#block-' + clientId + ' .iron-audioplayer').addClass('show-playlist');
        } else {
          jQuery('#block-' + clientId + ' .iron-audioplayer').removeClass('show-playlist');
        }

        if (!playlist_show_album_market) {
          jQuery('#block-' + clientId + ' .iron-audioplayer .album-store').hide();
        } else {
          jQuery('#block-' + clientId + ' .iron-audioplayer .album-store').show();
        }

        if (playlist_hide_artwork) {
          jQuery('#block-' + clientId + ' .iron-audioplayer').addClass('sonaar-no-artwork');
          jQuery('#block-' + clientId + ' .iron-audioplayer .sonaar-Artwort-box').hide();
        } else {
          jQuery('#block-' + clientId + ' .iron-audioplayer').removeClass('sonaar-no-artwork');
          jQuery('#block-' + clientId + ' .iron-audioplayer .sonaar-Artwort-box').show();
        }

        if (enable_scrollbar && scrollbar_height != '') {
          jQuery('#block-' + clientId + ' .iron-audioplayer .playlist ul').css({
            'height': scrollbar_height + 'px',
            'overflow-y': 'hidden',
            'overflow-x': 'hidden'
          });
        } else {
          jQuery('#block-' + clientId + ' .iron-audioplayer .playlist ul').css({
            'height': 'auto',
            'overflow-y': 'auto',
            'overflow-x': 'auto'
          });
        }

        if (move_playlist_below_artwork) {
          jQuery('#block-' + clientId + ' .iron-audioplayer .sonaar-grid').css('flex-direction', 'column');
        } else {
          jQuery('#block-' + clientId + ' .iron-audioplayer .sonaar-grid').css('flex-direction', 'row');
        }

        jQuery('#block-' + clientId + ' .iron-audioplayer .playlist li .sr_track_cover').css('width', track_artwork_size + 'px');
        jQuery('#block-' + clientId + ' .iron-audioplayer .playlist, #block-' + clientId + ' .iron-audioplayer .sonaar-Artwort-box, #block-' + clientId + ' .iron-audioplayer .buttons-block').css('width', playlist_width + '%');
        jQuery('#block-' + clientId + ' .iron-audioplayer .sonaar-grid').css('justify-content', playlist_justify);
        jQuery('#block-' + clientId + ' .sr_playlist_below_artwork_auto .iron-audioplayer .sonaar-grid').css('align-items', playlist_justify);
        jQuery('#block-' + clientId + ' .iron-audioplayer .playlist').css('margin', playlist_margin + 'px');
        jQuery('#block-' + clientId + ' .iron-audioplayer .srp_tracklist').css('margin', tracklist_margin + 'px');

        if (title_btshow) {
          jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .sr_it-playlist-title').hide();
        } else {
          jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .sr_it-playlist-title').show();
        }

        var titleClass = jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .sr_it-playlist-title').attr('class');
        jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .sr_it-playlist-title').replaceWith('<' + title_html_tag_playlist + ' class="' + titleClass + '" >' + jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .sr_it-playlist-title').html() + '</' + title_html_tag_playlist + '>');

        if (title_color != '' && title_color != undefined) {
          jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .sr_it-playlist-title').css('color', title_color);
        }

        if (title_fontsize > 0) {
          jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .sr_it-playlist-title').css('font-size', title_fontsize + 'px');
        }

        if (subtitle_btshow) {
          jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .sr_it-playlist-release-date').hide();
          jQuery('#block-' + clientId + ' .sonaar_audioplayer_block_cover').addClass('sr_player_subtitle_hide');
        } else {
          jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .sr_it-playlist-release-date').show();
          jQuery('#block-' + clientId + ' .sonaar_audioplayer_block_cover').removeClass('sr_player_subtitle_hide');
        }

        if (subtitle_fontsize > 0) {
          jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .sr_it-playlist-release-date').css('font-size', subtitle_fontsize + 'px');
        } else {
          jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .sr_it-playlist-release-date').css('font-size', '');
        }

        if (subtitle_color != '' && subtitle_color != undefined) {
          jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .sr_it-playlist-release-date').css('color', subtitle_color);
        } else {
          jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .sr_it-playlist-release-date').css('color', 'inherit');
        }

        if (track_separator_color != '' && track_separator_color != undefined) {
          jQuery('#block-' + clientId + ' .iron-audioplayer .playlist li').css('border-bottom', 'solid 1px ' + track_separator_color);
        } else {
          jQuery('#block-' + clientId + ' .iron-audioplayer .playlist li').css('border-bottom', 'none');
        }

        jQuery('#block-' + clientId + ' .iron-audioplayer .playlist li').css({
          'padding-top': tracklist_spacing + 'px',
          'padding-bottom': tracklist_spacing + 'px'
        });

        if (hide_number_btshow) {
          jQuery('#block-' + clientId + ' .sonaar_audioplayer_block_cover').addClass('sr_player_track_num_hide');
          jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .track-number .number').hide();
        } else {
          jQuery('#block-' + clientId + ' .sonaar_audioplayer_block_cover').removeClass('sr_player_track_num_hide');
          jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .track-number .number').show();
        }

        if (hide_time_duration) {
          jQuery('#block-' + clientId + ' .iron-audioplayer .tracklist-item-time').hide();
        } else {
          jQuery('#block-' + clientId + ' .iron-audioplayer .tracklist-item-time').show();
        }

        if (duration_fontsize > 0) {
          jQuery('#block-' + clientId + ' .iron-audioplayer .tracklist-item-time').css('font-size', duration_fontsize + 'px');
        } else {
          jQuery('#block-' + clientId + ' .iron-audioplayer .tracklist-item-time').css('font-size', '');
        }

        if (duration_color != '' && duration_color != undefined) {
          jQuery('#block-' + clientId + ' .iron-audioplayer .tracklist-item-time').css('color', duration_color);
        } else {
          jQuery('#block-' + clientId + ' .iron-audioplayer .tracklist-item-time').css('color', 'inherit');
        }

        if (play_pause_bt_show) {
          jQuery('#block-' + clientId + ' .iron-audioplayer .track-number').hide();
        } else {
          jQuery('#block-' + clientId + ' .iron-audioplayer .track-number').show();
        }

        if (tracklist_controls_color != '' && tracklist_controls_color != undefined) {
          jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .audio-track path, #block-' + clientId + ' .iron-audioplayer .playlist .audio-track rect').css('fill', tracklist_controls_color);
        } else {
          jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .audio-track path, #block-' + clientId + ' .iron-audioplayer .playlist .audio-track rect').css('fill', 'inherit');
        }

        var paddingValue = tracklist_controls_size + 12;
        jQuery('#block-' + clientId + ' .iron-audioplayer .track-number svg').css({
          'width': tracklist_controls_size + 'px',
          'height': tracklist_controls_size + 'px'
        });
        jQuery('#block-' + clientId + ' .iron-audioplayer .track-number').css('padding-left', paddingValue + 'px');

        if (hide_track_market) {
          jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .store-list').hide();
        } else {
          jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .store-list').show();
        }

        if (view_icons_alltime) {
          jQuery('#block-' + clientId + ' .sonaar_audioplayer_block_cover').addClass('sr_track_inline_cta_bt__yes');
        } else {
          jQuery('#block-' + clientId + ' .sonaar_audioplayer_block_cover').removeClass('sr_track_inline_cta_bt__yes');
        }

        if (popover_icons_store != '') {
          jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .song-store-list-menu .fa-ellipsis-v').css('color', popover_icons_store);
        } else {
          jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .song-store-list-menu .fa-ellipsis-v').css('color', 'inherit');
        }

        jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .store-list .song-store-list-container').css('column-gap', tracklist_icons_spacing + 'px');

        if (!wc_bt_show) {
          jQuery('#block-' + clientId + ' .iron-audioplayer .playlist a.song-store.sr_store_wc_round_bt').hide();
        } else {
          jQuery('#block-' + clientId + ' .iron-audioplayer .playlist a.song-store.sr_store_wc_round_bt').show();
        }

        if (wc_icons_color != '' && wc_icons_color != undefined) {
          jQuery('#block-' + clientId + ' .iron-audioplayer .playlist a.song-store.sr_store_wc_round_bt').css('color', wc_icons_color);
        } else {
          jQuery('#block-' + clientId + ' .iron-audioplayer .playlist a.song-store.sr_store_wc_round_bt').css('color', 'inherit');
        }

        if (wc_icons_bg_color != '' && wc_icons_bg_color != undefined) {
          jQuery('#block-' + clientId + ' .iron-audioplayer .playlist a.song-store.sr_store_wc_round_bt').css('background-color', wc_icons_bg_color);
        } else {
          jQuery('#block-' + clientId + ' .iron-audioplayer .playlist a.song-store.sr_store_wc_round_bt').css('background-color', 'inherit');
        }

        if (store_title_btshow) {
          jQuery('#block-' + clientId + ' .iron-audioplayer .available-now').hide();
        } else {
          jQuery('#block-' + clientId + ' .iron-audioplayer .available-now').show();
        }

        jQuery('#block-' + clientId + ' .iron-audioplayer .available-now').html(store_title_text);

        if (store_title_fontsize > 0) {
          jQuery('#block-' + clientId + ' .iron-audioplayer .available-now').css('font-size', store_title_fontsize + 'px');
        } else {
          jQuery('#block-' + clientId + ' .iron-audioplayer .available-now').css('font-size', '16px');
        }

        if (store_title_color != '' && store_title_color != undefined) {
          jQuery('#block-' + clientId + ' .iron-audioplayer .available-now').css('color', store_title_color);
        } else {
          jQuery('#block-' + clientId + ' .iron-audioplayer .available-now').css('color', 'inherit');
        }

        jQuery('#block-' + clientId + ' .iron-audioplayer .ctnButton-block').css({
          'justify-content': store_title_align,
          'align-items': store_title_align
        });
        jQuery('#block-' + clientId + ' .iron-audioplayer .buttons-block').css({
          'justify-content': album_stores_align,
          'align-items': album_stores_align
        });

        if (store_button_fontsize > 0) {
          jQuery('#block-' + clientId + ' .iron-audioplayer a.button').css('font-size', store_button_fontsize + 'px');
        } else {
          jQuery('#block-' + clientId + ' .iron-audioplayer a.button').css('font-size', '');
        }

        jQuery('#block-' + clientId + ' .buttons-block .store-list li .button').css('border-style', button_border_style);
        jQuery('#block-' + clientId + ' .buttons-block .store-list li .button').css('border-width', button_border_width + 'px');

        if (button_border_color != '' && button_border_color != undefined) {
          jQuery('#block-' + clientId + ' .buttons-block .store-list li .button').css('border-color', button_border_color);
        } else {
          jQuery('#block-' + clientId + ' .buttons-block .store-list li .button').css('border-color', 'inherit');
        }

        jQuery('#block-' + clientId + ' .store-list .button').css('border-radius', button_border_radius + 'px');

        if (store_icon_show) {
          jQuery('#block-' + clientId + ' .iron-audioplayer .store-list .button i').hide();
        } else {
          jQuery('#block-' + clientId + ' .iron-audioplayer .store-list .button i').show();
        }

        if (icon_font_size > 0) {
          jQuery('#block-' + clientId + ' .iron-audioplayer .buttons-block .store-list i').css('font-size', icon_font_size + 'px');
        } else {
          jQuery('#block-' + clientId + ' .iron-audioplayer .buttons-block .store-list i').css('font-size', '');
        }

        jQuery('#block-' + clientId + ' .iron-audioplayer .buttons-block .store-list i').css('margin-right', icon_indent + 'px');
        jQuery('#block-' + clientId + ' .iron-audioplayer.show-playlist .ctnButton-block').css('margin', album_stores_padding + 'px');
        var soundwaveClass = jQuery('#block-' + clientId + ' .iron-audioplayer .track-title').attr('class');
        jQuery('#block-' + clientId + ' .iron-audioplayer .track-title').replaceWith('<' + title_html_tag_soundwave + ' class="' + soundwaveClass + '" >' + jQuery('#block-' + clientId + ' .iron-audioplayer .track-title').html() + '</' + title_html_tag_soundwave + '>');

        if (soundwave_show) {
          jQuery('#block-' + clientId + ' .iron-audioplayer .sr_progressbar').hide();
        } else {
          jQuery('#block-' + clientId + ' .iron-audioplayer .sr_progressbar').show();
        }

        if (progressbar_inline) {
          jQuery('#block-' + clientId + ' .iron-audioplayer .album-player .player').addClass('sr_player__inline');
        } else {
          jQuery('#block-' + clientId + ' .iron-audioplayer .album-player .player').removeClass('sr_player__inline');
        }

        if (soundWave_progress_bar_color != '' && soundWave_progress_bar_color != undefined) {
          jQuery('#block-' + clientId + ' .iron-audioplayer .sonaar_wave_cut rect').css('fill', soundWave_progress_bar_color);
          jQuery('#block-' + clientId + ' .iron-audioplayer .sr_waveform_simplebar .sonaar_wave_cut').css('background-color', soundWave_progress_bar_color);
        } else {
          jQuery('#block-' + clientId + ' .iron-audioplayer .sonaar_wave_cut rect').css('fill', 'inherit');
          jQuery('#block-' + clientId + ' .iron-audioplayer .sr_waveform_simplebar .sonaar_wave_cut').css('background-color', 'inherit');
        }

        if (soundWave_bg_bar_color != '' && soundWave_bg_bar_color != undefined) {
          jQuery('#block-' + clientId + ' .iron-audioplayer .sonaar_wave_base rect').css('fill', soundWave_bg_bar_color);
          jQuery('#block-' + clientId + ' .iron-audioplayer .sr_waveform_simplebar .sonaar_wave_base').css('background-color', soundWave_bg_bar_color);
        } else {
          jQuery('#block-' + clientId + ' .iron-audioplayer .sonaar_wave_base rect').css('fill', 'inherit');
          jQuery('#block-' + clientId + ' .iron-audioplayer .sr_waveform_simplebar .sonaar_wave_base').css('background-color', 'inherit');
        }

        if (duration_soundwave_show) {
          jQuery('#block-' + clientId + ' .iron-audioplayer .currentTime').hide();
          jQuery('#block-' + clientId + ' .iron-audioplayer .totalTime').hide();
          jQuery('#block-' + clientId + ' .iron-audioplayer .sr_progressbar > .wave').css({
            'margin-left': 0,
            'margin-right': 0
          });
        } else {
          jQuery('#block-' + clientId + ' .iron-audioplayer .currentTime').show();
          jQuery('#block-' + clientId + ' .iron-audioplayer .totalTime').show();
          jQuery('#block-' + clientId + ' .iron-audioplayer .sr_progressbar > .wave').css({
            'margin-left': '10px',
            'margin-right': '10px'
          });
        }

        if (duration_soundwave_fontsize > 0) {
          jQuery('#block-' + clientId + ' .iron-audioplayer .player').css('font-size', duration_soundwave_fontsize + 'px');
        } else {
          jQuery('#block-' + clientId + ' .iron-audioplayer .player').css('font-size', '12px');
        }

        if (duration_soundwave_color != '' && duration_soundwave_color != undefined) {
          jQuery('#block-' + clientId + ' .iron-audioplayer .player').css('color', duration_soundwave_color);
        } else {
          jQuery('#block-' + clientId + ' .iron-audioplayer .player').css('color', 'inherit');
        }

        jQuery('#block-' + clientId + ' .iron-audioplayer .player .control').css({
          'top': audio_player_controls_spacebefore + 'px',
          'position': 'relative'
        });
      } //Display block preview and UI


      return [createElement(InspectorControls, {
        key: 'inspector'
      }, createElement(PanelBody, {
        title: __('Player Settings', 'sonaar-music'),
        initialOpen: true
      }, createElement(SelectControl, {
        label: __('Playlist Source', 'sonaar-music'),
        options: playlist_sources,
        value: playlist_source,
        onChange: function onChange(value) {
          setAttributes({
            playlist_source: value
          });
          ironAudioplayersLoaded = false;
          setIronAudioplayers;
          style_load = false;
        }
      }), playlist_source == 'from_cpt' && createElement(SelectControl, {
        label: __('Select Playlist(s)', 'sonaar-music'),
        multiple: true,
        id: "playlist-list-id" + clientId,
        className: 'playlist-list-id',
        options: playlist_list,
        value: album_id,
        onChange: function onChange(value) {
          setAttributes({
            album_id: value
          });
          ironAudioplayersLoaded = false;
          setIronAudioplayers;
          style_load = false;
        }
      }), playlist_source == 'from_cat' && createElement(SelectControl, {
        label: __('From specific category(s)', 'sonaar-music'),
        multiple: true,
        id: "playlist-list-cat" + clientId,
        className: 'playlist-list-cat',
        options: playlist_list_cat,
        value: cat_id,
        onChange: function onChange(value) {
          setAttributes({
            cat_id: value
          });
          ironAudioplayersLoaded = false;
          setIronAudioplayers;
          style_load = false;
        }
      }), playlist_source == 'from_cat' && createElement(ToggleControl, {
        label: __('Display category description', 'sonaar-music'),
        checked: show_cat_description,
        onChange: function onChange(show_cat_des) {
          setAttributes({
            show_cat_description: show_cat_des
          });
          ironAudioplayersLoaded = false;
          setIronAudioplayers;
          style_load = false;
        }
      }), playlist_source == 'from_cat' && show_cat_description && createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Description Color', 'sonaar-music')
      }), playlist_source == 'from_cat' && show_cat_description && createElement(ColorPalette, {
        label: __('Description Color', 'sonaar-music'),
        colors: colors,
        value: description_color,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            description_color: value
          });
          style_changes({
            description_color: value
          });
        }
      }), playlist_source == 'from_cat' && createElement(RangeControl, {
        label: __('Max number of posts to load', 'sonaar-music'),
        value: posts_per_page,
        min: 0,
        max: 1000,
        onChange: function onChange(value) {
          setAttributes({
            posts_per_page: value
          });
          ironAudioplayersLoaded = false;
          setIronAudioplayers;
          style_load = false;
        }
      }), createElement(SelectControl, {
        label: __('Player Design Layout', 'sonaar-music'),
        options: player_layout_options,
        value: player_layout,
        onChange: function onChange(player_layout) {
          setAttributes({
            player_layout: player_layout
          });
          ironAudioplayersLoaded = false;
          setIronAudioplayers;
          style_load = false;
        }
      }), createElement(ToggleControl, {
        label: __('Show Tracklist', 'sonaar-music'),
        checked: playlist_show_playlist,
        onChange: function onChange(show_playlist) {
          is_style_loaded;
          setAttributes({
            playlist_show_playlist: show_playlist
          });

          if (show_playlist) {
            jQuery('#block-' + clientId + ' .iron-audioplayer').addClass('show-playlist');
          } else {
            jQuery('#block-' + clientId + ' .iron-audioplayer').removeClass('show-playlist');
          }
        }
      }), createElement(ToggleControl, {
        label: __('External Links', 'sonaar-music'),
        checked: playlist_show_album_market,
        onChange: function onChange(show_album_market) {
          is_style_loaded;
          setAttributes({
            playlist_show_album_market: show_album_market
          });

          if (!show_album_market) {
            jQuery('#block-' + clientId + ' .iron-audioplayer .album-store').hide();
          } else {
            jQuery('#block-' + clientId + ' .iron-audioplayer .album-store').show();
          }
        }
      }), createElement(ToggleControl, {
        label: __('Show Controls over Image Cover', 'sonaar-music'),
        checked: sr_player_on_artwork,
        onChange: function onChange(player_on_artwork) {
          setAttributes({
            sr_player_on_artwork: player_on_artwork
          });
          ironAudioplayersLoaded = false;
          setIronAudioplayers;
          style_load = false;
        }
      }), createElement(ToggleControl, {
        label: __('Hide Image Cover', 'sonaar-music'),
        checked: playlist_hide_artwork,
        onChange: function onChange(hide_artwork) {
          is_style_loaded;
          setAttributes({
            playlist_hide_artwork: hide_artwork
          });

          if (hide_artwork) {
            jQuery('#block-' + clientId + ' .iron-audioplayer').addClass('sonaar-no-artwork');
            jQuery('#block-' + clientId + ' .iron-audioplayer .sonaar-Artwort-box').hide();
          } else {
            jQuery('#block-' + clientId + ' .iron-audioplayer').removeClass('sonaar-no-artwork');
            jQuery('#block-' + clientId + ' .iron-audioplayer .sonaar-Artwort-box').show();
          }
        }
      }), createElement(ToggleControl, {
        label: __('Hide Mini Player/Soundwave', 'sonaar-music'),
        checked: playlist_show_soundwave,
        onChange: function onChange(show_soundwave) {
          is_style_loaded;
          setAttributes({
            playlist_show_soundwave: show_soundwave
          });
          ironAudioplayersLoaded = false;
          setIronAudioplayers;
          style_load = false;
        }
      }), createElement(ToggleControl, {
        label: __('Play its own Post ID track', 'sonaar-music'),
        checked: play_current_id,
        onChange: function onChange(play_id) {
          setAttributes({
            play_current_id: play_id
          });
          ironAudioplayersLoaded = false;
          setIronAudioplayers;
          style_load = false;
        }
      }), createElement(ToggleControl, {
        label: __('Enable Sticky Audio Player', 'sonaar-music'),
        className: show_pro_badge,
        checked: enable_sticky_player,
        onChange: function onChange(sticky_player) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          setAttributes({
            enable_sticky_player: sticky_player
          });
          ironAudioplayersLoaded = false;
          setIronAudioplayers;
          style_load = false;
        }
      }), createElement(ToggleControl, {
        label: __('Enable Shuffle', 'sonaar-music'),
        checked: enable_shuffle,
        className: show_pro_badge,
        onChange: function onChange(shuffle) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          setAttributes({
            enable_shuffle: shuffle
          });
          ironAudioplayersLoaded = false;
          setIronAudioplayers;
          style_load = false;
        }
      }), createElement(ToggleControl, {
        label: __('Reverse Tracklist', 'sonaar-music'),
        checked: reverse_tracklist,
        className: show_pro_badge,
        onChange: function onChange(reverse_tracklist) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          setAttributes({
            reverse_tracklist: reverse_tracklist
          });
          ironAudioplayersLoaded = false;
          setIronAudioplayers;
          style_load = false;
        }
      }), createElement(ToggleControl, {
        label: __('Stop when track ends', 'sonaar-music'),
        checked: notrackskip,
        onChange: function onChange(notrackskip) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          setAttributes({
            notrackskip: notrackskip
          });
          ironAudioplayersLoaded = false;
          setIronAudioplayers;
          style_load = false;
        }
      }), createElement(ToggleControl, {
        label: __('Enable Scrollbar', 'sonaar-music'),
        checked: enable_scrollbar,
        className: show_pro_badge,
        onChange: function onChange(scrollbar) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          setAttributes({
            enable_scrollbar: scrollbar
          });
          ironAudioplayersLoaded = false;
          setIronAudioplayers;
          style_load = false;
        }
      }), run_pro && enable_scrollbar ? createElement(RangeControl, {
        label: __('Scrollbar Height (px)', 'sonaar-music'),
        value: scrollbar_height,
        min: 0,
        max: 2000,
        onChange: function onChange(value) {
          is_style_loaded;
          setAttributes({
            scrollbar_height: value
          });
          style_changes();
        }
      }) : null), !playlist_hide_artwork && createElement(PanelBody, {
        title: __('Image Cover', 'sonaar-music'),
        initialOpen: false,
        className: show_pro_badge
      }, player_layout == 'skin_float_tracklist' && createElement(RangeControl, {
        label: __('Image Width (px)', 'sonaar-music'),
        value: artwork_width,
        min: 1,
        max: 450,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            artwork_width: value
          });
          style_changes({
            artwork_width: value
          });
        }
      }), player_layout == 'skin_boxed_tracklist' && createElement(RangeControl, {
        label: __('Image Width (px)', 'sonaar-music'),
        value: boxed_artwork_width,
        min: 1,
        max: 450,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            boxed_artwork_width: value
          });
          style_changes({
            boxed_artwork_width: value
          });
        }
      }), player_layout == 'skin_float_tracklist' && createElement(RangeControl, {
        label: __('Image Padding', 'sonaar-music'),
        value: artwork_padding,
        min: 0,
        max: 100,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            artwork_padding: value
          });
          style_changes({
            artwork_padding: value
          });
        }
      }), createElement(RangeControl, {
        label: __('Image Radius', 'sonaar-music'),
        value: artwork_radius,
        min: 0,
        max: 300,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            artwork_radius: value
          });
          style_changes({
            artwork_radius: value
          });
        }
      }), sr_player_on_artwork && createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Audio Player Controls over Image', 'sonaar-music')
      }), sr_player_on_artwork && createElement(ColorPalette, {
        label: __('Audio Player Controls over Image', 'sonaar-music'),
        colors: colors,
        value: audio_player_artwork_controls_color,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            audio_player_artwork_controls_color: value
          });
          style_changes({
            audio_player_artwork_controls_color: value
          });
        }
      }), sr_player_on_artwork && createElement(RangeControl, {
        label: __('Control Size Scale', 'sonaar-music'),
        value: audio_player_artwork_controls_scale,
        min: 0,
        max: 10,
        step: 0.1,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            audio_player_artwork_controls_scale: value
          });
          style_changes({
            audio_player_artwork_controls_scale: value
          });
        }
      })), playlist_show_playlist && createElement(PanelBody, {
        title: __('Tracklist', 'sonaar-music'),
        initialOpen: false,
        className: show_pro_badge
      }, !playlist_hide_artwork && player_layout == 'skin_float_tracklist' && createElement(ToggleControl, {
        label: __('Move Playlist Below Artwork', 'sonaar-music'),
        checked: move_playlist_below_artwork,
        onChange: function onChange(move_playlist_artwork) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            move_playlist_below_artwork: move_playlist_artwork
          });

          if (move_playlist_artwork) {
            jQuery('#block-' + clientId + ' .iron-audioplayer .sonaar-grid').css('flex-direction', 'column');
          } else {
            jQuery('#block-' + clientId + ' .iron-audioplayer .sonaar-grid').css('flex-direction', 'row');
          }
        }
      }), !playlist_hide_artwork && createElement('hr', {}), createElement(ToggleControl, {
        label: __('Show Thumbnail for Each Track', 'sonaar-music'),
        checked: track_artwork_show,
        onChange: function onChange(artwork_show) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          setAttributes({
            track_artwork_show: artwork_show
          });
          ironAudioplayersLoaded = false;
          setIronAudioplayers;
          style_load = false;
        }
      }), sr_player_on_artwork && !playlist_hide_artwork && playlist_show_playlist && move_playlist_below_artwork && createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Image Alignment', 'sonaar-music')
      }), sr_player_on_artwork && !playlist_hide_artwork && playlist_show_playlist && move_playlist_below_artwork && createElement(SelectControl, {
        options: sr_alignments,
        value: artwork_align,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            artwork_align: value
          });
          style_changes({
            artwork_align: value
          });
        }
      }), track_artwork_show && createElement(RangeControl, {
        label: __('Thumbnail Width (px)', 'sonaar-music'),
        value: track_artwork_size,
        min: 0,
        max: 500,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            track_artwork_size: value
          });
          jQuery('#block-' + clientId + ' .iron-audioplayer .playlist li .sr_track_cover').css('width', value + 'px');
        }
      }), createElement('hr', {}), createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Playlist Container', 'sonaar-music')
      }), createElement(ColorPalette, {
        label: __('Playlist Background', 'sonaar-music'),
        colors: colors,
        value: tracklist_bg,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            tracklist_bg: value
          });
          style_changes({
            tracklist_bg: value
          });
        }
      }), createElement(RangeControl, {
        label: __('Playlist Width (%)', 'sonaar-music'),
        value: playlist_width,
        min: 0,
        max: 100,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            playlist_width: value
          });
          jQuery('#block-' + clientId + ' .iron-audioplayer .playlist, #block-' + clientId + ' .iron-audioplayer .sonaar-Artwort-box, #block-' + clientId + ' .iron-audioplayer .buttons-block').css('width', value + '%');
        }
      }), playlist_width < 91 && createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Playlist Alignments', 'sonaar-music')
      }), playlist_width < 91 && createElement(SelectControl, {
        options: sr_alignments,
        value: playlist_justify,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            playlist_justify: value
          });
          jQuery('#block-' + clientId + ' .iron-audioplayer .sonaar-grid').css('justify-content', value);
          jQuery('#block-' + clientId + ' .sr_playlist_below_artwork_auto .iron-audioplayer .sonaar-grid').css('align-items', value);
        }
      }), createElement(RangeControl, {
        label: __('Playlist Margin (px)', 'sonaar-music'),
        value: playlist_margin,
        min: 0,
        max: 200,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            playlist_margin: value
          });
          jQuery('#block-' + clientId + ' .iron-audioplayer .playlist').css('margin', value + 'px');
        }
      }), createElement(RangeControl, {
        label: __('Tracklist Margin (px)', 'sonaar-music'),
        value: tracklist_margin,
        min: 0,
        max: 200,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            tracklist_margin: value
          });
          jQuery('#block-' + clientId + ' .iron-audioplayer .srp_tracklist').css('margin', value + 'px');
        }
      }), player_layout != 'skin_boxed_tracklist' && createElement('hr', {}), player_layout != 'skin_boxed_tracklist' && createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Heading Settings', 'sonaar-music')
      }), player_layout != 'skin_boxed_tracklist' && createElement(ToggleControl, {
        label: __('Hide Heading', 'sonaar-music'),
        checked: title_btshow,
        onChange: function onChange(hide_title) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            title_btshow: hide_title
          });

          if (hide_title) {
            jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .sr_it-playlist-title').hide();
          } else {
            jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .sr_it-playlist-title').show();
          }
        }
      }), run_pro && player_layout != 'skin_boxed_tracklist' && !title_btshow && createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('HTML Heading Tag', 'sonaar-music')
      }), run_pro && player_layout != 'skin_boxed_tracklist' && !title_btshow && createElement(SelectControl, {
        options: html_tags,
        value: title_html_tag_playlist,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            title_html_tag_playlist: value
          });
          var thisClass = jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .sr_it-playlist-title').attr('class');
          jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .sr_it-playlist-title').replaceWith('<' + value + ' class="' + thisClass + '">' + jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .sr_it-playlist-title').html() + '</' + value + '>');
        }
      }), player_layout != 'skin_boxed_tracklist' && !title_btshow && createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Heading Color', 'sonaar-music')
      }), player_layout != 'skin_boxed_tracklist' && !title_btshow && createElement(ColorPalette, {
        label: __('Heading Color', 'sonaar-music'),
        colors: colors,
        value: title_color,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            title_color: value
          });

          if (value != '' && value != undefined) {
            jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .sr_it-playlist-title').css('color', value);
          } else {
            jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .sr_it-playlist-title').css('color', 'inherit');
          }
        }
      }), player_layout != 'skin_boxed_tracklist' && !title_btshow && createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Heading Alignment', 'sonaar-music')
      }), player_layout != 'skin_boxed_tracklist' && !title_btshow && createElement(SelectControl, {
        options: sr_text_alignments,
        value: title_align,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            title_align: value
          });
          style_changes({
            title_align: value
          });
        }
      }), player_layout != 'skin_boxed_tracklist' && !title_btshow && createElement(RangeControl, {
        label: __('Heading Fontsize (px)', 'sonaar-music'),
        value: title_fontsize,
        min: 0,
        max: 100,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            title_fontsize: value
          });

          if (value > 0) {
            jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .sr_it-playlist-title').css('font-size', value + 'px');
          } else {
            jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .sr_it-playlist-title').css('font-size', '2em');
          }
        }
      }), player_layout != 'skin_boxed_tracklist' && !title_btshow && createElement(RangeControl, {
        label: __('Heading Indent (px)', 'sonaar-music'),
        value: title_indent,
        min: -500,
        max: 100,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            title_indent: value
          });
          style_changes({
            title_indent: value
          });
        }
      }), player_layout != 'skin_boxed_tracklist' && createElement('hr', {}), player_layout != 'skin_boxed_tracklist' && createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Subheading Settings', 'sonaar-music')
      }), player_layout != 'skin_boxed_tracklist' && createElement(ToggleControl, {
        label: __('Hide Subheading', 'sonaar-music'),
        checked: subtitle_btshow,
        onChange: function onChange(hide_subtitle) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            subtitle_btshow: hide_subtitle
          });

          if (hide_subtitle) {
            jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .sr_it-playlist-release-date').hide();
            jQuery('#block-' + clientId + ' .sonaar_audioplayer_block_cover').addClass('sr_player_subtitle_hide');
          } else {
            jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .sr_it-playlist-release-date').show();
            jQuery('#block-' + clientId + ' .sonaar_audioplayer_block_cover').removeClass('sr_player_subtitle_hide');
          }
        }
      }), player_layout != 'skin_boxed_tracklist' && !subtitle_btshow && createElement(RangeControl, {
        label: __('Subheading Fontsize (px)', 'sonaar-music'),
        value: subtitle_fontsize,
        min: 0,
        max: 100,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            subtitle_fontsize: value
          });

          if (value > 0) {
            jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .sr_it-playlist-release-date').css('font-size', value + 'px');
          } else {
            jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .sr_it-playlist-release-date').css('font-size', '');
          }
        }
      }), player_layout != 'skin_boxed_tracklist' && !subtitle_btshow && createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Subheading Color', 'sonaar-music')
      }), player_layout != 'skin_boxed_tracklist' && !subtitle_btshow && createElement(ColorPalette, {
        label: __('Subheading Color', 'sonaar-music'),
        colors: colors,
        value: subtitle_color,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            subtitle_color: value
          });

          if (value != '' && value != undefined) {
            jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .sr_it-playlist-release-date').css('color', value);
          } else {
            jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .sr_it-playlist-release-date').css('color', 'inherit');
          }
        }
      }), createElement('hr', {}), createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Track Settings', 'sonaar-music')
      }), createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Track Title Color', 'sonaar-music')
      }), createElement(ColorPalette, {
        label: __('Track Title Color', 'sonaar-music'),
        colors: colors,
        value: track_title_color,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            track_title_color: value
          });
          style_changes({
            track_title_color: value
          });
        }
      }), createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Track Title Hover Color', 'sonaar-music')
      }), createElement(ColorPalette, {
        label: __('Track Title Hover Color', 'sonaar-music'),
        colors: colors,
        value: tracklist_hover_color,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            tracklist_hover_color: value
          });
          style_changes({
            tracklist_hover_color: value
          });
        }
      }), createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Track Title Active Color', 'sonaar-music')
      }), createElement(ColorPalette, {
        label: __('Track Title Active Color', 'sonaar-music'),
        colors: colors,
        value: tracklist_active_color,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            tracklist_active_color: value
          });
          style_changes({
            tracklist_active_color: value
          });
        }
      }), createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Track Separator Color', 'sonaar-music')
      }), createElement(ColorPalette, {
        label: __('Track Separator Color', 'sonaar-music'),
        colors: colors,
        value: track_separator_color,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            track_separator_color: value
          });

          if (value != '' && value != undefined) {
            jQuery('#block-' + clientId + ' .iron-audioplayer .playlist li').css('border-bottom', 'solid 1px ' + value);
          } else {
            jQuery('#block-' + clientId + ' .iron-audioplayer .playlist li').css('border-bottom', 'none');
          }
        }
      }), createElement('hr', {}), createElement(RangeControl, {
        label: __('Track Title Fontsize (px)', 'sonaar-music'),
        value: track_title_fontsize,
        min: 0,
        max: 100,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            track_title_fontsize: value
          });
          style_changes({
            track_title_fontsize: value
          });
        }
      }), createElement(RangeControl, {
        label: __('Track Spacing (px)', 'sonaar-music'),
        value: tracklist_spacing,
        min: 0,
        max: 50,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            tracklist_spacing: value
          });
          jQuery('#block-' + clientId + ' .iron-audioplayer .playlist li').css({
            'padding-top': value + 'px',
            'padding-bottom': value + 'px'
          });
        }
      }), createElement('hr', {}), createElement(SelectControl, {
        label: __('Link title to the playlist page', 'sonaar-music'),
        options: trueFalseDefault,
        value: post_link,
        onChange: function onChange(post_link) {
          setAttributes({
            post_link: post_link
          });
          ironAudioplayersLoaded = false;
          setIronAudioplayers;
          style_load = false;
        }
      }), createElement('hr', {}), createElement(ToggleControl, {
        label: __('Hide Track Number', 'sonaar-music'),
        checked: hide_number_btshow,
        onChange: function onChange(hide_track_num) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            hide_number_btshow: hide_track_num
          });

          if (hide_track_num) {
            jQuery('#block-' + clientId + ' .sonaar_audioplayer_block_cover').addClass('sr_player_track_num_hide');
            jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .track-number .number').hide(); // jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .track-number').css('padding-right', '0' );
          } else {
            jQuery('#block-' + clientId + ' .sonaar_audioplayer_block_cover').removeClass('sr_player_track_num_hide');
            jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .track-number .number').show(); // jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .track-number').css('padding-right', '10px' );
          }
        }
      }), createElement('hr', {}), createElement(ToggleControl, {
        label: __('Hide Track Duration', 'sonaar-music'),
        checked: hide_time_duration,
        onChange: function onChange(hide_time) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            hide_time_duration: hide_time
          });

          if (hide_time) {
            jQuery('#block-' + clientId + ' .iron-audioplayer .tracklist-item-time').hide();
          } else {
            jQuery('#block-' + clientId + ' .iron-audioplayer .tracklist-item-time').show();
          }
        }
      }), !hide_time_duration && createElement(RangeControl, {
        label: __('Duration Fontsize (px)', 'sonaar-music'),
        value: duration_fontsize,
        min: 0,
        max: 100,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            duration_fontsize: value
          });

          if (value > 0) {
            jQuery('#block-' + clientId + ' .iron-audioplayer .tracklist-item-time').css('font-size', value + 'px');
          } else {
            jQuery('#block-' + clientId + ' .iron-audioplayer .tracklist-item-time').css('font-size', '');
          }
        }
      }), !hide_time_duration && createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Time Duration Color', 'sonaar-music')
      }), !hide_time_duration && createElement(ColorPalette, {
        label: __('Time Duration Color', 'sonaar-music'),
        colors: colors,
        value: duration_color,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            duration_color: value
          });

          if (value != '' && value != undefined) {
            jQuery('#block-' + clientId + ' .iron-audioplayer .tracklist-item-time').css('color', value);
          } else {
            jQuery('#block-' + clientId + ' .iron-audioplayer .tracklist-item-time').css('color', 'inherit');
          }
        }
      }),
      /*PUBLISHING DATE*/
      createElement('hr', {}), createElement(SelectControl, {
        label: __('Show Publish Date', 'sonaar-music'),
        options: trueFalseDefault,
        value: show_track_publish_date,
        onChange: function onChange(show_track_publish_date) {
          setAttributes({
            show_track_publish_date: show_track_publish_date
          });
          ironAudioplayersLoaded = false;
          setIronAudioplayers;
          style_load = false;
        }
      }), show_track_publish_date != 'false' && createElement(RangeControl, {
        label: __('Publish Date Fontsize (px)', 'sonaar-music'),
        value: track_publish_date_fontsize,
        min: 0,
        max: 100,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            track_publish_date_fontsize: value
          });
          style_changes({
            track_publish_date_fontsize: value
          });
        }
      }), show_track_publish_date != 'false' && createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Publish Date Color', 'sonaar-music')
      }), show_track_publish_date != 'false' && createElement(ColorPalette, {
        label: __('Publish Date Color', 'sonaar-music'),
        colors: colors,
        value: track_publish_date_color,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            track_publish_date_color: value
          });
          style_changes({
            track_publish_date_color: value
          });
        }
      }),
      /*TRACK Desciption*/
      createElement('hr', {}), createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Track Description', 'sonaar-music')
      }), createElement(ToggleControl, {
        label: __('Hide Track Description', 'sonaar-music'),
        checked: hide_trackdesc,
        onChange: function onChange(hide_trackdesc) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          setAttributes({
            hide_trackdesc: hide_trackdesc
          });
          ironAudioplayersLoaded = false;
          setIronAudioplayers;
          style_load = false;
        }
      }), !hide_trackdesc && createElement(RangeControl, {
        label: __('Track Description Fontsize (px)', 'sonaar-music'),
        value: trackdesc_fontsize,
        min: 0,
        max: 100,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            trackdesc_fontsize: value
          });
          style_changes({
            trackdesc_fontsize: value
          });
        }
      }), !hide_trackdesc && createElement(RichText.Content, {
        tagName: 'label',
        //className: 'components-base-control__label sonaar-block-label',
        value: __('Track Description Color', 'sonaar-music')
      }), !hide_trackdesc && createElement(ColorPalette, {
        colors: colors,
        value: trackdesc_color,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            trackdesc_color: value
          });
          style_changes({
            trackdesc_color: value
          });
        }
      }), !hide_trackdesc && createElement(TextControl, {
        label: __('Excerpt Length', 'sonaar-music'),
        type: 'number',
        value: track_desc_lenght,
        onChange: function onChange(value) {
          setAttributes({
            track_desc_lenght: value.toString()
          });
          ironAudioplayersLoaded = false;
          setIronAudioplayers;
          style_load = false;
        }
      }), !hide_trackdesc && createElement(ToggleControl, {
        label: __('Strip HTML', 'sonaar-music'),
        checked: strip_html_track_desc,
        onChange: function onChange(strip_html_track_desc) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          setAttributes({
            strip_html_track_desc: strip_html_track_desc
          });
          ironAudioplayersLoaded = false;
          setIronAudioplayers;
          style_load = false;
        }
      }), createElement('hr', {}), createElement(ToggleControl, {
        label: __('Hide Play/Pause Button', 'sonaar-music'),
        checked: play_pause_bt_show,
        onChange: function onChange(hide_play_pause) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            play_pause_bt_show: hide_play_pause
          });

          if (hide_play_pause) {
            jQuery('#block-' + clientId + ' .iron-audioplayer .track-number').hide();
          } else {
            jQuery('#block-' + clientId + ' .iron-audioplayer .track-number').show();
          }
        }
      }), !play_pause_bt_show && createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Play/Pause Button Color', 'sonaar-music')
      }), !play_pause_bt_show && createElement(ColorPalette, {
        label: __('Play/Pause Button Color', 'sonaar-music'),
        colors: colors,
        value: tracklist_controls_color,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            tracklist_controls_color: value
          });

          if (value != '' && value != undefined) {
            jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .audio-track path, #block-' + clientId + ' .iron-audioplayer .playlist .audio-track rect').css('fill', value);
          } else {
            jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .audio-track path, #block-' + clientId + ' .iron-audioplayer .playlist .audio-track rect').css('fill', 'inherit');
          }
        }
      }), !play_pause_bt_show && createElement(RangeControl, {
        label: __('Play/Pause Button Size (px)', 'sonaar-music'),
        value: tracklist_controls_size,
        min: 0,
        max: 50,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            tracklist_controls_size: value
          });
          var paddingValue = value + 12;
          jQuery('#block-' + clientId + ' .iron-audioplayer .track-number svg').css({
            'width': value + 'px',
            'height': value + 'px'
          });
          jQuery('#block-' + clientId + ' .iron-audioplayer .track-number').css('padding-left', paddingValue + 'px');
        }
      }), createElement('hr', {}), createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Call-to-Action Icons', 'sonaar-music')
      }), createElement(ToggleControl, {
        label: __('Hide Track\'s Call-to-Action(s)', 'sonaar-music'),
        checked: hide_track_market,
        onChange: function onChange(track_market) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            hide_track_market: track_market
          });

          if (track_market) {
            jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .store-list').hide();
          } else {
            jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .store-list').show();
          }
        }
      }), !hide_track_market && createElement(ToggleControl, {
        label: __('Display Icons without the 3 dots hover', 'sonaar-music'),
        checked: view_icons_alltime,
        onChange: function onChange(icons_alltime) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            view_icons_alltime: icons_alltime
          });

          if (icons_alltime) {
            jQuery('#block-' + clientId + ' .sonaar_audioplayer_block_cover').addClass('sr_track_inline_cta_bt__yes');
          } else {
            jQuery('#block-' + clientId + ' .sonaar_audioplayer_block_cover').removeClass('sr_track_inline_cta_bt__yes');
          }
        }
      }), !hide_track_market && !view_icons_alltime && createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('3 Dots Color', 'sonaar-music')
      }), !hide_track_market && !view_icons_alltime && createElement(ColorPalette, {
        label: __('3 Dots Color', 'sonaar-music'),
        colors: colors,
        value: popover_icons_store,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            popover_icons_store: value
          });

          if (value != '' && value != undefined) {
            jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .song-store-list-menu .fa-ellipsis-v').css('color', value);
          } else {
            jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .song-store-list-menu .fa-ellipsis-v').css('color', 'inherit');
          }
        }
      }), !hide_track_market && createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Icons Color', 'sonaar-music')
      }), !hide_track_market && createElement(ColorPalette, {
        label: __('Icons Color', 'sonaar-music'),
        colors: colors,
        value: tracklist_icons_color,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            tracklist_icons_color: value
          });
          style_changes({
            tracklist_icons_color: value
          });
        }
      }), !hide_track_market && createElement(RangeControl, {
        label: __('Icon Spacing (px)', 'sonaar-music'),
        value: tracklist_icons_spacing,
        min: 0,
        max: 50,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            tracklist_icons_spacing: value
          });
          jQuery('#block-' + clientId + ' .iron-audioplayer .playlist .store-list .song-store-list-container').css('column-gap', value + 'px');
        }
      }), !hide_track_market && createElement(RangeControl, {
        label: __('Icon Size (px)', 'sonaar-music'),
        value: tracklist_icons_size,
        min: 0,
        max: 50,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            tracklist_icons_size: value
          });
          style_changes({
            tracklist_icons_size: value
          });
        }
      }), wc_enable && !hide_track_market && createElement('hr', {}), wc_enable && !hide_track_market && createElement(ToggleControl, {
        label: __('WooCommerce Hide Icons', 'sonaar-music'),
        checked: wc_bt_show,
        onChange: function onChange(wc_btn_show) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            wc_bt_show: wc_btn_show
          });

          if (!wc_btn_show) {
            jQuery('#block-' + clientId + ' .iron-audioplayer .playlist a.song-store.sr_store_wc_round_bt').hide();
          } else {
            jQuery('#block-' + clientId + ' .iron-audioplayer .playlist a.song-store.sr_store_wc_round_bt').show();
          }
        }
      }), wc_enable && wc_bt_show && !hide_track_market && createElement(ColorPalette, {
        label: __('WooCommerce Cart Icons Color', 'sonaar-music'),
        colors: colors,
        value: wc_icons_color,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            wc_icons_color: value
          });

          if (value != '' && value != undefined) {
            jQuery('#block-' + clientId + ' .iron-audioplayer .playlist a.song-store.sr_store_wc_round_bt').css('color', value);
          } else {
            jQuery('#block-' + clientId + ' .iron-audioplayer .playlist a.song-store.sr_store_wc_round_bt').css('color', 'inherit');
          }
        }
      }), wc_enable && wc_bt_show && !hide_track_market && createElement(ColorPalette, {
        label: __('WooCommerce Cart Icons Background', 'sonaar-music'),
        colors: colors,
        value: wc_icons_bg_color,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            wc_icons_bg_color: value
          });

          if (value != '' && value != undefined) {
            jQuery('#block-' + clientId + ' .iron-audioplayer .playlist a.song-store.sr_store_wc_round_bt').css('background-color', value);
          } else {
            jQuery('#block-' + clientId + ' .iron-audioplayer .playlist a.song-store.sr_store_wc_round_bt').css('background-color', 'inherit');
          }
        }
      })), createElement(PanelBody, {
        title: __('Metadata', 'sonaar-music'),
        initialOpen: false,
        className: show_pro_badge
      }, createElement(RangeControl, {
        label: __('Fontsize (px)', 'sonaar-music'),
        value: metadata_fontsize,
        min: 0,
        max: 100,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            metadata_fontsize: value
          });
          style_changes({
            metadata_fontsize: value
          });
        }
      }), createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Color', 'sonaar-music')
      }), createElement(ColorPalette, {
        colors: colors,
        value: metadata_color,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            metadata_color: value
          });
          style_changes({
            metadata_color: value
          });
        }
      }), createElement(SelectControl, {
        label: __('Show Publish Date', 'sonaar-music'),
        options: trueFalseDefault,
        value: show_publish_date,
        onChange: function onChange(show_publish_date) {
          setAttributes({
            show_publish_date: show_publish_date
          });
          ironAudioplayersLoaded = false;
          setIronAudioplayers;
          style_load = false;
        }
      }), createElement(SelectControl, {
        label: __('Show Playlist Duration', 'sonaar-music'),
        options: trueFalseDefault,
        value: show_meta_duration,
        onChange: function onChange(show_meta_duration) {
          setAttributes({
            show_meta_duration: show_meta_duration
          });
          ironAudioplayersLoaded = false;
          setIronAudioplayers;
          style_load = false;
        }
      }), createElement(SelectControl, {
        label: __('Show Number of Player Tracks', 'sonaar-music'),
        options: trueFalseDefault,
        value: show_tracks_count,
        onChange: function onChange(show_tracks_count) {
          setAttributes({
            show_tracks_count: show_tracks_count
          });
          ironAudioplayersLoaded = false;
          setIronAudioplayers;
          style_load = false;
        }
      })), createElement(PanelBody, {
        title: __('External Links', 'sonaar-music'),
        initialOpen: false,
        className: show_pro_badge
      }, createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Background', 'sonaar-music')
      }), createElement(ColorPalette, {
        label: __('Background', 'sonaar-music'),
        colors: colors,
        value: externalLinkButton_bg,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            externalLinkButton_bg: value
          });
          style_changes({
            externalLinkButton_bg: value
          });
        }
      }), createElement(ToggleControl, {
        label: __('Hide Heading', 'sonaar-music'),
        checked: store_title_btshow,
        onChange: function onChange(store_title_hide) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            store_title_btshow: store_title_hide
          });

          if (store_title_hide) {
            jQuery('#block-' + clientId + ' .iron-audioplayer .available-now').hide();
          } else {
            jQuery('#block-' + clientId + ' .iron-audioplayer .available-now').show();
          }
        }
      }), !store_title_btshow && createElement(TextControl, {
        label: __('Heading text', 'sonaar-music'),
        value: store_title_text,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            store_title_text: value
          });
          jQuery('#block-' + clientId + ' .iron-audioplayer .available-now').html(value);
        }
      }), !store_title_btshow && createElement(RangeControl, {
        label: __('Heading Fontsize (px)', 'sonaar-music'),
        value: store_title_fontsize,
        min: 0,
        max: 100,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            store_title_fontsize: value
          });

          if (value > 0) {
            jQuery('#block-' + clientId + ' .iron-audioplayer .available-now').css('font-size', value + 'px');
          } else {
            jQuery('#block-' + clientId + ' .iron-audioplayer .available-now').css('font-size', '16px');
          }
        }
      }), !store_title_btshow && createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Heading Color', 'sonaar-music')
      }), !store_title_btshow && createElement(ColorPalette, {
        label: __('Heading Color', 'sonaar-music'),
        colors: colors,
        value: store_title_color,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            store_title_color: value
          });

          if (value != '' && value != undefined) {
            jQuery('#block-' + clientId + ' .iron-audioplayer .available-now').css('color', value);
          } else {
            jQuery('#block-' + clientId + ' .iron-audioplayer .available-now').css('color', 'inherit');
          }
        }
      }), !store_title_btshow && createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Heading Alignment', 'sonaar-music')
      }), !store_title_btshow && createElement(SelectControl, {
        options: sr_alignments,
        value: store_title_align,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            store_title_align: value
          });
          jQuery('#block-' + clientId + ' .iron-audioplayer .ctnButton-block').css({
            'justify-content': value,
            'align-items': value
          });
        }
      }), createElement('hr', {}), createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Links Alignment', 'sonaar-music')
      }), createElement(SelectControl, {
        options: sr_alignments,
        value: album_stores_align,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            album_stores_align: value
          });
          jQuery('#block-' + clientId + ' .iron-audioplayer .buttons-block').css({
            'justify-content': value,
            'align-items': value
          });
        }
      }), createElement(RangeControl, {
        label: __('Store Button Fontsize (px)', 'sonaar-music'),
        value: store_button_fontsize,
        min: 0,
        max: 100,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            store_button_fontsize: value
          });

          if (value > 0) {
            jQuery('#block-' + clientId + ' .iron-audioplayer a.button').css('font-size', value + 'px');
          } else {
            jQuery('#block-' + clientId + ' .iron-audioplayer a.button').css('font-size', '');
          }
        }
      }), createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Text Color', 'sonaar-music')
      }), createElement(ColorPalette, {
        label: __('Text Color', 'sonaar-music'),
        colors: colors,
        value: button_text_color,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            button_text_color: value
          });
          style_changes({
            button_text_color: value
          });
        }
      }), createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Button Color', 'sonaar-music')
      }), createElement(ColorPalette, {
        label: __('Button Color', 'sonaar-music'),
        colors: colors,
        value: background_color,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            background_color: value
          });
          style_changes({
            background_color: value
          });
        }
      }), createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Text Hover Color', 'sonaar-music')
      }), createElement(ColorPalette, {
        label: __('Text Hover Color', 'sonaar-music'),
        colors: colors,
        value: button_hover_color,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            button_hover_color: value
          });
          style_changes({
            button_hover_color: value
          });
        }
      }), createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Button Hover Color', 'sonaar-music')
      }), createElement(ColorPalette, {
        label: __('Button Hover Color', 'sonaar-music'),
        colors: colors,
        value: button_background_hover_color,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            button_background_hover_color: value
          });
          style_changes({
            button_background_hover_color: value
          });
        }
      }), createElement('hr', {}), createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Border Style', 'sonaar-music')
      }), createElement(SelectControl, {
        options: border_types,
        value: button_border_style,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            button_border_style: value
          });
          jQuery('#block-' + clientId + ' .buttons-block .store-list li .button').css('border-style', value);
        }
      }), button_border_style != 'none' && createElement(RangeControl, {
        label: __('Button Border Width (px)', 'sonaar-music'),
        value: button_border_width,
        min: 0,
        max: 50,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            button_border_width: value
          });
          jQuery('#block-' + clientId + ' .buttons-block .store-list li .button').css('border-width', value + 'px');
        }
      }), button_border_style != 'none' && createElement(ColorPalette, {
        label: __('Button Border Color', 'sonaar-music'),
        colors: colors,
        value: button_border_color,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            button_border_color: value
          });
          style_changes({
            button_border_color: value
          });
        }
      }), button_border_style != 'none' && createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Button Border Hover Color', 'sonaar-music')
      }), button_border_style != 'none' && createElement(ColorPalette, {
        label: __('Button Border Hover Color', 'sonaar-music'),
        colors: colors,
        value: button_hover_border_color,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            button_hover_border_color: value
          });
          style_changes({
            button_hover_border_color: value
          });
        }
      }), button_border_style != 'none' && createElement(RangeControl, {
        label: __('Button Radius (px)', 'sonaar-music'),
        value: button_border_radius,
        min: 0,
        max: 30,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            button_border_radius: value
          });
          jQuery('#block-' + clientId + ' .store-list .button').css('border-radius', value + 'px');
        }
      }), createElement('hr', {}), createElement(ToggleControl, {
        label: __('Hide Icon', 'sonaar-music'),
        checked: store_icon_show,
        onChange: function onChange(store_icon_hide) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            store_icon_show: store_icon_hide
          });

          if (store_icon_hide) {
            jQuery('#block-' + clientId + ' .iron-audioplayer .store-list .button i').hide();
          } else {
            jQuery('#block-' + clientId + ' .iron-audioplayer .store-list .button i').show();
          }
        }
      }), !store_icon_show && createElement(RangeControl, {
        label: __('Icon Font Size (px)', 'sonaar-music'),
        value: icon_font_size,
        min: 0,
        max: 100,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            icon_font_size: value
          });

          if (value > 0) {
            jQuery('#block-' + clientId + ' .iron-audioplayer .buttons-block .store-list i').css('font-size', value + 'px');
          } else {
            jQuery('#block-' + clientId + ' .iron-audioplayer .buttons-block .store-list i').css('font-size', '');
          }
        }
      }), !store_icon_show && createElement(RangeControl, {
        label: __('Icon Spacing (px)', 'sonaar-music'),
        value: icon_indent,
        min: 0,
        max: 50,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            icon_indent: value
          });
          jQuery('#block-' + clientId + ' .iron-audioplayer .buttons-block .store-list i').css('margin-right', value + 'px');
        }
      }), !store_icon_show && createElement(RangeControl, {
        label: __('Link Buttons Margin (px)', 'sonaar-music'),
        value: album_stores_padding,
        min: 0,
        max: 100,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            album_stores_padding: value
          });
          jQuery('#block-' + clientId + ' .iron-audioplayer.show-playlist .ctnButton-block').css('margin', value + 'px');
        }
      })), !playlist_show_soundwave && createElement(PanelBody, {
        title: __('Mini Player & Soundwave', 'sonaar-music'),
        initialOpen: false,
        className: show_pro_badge
      }, createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Background', 'sonaar-music')
      }), createElement(ColorPalette, {
        colors: colors,
        value: player_bg,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            player_bg: value
          });
          style_changes({
            player_bg: value
          });
        }
      }), createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Heading', 'sonaar-music')
      }), createElement(ToggleControl, {
        label: __('Hide Heading', 'sonaar-music'),
        checked: hide_player_title,
        onChange: function onChange(hide_player_title) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            hide_player_title: hide_player_title
          });
          ironAudioplayersLoaded = false;
          setIronAudioplayers;
          style_load = false;
        }
      }), run_pro && !hide_player_title && createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('HTML Heading Tag', 'sonaar-music')
      }), run_pro && !hide_player_title && createElement(SelectControl, {
        options: html_tags,
        value: title_html_tag_soundwave,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            title_html_tag_soundwave: value
          });
          var thisClass = jQuery('#block-' + clientId + ' .iron-audioplayer .track-title').attr('class');
          jQuery('#block-' + clientId + ' .iron-audioplayer .track-title').replaceWith('<' + value + ' class="' + thisClass + '">' + jQuery('#block-' + clientId + ' .iron-audioplayer .track-title').html() + '</' + value + '>');
        }
      }), !hide_player_title && createElement(RangeControl, {
        label: __('Heading Fontsize (px)', 'sonaar-music'),
        value: title_soundwave_fontsize,
        min: 0,
        max: 100,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            title_soundwave_fontsize: value
          });
          style_changes({
            title_soundwave_fontsize: value
          });
        }
      }), !hide_player_title && createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Heading Color', 'sonaar-music')
      }), !hide_player_title && createElement(ColorPalette, {
        label: __('Heading Color', 'sonaar-music'),
        colors: colors,
        value: title_soundwave_color,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            title_soundwave_color: value
          });
          style_changes({
            title_soundwave_color: value
          });
        }
      }), createElement('hr', {}), !hide_player_title && createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Soundwave', 'sonaar-music')
      }), createElement(ToggleControl, {
        label: __('Hide SoundWave', 'sonaar-music'),
        checked: soundwave_show,
        onChange: function onChange(hide_soundwave) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            soundwave_show: hide_soundwave
          });

          if (hide_soundwave) {
            jQuery('#block-' + clientId + ' .iron-audioplayer .sr_progressbar').hide();
          } else {
            jQuery('#block-' + clientId + ' .iron-audioplayer .sr_progressbar').show();
          }
        }
      }), player_layout == 'skin_float_tracklist' && !soundwave_show && createElement(ToggleControl, {
        label: __('Inline Progress Bar', 'sonaar-music'),
        checked: progressbar_inline,
        onChange: function onChange(progressbar_inline_show) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            progressbar_inline: progressbar_inline_show
          });

          if (progressbar_inline_show) {
            jQuery('#block-' + clientId + ' .iron-audioplayer .album-player .player').addClass('sr_player__inline');
          } else {
            jQuery('#block-' + clientId + ' .iron-audioplayer .album-player .player').removeClass('sr_player__inline');
          }
        }
      }), !soundwave_show && createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('SoundWave Progress Bar Color', 'sonaar-music')
      }), !soundwave_show && createElement(ColorPalette, {
        label: __('SoundWave Progress Bar Color', 'sonaar-music'),
        colors: colors,
        value: soundWave_progress_bar_color,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          setAttributes({
            soundWave_progress_bar_color: value
          });
          ironAudioplayersLoaded = false;
          setIronAudioplayers;
          style_load = false;
        }
      }), !soundwave_show && createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('SoundWave Background Color', 'sonaar-music')
      }), !soundwave_show && createElement(ColorPalette, {
        label: __('SoundWave Background Color', 'sonaar-music'),
        colors: colors,
        value: soundWave_bg_bar_color,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          setAttributes({
            soundWave_bg_bar_color: value
          });
          ironAudioplayersLoaded = false;
          setIronAudioplayers;
          style_load = false;
        }
      }), !soundwave_show && createElement('hr', {}), !soundwave_show && createElement(ToggleControl, {
        label: __('Hide Time Durations', 'sonaar-music'),
        checked: duration_soundwave_show,
        onChange: function onChange(duration_soundwave_hide) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            duration_soundwave_show: duration_soundwave_hide
          });

          if (duration_soundwave_hide) {
            jQuery('#block-' + clientId + ' .iron-audioplayer .currentTime').hide();
            jQuery('#block-' + clientId + ' .iron-audioplayer .totalTime').hide();
            jQuery('#block-' + clientId + ' .iron-audioplayer .sr_progressbar > .wave').css({
              'margin-left': 0,
              'margin-right': 0
            });
          } else {
            jQuery('#block-' + clientId + ' .iron-audioplayer .currentTime').show();
            jQuery('#block-' + clientId + ' .iron-audioplayer .totalTime').show();
            jQuery('#block-' + clientId + ' .iron-audioplayer .sr_progressbar > .wave').css({
              'margin-left': '10px',
              'margin-right': '10px'
            });
          }
        }
      }), !soundwave_show && !duration_soundwave_show && createElement(RangeControl, {
        label: __('Time Fontsize (px)', 'sonaar-music'),
        value: duration_soundwave_fontsize,
        min: 0,
        max: 100,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            duration_soundwave_fontsize: value
          });

          if (value > 0) {
            jQuery('#block-' + clientId + ' .iron-audioplayer .player').css('font-size', value + 'px');
          } else {
            jQuery('#block-' + clientId + ' .iron-audioplayer .player').css('font-size', '12px');
          }
        }
      }), !soundwave_show && !duration_soundwave_show && createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Time Color', 'sonaar-music')
      }), !soundwave_show && !duration_soundwave_show && createElement(ColorPalette, {
        label: __('Time Color', 'sonaar-music'),
        colors: colors,
        value: duration_soundwave_color,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            duration_soundwave_color: value
          });

          if (value != '' && value != undefined) {
            jQuery('#block-' + clientId + ' .iron-audioplayer .player').css('color', value);
          } else {
            jQuery('#block-' + clientId + ' .iron-audioplayer .player').css('color', 'inherit');
          }
        }
      }), createElement('hr', {}), createElement(RichText.Content, {
        tagName: 'label',
        className: 'components-base-control__label sonaar-block-label',
        value: __('Audio Player Controls Color', 'sonaar-music')
      }), createElement(ColorPalette, {
        label: __('Audio Player Controls Color', 'sonaar-music'),
        colors: colors,
        value: audio_player_controls_color,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            audio_player_controls_color: value
          });
          style_changes({
            audio_player_controls_color: value
          });
        }
      }), !progressbar_inline && createElement(RangeControl, {
        label: __('Audio Player Controls Space Before (px)', 'sonaar-music'),
        value: audio_player_controls_spacebefore,
        min: -500,
        max: 200,
        onChange: function onChange(value) {
          if (!run_pro) {
            openGoProModal();
            return;
          }

          is_style_loaded;
          setAttributes({
            audio_player_controls_spacebefore: value
          });
          jQuery('#block-' + clientId + ' .iron-audioplayer .player .control').css({
            'top': value + 'px',
            'position': 'relative'
          });
        }
      }), createElement(SelectControl, {
        label: __('Show Skip 15/30 seconds button', 'sonaar-music'),
        options: trueFalseDefault,
        value: show_skip_bt,
        onChange: function onChange(show_skip_bt) {
          setAttributes({
            show_skip_bt: show_skip_bt
          });
          ironAudioplayersLoaded = false;
          setIronAudioplayers;
          style_load = false;
        }
      }), createElement(SelectControl, {
        label: __('Show Shuffle button', 'sonaar-music'),
        options: trueFalseDefault,
        value: show_shuffle_bt,
        onChange: function onChange(show_shuffle_bt) {
          setAttributes({
            show_shuffle_bt: show_shuffle_bt
          });
          ironAudioplayersLoaded = false;
          setIronAudioplayers;
          style_load = false;
        }
      }), createElement(SelectControl, {
        label: __('Show Speed Lecture button (0.5x, 1x, 2x)', 'sonaar-music'),
        options: trueFalseDefault,
        value: show_speed_bt,
        onChange: function onChange(show_speed_bt) {
          setAttributes({
            show_speed_bt: show_speed_bt
          });
          ironAudioplayersLoaded = false;
          setIronAudioplayers;
          style_load = false;
        }
      }), createElement(SelectControl, {
        label: __('Show Volume button', 'sonaar-music'),
        options: trueFalseDefault,
        value: show_volume_bt,
        onChange: function onChange(show_volume_bt) {
          setAttributes({
            show_volume_bt: show_volume_bt
          });
          ironAudioplayersLoaded = false;
          setIronAudioplayers;
          style_load = false;
        }
      }))), createElement(serverSideRender, {
        block: 'sonaar/sonaar-block',
        attributes: (_attributes = {
          //Refresh widget in the block editor
          album_id: album_id,
          cat_id: cat_id,
          show_cat_description: show_cat_description,
          posts_per_page: posts_per_page,
          playlist_source: playlist_source,
          track_desc_lenght: track_desc_lenght,
          sr_player_on_artwork: sr_player_on_artwork,
          play_current_id: play_current_id,
          track_artwork_show: track_artwork_show
        }, _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0___default()(_attributes, "track_artwork_show", track_artwork_show), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0___default()(_attributes, "enable_sticky_player", enable_sticky_player), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0___default()(_attributes, "enable_shuffle", enable_shuffle), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0___default()(_attributes, "reverse_tracklist", reverse_tracklist), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0___default()(_attributes, "enable_scrollbar", enable_scrollbar), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0___default()(_attributes, "soundWave_progress_bar_color", soundWave_progress_bar_color), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0___default()(_attributes, "soundWave_bg_bar_color", soundWave_bg_bar_color), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0___default()(_attributes, "hide_trackdesc", hide_trackdesc), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0___default()(_attributes, "strip_html_track_desc", strip_html_track_desc), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0___default()(_attributes, "notrackskip", notrackskip), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0___default()(_attributes, "player_layout", player_layout), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0___default()(_attributes, "show_track_publish_date", show_track_publish_date), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0___default()(_attributes, "show_skip_bt", show_skip_bt), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0___default()(_attributes, "show_shuffle_bt", show_shuffle_bt), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0___default()(_attributes, "show_speed_bt", show_speed_bt), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0___default()(_attributes, "show_volume_bt", show_volume_bt), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0___default()(_attributes, "post_link", post_link), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0___default()(_attributes, "show_publish_date", show_publish_date), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0___default()(_attributes, "show_meta_duration", show_meta_duration), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0___default()(_attributes, "show_tracks_count", show_tracks_count), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0___default()(_attributes, "playlist_show_soundwave", playlist_show_soundwave), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0___default()(_attributes, "hide_player_title", hide_player_title), _attributes),
        httpMethod: 'POST'
      })];
    },
    save: function save() {
      return null; //save has to exist. This all we need
    }
  });
})(window.wp);

/***/ }),

/***/ "@wordpress/element":
/*!******************************************!*\
  !*** external {"this":["wp","element"]} ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = this["wp"]["element"]; }());

/***/ })

/******/ });
//# sourceMappingURL=index.js.map