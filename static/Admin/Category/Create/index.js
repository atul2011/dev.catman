$(document).ready(function() {
    $(document).on("submit", '#item-form', function (e) {
        $('#form-item-content').val($('#editor-container .ql-editor').html());
    });

    var quill_editor = new Quill('#editor-container', {//quill
        modules: {
            toolbar: '#toolbar-container'
        },
        placeholder: 'Insert some text',
        theme: 'snow'
    });
});