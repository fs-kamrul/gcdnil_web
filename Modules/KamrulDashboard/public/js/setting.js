/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!****************************************!*\
  !*** ./Resources/assets/js/setting.js ***!
  \****************************************/
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
var SettingManagement = /*#__PURE__*/function () {
  function SettingManagement() {
    _classCallCheck(this, SettingManagement);
  }
  _createClass(SettingManagement, [{
    key: "init",
    value: function init() {
      var _this = this;
      this.handleMultipleAdminEmails();
      $('input[data-key=email-config-status-btn]').on('change', function (event) {
        var _self = $(event.currentTarget);
        var key = _self.prop('id');
        var url = _self.data('change-url');
        $.ajax({
          type: 'POST',
          url: url,
          data: {
            key: key,
            value: _self.prop('checked') ? 1 : 0
          },
          success: function success(res) {
            if (!res.error) {
              kamruldashboard.showSuccess(res.message);
            } else {
              kamruldashboard.showError(res.message);
            }
          },
          error: function error(res) {
            kamruldashboard.handleError(res);
          }
        });
      });
      $(document).on('change', '.setting-select-options', function (event) {
        $('.setting-wrapper').addClass('hidden');
        $('.setting-wrapper[data-type=' + $(event.currentTarget).val() + ']').removeClass('hidden');
      });
      $('.send-test-email-trigger-button').on('click', function (event) {
        event.preventDefault();
        var _self = $(event.currentTarget);
        var defaultText = _self.text();
        _self.text(_self.data('saving'));
        $.ajax({
          type: 'POST',
          url: route('settings.email.edit'),
          data: _self.closest('form').serialize(),
          success: function success(res) {
            if (!res.error) {
              kamruldashboard.showSuccess(res.message);
              $('#send-test-email-modal').modal('show');
            } else {
              kamruldashboard.showError(res.message);
            }
            _self.text(defaultText);
          },
          error: function error(res) {
            kamruldashboard.handleError(res);
            _self.text(defaultText);
          }
        });
      });
      $('#send-test-email-btn').on('click', function (event) {
        event.preventDefault();
        var _self = $(event.currentTarget);
        _self.addClass('button-loading');
        $.ajax({
          type: 'POST',
          url: route('setting.email.send.test'),
          data: {
            email: _self.closest('.modal-content').find('input[name=email]').val()
          },
          success: function success(res) {
            if (!res.error) {
              kamruldashboard.showSuccess(res.message);
            } else {
              kamruldashboard.showError(res.message);
            }
            _self.removeClass('button-loading');
            _self.closest('.modal').modal('hide');
          },
          error: function error(res) {
            kamruldashboard.handleError(res);
            _self.removeClass('button-loading');
            _self.closest('.modal').modal('hide');
          }
        });
      });
      $('.generate-thumbnails-trigger-button').on('click', function (event) {
        event.preventDefault();
        var _self = $(event.currentTarget);
        var defaultText = _self.text();
        _self.text(_self.data('saving'));
        $.ajax({
          type: 'POST',
          url: route('settings.media.post'),
          data: _self.closest('form').serialize(),
          success: function success(res) {
            if (!res.error) {
              $('#generate-thumbnails-modal').modal('show');
            } else {
              kamruldashboard.showError(res.message);
            }
            _self.text(defaultText);
          },
          error: function error(res) {
            kamruldashboard.handleError(res);
            _self.text(defaultText);
          }
        });
      });
      $('#generate-thumbnails-button').on('click', function (event) {
        event.preventDefault();
        var _self = $(event.currentTarget);
        _self.addClass('button-loading');
        $.ajax({
          type: 'POST',
          url: route('settings.media.generate-thumbnails'),
          success: function success(res) {
            if (!res.error) {
              kamruldashboard.showSuccess(res.message);
            } else {
              kamruldashboard.showError(res.message);
            }
            _self.removeClass('button-loading');
            _self.closest('.modal').modal('hide');
          },
          error: function error(res) {
            kamruldashboard.handleError(res);
            _self.removeClass('button-loading');
            _self.closest('.modal').modal('hide');
          }
        });
      });
      if (typeof CodeMirror !== 'undefined') {
        kamruldashboard.initCodeEditor('mail-template-editor');
      }
      $(document).on('click', '.btn-trigger-reset-to-default', function (event) {
        event.preventDefault();
        $('#reset-template-to-default-button').data('target', $(event.currentTarget).data('target'));
        $('#reset-template-to-default-modal').modal('show');
      });
      $(document).on('click', '.js-select-mail-variable', function (event) {
        event.preventDefault();
        var $this = $(event.currentTarget);
        var doc = $('.CodeMirror')[0].CodeMirror;
        var key = '{{ ' + $this.data('key') + ' }}';

        // If there's a selection, replace the selection.
        if (doc.somethingSelected()) {
          doc.replaceSelection(key);
          return;
        }

        // Otherwise, we insert at the cursor position.
        var cursor = doc.getCursor();
        var pos = {
          line: cursor.line,
          ch: cursor.ch
        };
        doc.replaceRange(key, pos);
      });
      $(document).on('click', '.js-select-mail-function', function (event) {
        event.preventDefault();
        var $this = $(event.currentTarget);
        var CodeMirror = $('.CodeMirror')[0].CodeMirror;
        var key = $this.data('sample');

        // If there's a selection, replace the selection.
        if (CodeMirror.somethingSelected()) {
          CodeMirror.replaceSelection(key);
          return;
        }

        // Otherwise, we insert at the cursor position.
        var cursor = CodeMirror.getCursor();
        var position = {
          line: cursor.line,
          ch: cursor.ch
        };
        CodeMirror.replaceRange(key, position);
      });
      $(document).on('click', '#reset-template-to-default-button', function (event) {
        event.preventDefault();
        var _self = $(event.currentTarget);
        _self.addClass('button-loading');
        $.ajax({
          type: 'POST',
          cache: false,
          url: _self.data('target'),
          data: {
            email_subject_key: $('input[name=email_subject_key]').val(),
            module: $('input[name=module]').val(),
            template_file: $('input[name=template_file]').val()
          },
          success: function success(res) {
            if (!res.error) {
              kamruldashboard.showSuccess(res.message);
              setTimeout(function () {
                window.location.reload();
              }, 1000);
            } else {
              kamruldashboard.showError(res.message);
            }
            _self.removeClass('button-loading');
            $('#reset-template-to-default-modal').modal('hide');
          },
          error: function error(res) {
            kamruldashboard.handleError(res);
            _self.removeClass('button-loading');
          }
        });
      });
      $(document).on('change', '.check-all', function (event) {
        var _self = $(event.currentTarget);
        var set = _self.attr('data-set');
        var checked = _self.prop('checked');
        $(set).each(function (index, el) {
          if (checked) {
            $(el).prop('checked', true);
          } else {
            $(el).prop('checked', false);
          }
        });
      });
      $('input.setting-selection-option').each(function (index, el) {
        var $settingContentContainer = $($(el).data('target'));
        $(el).on('change', function () {
          if ($(el).val() == '1') {
            $settingContentContainer.removeClass('d-none');
            kamruldashboard.initResources();
          } else {
            $settingContentContainer.addClass('d-none');
          }
        });
      });
      $(document).on('click', '.cronjob #copy-command', function () {
        _this.copyCommand();
      });
    }
  }, {
    key: "handleMultipleAdminEmails",
    value: function handleMultipleAdminEmails() {
      var $wrapper = $('#admin_email_wrapper');
      if (!$wrapper.length) {
        return;
      }
      var $addBtn = $wrapper.find('#add');
      var max = parseInt($wrapper.data('max'), 10);
      var emails = $wrapper.data('emails');
      if (emails.length === 0) {
        emails = [''];
      }
      var onAddEmail = function onAddEmail() {
        var count = $wrapper.find('input[type=email]').length;
        if (count >= max) {
          $addBtn.addClass('disabled');
        } else {
          $addBtn.removeClass('disabled');
        }
      };
      var addEmail = function addEmail() {
        var value = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';
        return $addBtn.before("<div class=\"d-flex mt-2 more-email align-items-center\">\n                <input type=\"email\" class=\"next-input\" placeholder=\"".concat($addBtn.data('placeholder'), "\" name=\"admin_email[]\" value=\"").concat(value ? value : '', "\" />\n                <a class=\"btn btn-link text-danger\"><i class=\"fa fa-minus\"></i></a>\n            </div>"));
      };
      var render = function render() {
        emails.forEach(function (email) {
          addEmail(email);
        });
        onAddEmail();
      };
      $wrapper.on('click', '.more-email > a', function () {
        $(this).parent('.more-email').remove();
        onAddEmail();
      });
      $addBtn.on('click', function (e) {
        e.preventDefault();
        addEmail();
        onAddEmail();
      });
      render();
    }
  }]);
  return SettingManagement;
}();
$(document).ready(function () {
  new SettingManagement().init();
});
/******/ })()
;