$(document).ready(function(){
    $('#editor-container, .editor-container').summernote();//SUMMERNOTE

    var available_on_site = $('#cm-item-available_on_site');
    var available_on_api = $('#cm-item-available_on_api');
    var master = $('#cm-item-master');

    available_on_site.prop('checked', available_on_site.val() == 1);
    available_on_api.prop('checked', available_on_api.val() == 1);
    master.prop('checked', master.val() == 1);

    var remove = new Quark.Controls.Dialog('.item-remove-dialog', {
        success: function(trigger, dialog){
            trigger.parents('.content-row').remove();

            var redirect = trigger.attr('quark-redirect');

            if (redirect)
                setTimeout(function(){
                    window.location.href = redirect
                }, 1000);
        }
    });//remove dialog window
});

$(document).on('click', '#cm-form-button-add-tag', function () {
    var tag = $('#cm-form-tag-input');

    $.ajax({url:"/admin/category/tag/link/" + $('#cm-category-id').val(), type:"POST", data:{tag:tag.val()}}).then(function (data) {
        if (data.status === 200)
            $('#cm-form-tag-container').append('<button type="button" class="quark-button block cm-button-tag cm-button-sub-item-action" action="/admin/category/tag/unlink/' + data.link.id + '">' + data.tag.name  + ' <a class="fa fa-close"></a></button>');

        tag.val('');
    });
});