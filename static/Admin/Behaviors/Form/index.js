//clear all items from left-table
function removeItems(selector){
    $(selector).remove();
}

function setImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('.cm-form-photo').attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

$(document).on('click', '.cm-button-sub-item-action', function (e) {
    e.preventDefault();

    var item = $(this);
    var url = $(this).attr('action');

    $.ajax({url:url, type:'Get'}).then(function (data) {
        if (data.status === 200)
            item.remove();
    });
});

function LinkPhoto(model, model_id, photo_id, selector) {
    $.ajax({url:'/admin/' + model +'/photo/link/' + model_id, type:"POST", data:{photo:photo_id}}).then(function (data) {
        if (data.status === 200) {
            selector.remove();
            var str = '<button type="button" class="cm-button-photo cm-button-sub-item-action" title="Link photo to this ' + model +'" action="/admin/' + model +'/photo/unlink/' + data.link.id + '">' +
                '<img src="' + data.photo.file + '" class="cm-form-related-photo" >' +
                '</button>';

            $('#cm-form-linked-photo-container').append(str);
        }
    });
}

function DragEndEvent (parent1) {}

function DropEvent (parent1, parent2, item) {}


function FindDropableParent(item) {
    for (var i=0; i < 1000; i++)
        if (item.attr('data-draggable') === 'target')
            return item;
        else
            item = item.parent();
}