$(document).ready(function () {
    $(document).on('click', '.input-fields', function () {
        var item=$(this).attr('id').split('input')[1].substr(1);
        hideError( '#'+item+'-error');
    });
});
function ceckLogin() {
    var login = $('#input-login').val(),
        pass = $('#input-password').val();

    if (login=== '' || pass === '') {
        if (login === '') {
            showError('Login should not be null!','#login-error');
        }
        if (pass === '') {
            showError('Password should not be null!','#password-error');
        }
        return false;
    }
    return true;
}
function showError(text, id) {
    $(id).text(text).css('visibility', 'visible');
    $(id + '-img').css('visibility', 'visible');
}
function hideError(id) {
    $(id).text('').css('visibility', 'hidden');
    $(id + '-img').css('visibility', 'hidden');
}