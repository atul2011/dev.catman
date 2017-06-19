$(document).ready(function(){
    var model_select =
        '<option value="id">ID</option>' +
        '<option value="name">Name</option>' +
        '<option value="startdate">Start Date</option>';
    $('#event-select').append(model_select);
    resizeList(120,83);
    LoadContent(false, 'event', ShowEvents,1);
    // add event listener on input in search bars
    $(document).on("input", '.search', function(){
        CheckSearch(this.value, 'event', $('#event-select').val(),ShowEvents,50);
    });
    $(document).on('dblclick', '.delete-button-event', function(){
        response = prompt('Do you want to delete this y/n ?', '');
        if (response === 'n') {
            return false;
        } else if (response === 'y') {
            $.ajax({url: "/event/delete/" + $(this).attr('id'), type: "POST"}).then(function(){
                removeItems('.content-row');
                removeItems('.content-values');
                LoadContent(false, 'event', ShowEvents,1);
            });
        }
    });
    $(document).on('click', '.content-row', function(){
        paintRow($(this).attr("id"));
    });
    ////////////////////////////navigation bar//////////////////////////////////////////
    LoadNavigationBar('event',ShowEvents);
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
}