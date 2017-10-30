//function what will run at end of loading of page
var selectedColor = 'rgb(51,\ 122,\ 183)';
var selectedTextColor = 'rgb(255,\ 255,\ 255)';
var rootPoint = '<div id="route-point-' + root_id + '" class="route-points quark-presence-column">' + root_name + '</div>';

var category_select =
    '<option value="id">ID</option>' +
    '<option value="title">Title</option>' +
    '<option value="sub">Type</option>' +
    '<option value="keywords">Keywords</option>' +
    '<option value="priority">Priority</option>';

var article_select =
    '<option value="id">ID</option>' +
    '<option value="title">Title</option>' +
    '<option value="release_date">Release Date</option>' +
    '<option value="event_id">Event</option>' +
    '<option value="author_id">Author</option>' +
    '<option value="keywords">Keywords</option>';

function setDefaultEvents(model,callback){
    $(document).on("input", '#'+model+'-search', function(){
        removeItems('.content-row-'+model);
        $('#loading-circle-'+model).css('display', 'block');
        CheckSearch($('#'+model+'-select').val(), this.value, model, callback, 50,'multiple');
    });
    
    $(document).on("change", '#'+model+'-orfan', function(){
        removeItems('.content-row-'+model);
        $('#loading-circle-'+model).css('display', 'block');
        noParents($(this).is(':checked'), model, callback, 50,'multiple');
    });
    
    $(document).on('click', '.delete-button-'+model, function(e){
        response = prompt('Do you want to delete this y/n ?', '');
        if (response === 'n') {
            e.preventDefault();
        } else if (response === 'y') {
            $.ajax({url: '/admin/'+model+'/delete/' + $(this).attr('id').split('-')[2], type: "POST",data:{type_of_delete:'all'}}).then(function(data){
                if (data !== null && data !== '')
                    console.log(data);
                LoadContent(false, model, callback, $('#current-number-'+model).val(), 50,'multiple');
                setCategory($(".route-points").last().attr('id').split('-')[2]);
            });
        } else {
            return false;
        }
    });
    $(document).on('click', '.special-delete-button-'+model, function(e){
        response = prompt('Do you want to delete this y/n ?', '');
        if (response === 'n') {
            e.preventDefault();
        } else if (response === 'y') {
            $.ajax({url: '/admin/'+model+'/delete/' + $(this).attr('id').split('-')[2], type: "POST",data:{type_of_delete:'link'}}).then(function(data){
                if (data !== null && data !== '')
                LoadContent(false, model, callback, $('#current-number-'+model).val(), 50,'multiple');
                setCategory($(".route-points").last().attr('id').split('-')[2]);
            });
        } else {
            return false;
        }
    });
    $(document).on('click', '.content-row-'+model, function(){
        paintRow($(this).attr("id"), model);
        checkRow($(this).find("td:first").text(), model);
    });
    ////////////////////////////navigation bar//////////////////////////////////////////
    LoadNavigationBar('multiple',model, callback);
}
$(document).ready(function(){
    $('.navigation_form').submit(function(e){
        e.preventDefault();
    });
    //load content
    LoadContent(false, 'article', ShowArticles, 1, 50,'multiple');
    LoadContent(false, 'category', ShowCategories, 1, 50,'multiple');

    setDefaultEvents('category',ShowCategories);
    setDefaultEvents('article',ShowArticles);


    //load selects with columns of models
    $('#category-select').append(category_select);
    $('#article-select').append(article_select);

    var list = $('.items-list');
    $('.loader').css('left', (list.width() / 3.3)).css('top', (list.height() / 6));
    //stop refreshing when submit
    $(".submit-buttons").submit(function(e){
        e.preventDefault();
    });

//event listener that will permite redirect when click to route node
    $(document).on("dblclick", '.route-points', function(){
        setCategory($(this).attr('id').split('-')[2]);
    });
    //set mouse over and out events to route points
    $(document).on("mouseover", '.route-points', function(){
        $(this).css("background-color", selectedColor).css("color", selectedTextColor);
    });
    $(document).on("mouseout", '.route-points', function(){
        $(this).css("background-color", 'white').css("color", 'black');
    });
// event listener that will permite open category in left table
    $(document).on("dblclick", '.actions-categories', function(){
        setCategory($(this).attr('id').split('-')[2]);
    });
//set mouse over and out events to list of items in left table
    $(document).on("mouseover", '.current-category', function(){
        $(this).css("background-color", selectedColor).css("color", selectedTextColor);
    });
    $(document).on("mouseout", '.current-category', function(){
        $(this).css("background-color", 'white').css("color", 'black');
    });
    $("#route-row").append(rootPoint);
    //set max with lo left-list
    $(window).resize(function(){
        $('#list-left').css('max-width',$(this).width() - 950);
    });
    $('#list-left').css('max-width',$(this).width()-950);
    
    //link-buttons
    var list_height = $('#list-right').height();
    $('#button-link-category').css('margin-top',list_height/4);
    $('#button-link-article').css('margin-top',list_height/2.5);

    setCategory($('.route-points').last().attr('id').split('-')[2]);
});

