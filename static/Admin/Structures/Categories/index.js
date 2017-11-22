var selectedColor = 'rgb(51,\ 122,\ 183)';
var selectedTextColor = 'rgb(255,\ 255,\ 255)';
var rootPoint = '<div id="route-point-' + root_id + '" class="route-points quark-presence-column">' + root_name + '</div>';//root_id and root_name i send from ViewModel.

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
    '<option value="type">Type</option>';

function setDefaultEvents (model,callback) {
    $(document).on("keydown", '#'+model+'-search', function(e) {
        if (e.keyCode === 13) {
            removeItems('.content-row-'+model);
            $('#loading-circle-'+model).css('display', 'block');
            CheckSearch($('#'+model+'-select').val(), this.value, model, callback, 50,'multiple');
        }
    });
    
    $(document).on("change", '#'+model+'-orfan', function() {
        removeItems('.content-row-'+model);
        $('#loading-circle-'+model).css('display', 'block');
        noParents($(this).is(':checked'), model, callback, 50,'multiple');
    });

    $(document).on('click', '.content-row-'+model, function() {
        paintRow($(this).attr("id"), model);
        checkRow($(this).find("td:first").text(), model);
    });

    LoadNavigationBar('multiple',model, callback);////////////////////////////navigation bar
}

$(document).ready(function () {
    $('.navigation_form').submit(function(e){
        e.preventDefault();
    });
    //load content
    LoadContent(false, 'article', ShowArticles, 1, 50,'multiple');
    LoadContent(false, 'category', ShowCategories, 1, 50,'multiple');

    setDefaultEvents('category',ShowCategories);
    setDefaultEvents('article',ShowArticles);

    setCategory(root_id);

    //load selects with columns of models
    $('#category-select').append(category_select);
    $('#article-select').append(article_select);

    var list = $('.items-list');
    $('.loader').css('left', (list.width() / 3.3)).css('top', (list.height() / 6));

    $(".submit-buttons").submit(function(e){//stop refreshing when submit
        e.preventDefault();
    });

//event listener that will permite redirect when click to route node
    $(document).on("dblclick", '.route-points', function () {
        if ($(this).attr('id').split('-')[2] == root_id)
            $(".route-points").remove();

        setCategory($(this).attr('id').split('-')[2]);
    });

    $(document).on("dblclick", '.contextual-refresh', function () {
        setCategory($('.route-points').last().attr('id').split('-')[2]);
    });

    //set mouse over and out events to route points
    $(document).on("mouseover", '.route-points', function () {
        $(this).css("background-color", selectedColor).css("color", selectedTextColor);
    });

    $(document).on("mouseout", '.route-points', function () {
        $(this).css("background-color", 'white').css("color", 'black');
    });

    $(document).on("dblclick", '.actions-categories', function () {// event listener that will permite open category in left table
        setCategory($(this).attr('id').split('-')[2]);
    });

//set mouse over and out events to list of items in left table
    $(document).on("mouseover", '.current-category', function () {
        $(this).css("background-color", selectedColor).css("color", selectedTextColor);
    });

    $(document).on("mouseout", '.current-category', function () {
        $(this).css("background-color", 'white').css("color", 'black');
    });

//set event to link-buttons that will realize the link between open category and right items
    var list_height = $('#list-right').height();
    $('#button-link-category').css('margin-top',list_height/5);
    $('#button-link-article').css('margin-top',list_height/2.2);

//when we click on priority-input, he will call this code to send ajax request which will update priority to this item
    $(document).on('submit', '.form-priority-change', function (e) {
        e.preventDefault();

        $.ajax({url:$(this).attr('action'), type:$(this).attr('method'), data:SerializeForm($(this))}).then(function (data) {
            if (data.status === 200)
                $('#presence-header').notify('Success', {position:'bottom-center', className:'success'});
            else if (data.status === 500)
                $('#presence-header').notify('Failed', {position:'bottom-center', className:'error'});
        });
    });
});

