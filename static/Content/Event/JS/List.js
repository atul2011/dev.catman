$(document).ready(function(){
<<<<<<< HEAD
    resizeList(120,0);
    LoadContent(false, 'event', ShowEvents);
    // add event listener on input in search bars
    $(document).on("input", '.search', function(){
        CheckSearch(this.value, 'event', 'name',ShowEvents,50);
=======
    var model_select =
        '<option value="id">ID</option>' +
        '<option value="name">Name</option>' +
        '<option value="startdate">Start Date</option>';
    $('#event-select').append(model_select);
    resizeList(120,83);
    LoadContent(false, 'event', ShowEvents,1,50);
    // add event listener on input in search bars
    $(document).on("input", '.search', function(){
        removeItems('.content-row');
        $('#loading-circle').css('display','block');
<<<<<<< HEAD
        CheckSearch($('#event-select').val(),this.value,'event', ShowEvents,50);
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
=======
        CheckSearch($('#event-select').val(),this.value,'event', ShowEvents,50,'single');
>>>>>>> 0c443798c3d3437785fe0ed756bac941c799f283
    });
    $(document).on('dblclick', '.delete-button-event', function(){
        response = prompt('Do you want to delete this y/n ?', '');
        if (response === 'n') {
            return false;
        } else if (response === 'y') {
            $.ajax({url: "/event/delete/" + $(this).attr('id'), type: "POST"}).then(function(){
                removeItems('.content-row');
                removeItems('.content-values');
<<<<<<< HEAD
<<<<<<< HEAD
                LoadContent(false, 'event', ShowEvents);
=======
                LoadContent(false, 'event', ShowEvents,50);
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
=======
                LoadContent(false, 'event', ShowEvents,$('#current-number').val(),50);
>>>>>>> 0c443798c3d3437785fe0ed756bac941c799f283
            });
        }
    });
    $(document).on('click', '.content-row', function(){
        paintRow($(this).attr("id"),'');
    });
<<<<<<< HEAD
=======
    ////////////////////////////navigation bar//////////////////////////////////////////
<<<<<<< HEAD
    LoadNavigationBar('event',ShowEvents);
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
=======
    LoadNavigationBar('single','event',ShowEvents);
>>>>>>> 0c443798c3d3437785fe0ed756bac941c799f283
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
<<<<<<< HEAD
=======
    $('#loading-circle').css('display','none');
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
}