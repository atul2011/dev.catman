$(document).ready(function(){
    $(document).on("submit",'#item-form',function(e){
        var title =$('#item-name');
        if(title.val()=== ''){
            title.addClass('title_null').attr('placeholder', 'Name must be not null');
            e.preventDefault();
        }
    });
});