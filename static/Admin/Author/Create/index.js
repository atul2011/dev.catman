$(document).ready(function(){
    $(document).on("submit",'#item-form',function(e){
        var name =$('#item-name');
        if(name.val()=== ''){
            name.addClass('title_null').attr('placeholder', 'Name must be not null');
            e.preventDefault();
        }
    });
});