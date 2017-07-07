$(document).ready(function(){
    var model_select =
        '<option value="id">ID</option>' +
        '<option value="title">Title</option>' +
        '<option value="release_date">Release Date</option>' +
        '<option value="event_id">Event</option>' +
        '<option value="author_id">Author</option>' +
        '<option value="keywords">Keywords</option>';
    $('#article-select').append(model_select);
    resizeList(120, 236);
    LoadContent(false, 'article', ShowArticles,1,50,'single');
    // add event listener on input in search bars
    $(document).on("input", '.search', function(){
        removeItems('.content-row');
        $('#loading-circle').css('display','block');
        CheckSearch($('#article-select').val(),this.value,'article',ShowArticles,50,'single');
    });
    
    //add event listener to checkbox "no parents"
    $(document).on("change", ".orfan", function(){
        removeItems('.content-row');
        $('#loading-circle').css('display','block');
        noParents($(this).is(':checked'), $(this).attr('id'), ShowArticles,50,'single');
    });
    
    $(document).on('dblclick', '.delete-button-article', function(e){
        response = prompt('Do you want to delete this y/n ?', '');
        if (response === 'n') {
            e.preventDefault();
        } else if (response === 'y') {
            $.ajax({url: "/admin/article/delete/" + $(this).attr('id'), type: "POST",data:{type_of_delete:'all'}}).then(function(){
                removeItems('.content-row');
                removeItems('.content-values');
                LoadContent(false, 'article', ShowArticles,$('#current-number').val(),50);
            });
        }
    });
    $(document).on('click', '.content-row', function(){
        paintRow($(this).attr("id"),'');
    });
    ////////////////////////////navigation bar//////////////////////////////////////////
    LoadNavigationBar('single','article',ShowArticles);
});
//fucntion to show the articles
function ShowArticles(response){
    str = '<div class="quark-presence-container presence-block content-row" id="article-values-' + response.id + '">' +
        '<div class="content-values quark-presence-column ids" id="id">' + response.id + '</div>' +
        '<div class="content-values quark-presence-column titles" id="title">' + response.title.substr(0, 50) + '</div>' +
        '<div class="content-values quark-presence-column dates" id="date">' + response.release_date + '</div>' +
        '<div class="content-values quark-presence-column events" id="event">' + response.event_id.name + '</div>' +
        '<div class="content-values quark-presence-column contents" id="content">' + '<textarea rows="3" cols="30" class="content quark-input" readonly>' + response.txtfield.substr(0, 200) + '</textarea>' + '</div>' +
        '<div class="content-values quark-presence-column actions" id="actions">' + setActions(response.id, 'article') + '</div>' +
        '</div>';
    $("#list-content").append(str);
    $('#loading-circle').css('display','none');
}