//fucntion to show categories
function ShowCategories(response){
    str = '<div class="quark-presence-container presence-block content-row-category content-row" id="category-values-' + response.id + '">' +
        '<div class="category-values quark-presence-column ids" id="category-id-' + response.id + '">' + response.id + '</div>' +
        '<div class="category-values quark-presence-column titles" id="category-title-' + response.id + '">' + response.title.substr(0, 70) + '</div>' +
        '<div class="category-values quark-presence-column types" id="category-type-' + response.id + '">' + response.sub + '</div>' +
        '<div class="category-values quark-presence-column contents" id="category-content-' + response.id + '">' + '<textarea rows="3" cols="30" class="content quark-input" readonly>' + response.intro.substr(0, 200) + '</textarea>' + '</div>' +
        '<div class="category-values quark-presence-column actions" id="category-actions-' + response.id + '">' + setActions(response.id, 'category') + '</div>' +
        '</div>';
    $("#category-column").append(str);
    $('#loading-circle-category').css('display', 'none');
}

//fucntion to show the articles
function ShowArticles(response){
    str = '<div class="quark-presence-container presence-block content-row-article content-row" id="article-values-' + response.id + '">' +
        '<div class="article-values quark-presence-column ids" id="article-id-' + response.id + '">' + response.id + '</div>' +
        '<div class="article-values quark-presence-column titles" id="article-title-' + response.id + '">' + response.title.substr(0, 50) + '</div>' +
        '<div class="article-values quark-presence-column dates" id="article-date-' + response.id + '">' + response.release_date + '</div>' +
        '<div class="article-values quark-presence-column contents" id="article-content-' + response.id + '">' + '<textarea rows="3" cols="30" class="content quark-input" readonly>' + response.txtfield.substr(0, 200) + '</textarea>' + '</div>' +
        '<div class="article-values quark-presence-column actions" id="article-actions-' + response.id + '">' + setActions(response.id, 'article') + '</div>' +
        '</div>';
    $("#article-column").append(str);
    $('#loading-circle-article').css('display', 'none');
}
//return height of right div for resizing left div
function getHeight(){
    height = $("div#list-right").outerHeight() - $("table#route").outerHeight();
    $("div#elements-list").outerHeight(height).css("border", "1px solid grey").css("border-top", "0");
    $("div#list-center , div#list-center table").outerHeight(height);
}

//fuction to ceck row
function checkRow(data, type){
    var
        categoryParentId = $(".route-points").last().attr('id').split('-')[2],
        childId = data,
        url = "",
        dataGiven = "";
    //define default valuses
    if (type === 'category') {
        url = "/admin/category/relation/categories/";
    }
    else if (type === 'article') {
        url = "/admin/category/relation/articles/";
    }
    //if we are in root, we go on in selected category
    if (categoryParentId === root_id) {
        button_true('category');
        button_false('article');
    }
    //if not
    else if (categoryParentId !== root_id) {
        if (categoryParentId === childId) {
            button_false(type);
            return;
        }
        //we search in current category all items
        $.ajax({url: url + categoryParentId}).then(function(json){
            if (type === 'category') {
                dataGiven = json.children;
            }
            else if (type === 'article') {
                dataGiven = json.articles;
            }
            //if category hasn't child, we append current
            if (dataGiven.length === 0) {
                button_true(type);
                //if not
            } else if (dataGiven.length !== 0) {
                var status = true;
                dataGiven.forEach(function(data){
                    //check if current child is in this category
                    if (data.id === childId) {
                        //if we found same link in Db, we set "false" class
                        button_false(type);
                        status = false;
                    }
                });
                //if not, we add "true" class
                if (status === true) {
                    button_true(type);
                }
            }
        });
    }
}
//function to put style to buttons
function button_true(type){
    $("#" + type + "-link").removeClass("link-false").removeClass("link-none").addClass("link-true");
}
function button_false(type){
    $("#" + type + "-link").removeClass("link-true").removeClass("link-none").addClass("link-false");
}
function button_none(type){
    $("#" + type + "-link").removeClass("link-true").removeClass("link-false").addClass("link-none");
}

