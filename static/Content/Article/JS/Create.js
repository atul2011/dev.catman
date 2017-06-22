$(document).ready(function(){
    $(document).on("input", '#input_event', function(){
        removeItems('#eventlist');
        CheckSearch(this.value, 'event', 'name', 5, 'eventlist');
    });
    $(document).on("input", '#input_author', function(){
        removeItems('#authorlist');
        CheckSearch(this.value, 'author', 'name', 5, 'authorlist');
    });
});
//function to check when you want to find items
function CheckSearch(str, model, name, limit, listname){
    var url = '/' + model + '/search?' + name + '=' + str;
    var string = '';
    if (limit !== 0) url += '&limit=' + limit;
    //if not to search in DB items by inserted string
    $.ajax({url: url, type: 'POST'}).then(
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
