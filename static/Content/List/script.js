var selectedColor = 'rgb(51,\ 122,\ 183)';
var selectedTextColor = 'rgb(255,\ 255,\ 255)';
<<<<<<< HEAD
=======
$(document).ready(function(){
    $('.navigation_form').submit(function(e){
        e.preventDefault();
    });
    $('input[type="text"]').keypress(function(event){
        if (event.which === 13) {
            event.preventDefault();
        }
    });
    //set loader position
    var list = $('.items-list');
    $('#loading-circle').css('left', (list.width() / 3.3)).css('top', (list.height() * 1.8));
});
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
function resizeList(height_difference, width_difference){
    var height = $('body').height() - (height_difference + 72), list = $('.items-list'),
        width = list.width() - width_difference;
    
    list.css('max-height', height).css('min-height', height);
    $('.search').css('max-width', width).css('min-width', width);
    
    $(window).resize(function(){
        list.css('max-height', height).css('min-height', height);
    });
    
    $(window).resize(function(){
        $('.search').css('max-width', width).css('min-width', width);
    });
}
//function to load content
<<<<<<< HEAD
<<<<<<< HEAD
function LoadContent(state, model, callback){
    if (model === null || model === undefined) model = 'none';
    $.ajax({url: '/' + model + '/list', data: {orfan: state, model: model}, type: 'POST'}).then(function(json){
        if (json.response !== null) {
            removeItems('.content-row');
            json.response.forEach(callback);
        }
=======
function LoadContent(state, model, callback,skip,limit){
=======
function LoadContent(alone, model, callback, skip, limit,state){
    var special_model = '';
    if (state === 'multiple') special_model = '-' + model;
>>>>>>> 0c443798c3d3437785fe0ed756bac941c799f283
    var start = (parseInt(skip) - 1) * 50;
    if (isNaN(start))
        start = (parseInt($('#number'+special_model)) - 1) * 50;
    if (model === null || model === undefined) model = 'none';
    $.ajax({
               url: '/' + model + '/list?skip=' + start + '&limit=' + limit,
               data: {orfan: alone, model: model},
               type: 'POST'
           }).then(
        function(json){
            removeItems('.content-row'+special_model);
            if (json.response !== null) {
                json.response.forEach(callback);
                if(state === 'multiple')getHeight();
            }
<<<<<<< HEAD
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
    });
}

//function to search in db items without relations
<<<<<<< HEAD
function noParents(state, model, callback){
    LoadContent(state, model, callback);
}

//fucntion to add to each item in actions column the anchors-icons for redirecting
=======
function noParents(state, model, callback, start){
    if (isNaN(start))
        start = parseInt($('.current-page .selected-page').val());
    LoadContent(state, model, callback, start,50);
=======
        });
}
function noParents(alone, model, callback, limit, state){
    var special_model = '';
    if(state === 'multiple') special_model = '-' + model;
    
    var start = parseInt($('#current-number' + special_model).val());
    LoadContent(alone, model, callback, start, limit, state);
>>>>>>> 0c443798c3d3437785fe0ed756bac941c799f283
}

//function to add to each item in actions column the anchors-icons for redirecting
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
function setActions(id, model){
    //define edit and remove buttons for all rows
    return actions =
        '<a class="fa actions edit-button-' + model + ' fa-pencil content-actions " id="' + id + '" href="/' + model + '/edit/' + id + '?source=EditContent""></a>' +
        '<a class="fa actions delete-button-' + model + ' fa-eraser content-actions "  id="' + id + '" "></a>';
}
//clear all items from left-table
function removeItems(selector){
    $(selector).remove();
}
//function to paint checked row
function paintRow(id, type){
    status = true;
    var selector = "content-row";
    if (type !== '') selector = "content-row-"+type;
    var row = $("." + selector);
    //ceck if any another row has checked
    row.each(function(){
        if ($(this).css("background-color") === selectedColor) {
            status = false;
        }
    });
    //if not, we paint selected row
    if (status === "true") {
        $("#" + id).css("background-color", selectedColor).addClass("selected").css("color", selectedTextColor);
    }
    //if yes, we paint in white all another rows before paint current row
    else if (status === "false") {
        row.each(function(){
            $(this).css("background-color", "white").css("color", 'black').removeClass('selected').addClass(selector);
        });
        
        $("#" + id).css("background-color", selectedColor).addClass("selected").css("color", selectedTextColor);
    }
}
<<<<<<< HEAD
<<<<<<< HEAD

//function to check when you want to find items
function CheckSearch(str, model, name, callback, limit){
    //if search bar is empty, we load default list
    if (str.length === 0) {
        LoadContent(false, model, callback);
        return;
    }
    var url = '/' + model + '/search?' + name + '=' + str;
    if (limit !== 0) url += '&limit=' + limit;
    //if not to search in DB items by inserted string
    $.ajax({url: url,type:'POST'}).then(
=======
//function to check when you want to find items
function CheckSearch(name, str, model, callback, limit){
=======
function CheckSearch(name, str, model, callback, limit,state){
    var special_model = '';
    if (state === 'multiple') special_model = '-' + model;
>>>>>>> 0c443798c3d3437785fe0ed756bac941c799f283
    //if search bar is empty, we load default list
    if (str.length === 0) {
        LoadContent(false, model, callback, 1, 50,state);
        return;
    }
    //if not to search in DB items by inserted string
    $.ajax({url: '/' + model + '/search?limit=' + limit, type: 'POST', data: {value: str, field: name}}).then(
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
        function(json){
            removeItems('.content-row'+ special_model);
            if (json.response !== '') {
                json.response.forEach(callback);
            }
        }
<<<<<<< HEAD
<<<<<<< HEAD
    );
=======
        );
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
=======
    );
>>>>>>> 0c443798c3d3437785fe0ed756bac941c799f283
}