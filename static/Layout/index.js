$(document).ready(function () {
    $('.js-equal-height').css('padding-bottom', '16px');
    $('.related-items-container').height($('#content-container').height());
    var side_menu_list = $('.side-menu-list li');

    side_menu_list.slice(side_menu_list.index($('.list-delimiter')) + 1, side_menu_list.length).css('font-weight', 'bold');

    $(window).on('resize', function () {
        if ($(this).width() < 975) {
            $('.related-items-container').height($('#related-websites-container').height() + $('#news-container').height());
        } else {
            $('.related-items-container').height($('#content-container').height());
        }
    });
});