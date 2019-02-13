$(document).on('click', '#cm-form-button-add-tag', function () {
    var tag = $('#cm-form-tag-input');

    $.ajax({url:"/admin/photo/tag/link/" + $('#cm-photo-id').val(), type:"POST", data:{tag:tag.val()}}).then(function (data) {
        if (data.status === 200)
            $('#cm-form-tag-container').append('<button type="button" class="quark-button block cm-button-tag cm-button-sub-item-action" action="/admin/photo/tag/unlink/' + data.link.id + '">' + data.tag.name  + ' <a class="fa fa-close"></a></button>');

        tag.val('');
    });
});
