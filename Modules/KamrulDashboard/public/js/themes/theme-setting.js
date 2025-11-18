$(document).ready(() => {

    $(document).ready(function () {
        $(document).on('click', '.button-save-theme-options', event => {
            event.preventDefault();
            let _self = $(event.currentTarget);
            _self.addClass('button-loading');

            if (typeof tinymce != 'undefined') {
                for (var instance in tinymce.editors) {
                    if (tinymce.editors[instance].getContent) {
                        $('#' + instance).html(tinymce.editors[instance].getContent());
                    }
                }
            }

            let $form = _self.closest('form');

            $.ajax({
                url: $form.prop('action'),
                type: 'POST',
                data: $form.serialize(),
                success: data => {
                    _self.removeClass('button-loading');

                    if (data.error) {
                        kamruldashboard.showError(data.message);
                    } else {
                        kamruldashboard.showSuccess(data.message);
                        $form.removeClass('dirty');
                    }
                },
                error: data => {
                    _self.removeClass('button-loading');
                    kamruldashboard.handleError(data);
                }
            });
        });
    });

});
