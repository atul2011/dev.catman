$(document).ready(function(){
    var fields ='<option value="id">ID</option>' +
                '<option value="title">Name</option>' +
                '<option value="type">Type</option>'+
                '<option value="lastediteby_userid">UserId</option>';
    $('#news-select').append(fields);
    
    resizeList(120,60);
    LoadContent(false, 'news', ShowNews,1,50,'single');
    
    // add event listener on input in search bars
    $(document).on("input", '.search', function(){
        removeItems('.content-row');
        $('#loading-circle').css('display','block');
        CheckSearch($('#news-select').val(),this.value,'news', ShowNews,50,'single');
    });
    
    $(document).on('dblclick', '.delete-button-news', function(e){
        response = prompt('Do you want to delete this y/n ?', '');
        if (response === 'n') {
            e.preventDefault();
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
    str = '<div class="quark-presence-container presence-block content-row" id="news-values-' + response.id + '">' +
        '<div class="content-values quark-presence-column ids">' + response.id + '</div>' +
        '<div class="content-values quark-presence-column titles">' + response.title.substr(0, 70)  + '</div>' +
        '<div class="content-values quark-presence-column types">' + response.type + '</div>' +
        '<div class="content-values quark-presence-column contents">' + '<textarea rows="3" cols="30" class="content quark-input" readonly>' + response.text.substr(0, 200) + '</textarea>' + '</div>' +
        '<div class="content-values quark-presence-column users">' + response.lastediteby_userid.id + '</div>' +
        '<div class="content-values quark-presence-column dates">' + response.lastedited_date + '</div>' +
        '<div class="content-values quark-presence-column actions">' + setActions(response.id,'news') + '</div>' +
        '</div>';
    $("#list-content").append(str);
    $('#loading-circle').css('display','none');
}