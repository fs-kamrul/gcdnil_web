/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!***********************************************!*\
  !*** ./Resources/assets/js/payment-detail.js ***!
  \***********************************************/


$(function () {
  $(document).on('click', '.get-refund-detail', function (e) {
    e.preventDefault();
    var $this = $(e.currentTarget);
    $.ajax({
      type: 'GET',
      cache: false,
      url: $this.data('url'),
      beforeSend: function beforeSend() {
        $this.find('i').addClass('fa-spin');
      },
      success: function success(res) {
        if (!res.error) {
          $($this.data('element')).html(res.data);
        } else {
          kamruldashboard.showError(res.message);
        }
      },
      error: function error(res) {
        kamruldashboard.handleError(res);
      },
      complete: function complete() {
        $this.find('i').removeClass('fa-spin');
      }
    });
  });
});
/******/ })()
;