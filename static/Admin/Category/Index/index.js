$(document).ready(function(){
    $(document).on("submit",'#item-form',function(e){
        var title =$('#item-title');

        if(title.val()=== '') {
            title.addClass('title_null').attr('placeholder', 'Title must be not null');
            e.preventDefault();
        }
    });


    $(document).on("submit", '#item-form', function (e) {
        $('#form-item-content').val($('#content-container .ql-editor').html());
    });

    var quill_editor = new Quill('#editor-container', {//quill
        modules: {
            toolbar: '#toolbar-container'
        },
        placeholder: 'Insert some text',
        theme: 'snow'
    });
});

$(document).on('click', '#cm-form-button-add-tag', function () {
    var tag = $('#cm-form-tag-input');

    $.ajax({url:"/admin/category/tag/link/" + $('#cm-category-id').val(), type:"POST", data:{tag:tag.val()}}).then(function (data) {
        if (data.status === 200)
            $('#cm-form-tag-container').append('<button type="button" class="quark-button block cm-button-tag cm-button-sub-item-action" action="/admin/category/tag/unlink/' + data.link.id + '">' + data.tag.name  + ' <a class="fa fa-close"></a></button>');

        tag.val('');
    });
});