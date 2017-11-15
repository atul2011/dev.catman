$(document).ready(function(){
    var fields =
        '<option value="id">ID</option>' +
        '<option value="active">Active</option>';
    $('#banner-select').append(fields);

    resizeList(130,173);//set height of list and width of search-bar

    LoadContent(false, 'banner', ShowBanners,1,50,'single');

    $(document).on("keydown", '.search', function(e){// add event listener on input in search bars
        if (e.keyCode === 13) {
            removeItems('.content-row');
            $('#loading-circle').css('display','block');
            CheckSearch($('#banner-select').val(),this.value,'banner', ShowBanners,50,'single');
        }
    });

    $(document).on('click', '.content-row', function(){
        paintRow($(this).attr("id"),'');
    });
    ////////////////////////////navigation bar//////////////////////////////////////////
    LoadNavigationBar('single','banner',ShowBanners);
});
//function to show categories
function ShowBanners(response) {
    str = '<div class="quark-presence-container presence-block content-row" id="banner-values-' + response.id + '">' +
        '<div class="content-values quark-presence-column ids">' + response.id + '</div>' +
        '<div class="content-values quark-presence-column files">' +
            '<img class="banner-image" src="' + response.file + '">' +
        '</div>' +
        '<div class="content-values quark-presence-column actions">' + setActions(response.id,'banner') + '</div>' +
        '</div>';
    $("#list-content").append(str);
    $('#loading-circle').css('display','none');
}