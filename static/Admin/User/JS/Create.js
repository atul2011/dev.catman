$(document).ready(function(){
    if ($('#login').val() !== '')
        $('.additional').css('display', 'none');
    $(document).on("submit", '#form', function(e){
        var login = $('#login'),
            password = $('#password'),
            re_password = $('#re_password'),
            rights = $('#rights'),
            action = $.trim($('.submit-button').text());

        if (login.val() === '') {
            login.addClass('title_null').attr('placeholder', 'Login must be not null');
            e.preventDefault();
        }
        if (password.val() === '' && password.css('display')) {
            password.addClass('title_null').attr('placeholder', 'Password must be not null');
            e.preventDefault();
        }
        if (rights.val() === '') {
            rights.addClass('title_null').attr('placeholder', 'Rights must be not null');
            e.preventDefault();
        }
        if ((password.val() !== re_password.val()) && action === 'Create') {
            re_password.addClass('title_null').attr('placeholder', 'Passwords not match');
            e.preventDefault();
        }
    });
});