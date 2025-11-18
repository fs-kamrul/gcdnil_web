(function ($) {
    "use strict"

/*******************
Sweet-alert JS
*******************/

    document.querySelector(".sweet-ajax").onclick = function () {
        // swal({
        //     title: "Sweet ajax request !!",
        //     text: "Submit to run ajax request !!",
        //     type: "info",
        //     showCancelButton: !0,
        //     closeOnConfirm: !1,
        //     showLoaderOnConfirm: !0
        // }, function () {
        //     setTimeout(function () {
        //         swal("Hey, your ajax request finished !!")
        //     }, 2e3)
        // })
        Swal.fire({
            title: 'Submit your Github username',
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Look up',
            showLoaderOnConfirm: true,
            preConfirm: (login) => {
                return fetch(`//api.github.com/users/${login}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText)
                        }
                        return response.json()
                    })
                    .catch(error => {
                        Swal.showValidationMessage(
                            `Request failed: ${error}`
                        )
                    })
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: `${result.value.login}'s avatar`,
                    imageUrl: result.value.avatar_url
                })
            }
        })
    };

})(jQuery);
