$(document).ready(function () {
    $(".gallery_row").magnificPopup({
        type: "image",
        delegate: "a",
        gallery: {
            enabled: true,
        },
    });
});
