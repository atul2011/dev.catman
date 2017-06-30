function LoadNavigationBar(state, model, callback){
    var special_model = '';
    if (state === 'multiple') special_model = '-' + model;
    //number of objects
    var data = $('#number' + special_model).val();
    //number of pages
    var endpoint = parseInt(parseInt(data) / 50) + 1;
    //load default pages
    getMaxPages(1, endpoint, special_model);
    setCurrentPage(special_model, 1);
    //listener for numbered buttons
    $(document).on('click', '.current-page' + special_model + ' .nav-button', function(){
        ShowLoader(special_model);
        LoadContent(false, model, callback, $(this).val(), 50,state);
        getMaxPages($(this).val(), endpoint, special_model);
    });
    //listener for BACK button
    $(document).on('click', '#prev' + special_model, function(){
        var skip = parseInt($('#current-number' + special_model).val()) - 1;
        ShowLoader(special_model);
        LoadContent(false, model, callback, skip, 50,state);
        getMaxPages(skip, endpoint, special_model);
        
    });
    //listener for FORWARD button
    $(document).on('click', '#next' + special_model, function(){
        var skip = parseInt($('#current-number' + special_model).val()) + 1;
        ShowLoader(special_model);
        LoadContent(false, model, callback, skip, 50,state);
        getMaxPages(skip, endpoint, special_model);
    });
    //listener for FIRST button
    setEventToNavButton('#first',1,endpoint,special_model,model,callback,state);
    //listener for LAST button
    setEventToNavButton('#last',endpoint,endpoint,special_model,model,callback,state);
}
function setEventToNavButton(selector,start,endpoint,special_model,model,callback,state){
    $(document).on('click', selector + special_model, function(){
        ShowLoader(special_model);
        LoadContent(false, model, callback, start, 50,state);
        getMaxPages(start, endpoint, special_model);
    });
}
function ShowLoader(special_model){
    removeItems('.content-row'+special_model);
    $('#loading-circle' + special_model).css('display', 'block');
}
//////////////////////////////////    | |    ///////////////////////////
//////////////////////////////////   _| |_   ///////////////////////////
//////////////////////////////////   \   /   ///////////////////////////
//////////////////////////////////    \ /    ///////////////////////////
//////////////////////////////////     V     ///////////////////////////
function getMaxPages(current, endpoint, special_model){
    $(".orfan").prop('checked', false);
    current = parseInt(current);
    endpoint = parseInt(endpoint);
    //is we selected the last page, NEXT,LAST buttons are disabled
    if (current === endpoint) {
        InactiveButton('#next', special_model);
        InactiveButton('#last', special_model);
    }
    if (current !== endpoint) { //else enabled
        ActiveButton('#next', special_model);
        ActiveButton('#last', special_model);
    }
    //if we selecterd first page, BACK,FIRST buttons are disabled
    if (current === 1) {
        InactiveButton('#first', special_model);
        InactiveButton('#prev', special_model);
    }
    if (current !== 1) {//else enabled
        ActiveButton('#first', special_model);
        ActiveButton('#prev', special_model);
    }
    getPages(current, endpoint, special_model);
}

function InactiveButton(selector, special_model){
    $(selector + special_model).prop('disabled', true).addClass('inactive-page');
}
function ActiveButton(selector,special_model){
    $(selector + special_model).prop('disabled', false).removeClass('inactive-page');
}
//////////////////////////////////    | |    ///////////////////////////
//////////////////////////////////   _| |_   ///////////////////////////
//////////////////////////////////   \   /   ///////////////////////////
//////////////////////////////////    \ /    ///////////////////////////
//////////////////////////////////     V     ///////////////////////////
function getPages(current, endpoint, special_model){
    var start = 1,
        stop = endpoint;
    //if we have less that 6 pages, we load all they without 3points symbols
    if (endpoint < 6) {
        $('.space_buttons' + special_model).css('display', 'none');
        removeItems('.current-page' + special_model);
        start = 1;
        stop = endpoint;
    } else if (endpoint >= 6) {
        //calculte first-button-page
        start = current - 2;
        //calculate
        if (start > 1) $('#space_prev' + special_model).css('display', 'inline');
        else if (start <= 1) {
            $('#space_prev' + special_model).css('display', 'none');
            start = 1;
        }
        //calculte last-button-page
        stop = start + 4;
        if (stop >= endpoint) {
            $('#space_next' + special_model).css('display', 'none');
            stop = endpoint;
            start = stop - 5;
        } else if (stop < endpoint) $('#space_next' + special_model).css('display', 'inline');
        removeItems('.current-page' + special_model);
    }
    setPages(current, start, stop, special_model);
}
//////////////////////////////////    | |    ///////////////////////////
//////////////////////////////////   _| |_   ///////////////////////////
//////////////////////////////////   \   /   ///////////////////////////
//////////////////////////////////    \ /    ///////////////////////////
//////////////////////////////////     V     ///////////////////////////
function setPages(current, start, stop, special_model){
    var string = '';
    //after we get all info aboout pages, we generate HTML with pages
    while (start <= stop) {
        string += '<div class="quark-presence-column  current-page' + special_model + '">' +
            '<button type="submit" class="nav-button " value="' + start + '" id="' + start + special_model + '">' + start + '</button>' +
            '</div>';
        ++start;
    }
    //insert pages in HTMl
    $('.current-pages' + special_model).append(string);
    
    if (setCurrentPage(special_model, current))
        PaintCurrentPage(special_model);
}
function setCurrentPage(special_model, value){
    $('#current-number' + special_model).val(value);
    return true;
}
function PaintCurrentPage(special_model){
    var id = $('#current-number' + special_model).val();
    $('#' + id + special_model).addClass('selected-page');
}