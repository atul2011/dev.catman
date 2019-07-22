$(document).on('click', '.openInOverlay', function () {
    var overlay_container = $('#news-overlay');
    overlay_container.addClass('show');
    overlay_container.find('.news-title').html($(this).attr('news-title'));
    overlay_container.find('.news-description').html($(this).attr('news-description'));
});$(document).on('click', '.overlay-close', function () {
    $('#news-overlay').removeClass('show');
});