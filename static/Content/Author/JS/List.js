$(document).ready(function(){
    var model_select =
        '<option value="id">ID</option>' +
        '<option value="name">Name</option>' +
        '<option value="type">Type</option>';
    $('#author-select').append(model_select);
    
    resizeList(120,60);
    LoadContent(false, 'author', ShowAuthors,1,50);
    
    // add event listener on input in search bars
    $(document).on("input", '.search', function(){
        removeItems('.content-row');
        $('#loading-circle').css('display','block');
        CheckSearch($('#author-select').val(),this.value,'author', ShowAuthors,50);
    });
    
    $(document).on('dblclick', '.delete-button-author', function(){
        response = prompt('Do you want to delete this y/n ?', '');
        if (response === 'n') {
            return false;
        } else if (response === 'y') {
            $.ajax({url: "/author/delete/" + $(this).attr('id'), type: "POST"}).then(function(){
                removeItems('.content-row');
                removeItems('.content-values');
                LoadContent(false, 'author', ShowAuthors,$('#current-number').val(),50);
            });
        }
    });
    
    $(document).on('click', '.content-row', function(){
        paintRow($(this).attr("id"));
    });
    ////////////////////////////navigation bar//////////////////////////////////////////
    LoadNavigationBar('single','author',ShowAuthors);
});
//function to show categories
function ShowAuthors(response) {
    str = '<div class="quark-presence-container presence-block content-row" id="author-values-' + response.id + '">' +
        '<div class="content-values quark-presence-column ids" id="id">' + response.id + '</div>' +
        '<div class="content-values quark-presence-column names" id="name">' + response.name.substr(0, 70)  + '</div>' +
        '<div class="content-values quark-presence-column types" id="type">' + response.type + '</div>' +
        '<div class="content-values quark-presence-column keywords" id="content">' + response.keywords.substr(0, 100) + '</div>' +
        '<div class="content-values quark-presence-column actions" id="actions">' + setActions(response.id,'author') + '</div>' +
        '</div>';
    $("#list-content").append(str);
    $('#loading-circle').css('display','none');
}