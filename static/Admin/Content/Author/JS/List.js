$(document).ready(function(){
    var fields =
        '<option value="id">ID</option>' +
        '<option value="name">Name</option>' +
        '<option value="type">Type</option>';
    $('#author-select').append(fields);
    
    resizeList(120,60);
    LoadContent(false, 'author', ShowAuthors,1,50,'single');
    
    // add event listener on input in search bars
    $(document).on("keydown", '.search', function(e){
        if (e.keyCode === 13) {
            removeItems('.content-row');
            $('#loading-circle').css('display','block');
            CheckSearch($('#author-select').val(),this.value,'author', ShowAuthors,50,'single');
        }
    });

    $(document).on('click', '.content-row', function(){
        paintRow($(this).attr("id"),'');
    });

    ////////////////////////////navigation bar//////////////////////////////////////////
    LoadNavigationBar('single','author',ShowAuthors);
});
//function to show categories
function ShowAuthors(response) {
    str = '<div class="quark-presence-container presence-block content-row" id="author-values-' + response.id + '">' +
        '<div class="content-values quark-presence-column ids">' + response.id + '</div>' +
        '<div class="content-values quark-presence-column names">' + response.name.substr(0, 70)  + '</div>' +
        '<div class="content-values quark-presence-column types">' + response.type + '</div>' +
        '<div class="content-values quark-presence-column keywords">' + response.keywords.substr(0, 100) + '</div>' +
        '<div class="content-values quark-presence-column actions">' + setActions(response.id,'author') + '</div>' +
        '</div>';
    $("#list-content").append(str);
    $('#loading-circle').css('display','none');
}