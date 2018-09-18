$(document).ready(function () {
    $('#editor-container').summernote();
});

$(document).on("submit", '#item-form', function (e) {
    $('#form-item-content').val($('#editor-container .ql-editor').html());
});