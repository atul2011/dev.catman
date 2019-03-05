$(document).ready(function(){
    var fields =
        '<option value="id">ID</option>' +
        '<option value="title">Title</option>' +
        '<option value="release_date">Release Date</option>' +
        '<option value="event_id">Event</option>' +
        '<option value="author_id">Author</option>' +
        '<option value="keywords">Keywords</option>';
    $('#article-select').append(fields);

    resizeList(130, 281);//set height of list and width of search-bar

    LoadContent(false, 'article', ShowArticles, 1, 50, 'single');

    $(document).on("keydown", '.search', function(e){// add event listener on input in search bars
        if (e.keyCode === 13) {
            removeItems('.content-row');
            $('#loading-circle').css('display','block');
            CheckSearch($('#article-select').val(),this.value,'article',ShowArticles,50,'single');
        }
    });

    $(document).on("change", ".orfan", function() {//add event listener to checkbox "no parents"
        removeItems('.content-row');
        $('#loading-circle').css('display','block');
        noParents($(this).is(':checked'), $(this).attr('id').split('-')[0], ShowArticles,50,'single');
    });

    $(document).on('click', '.content-row', function(){
        paintRow($(this).attr("id"),'');
    });
    ////////////////////////////navigation bar//////////////////////////////////////////
    LoadNavigationBar('single','article',ShowArticles);
});
//fucntion to show the articles
function ShowArticles(response){
    var event_name = response.event_id !== null ? response.event_id.name : '';
    var str = '<div class="quark-presence-container presence-block content-row" id="article-values-' + response.id + '">' +
        '<div class="content-values quark-presence-column ids">' + response.id + '</div>' +
        '<div class="content-values quark-presence-column titles">' + response.title.substr(0, 50) + '</div>' +
        '<div class="content-values quark-presence-column dates">' + response.release_date + '</div>' +
        '<div class="content-values quark-presence-column events">' + event_name + '</div>' +
        '<div class="content-values quark-presence-column actions">' +
            '<a class="fa fa-pencil actions edit-button-article content-actions " id="edit-article -' + response.id + '" href="/admin/article /edit/' + response.id + '" title="Article Edit"></a>' +
            '<a class="fa fa-trash actions delete-button-article content-actions item-remove-dialog" quark-dialog="#item-remove" quark-redirect="/admin/article/list/"  id="delete-article-' + response.id + '" href="/admin/article/delete/' + response.id + '" title="Article Delete"></a>'+
            '<a class="fa fa-chain actions content-actions" href="/admin/link/list/article/' + response.id + '" title="Article Links"></a>'+
        '</div>' +
        '</div>';
    $("#list-content").append(str);
    $('#loading-circle').css('display','none');
}