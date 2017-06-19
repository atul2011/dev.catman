var selectedColor = 'rgb(51,\ 122,\ 183)';
var selectedTextColor = 'rgb(255,\ 255,\ 255)';
$(document).ready(function(){
    $('.navigation_form').submit(function (e) {
        e.preventDefault();
    });
});
function resizeList(height_difference, width_difference){
    var height = $('body').height() - (height_difference+72), list = $('.items-list'),
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
function checkTitle(name){
    var title = $('#' + name).val();
    if (title.val() === '') {
        title.addClass('title_null').attr('placeholder', 'Title must be not null');
        return false;
    }
    return true;
}
//function to load content
function LoadContent(state, model, callback,skip){
    console.log(skip+'laodc');
    var start = (parseInt(skip) - 1) * 50;
    if (model === null || model === undefined) model = 'none';
    $.ajax({url: '/' + model + '/list?skip='+start, data: {orfan: state, model: model}, type: 'POST'}).then(function(json){
        if (json.response !== null) {
            removeItems('.content-row');
            json.response.forEach(callback);
        }
    });
}

//function to search in db items without relations
function noParents(state, model, callback){
    LoadContent(state, model, callback,1);
}

//fucntion to add to each item in actions column the anchors-icons for redirecting
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
function paintRow(id){
    var selector = "content-row",
        row = $('.' + selector);
    status = true;
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

//function to check when you want to find items
function CheckSearch(str, model, name, callback, limit,skip){
    //if search bar is empty, we load default list
    if (str.length === 0) {
        LoadContent(false, model, callback,skip);
        return;
    }
    var url = '/' + model + '/search';
    if (limit !== 0) url += '?limit=' + limit;
    //if not to search in DB items by inserted string
    $.ajax({url: url,type:'POST',data:{ value : str,field: name}}).then(
        function(json){
            if (json.response !== '') {
                removeItems('.content-row');
                json.response.forEach(callback);
            } else {
                removeItems('.content-row');
            }
        }
    );
}