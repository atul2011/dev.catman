//function what will run at end of loading of page
var selectedColor = 'rgb(51,\ 122,\ 183)';
var selectedTextColor = 'rgb(255,\ 255,\ 255)';
var rootPoint = '<div id="0" class="route-points quark-presence-column">></div>';
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
    $(document).on('dblclick', '.delete-button-'+model, function(e){
        response = prompt('Do you want to delete this y/n ?', '');
        if (response === 'n') {
            e.preventDefault();
        } else if (response === 'y') {
            $.ajax({url: '/'+model+'/delete/' + $(this).attr('id'), type: "POST",data:{type_of_delete:'all'}}).then(function(data){
                if (data !== null && data !== '')
                    console.log(data);
                LoadContent(false, model, callback, $('#current-number-'+model).val(), 50,'multiple');
                setCategory($(".route-points").last().attr('id'));
            });
        } else {
            return false;
        }
    });
    $(document).on('dblclick', '.special-delete-button-'+model, function(e){
        response = prompt('Do you want to delete this y/n ?', '');
        if (response === 'n') {
            e.preventDefault();
        } else if (response === 'y') {
            $.ajax({url: '/'+model+'/delete/' + $(this).attr('id'), type: "POST",data:{type_of_delete:'link'}}).then(function(data){
                if (data !== null && data !== '')
                    console.log(data);
                LoadContent(false, model, callback, $('#current-number-'+model).val(), 50,'multiple');
                setCategory($(".route-points").last().attr('id'));
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
    /////////////////////////////////////////////////////////////////
    setDefaultEvents('category',ShowCategories);
    setDefaultEvents('article',ShowArticles);
    //load selects with columns of models
    $('#category-select').append(category_select);
    $('#article-select').append(article_select);
    /////////////////////////////////////////////////////////////////
    var list = $('.items-list');
    $('.loader').css('left', (list.width() / 3.3)).css('top', (list.height() / 6));
    //stop refreshing when submit
    $(".submit-buttons").submit(function(e){
        e.preventDefault();
    });

//event listener that will permite redirect when click to route node
    $(document).on("dblclick", '.route-points', function(){
        routeRedirect($(this).attr('id'));
    });
    //set mouse over and out events to route points
    $(document).on("mouseover", '.route-points', function(){
        $(this).css("background-color", selectedColor).css("color", selectedTextColor);
    });
    $(document).on("mouseout", '.route-points', function(){
        $(this).css("background-color", 'white').css("color", 'black');
    });
// event listener that will permite open category in left table
    $(document).on("dblclick", ".current-category", function(){
        openCategory($(this).find("#id").text());
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
        $('#list-left').css('max-width',$(this).width()-950);
    });
    $('#list-left').css('max-width',$(this).width()-950);
    
    //link-buttons
    var list_height = $('#list-right').height();
    console.log(list_height);
    $('#button-link-category').css('margin-top',list_height/4);
    $('#button-link-article').css('margin-top',list_height/2.5);
});
//fucntion to show categories
function ShowCategories(response){
    str = '<div class="quark-presence-container presence-block content-row-category content-row" id="category-values-' + response.id + '">' +
        '<div class="category-values quark-presence-column ids" id="id">' + response.id + '</div>' +
        '<div class="category-values quark-presence-column titles" id="title">' + response.title.substr(0, 70) + '</div>' +
        '<div class="category-values quark-presence-column types" id="type">' + response.sub + '</div>' +
        '<div class="category-values quark-presence-column contents" id="content">' + '<textarea rows="3" cols="30" class="content quark-input" readonly>' + response.intro.substr(0, 200) + '</textarea>' + '</div>' +
        '<div class="category-values quark-presence-column actions" id="actions">' + setActions(response.id, 'category') + '</div>' +
        '</div>';
    $("#category-column").append(str);
    $('#loading-circle-category').css('display', 'none');
}

//fucntion to show the articles
function ShowArticles(response){
    str = '<div class="quark-presence-container presence-block content-row-article content-row" id="article-values-' + response.id + '">' +
        '<div class="article-values quark-presence-column ids" id="id">' + response.id + '</div>' +
        '<div class="article-values quark-presence-column titles" id="title">' + response.title.substr(0, 50) + '</div>' +
        '<div class="article-values quark-presence-column dates" id="date">' + response.release_date + '</div>' +
        '<div class="article-values quark-presence-column contents" id="content">' + '<textarea rows="3" cols="30" class="content quark-input" readonly>' + response.txtfield.substr(0, 200) + '</textarea>' + '</div>' +
        '<div class="article-values quark-presence-column actions" id="actions">' + setActions(response.id, 'article') + '</div>' +
        '</div>';
    $("#article-column").append(str);
    $('#loading-circle-article').css('display', 'none');
}

//function to create an ICon for category as folder
function setCategoryIcon(){
    //define icon for category
    return '<a class="fa actions fa-folder-open actions-categories" id="modify"></a>';
}
//function to create an ICon for article as file
function setArticleIcon(){
    //define icon for category
    return '<a class="fa actions  fa-file-text  actions-articles" id="modify"></a>';
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
        categoryParentId = $(".route-points").last().attr('id'),
        childId = data,
        url = "",
        dataGiven = "";
    //define default valuses
    if (type === 'category') {
        url = "/category/category_relation/";
    }
    else if (type === 'article') {
        url = "/category/article_relation/";
    }
    //if we are in root, we go on in selected category
    if (categoryParentId === "0") {
        button_true('category');
        button_false('article');
    }
    //if not
    else if (categoryParentId !== "0") {
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
    var parentId = $(".route-points").last().attr('id');
    var childId = $(".selected ." + service + "-values#id").text();
    if (parentId === childId && service === "category") {
        checkResponse(409);
        return;
    }
    //if is root category and we select service, we show that category
    if ((parentId === "0" ) && (service === "category")) {
        checkResponse(200, childId, "set", service);
        return;
    }
    //if not, we link curent category with current item
    status = $.ajax({
                        type: 'POST',
                        url: "/" + service + "/link",
                        data: {parent: parentId, child: childId}
                    }).then(function(json){
        checkResponse(json.status, json.category, "add");
    });
}
//function to make decisions after get response message
function checkResponse(status, id, type){
    if (status === 200) {
        if (type === "set") {
            setCategory(id);
        } else if (type === "add") {
            openCategory(id);
        }
    }
}
//function that set in route the selected category and show all items of this
function setCategory(id){
    button_none('category');
    button_none('article');
    if (id === '0') {
        removeItems('.route-points');
        $("#route-row").append(rootPoint);
    } else {
        $.ajax({type: "GET", url: "/category/" + id}).then(function(json){
            str = '<div id="' + json.item.id + '" class="route-points quark-presence-column" >' +  json.item.title.substr(0, 15) + '</div>';
            var status = true;
            //check if that category is already in path
            $(".route-points").each(function(){
                if ($(this).text() === json.item.title) {
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
    if (categoryId === '0')return;
    var categories = $.ajax({url: "/category/Category_Relation/" + categoryId}).then(function(json){
        json.children.forEach(function(data){
            showCurrentItems(data, 'category');
        });
        
    });
    var articles = $.ajax({url: "/category/Article_Relation/" + categoryId}).then(function(json){
        json.articles.forEach(function(data){
            showCurrentItems(data, 'article');
        });
    });
}
//function that will permite open category from list
function openCategory(id){
    setCategory(id);
}
//fucntion to show categories
function showCurrentItems(response, service){
    var setIcon;
    if (service === 'category') {
        setIcon = setCategoryIcon();
    } else {
        setIcon = setArticleIcon();
    }
    str = '<div id="' + service + '-' + response.id + '" class="quark-presence-container current-items current-' + service + '">' +
            '<div class="quark-presence-column icons ' + service + '" id="icon">' + setIcon + '</div>' +
            '<div class="quark-presence-column ids ' + service + '" id="id">' + response.id + '</div>' +
            '<div class="quark-presence-column titles ' + service + '" id="title">' + response.title + '</div>' +
            '<div class="quark-presence-column actions ' + service + '" id="actions">' + setSpecialActions(response.id,service) + '</div>' +
          '</div>';
    $("#content-container").append(str);
}
//function to redirect to clicked category in root bar
function routeRedirect(id){
    setCategory(id);
}
//action for management items in left column
function setSpecialActions(id, model){
    //define edit and remove buttons for all rows
    return actions =
        '<a class="fa actions edit-button-' + model + ' fa-pencil content-actions " id="' + id + '" href="/' + model + '/edit/' + id + '?source=EditContent""></a>' +
        '<a class="fa actions special-delete-button-' + model + ' fa-eraser content-actions "  id="' + id + '" "></a>';
}