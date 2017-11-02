$(document).ready(function(){
    var fields =
        '<option value="id">ID</option>' +
        '<option value="title">Title</option>' +
        '<option value="release_date">Release Date</option>' +
        '<option value="event_id">Event</option>' +
        '<option value="author_id">Author</option>' +
        '<option value="keywords">Keywords</option>';
    $('#article-select').append(fields);
    resizeList(120, 236);
    LoadContent(false, 'article', ShowArticles,1,50,'single');

    // add event listener on input in search bars
    $(document).on("keydown", '.search', function(e){
        if (e.keyCode === 13) {
            removeItems('.content-row');
            $('#loading-circle').css('display','block');
            CheckSearch($('#article-select').val(),this.value,'article',ShowArticles,50,'single');
        }
    });

    //add event listener to checkbox "no parents"
    $(document).on("change", ".orfan", function(){
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
    str = '<div class="quark-presence-container presence-block content-row" id="article-values-' + response.id + '">' +
        '<div class="content-values quark-presence-column ids">' + response.id + '</div>' +
        '<div class="content-values quark-presence-column titles">' + response.title.substr(0, 50) + '</div>' +
        '<div class="content-values quark-presence-column dates">' + response.release_date + '</div>' +
        '<div class="content-values quark-presence-column events">' + response.event_id.name + '</div>' +
        '<div class="content-values quark-presence-column contents">' + '<textarea rows="3" cols="30" class="content quark-input" readonly>' + response.txtfield.substr(0, 200) + '</textarea>' + '</div>' +
        '<div class="content-values quark-presence-column actions">' + setActions(response.id, 'article') + '</div>' +
        '</div>';
    $("#list-content").append(str);
    $('#loading-circle').css('display','none');
}