$(document).ready(function(){
    var fields =
        '<option value="id">ID</option>' +
        '<option value="title">Title</option>' +
        '<option value="first_letter">First Letter</option>';
    $('#term-select').append(fields);

    resizeList(130, 177);//set height of list and width of search-bar

    LoadContent(false, 'term', ShowTerms, 1, 50, 'single');

    $(document).on("keydown", '.search', function(e){// add term listener on input in search bars
        if (e.keyCode === 13) {
            removeItems('.content-row');
            $('#loading-circle').css('display','block');
            CheckSearch($('#term-select').val(),this.value, 'term', ShowTerms,50,'single');
        }
    });

    $(document).on('click', '.content-row', function(){
        paintRow($(this).attr("id"),'');
    });
    ////////////////////////////navigation bar//////////////////////////////////////////
    LoadNavigationBar('single', 'term', ShowTerms);
});
//function to show categories
function ShowTerms(response) {
    str = '<div class="quark-presence-container presence-block content-row" id="term-values-' + response.id + '">' +
        '<div class="content-values quark-presence-column ids">' + response.id + '</div>' +
        '<div class="content-values quark-presence-column names">' + response.title.substr(0, 70)  + '</div>' +
        '<div class="content-values quark-presence-column actions">' + setActions(response.id, 'term') + '</div>' +
        '</div>';
    $("#list-content").append(str);
    $('#loading-circle').css('display','none');
}