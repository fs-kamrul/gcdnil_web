jQuery(document).ready(function() {

    // var HelloButton = function (context) {
    //     var ui = $.summernote.ui;
    //
    //     // create button
    //     var button = ui.button({
    //         contents: '<i class="fa fa-child"/> Hello',
    //         tooltip: 'hello',
    //         click: function () {
    //             // invoke insertText method with 'hello' on editor module.
    //             context.invoke('editor.insertText', '[hello][/hello]');
    //         }
    //     });
    //
    //     return button.render();   // return button as jquery object
    // }
    // var ParametrosButton = function (context) {
    //
    //     var ui = $.summernote.ui;
    //     var list = $('#elements-list').val();
    //
    //     var button = ui.buttonGroup([
    //         ui.button({
    //             className: 'dropdown-toggle',
    //             contents: '<span class="fa fa-database"></span> Parámetros <span class="caret"></span>',
    //             tooltip: "Parámetros disponibles",
    //             data: {
    //                 toggle: 'dropdown'
    //             },
    //             click: function() {
    //
    //                 context.invoke('editor.saveRange');
    //             }
    //         }),
    //         ui.dropdown({
    //             items: JSON.parse(list),
    //             callback: function (items) {
    //                 $(items).find('li a').on('click', function(){
    //                     context.invoke("editor.insertText", $(this).html());
    //                     // $('#summernote').summernote('insertText', 'hit ');
    //                 })
    //             }
    //         })
    //     ]);
    //     return button.render();   // return button as jquery object
    // }
    $(".summernote").summernote({
        height: 190,
        minHeight: null,
        maxHeight: null,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['fontsize', ['fontsize']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview']],
            ['help', ['help']],
            ['mybutton', ['ParametrosB']]
        ],
        focus: !1,
        buttons: {
            // hello: HelloButton,
            // ParametrosB: ParametrosButton
        }
    }), $(".inline-editor").summernote({
        airMode: !0
    });

}), window.edit = function() {
    $(".click2edit").summernote()
}, window.save = function() {
    $(".click2edit").summernote("destroy")
};
