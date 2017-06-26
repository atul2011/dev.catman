$(document).ready(function(){
<<<<<<< HEAD
    resizeList(120,130);
    LoadContent(false, 'article', ShowArticles);
    // add event listener on input in search bars
    $(document).on("input", '.search', function(){
        CheckSearch(this.value, 'article', 'title',ShowArticles,50);
    });
    //add event listener to checkbox "no parents"
    $(document).on("change", ".orfan", function(){
        noParents($(this).is(':checked'), $(this).attr('id'), ShowArticles);
    });
=======
    var model_select =
        '<option value="id">ID</option>' +
        '<option value="title">Title</option>' +
        '<option value="release_date">Release Date</option>' +
        '<option value="event_id">Event</option>' +
        '<option value="author_id">Author</option>' +
        '<option value="keywords">Keywords</option>';
    $('#article-select').append(model_select);
    resizeList(120, 236);
    LoadContent(false, 'article', ShowArticles,1,50);
    
    // add event listener on input in search bars
    $(document).on("input", '.search', function(){
        removeItems('.content-row');
        $('#loading-circle').css('display','block');
        CheckSearch($('#article-select').val(),this.value,'article',ShowArticles,50);
    });
    
    //add event listener to checkbox "no parents"
    $(document).on("change", ".orfan", function(){
        noParents($(this).is(':checked'), $(this).attr('id'), ShowArticles,'none');
    });
    
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
    $(document).on('dblclick', '.delete-button-article', function(){
        response = prompt('Do you want to delete this y/n ?', '');
        if (response === 'n') {
            return false;
        } else if (response === 'y') {
            $.ajax({url: "/article/delete/" + $(this).attr('id'), type: "POST"}).then(function(){
                removeItems('.content-row');
                removeItems('.content-values');
<<<<<<< HEAD
                LoadContent(false, 'article', ShowArticles);
            });
    
=======
                LoadContent(false, 'article', ShowArticles,1,50);
            });
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
        }
    });
    $(document).on('click', '.content-row', function(){
        paintRow($(this).attr("id"));
    });
<<<<<<< HEAD
=======
    ////////////////////////////navigation bar//////////////////////////////////////////
    LoadNavigationBar('article',ShowArticles);

>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
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
<<<<<<< HEAD
=======
    $('#loading-circle').css('display','none');
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
}