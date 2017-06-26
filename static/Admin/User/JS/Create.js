$(document).ready(function(){
   if($('#login').val() !== '')
       $('.additional').css('display','none');
});
function CheckData(){
    var login =$('#login'),
        password = $('#password'),
        re_password = $('#re_password'),
        rights = $('#rights');
    if(login.val()=== ''){
        login.addClass('title_null').attr('placeholder', 'Login must be not null');
        return false;
    }
    if(password.val()=== ''){
        password.addClass('title_null').attr('placeholder', 'Password must be not null');
        return false;
    }
    if(rights.val()=== ''){
        rights.addClass('title_null').attr('placeholder', 'Rights must be not null');
        return false;
    }
    if(password.val() !== re_password.val()){
        re_password.addClass('title_null').attr('placeholder', 'Passwords not match');
        return false;
    }
    return true;
}