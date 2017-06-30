$(document).ready(function(){
    var model_select =
        '<option value="id">ID</option>' +
        '<option value="title">Title</option>' +
        '<option value="sub">Type</option>' +
        '<option value="keywords">Keywords</option>' +
        '<option value="priority">Priority</option>';
    $('#category-select').append(model_select);
    resizeList(120,137);
    LoadContent(false, 'category', ShowCategories,1,50);
    
    // add event listener on input in search bars
    $(document).on("input", '.search', function(){
        removeItems('.content-row');
        $('#loading-circle').css('display','block');
        CheckSearch($('#category-select').val(),this.value,'category', ShowCategories,50);
        
    });
    
    //add event listener to checkbox "no parents"
    $(document).on("change", ".orfan", function(){
        removeItems('.content-row');
        $('#loading-circle').css('display','block');
        noParents($(this).is(':checked'), $(this).attr('id'), ShowCategories,50,'single','single');
    });
    
    $(document).on('dblclick', '.delete-button-category', function(){
        response = prompt('Do you want to delete this y/n ?', '');
        if (response === 'n') {
            return false;
        } else if (response === 'y') {
            $.ajax({url: "/category/delete/" + $(this).attr('id'), type: "POST"}).then(function(){
                removeItems('.content-row');
                removeItems('.content-values');
                LoadContent(false, 'category', ShowCategories,$('#current-number').val(),50);
            });
        }
    });
    $(document).on('click', '.content-row', function(){
        paintRow($(this).attr("id"),'');
    });
    ////////////////////////////navigation bar//////////////////////////////////////////
    LoadNavigationBar('single','category',ShowCategories);
});
//function to show categories
function ShowCategories(response) {
    str = '<div class="quark-presence-container presence-block content-row" id="category-values-' + response.id + '">' +
        '<div class="content-values quark-presence-column ids" id="id">' + response.id + '</div>' +
        '<div class="content-values quark-presence-column titles" id="title">' + response.title.substr(0, 70)  + '</div>' +
        '<div class="content-values quark-presence-column types" id="type">' + response.sub + '</div>' +
        '<div class="content-values quark-presence-column contents" id="content">' + '<textarea rows="3" cols="30" class="content quark-input" readonly>' + response.intro.substr(0, 200) + '</textarea>' + '</div>' +
        '<div class="content-values quark-presence-column actions" id="actions">' + setActions(response.id,'category') + '</div>' +
        '</div>';
    $("#list-content").append(str);
    $('#loading-circle').css('display','none');
}