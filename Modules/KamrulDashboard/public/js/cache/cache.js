class CacheManagement {
    init() {
        $(document).on('click', '.btn-clear-cache', event =>  {
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
                type: 'POST',
                data: {
                    type: _self.data('type'),
                },
                success: data =>  {
                    _self.removeClass('button-loading');

                    if (data.error) {
                        kamruldashboard.showError(data.message);
                    } else {
                        kamruldashboard.showSuccess(data.message);
                    }
                },
                error: data =>  {
                    kamruldashboard.showError(data.message);
                    _self.removeClass('button-loading');
                    // console.log(data.message)
                }
            });
        });
    }
}

$(document).ready(() => {
    new CacheManagement().init();
});