function ShowCategories (response) {//function to show categories
    var str =
        '<div class="quark-presence-container presence-block content-row-category content-row" id="category-values-' + response.id + '">' +
            '<div class="category-values quark-presence-column ids" id="category-id-' + response.id + '">' + response.id + '</div>' +
            '<div class="category-values quark-presence-column titles" id="category-title-' + response.id + '">' + response.title.substr(0, 70) + '</div>' +
            '<div class="category-values quark-presence-column types" id="category-type-' + response.id + '">' + response.sub + '</div>' +
            '<div class="category-values quark-presence-column actions" id="category-actions-' + response.id + '">' + setActions(response.id, 'category') + '</div>' +
        '</div>';

    $("#category-column").append(str);
    $('#loading-circle-category').css('display', 'none');
}

function ShowArticles (response) {//function to show the articles
    var str =
        '<div class="quark-presence-container presence-block content-row-article content-row" id="article-values-' + response.id + '">' +
            '<div class="article-values quark-presence-column ids" id="article-id-' + response.id + '">' + response.id + '</div>' +
            '<div class="article-values quark-presence-column titles" id="article-title-' + response.id + '">' + response.title.substr(0, 50) + '</div>' +
            '<div class="article-values quark-presence-column dates" id="article-date-' + response.id + '">' + response.release_date + '</div>' +
            '<div class="article-values quark-presence-column actions" id="article-actions-' + response.id + '">' + setActions(response.id, 'article') + '</div>' +
        '</div>';
    $("#article-column").append(str);
    $('#loading-circle-article').css('display', 'none');
}

function getHeight () {//return height of right div for resizing left div
    var height = $("div#list-right").outerHeight() - $("table#route").outerHeight();

    $("div#elements-list").outerHeight(height).css("border", "1px solid grey").css("border-top", "0");
    $("div#list-center , div#list-center table").outerHeight(height);
}

//fuction to ceck row
function checkRow(data, type){
    var categoryParentId = $(".route-points").last().attr('id').split('-')[2],
        childId = data,
        url = "",
        dataGiven = "";

    if (type === 'category') {//define default link
        url = "/admin/category/relation/categories/";
    }
    else if (type === 'article') {
        url = "/admin/category/relation/articles/";
    }

    if (categoryParentId === root_id) {//if we are in root, we go on in selected category
        button_true('category');
        button_false('article');
    }
    else if (categoryParentId !== root_id) {//if not
        if (categoryParentId === childId) {
            button_false(type);
            return;
        }

        $.ajax({url: url + categoryParentId}).then(function (json) {//we search in current category all items
            if (type === 'category')
                dataGiven = json.children;
            else if (type === 'article')
                dataGiven = json.articles;

            if (dataGiven.length === 0) {//if category hasn't child, we append current
                button_true(type);
            } else if (dataGiven.length !== 0) {//if not
                var status = true;
                dataGiven.forEach(function(data){
                    if (data.id === childId) {//check if current child is in this category
                        button_false(type);//if we found same link in Db, we set "false" class
                        status = false;
                    }
                });

                if (status === true) {//if not, we add "true" class
                    button_true(type);
                }
            }
        });
    }
}
//function to put style to buttons
function button_true (type) {
    $("#" + type + "-link").removeClass("link-false").removeClass("link-none").addClass("link-true");
}

function button_false (type) {
    $("#" + type + "-link").removeClass("link-true").removeClass("link-none").addClass("link-false");
}

function button_none (type) {
    $("#" + type + "-link").removeClass("link-true").removeClass("link-false").addClass("link-none");
}

function Link (service) {//function ceck link between current category and selected item
    if ($("#" + service + "-link").attr("class") !== "link-true")
        return;

    var parentId = $(".route-points").last().attr('id').split('-')[2];
    var childId = $(".selected ." + service + "-values").attr('id').split('-')[2];

    if (parentId === childId && service === "category") {
        checkResponse(409,'');

        return;
    }

    if ((parentId === "0" ) && (service === "category")) {//if is root category and we select service, we show that category
        checkResponse(200, childId);

        return;
    }

    $.ajax({type: 'POST', url: "/admin/" + service + "/link",data: {parent: parentId, child: childId}})//if not, we link curent category with current item
     .then(function (json) {
        checkResponse(json.status, json.category);
    });
}

function checkResponse (status, id) {//function to make decisions after get response message
    if (status === 200) setCategory(id);
}

