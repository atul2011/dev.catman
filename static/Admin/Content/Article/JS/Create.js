$(document).ready(function(){
    $(document).on("input", '#item-event', function(){
        removeItems('#eventlist');
        CheckSearch(this.value, 'event', 'name', 5, 'eventlist');
    });
    $(document).on("input", '#item-author', function(){
        removeItems('#authorlist');
        CheckSearch(this.value, 'author', 'name', 5, 'authorlist');
    });
    $(document).on("submit",'#item-form',function(e){
        var title = $('#item-title');
        
        if(title.val()=== ''){
            title.addClass('title_null').attr('placeholder', 'Title must be not null');
            e.preventDefault();
        }
    });
    
    editor = new MediumEditor($('.content'));
});
//function to check when you want to find items
function CheckSearch(str, model, name, limit, listname){
    var url = '/admin/' + model + '/search?' + name + '=' + str;
    var string = '';
    if (limit !== 0) url += '&limit=' + limit;
    //if not to search in DB items by inserted string
    $.ajax({url: url, type: 'POST',data:{
        field:name,value:str
    }}).then(
        function(json){
            if (json.response !== '') {
                string = '<datalist id="' + listname + '">';
                json.response.forEach(function(json){
                    string += '<option value="' + json.name + '">';
                });
                string += '</datalist>';
                $('#' + model + '-field').append(string);
            }
        }
    );
}