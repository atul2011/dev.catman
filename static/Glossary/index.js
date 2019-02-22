$(document).on('click', '.glossary-item-title.related-item-link', function () {
   var overlay_container = $('#glossary-overlay');
   overlay_container.addClass('show');
   overlay_container.find('.glossary-title').html($(this).attr('glossary-title'));
   overlay_container.find('.glossary-description').html($(this).attr('glossary-description'));
});$(document).on('click', '.overlay-close', function () {
   $('#glossary-overlay').removeClass('show');
});