var selectedColor = 'rgb(51,\ 122,\ 183)';
var selectedTextColor = 'rgb(255,\ 255,\ 255)';

$(document).ready(function () {
    $('.navigation_form').submit(function (e) {
        e.preventDefault();
    });

    $('input[type="text"]').keypress(function (event) {
        if (event.which === 13) {
            event.preventDefault();
        }
    });

    //set loader position
    var list = $('.items-list');
    $('#loading-circle').css('left', (list.width() / 3.3)).css('top', (list.height() * 1.8));

    DialogWindow();
});

function DialogWindow () {
    var remove = new Quark.Controls.Dialog('.item-remove-dialog', {
        success: function(trigger, dialog){
            trigger.parents('.content-row').remove();

            var redirect = trigger.attr('quark-redirect');

            if (redirect)
                setTimeout(function(){
                    window.location.href = redirect
                }, 1000);
        }
    });
}

function resizeList (height_difference, width_difference) {
    var height = $('body').height() - (height_difference + 72),
        list = $('.items-list'),
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

function LoadContent (alone, model, callback, skip, limit,state) {//function to load content
    console.log(2);
    var special_model = '';
    if (state === 'multiple')
        special_model = '-' + model;
    var start = (parseInt(skip) - 1) * 50;

    if (isNaN(start))
        start = (parseInt($('#number'+special_model)) - 1) * 50;

    if (model === null || model === undefined)
        model = 'none';
    console.log('dadasd');
    $.ajax({url: '/admin/' + model + '/list?skip=' + start + '&limit=' + limit, data: {orfan: alone, model: model}, type: 'POST'})
    .then(function(json){
        console.log(json);
        removeItems('.content-row'+special_model);

        if (json.response !== null) {
            json.response.forEach(callback);

            if (state === 'multiple')
                getHeight();

            DialogWindow();
        }
    });
}
function LoadContentAsCards (model, callback, skip, limit, items_selector) {//function to load content
    var start = (parseInt(skip) - 1) * 50;

    if (model === null || model === undefined)
        model = 'none';

    $.ajax({
            url: '/admin/' + model + '/list?skip=' + start + '&limit=' + limit,
            data: {model: model},
            type: 'POST'
           }).then(
        function (json) {
            removeItems(items_selector);

            if (json.response !== null) {
                json.response.forEach(callback);

                DialogWindow();
            }
    });
}

function noParents(alone, model, callback, limit, state){
    var special_model = '';
    if(state === 'multiple') special_model = '-' + model;
    
    var start = parseInt($('#current-number' + special_model).val());
    LoadContent(alone, model, callback, start, limit, state);
}

function setActions(id, model){//function to add to each item in actions column the anchors-icons for redirecting
    //define edit and remove buttons for all rows
    return actions =
        '<a class="fa actions edit-button-' + model + ' fa-pencil content-actions " id="edit-'+model+'-' + id + '" href="/admin/' + model + '/edit/' + id + '"></a>' +
        '<a class="fa actions delete-button-' + model + ' fa-trash content-actions item-remove-dialog" quark-dialog="#item-remove" quark-redirect="/admin/' + model + '/list/"  id="delete-'+model+'-' + id + '" href="/admin/' + model + '/delete/' + id + '"></a>';
}

function removeItems(selector){//clear all items from left-table
    $(selector).remove();
}

function paintRow(id, type) {//function to paint checked row
    status = true;
    var selector = "content-row";
    if (type !== '') selector = "content-row-"+type;
    var row = $("." + selector);

    row.each(function(){
        if ($(this).css("background-color") === selectedColor) {//ceck if any another row has checked
            status = false;
        }
    });

    if (status === "true") {//if not, we paint selected row
        $("#" + id).css("background-color", selectedColor).addClass("selected").css("color", selectedTextColor);
    }
    else if (status === "false") {//if yes, we paint in white all another rows before paint current row
        row.each(function(){
            $(this).css("background-color", "white").css("color", 'black').removeClass('selected').addClass(selector);
        });
        
        $("#" + id).css("background-color", selectedColor).addClass("selected").css("color", selectedTextColor);
    }
}

function CheckSearch(name, str, model, callback, limit,state){
    var special_model = '';
    if (state === 'multiple') special_model = '-' + model;

    if (str.length === 0) {//if search bar is empty, we load default list
        LoadContent(false, model, callback, 1, 50,state);
        return;
    }

    $.ajax({url: '/admin/' + model + '/search?limit=' + limit, type: 'POST', data: {value: str, field: name}}).then(
        function(json){//if not to search in DB items by inserted string
            removeItems('.content-row'+ special_model);

            if (json.response != '') {
                json.response.forEach(callback);
            } else {
                $('.loader').remove();
            }
        }
    );
}
