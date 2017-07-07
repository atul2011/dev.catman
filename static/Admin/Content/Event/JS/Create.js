$(document).ready(function(){
    $(document).on("submit",'#form',function(e){
        var title =$('input#name');
        if(title.val()=== ''){
            title.addClass('title_null').attr('placeholder', 'Name must be not null');
            e.preventDefault();
        }
    });
});