'use strict';

$(document).ready(function () {
    $(document).on('click', '.add-curriculum-schema-items', function (event) {
        event.preventDefault();

        $('.curriculum-schema-items').toggleClass('hidden');
    });

});
