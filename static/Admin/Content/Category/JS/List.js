$(document).ready(function(){
    var fields =
        '<option value="id">ID</option>' +
        '<option value="title">Title</option>' +
        '<option value="sub">Type</option>' +
        '<option value="keywords">Keywords</option>' +
        '<option value="priority">Priority</option>';
    $('#category-select').append(fields);
    resizeList(120,137);
    LoadContent(false, 'category', ShowCategories,1,50,'single');
    
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
        noParents($(this).is(':checked'), $(this).attr('id').split('-')[0], ShowCategories,50,'single','single');
    });
    
    $(document).on('dblclick', '.delete-button-category', function(){
        response = prompt('Do you want to delete this y/n ?', '');
        if (response === 'n') {
            return false;
        } else if (response === 'y') {
            $.ajax({url: "/admin/category/delete/" + $(this).attr('id').split('-')[2], type: "POST",data:{type_of_delete:'all'}}).then(function(){
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
        '<div class="content-values quark-presence-column ids">' + response.id + '</div>' +
        '<div class="content-values quark-presence-column titles">' + response.title.substr(0, 70)  + '</div>' +
        '<div class="content-values quark-presence-column types">' + response.sub + '</div>' +
        '<div class="content-values quark-presence-column contents">' + '<textarea rows="3" cols="30" class="content quark-input" readonly>' + response.intro.substr(0, 200) + '</textarea>' + '</div>' +
        '<div class="content-values quark-presence-column actions">' + setActions(response.id,'category') + '</div>' +
        '</div>';
    $("#list-content").append(str);
    $('#loading-circle').css('display','none');
}