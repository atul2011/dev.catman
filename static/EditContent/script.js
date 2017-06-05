$(document).ready(function () {
    editor = new MediumEditor($('.content'));
});
function checkTitle() {
    var title= $('input#title');
    if(title.val() === '') {
        title.addClass('title_null').attr('placeholder','Title must be not null');
        return false;
    }
    return true;
}