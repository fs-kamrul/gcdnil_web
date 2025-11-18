class ThemeManagement {
    init() {
        $(document).on('click', '.btn-trigger-active-theme', event =>  {
            event.preventDefault();
            let _self = $(event.currentTarget);
            _self.addClass('button-loading');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrf_token
                }
            });
            $.ajax({
                // url: route('theme.active'),
                url: url_theme_active,
                data: {
                    'theme': _self.data('theme')
                },
                type: 'POST',
                success: data =>  {
                    if (data.error) {
                        kamruldashboard.showError(data.message);
                    } else {
                        kamruldashboard.showSuccess(data.message);
                        window.location.reload();
                    }
                    _self.removeClass('button-loading');
                },
                error: data =>  {
                    kamruldashboard.showError(data.message);
                    _self.removeClass('button-loading');
                }
            });
        });

        $(document).on('click', '.btn-trigger-remove-theme', event =>  {
            event.preventDefault();
            $('#confirm-remove-theme-button').data('theme', $(event.currentTarget).data('theme'));
            $('#remove-theme-modal').modal('show');
        });

        $(document).on('click', '#confirm-remove-theme-button', event =>  {
            event.preventDefault();
            let _self = $(event.currentTarget);
            _self.addClass('button-loading');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrf_token
                }
            });
            $.ajax({
                // url: route('theme.remove', {theme: _self.data('theme')}),
                url: url_theme_remove,
                data: {
                    'theme': _self.data('theme')
                },
                type: 'POST',
                success: data =>  {
                    if (data.error) {
                        kamruldashboard.showError(data.message);
                    } else {
                        kamruldashboard.showSuccess(data.message);
                        window.location.reload();
                    }
                    _self.removeClass('button-loading');
                    $('#remove-theme-modal').modal('hide');
                },
                error: data =>  {
                    kamruldashboard.showError(data.message);
                    _self.removeClass('button-loading');
                    $('#remove-theme-modal').modal('hide');
                }
            });
        });
        $(document).on('click', '.btn-trigger-clear-cache', event =>  {
            event.preventDefault();
            let _self = $(event.currentTarget);
            _self.addClass('button-loading');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrf_token
                }
            });
            $.ajax({
                url: _self.data('url'),
                data: {
                    'theme': _self.data('theme')
                },
                type: 'GET',
                success: data => {
                    _self.removeClass('button-loading');
                    _self.closest('.modal').modal('hide');

                    if (data.error) {
                        kamruldashboard.showError(data.message);
                    } else {
                        kamruldashboard.showSuccess(data.message);
                    }
                },
                error: data => {
                    _self.removeClass('button-loading');
                    kamruldashboard.handleError(data);
                }
            });
        });
    }
}

$(document).ready(() => {
    new ThemeManagement().init();
});
