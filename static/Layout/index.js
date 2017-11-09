$(document).ready(function () {
    $('.related-items-container').height($('#content-container').height());
    $('.js-equal-height').css('padding-bottom', '16px');

    var side_menu_list = $('.side-menu-list li');

    side_menu_list.slice(side_menu_list.index($('.list-delimiter')) + 1, side_menu_list.length).css('font-weight', 'bold');
});