$(document).ready(function(){
    editor = new MediumEditor($('.content'));
    $(document).on("submit",'#item-form',function(e){
        var title =$('#item-title');
        if(title.val()=== ''){
            title.addClass('title_null').attr('placeholder', 'Title must be not null');
            e.preventDefault();
        }
    });
});