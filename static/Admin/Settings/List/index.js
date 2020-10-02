$(document).ready(function(){
    var fields =
        '<option value="id">ID</option>' +
        '<option value="setting_description">Setting Description</option>' +
        '<option value="setting_value">Setting Value</option>';
    $('#term-select').append(fields);

    resizeList(130, 177);//set height of list and width of search-bar

    LoadContent(false, 'settings', ShowSettings, 1, 50, 'single');

    $(document).on("keydown", '.search', function(e){// add settings listener on input in search bars
        if (e.keyCode === 13) {
            removeItems('.content-row');
            $('#loading-circle').css('display','block');
            CheckSearch($('#term-select').val(),this.value, 'settings', ShowSettings,50,'single');
        }
    });

    $(document).on('click', '.content-row', function(){
        paintRow($(this).attr("id"),'');
    });
    ////////////////////////////navigation bar//////////////////////////////////////////
    LoadNavigationBar('single', 'settings', ShowSettings);
});
//function to show categories
function ShowSettings(response) {
    str = '<div class="quark-presence-container presence-block content-row" id="settings-values-' + response.id + '">' +
        '<div class="content-values quark-presence-column ids">' + response.id + '</div>' +
        '<div class="content-values quark-presence-column names">' + response.setting_description.substr(0, 70)  + '</div>' +
        '<div class="content-values quark-presence-column actions">' + setActions_nodelete(response.id, 'settings') + '</div>' +
        '</div>';
    $("#list-content").append(str);
    $('#loading-circle').css('display','none');
}
