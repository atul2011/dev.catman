$(document).ready(function(){
    $('.main-page-banner').css('width',$('.item-head').width());

    $(window).resize(function () {
        $('.main-page-banner').css('width',$('.item-head').width());
    });
});