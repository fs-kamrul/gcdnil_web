class Newsletter_submit {
    init() {
        $(document).on('click', '.newsletter_submit_btn', event =>  {
            event.preventDefault();
            let email = $('#email').val();
            // let newsletter_agree = $('#newsletter_agree').is(':checked');
            let _self = $(event.currentTarget);
            _self.addClass('button-loading');
            $.ajax({
                url: _self.data('url'),
                type: 'POST',
                // data: {
                //     type: _self.data('type'),
                // },
                data: {
                    email: email,
                    // newsletter_agree: newsletter_agree,
                    course_id: _self.data('course')
                },
                success: data =>  {
                    if (!data.error) {
                        kamruldashboard.showSuccess(data.message);
                    } else {
                        kamruldashboard.showError(data.message);
                    }
                    _self.removeClass('button-loading');

                    // _self.removeClass('button-loading');
                    // // console.log(data);
                    // var obj = jQuery.parseJSON( data );
                    // if (obj.errors || obj.error) {
                    //     console.log(obj.message);
                    //     kamruldashboard.showError(obj.message);
                    // } else {
                    //     kamruldashboard.showSuccess(obj.message);
                    // }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status === 422) {
                        var errors = jqXHR.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            if(key == 'email') {
                                $.each(value, function (index, message) {
                                    // console.log(message);
                                    kamruldashboard.showError(message);
                                    _self.removeClass('button-loading');
                                    // messages = message;
                                });
                            }
                        });
                    }
                }
            });
        });
    }
}

$(document).ready(() => {
    new Newsletter_submit().init();
});
