$(document).ready(function () {
    let languageTable = $('.table-language');

    languageTable.on('click', '.delete-locale-button', event => {
        event.preventDefault();

        $('.delete-crud-entry').data('url', $(event.currentTarget).data('url'));
        $('.modal-confirm-delete').modal('show');
    });

    $(document).on('click', '.delete-crud-entry', event => {
        event.preventDefault();
        $('.modal-confirm-delete').modal('hide');

        let deleteURL = $(event.currentTarget).data('url');
        $(this).prop('disabled', true).addClass('button-loading');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrf_token
            }
        });
        $.ajax({
            url: deleteURL,
            type: 'DELETE',
            success: data => {
                if (data.error) {
                    kamruldashboard.showError(data.message);
                } else {
                    if (data.data) {
                        languageTable.find('i[data-locale=' + data.data + ']').unwrap();
                        $('.tooltip').remove();
                    }
                    languageTable.find('a[data-url="' + deleteURL + '"]').closest('tr').remove();
                    kamruldashboard.showSuccess(data.message);
                }
                $(this).prop('disabled', false).removeClass('button-loading');
            },
            error: data => {
                $(this).prop('disabled', false).removeClass('button-loading');
                kamruldashboard.handleError(data);
            }
        });
    });

    $(document).on('click', '.add-locale-form button[type=submit]', function (event) {
        event.preventDefault();
        event.stopPropagation();
        $(this).prop('disabled', true).addClass('button-loading');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrf_token
            }
        });
        $.ajax({
            type: 'POST',
            cache: false,
            url: $(this).closest('form').prop('action'),
            data: new FormData($(this).closest('form')[0]),
            contentType: false,
            processData: false,
            success: res => {
                if (!res.error) {
                    kamruldashboard.showSuccess(res.message);
                    languageTable.load(window.location.href + ' .table-language > *');
                } else {
                    kamruldashboard.showError(res.message);
                }

                $(this).prop('disabled', false).removeClass('button-loading');
            },
            error: res => {
                $(this).prop('disabled', false).removeClass('button-loading');
                kamruldashboard.handleError(res);
            }
        });
    });
});
