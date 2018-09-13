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

// $(document).on('click', '.script-additional', function () {
//     pasteHtmlAtCaret('<h6 class="new-line"></h6>');
//
// });
//
// function pasteHtmlAtCaret(html) {
//     var sel, range;
//     if (window.getSelection) {
//         // IE9 and non-IE
//         sel = window.getSelection();
//         if (sel.getRangeAt && sel.rangeCount) {
//             range = sel.getRangeAt(0);
//             range.deleteContents();
//
//             // Range.createContextualFragment() would be useful here but is
//             // non-standard and not supported in all browsers (IE9, for one)
//             var el = document.createElement("div");
//             el.innerHTML = html;
//             var frag = document.createDocumentFragment(), node, lastNode;
//             while ( (node = el.firstChild) ) {
//                 lastNode = frag.appendChild(node);
//             }
//             range.insertNode(frag);
//
//             // Preserve the selection
//             if (lastNode) {
//                 range = range.cloneRange();
//                 range.setStartAfter(lastNode);
//                 range.collapse(true);
//                 sel.removeAllRanges();
//                 sel.addRange(range);
//             }
//         }
//     } else if (document.selection && document.selection.type != "Control") {
//         // IE < 9
//         document.selection.createRange().pasteHTML(html);
//     }
// }