$(document).ready(function(){
    var fields =
        '<option value="id">ID</option>' +
        '<option value="name">Name</option>' +
        '<option value="startdate">Start Date</option>';
    $('#event-select').append(fields);
    resizeList(120,83);
    LoadContent(false, 'event', ShowEvents,1,50,'single');

    $(document).on("keydown", '.search', function(e){// add event listener on input in search bars
        if (e.keyCode === 13) {
            removeItems('.content-row');
            $('#loading-circle').css('display','block');
            CheckSearch($('#event-select').val(),this.value,'event', ShowEvents,50,'single');
        }
    });

    $(document).on('click', '.content-row', function(){
        paintRow($(this).attr("id"),'');
    });
    ////////////////////////////navigation bar//////////////////////////////////////////
    LoadNavigationBar('single','event',ShowEvents);
});
//function to show categories
function ShowEvents(response) {
    str = '<div class="quark-presence-container presence-block content-row" id="event-values-' + response.id + '">' +
        '<div class="content-values quark-presence-column ids">' + response.id + '</div>' +
        '<div class="content-values quark-presence-column names">' + response.name.substr(0, 70)  + '</div>' +
        '<div class="content-values quark-presence-column dates">' + response.startdate + '</div>' +
        '<div class="content-values quark-presence-column actions">' + setActions(response.id,'event') + '</div>' +
        '</div>';
    $("#list-content").append(str);
    $('#loading-circle').css('display','none');
}