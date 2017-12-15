$(document).ready(function () {
    $(document).on("input", '#item-event', function () {
        removeItems('#eventlist');
        CheckSearch(this.value, 'event', 'name', 5, 'eventlist');
    });

    $(document).on("input", '#item-author', function () {
        removeItems('#authorlist');
        CheckSearch(this.value, 'author', 'name', 5, 'authorlist');
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

function CheckSearch(str, model, name, limit, listname) {//function to check when you want to find items
    var url = '/admin/' + model + '/search?' + name + '=' + str;
    var string = '';
    if (limit !== 0) url += '&limit=' + limit;
    //if not to search in DB items by inserted string
    $.ajax({
        url: url, type: 'POST', data: {
            field: name, value: str
        }
    }).then(
        function (json) {
            if (json.response !== '') {
                string = '<datalist id="' + listname + '">';
                json.response.forEach(function (json) {
                    string += '<option value="' + json.name + '">';
                });
                string += '</datalist>';
                $('#' + model + '-field').append(string);
            }
        }
    );
}

$(document).on('click', '#cm-form-button-add-tag', function () {
    var tag = $('#cm-form-tag-input');

    $.ajax({url:"/admin/article/tag/link/" + $('#cm-article-id').val(), type:"POST", data:{tag:tag.val()}}).then(function (data) {
        if (data.status === 200)
            $('#cm-form-tag-container').append('<button type="button" class="quark-button block cm-button-tag cm-button-sub-item-action" href="/admin/article/tag/unlink/' + data.link.id + '">' + data.tag.name  + ' <a class="fa fa-close"></a></button>');

        tag.val('');
    });
});