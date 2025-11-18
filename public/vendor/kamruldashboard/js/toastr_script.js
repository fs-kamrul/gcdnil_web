class kamruldashboard {

    constructor() {

    }

    static unblockUI(target) {
        if (target) {
            $(target).unblock({
                onUnblock: () => {
                    $(target).css('position', '');
                    $(target).css('zoom', '');
                }
            });
        } else {
            $.unblockUI();
        }
    }

    static blockUI(options) {
        options = $.extend(true, {}, options);
        let html = '';
        if (options.animate) {
            html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '') + '">' + '<div class="block-spinner-bar"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>' + '</div>';
        } else if (options.iconOnly) {
            html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '') + '"><img src="/vendor/kamruldashboard/images/loading-spinner-blue.gif" alt="loading"></div>';
        } else if (options.textOnly) {
            html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '') + '"><span>&nbsp;&nbsp;' + (options.message ? options.message : 'LOADING...') + '</span></div>';
        } else {
            html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '') + '"><img src="/vendor/kamruldashboard/images/loading-spinner-blue.gif" alt="loading"><span>&nbsp;&nbsp;' + (options.message ? options.message : 'LOADING...') + '</span></div>';
        }

        if (options.target) { // element blocking
            let el = $(options.target);
            // console.log(el);
            if (el.height() <= $(window).height()) {
                options.cenrerY = true;
            }
            el.block({
                message: html,
                baseZ: options.zIndex ? options.zIndex : 1000,
                centerY: options.cenrerY !== undefined ? options.cenrerY : false,
                css: {
                    top: '10%',
                    border: '0',
                    padding: '0',
                    backgroundColor: 'none'
                },
                overlayCSS: {
                    backgroundColor: options.overlayColor ? options.overlayColor : '#555555',
                    opacity: options.boxed ? 0.05 : 0.1,
                    cursor: 'wait'
                }
            });
        } else { // page blocking
            $.blockUI({
                message: html,
                baseZ: options.zIndex ? options.zIndex : 1000,
                css: {
                    border: '0',
                    padding: '0',
                    backgroundColor: 'none'
                },
                overlayCSS: {
                    backgroundColor: options.overlayColor ? options.overlayColor : '#555555',
                    opacity: options.boxed ? 0.05 : 0.1,
                    cursor: 'wait'
                }
            });
        }
    }
    static showNotice(messageType, message, messageHeader = '') {
        toastr.clear();

        toastr.options = {
            closeButton: true,
            positionClass: 'toast-bottom-right',
            onclick: null,
            showDuration: 1000,
            hideDuration: 1000,
            timeOut: 10000,
            extendedTimeOut: 1000,
            showEasing: 'swing',
            hideEasing: 'linear',
            showMethod: 'fadeIn',
            hideMethod: 'fadeOut'
        };
        //
        if (!messageHeader) {
            switch (messageType) {
                case 'error':
                    messageHeader = 'Error!';
                    break;
                case 'success':
                    messageHeader = 'Success!';
                    break;
            }
        }
        toastr[messageType](message, messageHeader);
    }
    static showSuccess(message, messageHeader = '') {
        this.showNotice('success', message, messageHeader);
    }
    static showError(message, messageHeader = '') {
        this.showNotice('error', message, messageHeader);
    }

    static handleError(data) {
        if (typeof (data.errors) !== 'undefined' && !_.isArray(data.errors)) {
            kamruldashboard.handleValidationError(data.errors);
        } else {
            if (typeof (data.responseJSON) !== 'undefined') {
                if (typeof (data.responseJSON.errors) !== 'undefined') {
                    if (data.status === 422) {
                        kamruldashboard.handleValidationError(data.responseJSON.errors);
                    }
                } else if (typeof (data.responseJSON.message) !== 'undefined') {
                    kamruldashboard.showError(data.responseJSON.message);
                } else {
                    $.each(data.responseJSON, (index, el) => {
                        $.each(el, (key, item) => {
                            kamruldashboard.showError(item);
                        });
                    });
                }
            } else {
                kamruldashboard.showError(data.statusText);
            }
        }
    }
    static handleValidationError(errors) {
        let message = '';
        $.each(errors, (index, item) => {
            message += item + '<br />';

            let $input = $('*[name="' + index + '"]');
            if ($input.closest('.next-input--stylized').length) {
                $input.closest('.next-input--stylized').addClass('field-has-error');
            } else {
                $input.addClass('field-has-error');
            }

            let $input_array = $('*[name$="[' + index + ']"]');

            if ($input_array.closest('.next-input--stylized').length) {
                $input_array.closest('.next-input--stylized').addClass('field-has-error');
            } else {
                $input_array.addClass('field-has-error');
            }
        });
        kamruldashboard.showError(message);
    }
    static callScroll(obj) {
        obj.mCustomScrollbar({
            theme: 'dark',
            scrollInertia: 0,
            callbacks: {
                whileScrolling: function () {
                    obj.find('.tableFloatingHeaderOriginal').css({
                        'top': -this.mcs.top + 'px'
                    });
                }
            }
        });

        obj.stickyTableHeaders({scrollableArea: obj, 'fixedOffset': 2});
    }

    static initDatePicker(element) {
        if (jQuery().bootstrapDP) {
            let format = $(document).find(element).data('date-format');
            if (!format) {
                format = 'yyyy-mm-dd';
            }
            $(document).find(element).bootstrapDP({
                maxDate: 0,
                changeMonth: true,
                changeYear: true,
                autoclose: true,
                dateFormat: format,
            });
        }
    }
    static initResources() {

        if (jQuery().select2) {
            $.each($(document).find('.select-multiple'), function (index, element) {
                let options = {
                    width: '100%',
                    allowClear: true,
                };

                let parent = $(element).closest('.modal');
                if (parent.length) {
                    options.dropdownParent = parent;
                }

                $(element).select2(options);
            });

            $.each($(document).find('.select-search-full'), function (index, element) {
                let options = {
                    width: '100%',
                };

                let parent = $(element).closest('.modal');
                if (parent.length) {
                    options.dropdownParent = parent;
                }

                $(element).select2(options);
            });

            $.each($(document).find('.select-full'), function (index, element) {
                let options = {
                    width: '100%',
                    minimumResultsForSearch: -1
                };

                let parent = $(element).closest('.modal');
                if (parent.length) {
                    options.dropdownParent = parent;
                }

                $(element).select2(options);
            });

            $('select[multiple].select-sorting').on('select2:select', function (evt) {
                const $element = $(evt.params.data.element);

                $element.detach();
                $(this).append($element);
                $(this).trigger('change');
            });

            $.each($(document).find('.select-search-ajax'), function (index, element) {
                if ($(element).data('url')) {
                    let options = {
                        placeholder: $(element).data('placeholder') || '--Select--',
                        minimumInputLength: $(element).data('minimum-input') || 1,
                        width: '100%',
                        delay: 250,
                        ajax: {
                            url: $(element).data('url'),
                            dataType: 'json',
                            type: $(element).data('type') || 'GET',
                            quietMillis: 50,
                            data: function (params) {
                                // Query parameters will be ?search=[term]&page=[page]
                                return {
                                    search: params.term,
                                    page: params.page || 1
                                };
                            },
                            processResults: function (response) {
                                /**
                                 * response {
                                 *  error: false
                                 *  data: {},
                                 *  message: ''
                                 * }
                                 */
                                return {
                                    results: $.map(response.data, function (item) {
                                        return Object.assign(
                                            {
                                                text: item.name,
                                                id: item.id
                                            },
                                            item
                                        );
                                    }),
                                    pagination: {
                                        more: response.links
                                            ? response.links.next
                                            : null
                                    }
                                };
                            },
                            cache: true
                        },
                        allowClear: true
                    };

                    let parent = $(element).closest('.modal');
                    if (parent.length) {
                        options.dropdownParent = parent;
                    }

                    $(element).select2(options);
                }
            });
        }

        if (jQuery().timepicker) {
            if (jQuery().timepicker) {

                $('.timepicker-default').timepicker({
                    autoclose: true,
                    showSeconds: false,
                    minuteStep: 1,
                    defaultTime: false
                });

                $('.timepicker-24').timepicker({
                    autoclose: true,
                    minuteStep: 5,
                    showSeconds: false,
                    showMeridian: false,
                    defaultTime: false
                });
            }
        }

        if (jQuery().inputmask) {
            $.each($(document).find('.input-mask-number'), function (index, element) {
                $(element).inputmask({
                    alias: 'numeric',
                    rightAlign: false,
                    digits: $(element).data('digits') ?? 5,
                    groupSeparator: $(element).data('thousands-separator') ?? ',',
                    radixPoint: $(element).data('decimal-separator') ?? '.',
                    digitsOptional: true,
                    placeholder: '0',
                    autoGroup: true,
                    autoUnmask: true,
                    removeMaskOnSubmit: true,
                });
            });
        }

        if (jQuery().colorpicker) {
            $('.color-picker').colorpicker({
                inline: false,
                container: true,
                format: 'hex',
                extensions: [
                    {
                        name: 'swatches',
                        options: {
                            colors: {
                                'tetrad1': '#000000',
                                'tetrad2': '#000000',
                                'tetrad3': '#000000',
                                'tetrad4': '#000000'
                            },
                            namesAsValues: false
                        }
                    }
                ]
            })
                .on('colorpickerChange colorpickerCreate', function (e) {
                    var colors = e.color.generate('tetrad');

                    colors.forEach(function (color, i) {
                        var colorStr = color.string(),
                            swatch = e.colorpicker.picker
                                .find('.colorpicker-swatch[data-name="tetrad' + (i + 1) + '"]');

                        swatch
                            .attr('data-value', colorStr)
                            .attr('title', colorStr)
                            .find('> i')
                            .css('background-color', colorStr);
                    });
                });
        }

        if (jQuery().fancybox) {
            $('.iframe-btn').fancybox({
                width: '900px',
                height: '700px',
                type: 'iframe',
                autoScale: false,
                openEffect: 'none',
                closeEffect: 'none',
                overlayShow: true,
                overlayOpacity: 0.7
            });

            $('.fancybox').fancybox({
                openEffect: 'none',
                closeEffect: 'none',
                overlayShow: true,
                overlayOpacity: 0.7,
                helpers: {
                    media: {}
                }
            });
        }

        if (jQuery().tooltip) {
            $('[data-bs-toggle="tooltip"]').tooltip({placement: 'top', boundary: 'window'});
        }

        if (jQuery().areYouSure) {
            $('form').areYouSure();
        }

        kamruldashboard.initDatePicker('.datepicker');
        if (jQuery().mCustomScrollbar) {
            kamruldashboard.callScroll($('.list-item-checkbox'));
        }

        if (jQuery().textareaAutoSize) {
            $('textarea.textarea-auto-height').textareaAutoSize();
        }

        $('.select2_google_fonts_picker').each(function (i, obj) {
            if (!$(obj).hasClass('select2-hidden-accessible')){
                $(obj).select2({
                    templateResult: function (opt) {
                        if (!opt.id) {
                            return opt.text;
                        }
                        return $('<span style="font-family:\'' + opt.id + '\';"> ' + opt.text + '</span>');
                    },
                })
            }
        });

        document.dispatchEvent(new CustomEvent('core-init-resources'));
    }
}

$(document).ready(() => {
    new kamruldashboard();
    window.kamruldashboard = kamruldashboard;
});