//function ceck link between current category and selected item
function Link(service){
    if ($("#" + service + "-link").attr("class") !== "link-true")
        return;
    var parentId = $(".route-points").last().attr('id').split('-')[2];
    var childId = $(".selected ." + service + "-values").attr('id').split('-')[2];
    if (parentId === childId && service === "category") {
        checkResponse(409,'');
        return;
    }
    //if is root category and we select service, we show that category
    if ((parentId === "0" ) && (service === "category")) {
        checkResponse(200, childId);
        return;
    }
    //if not, we link curent category with current item
    $.ajax({type: 'POST', url: "/admin/" + service + "/link",data: {parent: parentId, child: childId}})
     .then(function(json){
        checkResponse(json.status, json.category);
    });
}
//function to make decisions after get response message
function checkResponse(status, id){
    if (status === 200) setCategory(id);
}
//function that set in route the selected category and show all items of this
function setCategory(id){
    button_none('category');
    button_none('article');
    if (id === root_id) {
        removeItems('.route-points');
        $("#route-row").append(rootPoint);
    } else {
        $.ajax({type: "GET", url: "/admin/category/" + id}).then(function(json){
            str = '<div id="route-point-' + json.item.id + '" class="route-points quark-presence-column" >' +  json.item.title.substr(0, 15) + '</div>';
            var status = true;
            //check if that category is already in path
            $(".route-points").each(function(){
                if ( $(this).text().substr(0,10) === json.item.title.substr(0,10)) {
                    $(".route-points").remove();
                    $("#route-row").append(rootPoint);
                }
            });
            $("#route-row").append(str);
        });
    }
    ListCategory(id);
}
//function to load in left table data about category
function ListCategory(categoryId){
    removeItems('.current-items');
    if (categoryId === root_id)return;
    $.ajax({url: "/admin/category/relation/categories/" + categoryId}).then(function(json){
        if (json.status === 404) return false;
        json.children.forEach(function(data){
            showCurrentItems(data, 'category');
        });
        
    });
    $.ajax({url: "/admin/category/relation/articles/" + categoryId}).then(function(json){
        if (json.status === 404) return false;
        json.articles.forEach(function(data){
            showCurrentItems(data, 'article');
        });
    });
}
//fucntion to show categories
function showCurrentItems(response, service){
    var setIcon;
    if (service === 'category') {
        setIcon = setCategoryIcon(response.id);
    } else {
        setIcon = setArticleIcon(response.id);
    }
    str = '<div id="' + service + '-' + response.id + '" class="quark-presence-container current-items current-' + service + '">' +
            '<div class="quark-presence-column icons ' + service + '" id="current-category-icon-'+response.id+'">' + setIcon + '</div>' +
            '<div class="quark-presence-column ids ' + service + '" id="current-category-id-'+response.id+'">' + response.id + '</div>' +
            '<div class="quark-presence-column titles ' + service + '" id="current-category-title-'+response.id+'">' + response.title + '</div>' +
            '<div class="quark-presence-column actions ' + service + '" id="current-category-actions-'+response.id+'">' + setSpecialActions(response.id,service) + '</div>' +
          '</div>';
    $("#content-container").append(str);
}
//action for management items in left column
function setSpecialActions(id, model){
    //define edit and remove buttons for all rows
    return actions =
        '<a class="fa actions edit-button-' + model + ' fa-pencil content-actions " id="current-category-edit-' + id + '" href="/' + model + '/edit/' + id + '""></a>' +
        '<a class="fa actions special-delete-button-' + model + ' fa-eraser content-actions "  id="current-category-delete-' + id + '" "></a>';
}
//function to create an ICon for category as folder
function setCategoryIcon(id){
    //define icon for category
    return '<a class="fa actions fa-folder-open actions-categories" id="category-icon-'+id+'"></a>';
}
//function to create an ICon for article as file
function setArticleIcon(id){
    //define icon for category
    return '<a class="fa actions  fa-file-text  actions-articles" id="article-icon-'+id+'"></a>';
}