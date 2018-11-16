$(document).ready(function () {
    $('.js-equal-height').css('padding-bottom', '16px');
    $('.related-items-container').height($('#content-container').height());

    var side_menu_list = $('.side-menu-list li');
    var related_categories = $('.item-related-categories-container');
    var related_articles = $('.item-related-articles-container');
    var related_content = $('.item-related-content');
    var related_photos = $('.item-related-photo-container');
    var related_links = $('.item-related-content a');

    side_menu_list.slice(side_menu_list.index($('.list-delimiter')) + 1, side_menu_list.length).css('font-weight', 'bold');

    $(window).on('resize', function () {
        if ($(this).width() < 975) {
            $('.related-items-container').height($('#related-websites-container').height() + $('#news-container').height());
        } else {
            $('.related-items-container').height($('#content-container').height());
        }
    });

    $('.item-content img').css('max-width', $('.item-content').width()).height('auto');
    console.log(related_content.html().trim().length);

    if (related_content[0] !== undefined) {
        if (related_content.html().trim().length === 0) {
            related_content.hide();
            $('.cm-header-content-delimiter').hide();
        }
    }

    if (related_photos[0] !== undefined) {
        if (related_photos.html().trim().length === 0) {
            related_photos.hide();
            $('.cm-content-photos-delimiter').hide();
        }
    }

    if (related_categories[0] !== undefined) {
        if (related_categories.html().trim().length === 0) {
            $('.cm-content-categories-delimiter').hide();
            related_categories.hide();
        }
    }

    if (related_articles[0] !== undefined) {
        if (related_articles.html().trim().length === 0 ) {
            $('.cm-categories-articles-delimiter').hide();
            related_articles.hide();
        }
    }

    related_links.removeAttr('target');

});

$(document).on('click', '.dropdown-item', function () {
    var sub_list = $('.inner_mnu-expanded');

    if (sub_list.css('display') === 'none')
        sub_list.show();
    else
        sub_list.hide();
});

function SetMaxheight () {
    var left_links = $('#main-links-container .related-items-container');
    var content = $('#content-container');
    var right_links = $('#additional-links-container .related-items-container');

    var height = Math.max(left_links.height(), content.height(), right_links.height());
}