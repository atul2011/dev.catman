$(document).ready(function(){
    $('.navigation_form').submit(function(e){
        e.preventDefault();
    });
    // $('#loading-circle').css('')
});
function LoadNavigationBar(model, callback){
    var data = $('#number').val();
    var endpoint = parseInt(parseInt(data) / 50) + 1;
    getMaxPages(1, endpoint);
    //set events to created negigation buttons
    $(document).on('click', '.current-page .nav-button', function(){
        LoadContent(false, model, callback, $(this).val(),50);
        getMaxPages($(this).val(), endpoint);
    });
    $(document).on('click', '.nav-button#prev', function(){
        var skip = parseInt($('.current-page .selected-page').val());
        --skip;
        LoadContent(false, model, callback, skip,50);
        getMaxPages(skip, endpoint);
    });
    $(document).on('click', '.nav-button#next', function(){
        var skip = parseInt($('.current-page .selected-page').val());
        ++skip;
        LoadContent(false, model, callback, skip,50);
        getMaxPages(skip, endpoint);
    });
    $(document).on('click', '.nav-button#first', function(){
        LoadContent(false, model, callback, 1,50);
        getMaxPages(1, endpoint);
    });
    
    $(document).on('click', '.nav-button#last', function(){
        LoadContent(false, model, callback, endpoint,50);
        getMaxPages(endpoint, endpoint);
    });
}
//////////////////////////////////    | |    ///////////////////////////
//////////////////////////////////   _| |_   ///////////////////////////
//////////////////////////////////   \   /   ///////////////////////////
//////////////////////////////////    \ /    ///////////////////////////
//////////////////////////////////     V     ///////////////////////////
function getMaxPages(current,endpoint){
    $(".orfan").prop('checked', false);
    
    
    if (parseInt(current) === endpoint) {
        $('.nav-button#next').prop('disabled', true).addClass('inactive-page');
        $('.nav-button#last').prop('disabled', true).addClass('inactive-page');
    }
    else {
        $('.nav-button#next').prop('disabled', false).removeClass('inactive-page');
        $('.nav-button#last').prop('disabled', false).removeClass('inactive-page');
    }
    if (parseInt(current) === 1) {
        $('.nav-button#first').prop('disabled', true).addClass('inactive-page');
        $('.nav-button#prev').prop('disabled', true).addClass('inactive-page');
    } else {
        $('.nav-button#first').prop('disabled', false).removeClass('inactive-page');
        $('.nav-button#prev').prop('disabled', false).removeClass('inactive-page');
    }
    getPages(current, endpoint);
}
//////////////////////////////////    | |    ///////////////////////////
//////////////////////////////////   _| |_   ///////////////////////////
//////////////////////////////////   \   /   ///////////////////////////
//////////////////////////////////    \ /    ///////////////////////////
//////////////////////////////////     V     ///////////////////////////
function getPages(current, endpoint){
    var start = 1,
        stop = endpoint;
    if (endpoint < 6) {
        $('.space_buttons').css('display', 'none');
        removeItems('.current-page');
        start = 1;
        stop = endpoint;
    } else if (endpoint >= 6) {
        //calculte first-button-page
        start = current - 2;
        if (start > 1) $('#space_prev').css('display', 'inline');
        else if (start <= 1) {
            $('#space_prev').css('display', 'none');
            start = 1;
        }
        //calculte last-button-page
        stop = start + 4;
        if (stop >= endpoint) {
            $('#space_next').css('display', 'none');
            stop = endpoint;
            start = stop - 5;
        } else if (stop < endpoint) $('#space_next').css('display', 'inline');
        removeItems('.current-page');
    }
    setPages(current, start, stop);
}
//////////////////////////////////    | |    ///////////////////////////
//////////////////////////////////   _| |_   ///////////////////////////
//////////////////////////////////   \   /   ///////////////////////////
//////////////////////////////////    \ /    ///////////////////////////
//////////////////////////////////     V     ///////////////////////////
function setPages(current, start, stop){
    var string = '';
    while (start <= stop) {
        string += '<div class="quark-presence-column  current-page">' +
            '<button type="submit" class="nav-button" value="' + start + '" id="' + start + '">' + start + '</button>' +
            '</div>';
        ++start;
    }
    $('.current-pages').append(string);
    
    $('.nav-button').removeClass('selected-page');
    $('.nav-button#' + current).addClass('selected-page');
}