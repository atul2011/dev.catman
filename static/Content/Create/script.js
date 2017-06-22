$(document).ready(function(){
    editor = new MediumEditor($('.content'));
    // var width = $('.content-container').width();
    // $('#content .content').css('width', width).css('height', '220');

});
//clear all items from left-table
function removeItems(selector){
    $(selector).remove();
}