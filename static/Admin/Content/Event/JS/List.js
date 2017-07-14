$(document).ready(function(){
    var fields =
        '<option value="id">ID</option>' +
        '<option value="name">Name</option>' +
        '<option value="startdate">Start Date</option>';
    $('#event-select').append(fields);
    resizeList(120,83);
    LoadContent(false, 'event', ShowEvents,1,50,'single');
    // add event listener on input in search bars
    $(document).on("input", '.search', function(){
        removeItems('.content-row');
        $('#loading-circle').css('display','block');
        CheckSearch($('#event-select').val(),this.value,'event', ShowEvents,50,'single');
    });
    $(document).on('dblclick', '.delete-button-event', function(){
        response = prompt('Do you want to delete this y/n ?', '');
        if (response === 'n') {
            return false;
        } else if (response === 'y') {
            $.ajax({url: "/admin/event/delete/" + $(this).attr('id').split('-')[2], type: "POST"}).then(function(){
                removeItems('.content-row');
                removeItems('.content-values');
                LoadContent(false, 'event', ShowEvents,$('#current-number').val(),50);
            });
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
        '<div class="content-values quark-presence-column ids" id="id">' + response.id + '</div>' +
        '<div class="content-values quark-presence-column names" id="name">' + response.name.substr(0, 70)  + '</div>' +
        '<div class="content-values quark-presence-column dates" id="date">' + response.startdate + '</div>' +
        '<div class="content-values quark-presence-column actions" id="actions">' + setActions(response.id,'event') + '</div>' +
        '</div>';
    $("#list-content").append(str);
    $('#loading-circle').css('display','none');
}