$(document).ready(function(){
    resizeList(130, 131);//set height of list and width of search-bar

    $(document).on('click', '.content-row', function(){
        paintRow($(this).attr("id"),'');
    });

});

$(document).on('click', '.content-values.priorities', function () {
    $(this).attr('contenteditable', 'true');
});

$(document).on('keypress', '.content-values.priorities', function (e) {
    var item = $(this);
    if (isNaN(String.fromCharCode(e.which))) e.preventDefault();

    if (e.keyCode == 13) {
        $.ajax({url:'/admin/link/edit/' + item.attr('item-id'), type:'POST', data:{'priority' : item.html()}}).then(function (data) {
            window.location.replace(window.location.href);
        });
    }
});