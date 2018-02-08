$(document).ready(function(){
    document.title = 'Контакт';

    $(document).on('submit', '.contact-form', function(e){
        $('.contact-form-item').hide();
        $('.contact-form-container').css('height','150px');
        $('.contact-form-title').empty().show().css('margin-top','40px').append('<h3 class="after-submit-message">Спасибо за сообщение. Мы напишем вам позже.</h3>');
    });
});