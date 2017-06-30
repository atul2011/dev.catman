$(document).ready(function(){
    $(document).on("submit",'#form',function(e){
        var name =$('input#name');
        if(name.val()=== ''){
            name.addClass('title_null').attr('placeholder', 'Name must be not null');
            e.preventDefault();
        }
    });
});
