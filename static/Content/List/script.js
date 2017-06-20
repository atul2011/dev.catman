var selectedColor = 'rgb(51,\ 122,\ 183)';
var selectedTextColor = 'rgb(255,\ 255,\ 255)';
$(document).ready(function(){
    $('.navigation_form').submit(function(e){
        e.preventDefault();
    });
    $('input[type="text"]').keypress(function(event){
        if (event.which === 13) {
            event.preventDefault();
        }
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
function LoadContent(state, model, callback,skip,service, name,str){
    var start = (parseInt(skip) - 1) * 50;
    if (isNaN(start))
    
    console.log(state, model,start,service, name,str);
    if (model === null || model === undefined) model = 'none';
    $.ajax({url: '/' + model + '/'+service+'?skip='+start, data: {orfan: state, model: model,value : str,field: name}, type: 'POST'}).then(
        function(json){
            if (json.response !== null) {
                removeItems('.content-row');
                json.response.forEach(callback);
                // $('#number').val(json.number);
            } else {
                removeItems('.content-row');
            }
    });
}

//function to search in db items without relations
function noParents(state, model, callback, start){
    if (isNaN(start))
        start = parseInt($('.current-page .selected-page').val());
    LoadContent(state, model, callback, start,'list',null,null);
}

//function to add to each item in actions column the anchors-icons for redirecting
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
function CheckService(){
    var service=$('.search').val();
    if(service === '') return 'list';
    else if(service !== '')return 'search';
}