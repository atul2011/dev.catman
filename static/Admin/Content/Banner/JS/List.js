$(document).ready(function(){
    var fields =
        '<option value="id">ID</option>' +
        '<option value="active">Active</option>';
    $('#banner-select').append(fields);
    resizeList(120,63);
    LoadContent(false, 'banner', ShowBanners,1,50,'single');
    // add event listener on input in search bars
    $(document).on("input", '.search', function(){
        removeItems('.content-row');
        $('#loading-circle').css('display','block');
        CheckSearch($('#banner-select').val(),this.value,'banner', ShowBanners,50,'single');
    });
    $(document).on('dblclick', '.delete-button-banner', function(){
        response = prompt('Do you want to delete this y/n ?', '');
        if (response === 'n') {
            return false;
        } else if (response === 'y') {
            $.ajax({url: "/admin/banner/delete/" + $(this).attr('id').split('-')[2], type: "POST"}).then(function(){
                removeItems('.content-row');
                removeItems('.content-values');
                LoadContent(false, 'banner', ShowBanners,$('#current-number').val(),50);
            });
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