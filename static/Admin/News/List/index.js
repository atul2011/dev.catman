$(document).ready(function(){
    var fields ='<option value="id">ID</option>' +
                '<option value="title">Title</option>' +
                '<option value="type">Type</option>'+
                '<option value="lastediteby_userid">UserId</option>';
    $('#news-select').append(fields);
    
    resizeList(130, 168);//set height of list and width of search-bar

    LoadContent(false, 'news', ShowNews,1,50,'single');

    $(document).on("keydown", '.search', function(e){// add event listener on input in search bars
        if (e.keyCode === 13) {
            removeItems('.content-row');
            $('#loading-circle').css('display','block');
            CheckSearch($('#news-select').val(), this.value,'news', ShowNews,50,'single');
        }
    });

    $(document).on('click', '.content-row', function(){
        paintRow($(this).attr("id"),'');
    });
    ////////////////////////////navigation bar//////////////////////////////////////////
    LoadNavigationBar('single','news',ShowNews);
});
//function to show categories
function ShowNews(response) {
    var str =
        '<div class="quark-presence-container presence-block content-row" id="news-values-' + response.id + '">' +
            '<div class="content-values quark-presence-column ids">' + response.id + '</div>' +
            '<div class="content-values quark-presence-column titles">' + response.title.substr(0, 100)  + '</div>' +
            '<div class="content-values quark-presence-column types">' + response.type + '</div>' +
            '<div class="content-values quark-presence-column users">' + response.lastediteby_userid.id + '</div>' +
            '<div class="content-values quark-presence-column dates">' + response.publish_date + '</div>' +
            '<div class="content-values quark-presence-column actions">' + setActions(response.id, 'news') + '</div>' +
        '</div>';

    $("#list-content").append(str);
    $('#loading-circle').css('display','none');
}