function setCategory (id) {//function that set in route the selected category and show all items of this
    button_none('category');
    button_none('article');

    $.ajax({type: "GET", url: "/admin/category/" + id}).then(function (json) {
        var str = '<div id="route-point-' + json.item.id + '" class="route-points quark-presence-column" >' +  json.item.title.substr(0, 15) + '</div>';

        $(".route-points").each(function() {//check if that category is already in path
            if ($(this).attr('id').split('-')[2] == json.item.id) {
                $(".route-points").remove();

                if (id != root_id)
                    $("#route-row").append(rootPoint);
            }
        });

        $("#route-row").append(str);

        ListCategory(id, 50);
    });


}

function ListCategory (categoryId, limit) {//function to load in left table data about category
    removeItems('.current-items');

    $.ajax({url: "/admin/category/relation/categories/" + categoryId + "?limit=" + limit}).then(function (json) {//load categories for selected category
        if (json.status === 404)
            return false;

        json.children.forEach(function (data) {
            showCurrentItems(data, 'category');
        });
        
    });

    $.ajax({url: "/admin/category/relation/articles/" + categoryId}).then(function (json) {//load articles for selected category
        if (json.status === 404)
            return false;

        json.articles.forEach(function (data) {
            showCurrentItems(data, 'article');
        });
    });
}

function showCurrentItems (response, service) {//function to show related items(categories and articles) of selected category
    var setIcon;

    if (service === 'category')
        setIcon = setCategoryIcon(response.id);
    else
        setIcon = setArticleIcon(response.id);

    var str =
        '<div id="' + service + '-' + response.id + '" class="quark-presence-container current-items current-' + service + '">' +
            '<div class="quark-presence-column icons ' + service + '" id="current-category-icon-' + response.id + '">' + setIcon + '</div>' +
            '<div class="quark-presence-column ids ' + service + '" id="current-category-id-' + response.id + '">' + response.id + '</div>' +
            '<div class="quark-presence-column titles ' + service + '" id="current-category-title-' + response.id + '">' + response.title + '</div>' +
            '<div class="quark-presence-column actions special-actions ' + service + '" id="current-category-actions-' + response.id + '">' + setSpecialActions(response.id, service) + '</div>' +
                '<div class="quark-presence-column relation-priority-container">' +
                    '<form class="form-priority-change" action="/admin/' + service + '/relation/priority/" method="POST">' +
                        '<input class="structure-input-priority" name="priority" type="number" min="0" max="100" size="4" value="' + response.runtime_priority + '">' +
                        '<input name="parent_id" type="hidden" value="' + response.runtime_category + '">' +
                        '<input name="child_id" type="hidden" value="' + response.id + '">' +
                    '</form>' +
                '</div>' +
        '</div>';

    $("#content-container").append(str);
}

function setSpecialActions (id, model) {//action for management items in left column
    var current_category_id = $('.route-points').last().attr('id').split('-')[2];

    return actions =
        '<a class="fa actions edit-button-' + model + ' fa-pencil content-actions " id="current-category-edit-' + id + '" href="/admin/' + model + '/edit/' + id + '"></a>' +
        '<a class="fa actions special-delete-button-' + model + ' fa-eraser content-actions item-remove-dialog" href="/admin/' + model + '/relation/delete/' + current_category_id + '/' + id + '" quark-dialog="#item-remove" quark-redirect="/admin/structures/categories/"></a>';
}

function setCategoryIcon (id) {//function to create an icon for category as folder
    return '<a class="fa actions fa-folder-open actions-categories" id="category-icon-'+id+'"></a>';
}

function setArticleIcon (id) {//function to create an icon for article as file
    return '<a class="fa actions  fa-file-text  actions-articles" id="article-icon-'+id+'"></a>';
}

function SerializeForm (form) {//function that create form on form -> json object which i can use in ajax requests
    var config = {};

    form.serializeArray().map(function (item) {
        if ( config[item.name] ) {
            if ( typeof(config[item.name]) === "string" ) {
                config[item.name] = [config[item.name]];
            }
            config[item.name].push(item.value);
        } else {
            config[item.name] = item.value;
        }
    });

    return config;
}