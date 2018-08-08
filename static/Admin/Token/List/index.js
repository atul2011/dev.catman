$(document).ready(function(){
    resizeList(130, 174);//set height of list and width of search-bar

    LoadContent(false, 'token', ShowTokens, 0, 0,'single');

    $(document).on('click', '.content-row', function(){
        paintRow($(this).attr("id"), '');
    });
});
//function to show categories
function ShowTokens(response) {
    var str = '<div class="quark-presence-container presence-block content-row">' +
        '<div class="content-values quark-presence-column ids">' + response.id + '</div>' +
        '<div class="content-values quark-presence-column tokens">' + response.token  + '</div>' +
        '<div class="content-values quark-presence-column creates">' + response.created + '</div>' +
        '<div class="content-values quark-presence-column actions">' + setActions(response.id, 'token') + '</div>' +
        '</div>';
    $("#list-content").append(str);
    $('#loading-circle').css('display','none');
}