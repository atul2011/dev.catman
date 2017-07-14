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
    
    $(document).on('dblclick', '.delete-button-news', function(){
        response = prompt('Do you want to delete this y/n ?', '');
        if (response === 'n') {
            return false;
        } else if (response === 'y') {
            $.ajax({url: "/admin/news/delete/" + $(this).attr('id').split('-')[2], type: "POST"}).then(function(){
                removeItems('.content-row');
                removeItems('.content-values');
                LoadContent(false, 'news', ShowNews,$('#current-number').val(),50);
            });
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
        '<div class="content-values quark-presence-column ids" id="item-id-' + response.id + '">' + response.id + '</div>' +
        '<div class="content-values quark-presence-column titles" id="item-title-' + response.id + '">' + response.title.substr(0, 70)  + '</div>' +
        '<div class="content-values quark-presence-column types" id="item-type-' + response.id + '">' + response.type + '</div>' +
        '<div class="content-values quark-presence-column contents" id="item-content-' + response.id + '">' + '<textarea rows="3" cols="30" class="content quark-input" readonly>' + response.text.substr(0, 200) + '</textarea>' + '</div>' +
        '<div class="content-values quark-presence-column users" id="item-user-' + response.id + '">' + response.lastediteby_userid.id + '</div>' +
        '<div class="content-values quark-presence-column dates" id="item-date-' + response.id + '">' + response.lastedited_date + '</div>' +
        '<div class="content-values quark-presence-column actions" id="item-actions-' + response.id + '">' + setActions(response.id,'news') + '</div>' +
        '</div>';
    $("#list-content").append(str);
    $('#loading-circle').css('display','none');
}