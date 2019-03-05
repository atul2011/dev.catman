$(document).ready(function(){
    var fields =
        '<option value="id">ID</option>' +
        '<option value="title">Title</option>' +
        '<option value="sub">Type</option>' +
        '<option value="keywords">Keywords</option>' +
        '<option value="priority">Priority</option>';

    $('#category-select').append(fields);

    resizeList(130,220);//set height of list and width of search-bar

    LoadContent(false, 'category', ShowCategories,1,50,'single');

    $(document).on("keydown", '.search', function(e){// add event listener on input in search bars
        if (e.keyCode === 13) {
            removeItems('.content-row');
            $('#loading-circle').css('display', 'block');
            CheckSearch($('#category-select').val(),this.value,'category', ShowCategories,50);
        }
    });

    $(document).on("change", ".orfan", function(){ //add event listener to checkbox "no parents"
        removeItems('.content-row');
        $('#loading-circle').css('display','block');
        noParents($(this).is(':checked'), $(this).attr('id').split('-')[0], ShowCategories,50,'single','single');
    });

    $(document).on('click', '.content-row', function(){
        paintRow($(this).attr("id"),'');
    });

    LoadNavigationBar('single','category',ShowCategories);//////////navigation bar
});

function ShowCategories (response) {//function to show categories
    var str = '<div class="quark-presence-container presence-block content-row" id="category-values-' + response.id + '">' +
        '<div class="content-values quark-presence-column ids">' + response.id + '</div>' +
        '<div class="content-values quark-presence-column titles">' + response.title.substr(0, 70)  + '</div>' +
        '<div class="content-values quark-presence-column types">' + response.sub + '</div>' +
        '<div class="content-values quark-presence-column actions">' +
            '<a class="fa fa-pencil actions edit-button-category content-actions " id="edit-category-' + response.id + '" href="/admin/category/edit/' + response.id + '" title="Category Edit"></a>' +
            '<a class="fa fa-trash actions delete-button-category content-actions item-remove-dialog" quark-dialog="#item-remove" quark-redirect="/admin/category/list/"  id="delete-category-' + response.id + '" href="/admin/category/delete/' + response.id + '" title="Category Delete"></a>'+
            '<a class="fa fa-chain actions content-actions" href="/admin/link/list/category/' + response.id + '" title="Category Links"></a>'+
            (response.has_links === 'true' ? '<a class="fa fa-database actions edit-button-category content-actions" href="/admin/category/group/' + response.id + '" title="Category Groups"></a>' : '') +
        '</div>' +
        '</div>';

    $("#list-content").append(str);
    $('#loading-circle').css('display','none');
}