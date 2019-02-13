$(document).ready(function(){
    ////////////////////////////navigation bar//////////////////////////////////////////
    LoadNavigationBar('single', 'photo', ShowPhotos);

    LoadContentAsCards('photo', ShowPhotos, $('#current-number').val(), 50, '.list-item');

    $(document).on("keydown", '.search', function(e){// add event listener on input in search bars
        if (e.keyCode === 13) {
            removeItems('.content-row');
            $('#loading-circle').css('display','block');
            CheckSearch('tag', this.value, 'photo', ShowPhotos, 50, 'single');
        }
    });

    $(document).on('click', '.content-row', function(){
        paintRow($(this).attr("id"),'');
    });
    ResizeContainers();//set size of list
});

function ShowPhotos(response) {//function to show categories
    var response_string =
        '<div class="quark-presence-column list-item">' +
            '<div class="quark-presence-container">' +
                '<div><img class="list-item-photo" src="' + response.file + '"></div>' +
            '<br />'+
                '<div class="quark-presence-container list-item-actions">' +
                    '<a class="list-item-link action-icons item-remove-dialog fa-close fa" href="/admin/photo/delete/' +  response.id + '"   quark-dialog="#item-remove" sl-redirect="/admin/photo/list/" title="Delete"></a>' +
                    '<a class="list-item-link action-icons fa-pencil fa" href="/admin/photo/edit/' + response.id+ '" title="Details"></a>' +
                '</div>' +
            '</div>' +
        '</div>';
    $("#photo-list").append(response_string);
    $('#loading-circle').css('display','none');
}

//             Card List

$(window).on('resize', function () {
    ResizeContainers();
});

function ResizeContainers() {
    $('.list-body, .search').css('width', ($(document).width() - $('#presence-menu-side-parent').width())*0.9);
}
function DialogWindow () {
    var remove = new Quark.Controls.Dialog('.item-remove-dialog', {
        success: function(trigger, dialog){
            trigger.parents('.list-item').remove();

            var redirect = trigger.attr('quark-redirect');

            if (redirect)
                setTimeout(function(){
                    window.location.href = redirect
                }, 1000);
        }
    });
}