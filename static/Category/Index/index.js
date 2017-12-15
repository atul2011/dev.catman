$(document).ready(function () {
    var related_categories = $('.item-related-categories-container');
    var related_articles = $('.item-related-articles-container');
    var related_content = $('.item-related-content');

    if (related_categories.html().trim().length === 0 && related_articles.html().trim().length === 0 )
        related_categories.css('border', 'none');

    if (related_content.html().trim().length === 0)
        related_content.css('border', 'none');
});