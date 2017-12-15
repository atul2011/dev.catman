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

    $('.item-content img').css('max-width', $('.item-content').width()).height('auto');
});

$(document).on('click', '.dropdown-item', function () {
    var sub_list = $('.inner_mnu-expanded');

    if (sub_list.css('display') === 'none')
        sub_list.show();
    else
        sub_list.hide();
});
