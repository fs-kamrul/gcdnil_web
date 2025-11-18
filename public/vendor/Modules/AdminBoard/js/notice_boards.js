/******/ (() => { // webpackBootstrap
/*!**********************************************!*\
  !*** ./Resources/assets/js/notice_boards.js ***!
  \**********************************************/
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(a, n) { if (!(a instanceof n)) throw new TypeError("Cannot call a class as a function"); }
function _defineProperties(e, r) { for (var t = 0; t < r.length; t++) { var o = r[t]; o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(e, _toPropertyKey(o.key), o); } }
function _createClass(e, r, t) { return r && _defineProperties(e.prototype, r), t && _defineProperties(e, t), Object.defineProperty(e, "prototype", { writable: !1 }), e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var NoticeBoardJs = /*#__PURE__*/function () {
  function NoticeBoardJs() {
    _classCallCheck(this, NoticeBoardJs);
    // Initialization logic, e.g., set up any default values if needed
    this.categoryId = '';
    this.searchQuery = '';
  }

  // Initialize the event listeners for search and filter
  return _createClass(NoticeBoardJs, [{
    key: "init",
    value: function init() {
      var _this = this;
      // Bind event listeners
      $('#searchBox').on('keyup', function () {
        return _this.searchNotices();
      });
      $('#filterDropdown').on('change', function () {
        return _this.filterNotices();
      });
    }

    // Function to filter notices by category
  }, {
    key: "filterNotices",
    value: function filterNotices() {
      this.categoryId = $('#filterDropdown').val();
      this.searchQuery = $('#searchBox').val();

      // Trigger AJAX request to get filtered data
      this.fetchNotices(this.categoryId, this.searchQuery);
    }

    // Function to search notices by input text
  }, {
    key: "searchNotices",
    value: function searchNotices() {
      this.searchQuery = $('#searchBox').val();
      this.categoryId = $('#filterDropdown').val();

      // Trigger AJAX request to get filtered data
      this.fetchNotices(this.categoryId, this.searchQuery);
    }

    // AJAX function to request filtered notices
  }, {
    key: "fetchNotices",
    value: function fetchNotices() {
      var categoryId = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';
      var searchQuery = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';
      $.ajax({
        url: '/noticeboard/filter',
        // The route where the request will be sent
        type: 'POST',
        data: {
          category_id: categoryId,
          search_query: searchQuery,
          _token: $('meta[name="csrf-token"]').attr('content') // Use CSRF token
        },
        success: function success(response) {
          // console.log(response.html);
          // Update the notice board with the filtered data
          $('#noticesContainer').empty().html(response.data);
          $('#noticesContainer_pagination').empty();
        },
        error: function error(xhr, status, _error) {
          console.error('Error fetching notices:', _error);
        }
      });
    }
  }]);
}(); // Instantiate and initialize the NoticeBoardJs class when the DOM is ready
$(document).ready(function () {
  var noticeBoardJs = new NoticeBoardJs();
  noticeBoardJs.init();
});
/******/ })()
;