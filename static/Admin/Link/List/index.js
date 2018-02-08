$(document).ready(function(){
    resizeList(130, 131);//set height of list and width of search-bar

    $(document).on('click', '.content-row', function(){
        paintRow($(this).attr("id"),'');
    });

});