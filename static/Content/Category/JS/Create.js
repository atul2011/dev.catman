$(document).ready(function(){
    editor = new MediumEditor($('.content'));
    $(document).on("submit",'#form',function(e){
        var title =$('input#title');
        if(title.val()=== ''){
            title.addClass('title_null').attr('placeholder', 'Title must be not null');
            e.preventDefault();
        }
    });
});