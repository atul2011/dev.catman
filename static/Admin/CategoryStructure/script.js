//function what will run at end of loading of page
var selectedColor = 'rgb(51,\ 122,\ 183)';
var selectedTextColor = 'rgb(255,\ 255,\ 255)';
var rootPoint = '<td id="0" class="route-points">></td>';
$(document).ready(function () {
<<<<<<< HEAD
    LoadContent(false, 'none');
    //add event listener on input in search bars
    $(document).on("input", '.search', function () {
        CheckSearch(this.value, this.id);
=======
    
    $('input[type="text"]').keypress(function(event){
        if (event.which === 13) {
            event.preventDefault();
        }
    });
    $('.navigation_form').submit(function(e){
        e.preventDefault();
    });
    //load content
    LoadContent(false, 'article',ShowArticles,1,50);
    LoadContent(false, 'category',ShowCategories,1,50);
    /////////////////////////////////////////////////////////////////
    
    //load selects with columns of models
    var category_select =
        '<option value="id">ID</option>' +
        '<option value="title">Title</option>' +
        '<option value="sub">Type</option>' +
        '<option value="keywords">Keywords</option>' +
        '<option value="priority">Priority</option>';
    $('#category-select').append(category_select);
    
    var article_select =
        '<option value="id">ID</option>' +
        '<option value="title">Title</option>' +
        '<option value="release_date">Release Date</option>' +
        '<option value="event_id">Event</option>' +
        '<option value="author_id">Author</option>' +
        '<option value="keywords">Keywords</option>';
    $('#article-select').append(article_select);
    /////////////////////////////////////////////////////////////////
    var list=$('.items-list');
    $('.loader').css('left',(list.width()/3.3)).css('top',(list.height()/6));
    //add event listener on input in search bars
    $(document).on("input", '#category-search', function () {
        removeItems('.category-row');
        $('#loading-circle-category').css('display','block');
        CheckSearch($('#category-select').val(),this.value,'category', ShowCategories,50);
    });
    $(document).on("input", '#article-search', function () {
        removeItems('.article-row');
        $('#loading-circle-article').css('display','block');
        CheckSearch($('#article-select').val(),this.value,'article', ShowArticles,50);
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
    });

    //stop refreshing when submit
    $(".submit-buttons").submit(function (e) {
        e.preventDefault();
    });

    //add event listener to checkbox "no parents"
    $(document).on("change", ".orfan", function () {
        noParents($(this).is(':checked'), $(this).attr('id'));
    });
    ///event listener to delete icons for delete content
    $(document).on('dblclick', '.delete-button-category', function () {
        response = prompt('Do you want to delete this y/n ?', '');
        if (response === 'n') {
            return false;
        } else if (response === 'y') {
            $.ajax({url: "/category/delete/" + $(this).attr('id'), type: "POST"}).then(function (data) {
                if (data !== null && data !== '')
                    console.log(data);
            });
<<<<<<< HEAD
            LoadContent(false, 'none');
=======
            LoadContent(false, 'category',ShowCategories,1,50);
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
            setCategory($(".route-points").last().attr('id'));
        } else {
            return false;
        }
    });
    $(document).on('dblclick', '.delete-button-article', function () {
        response = prompt('Do you want to delete this y/n ?', '');
        if (response === 'n') {
            return false;
        } else if (response === 'y') {
            $.ajax({url: "/article/delete/" + $(this).attr('id'), type: "POST"}).then(function (data) {
                if (data !== null && data !== '')
                    console.log(data);
            });
<<<<<<< HEAD
            LoadContent(false, 'none');
=======
            LoadContent(false, 'article',ShowArticles,1,50);
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
            setCategory($(".route-points").last().attr('id'));
        }
    });

    //event listener to set paint property to selected rows
    $(document).on('click', '.category-row', function () {
        paintRow($(this).attr("id"), 'category');
        checkRow($(this).find("td:first").text(), 'category');
    });

    $(document).on('click', '.article-row', function () {
        paintRow($(this).attr("id"), 'article');
        checkRow($(this).find("td:first").text(), 'article');
    });

//event listener that will permite redirect when click to route node
    $(document).on("dblclick", '.route-points', function () {
        routeRedirect($(this).attr('id'));
    });
    //set mouse over and out events to route points
    $(document).on("mouseover", '.route-points', function () {
        $(this).css("background-color", selectedColor).css("color", selectedTextColor);
    });
    $(document).on("mouseout", '.route-points', function () {
        $(this).css("background-color", 'white').css("color", 'black');
    });
// event listener that will permite open category in left table
    $(document).on("dblclick", ".current-category", function () {
        openCategory($(this).find("td#id").text());
    });
//set mouse over and out events to list of items in left table
    $(document).on("mouseover", '.current-category', function () {
        $(this).css("background-color", selectedColor).css("color", selectedTextColor);
    });
    $(document).on("mouseout", '.current-category', function () {
        $(this).css("background-color", 'white').css("color", 'black');
    });
    $("#route-row").append(rootPoint);
<<<<<<< HEAD
=======
    
    ////////////////////////////navigation bar//////////////////////////////////////////
    LoadNavigationBar('category',ShowCategories);
    LoadNavigationBar('article',ShowArticles);
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
});

function noParents(orfan, model) {
    LoadContent(orfan, model);
}
<<<<<<< HEAD

//function to load content
function LoadContent(orfan, model) {
    if (model === null || model === undefined) model = 'none';
    //search in db all categories
    $.ajax({url: "/category/list", data: {orfan: orfan, model: model},type:'POST'}).then(function (json) {
        if (json.response !== null) {
            removeItems('.category-row');
            json.response.forEach(ShowCategories);
        }
        //resize the left-table
        getHeight();
        //this script will load after loading of all categories all articles which it contains
        $.ajax({url: "/article/list", data: {orfan: orfan, model: model},type:'POST'}).then(function (json) {
            if (json.response !== null) {
                removeItems('.article-row');
                json.response.forEach(ShowArticles);
            }
//resize the left-table
            getHeight();
        });
    });
=======
//function to load content
function LoadContent(state, model, callback,skip,limit){
    var start = (parseInt(skip) - 1) * 50;
    if (isNaN(start))
        start = (parseInt($('#number'))-1)*50;
    if (model === null || model === undefined) model = 'none';
    $.ajax({url: '/' + model + '/list?skip='+start+'&limit='+limit, data: {orfan: state, model: model}, type: 'POST'}).then(
        function(json){
            if (json.response !== null) {
                removeItems('.'+model+'-row');
                json.response.forEach(callback);
                getHeight();
            } else {
                removeItems('.'+model+'-row');
            }
        });
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
}

//fucntion to show categories
function ShowCategories(response) {
<<<<<<< HEAD
    str = '<tr id="category-values-' + response.id + '" class="category-row">' +
        '<td class="category-values" id="id">' + response.id + '</td>' +
        '<td class="category-values" id="title">' + response.title.substr(0, 30)  + '</td>' +
        '<td class="category-values" id="type">' + response.sub + '</td>' +
        '<td class="category-values" id="content">' + '<textarea rows="3" cols="25" class="content quark-input" readonly>' + response.intro.substr(0, 200) + '</textarea>' + '</td>' +
        '<td class="category-values" id="actions">' + setActions('category', response.id) + '</td>' +
        '</tr>';
    $("#category-container").append(str);
=======
    str = '<div class="quark-presence-container presence-block category-row" id="category-values-' + response.id + '">' +
        '<div class="category-values quark-presence-column ids" id="id">' + response.id + '</div>' +
        '<div class="category-values quark-presence-column titles" id="title">' + response.title.substr(0, 70)  + '</div>' +
        '<div class="category-values quark-presence-column types" id="type">' + response.sub + '</div>' +
        '<div class="category-values quark-presence-column contents" id="content">' + '<textarea rows="3" cols="30" class="content quark-input" readonly>' + response.intro.substr(0, 200) + '</textarea>' + '</div>' +
        '<div class="category-values quark-presence-column actions" id="actions">' + setActions(response.id,'category') + '</div>' +
        '</div>';
    $("#category-column").append(str);
    $('#loading-circle-category').css('display','none');
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
}

//fucntion to show the articles
function ShowArticles(response) {
<<<<<<< HEAD
    str = '<tr id="article-values-' + response.id + '" class="article-row">' +
        '<td class="article-values" id="id">' + response.id + '</td>' +
        '<td class="article-values" id="title">' + response.title.substr(0, 30)  + '</td>' +
        '<td class="article-values" id="date">' + response.release_date + '</td>' +
        '<td class="article-values" id="content">' + '<textarea rows="3" cols="25" class="content quark-input" readonly>' + response.txtfield.substr(0, 200) + '</textarea>' + '</td>' +
        '<td class="article-values" id="actions">' + setActions('article', response.id) + '</td>' +
        '</tr>';
    $("#articles-container").append(str);
=======
    str = '<div class="quark-presence-container presence-block article-row" id="article-values-' + response.id + '">' +
        '<div class="article-values quark-presence-column ids" id="id">' + response.id + '</div>' +
        '<div class="article-values quark-presence-column titles" id="title">' + response.title.substr(0, 50) + '</div>' +
        '<div class="article-values quark-presence-column dates" id="date">' + response.release_date + '</div>' +
        '<div class="article-values quark-presence-column contents" id="content">' + '<textarea rows="3" cols="30" class="content quark-input" readonly>' + response.txtfield.substr(0, 200) + '</textarea>' + '</div>' +
        '<div class="article-values quark-presence-column actions" id="actions">' + setActions(response.id, 'article') + '</div>' +
        '</div>';
    $("#article-column").append(str);
    $('#loading-circle-article').css('display','none');
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
}

//fucntion to add to each item in actions column the anchors-icons for redirecting
function setActions(model, id) {
    //define edit and remove buttons for all rows
    return actions =
        '<a class="fa actions edit-button-' + model + ' fa-pencil content-actions " id="' + id + '" href="/' + model + '/edit/' + id + '""></a>' +
        '<a class="fa actions delete-button-' + model + ' fa-eraser content-actions " id="' + id + '" "></a>';
}
//function to create an ICon for category as folder
function setCategoryIcon() {
    //define icon for category
    return '<a class="fa actions fa-folder-open actions-categories" id="modify"></a>';
}
//function to create an ICon for article as file
function setArticleIcon() {
    //define icon for category
    return '<a class="fa actions  fa-file-text  actions-articles" id="modify"></a>';
}
//return height of right div for resizing left div
function getHeight() {
    height = $("div#list-right").outerHeight() - $("table#route").outerHeight();
    $("div#elements-list").outerHeight(height).css("border", "1px solid grey").css("border-top", "0");
    $("div#list-center , div#list-center table").outerHeight(height);
}

//function to check when you want to find items
<<<<<<< HEAD
function CheckSearch(str, id) {
    //if search bar is empty, we load default list
    if (str.length === 0) {
        LoadContent(false, type);
        return;
    }
    var type = '';
    if (id === 'categories') type = 'category'; else type = 'article';
    //if not to search in DB items by inserted string
    $.ajax({url: "/" + type + "/search?title=" + str,type:'POST'}).then(function (json) {
            if (id === 'categories') {
                if (json.response !== '') {
                    //remove all old search and put new
                    removeItems('.category-row');
                    json.response.forEach(ShowCategories);
                }
                else {
                    removeItems('.category-row');
                }
            }
            else if (id === 'articles') {
                if (json.response !== '') {
                    removeItems('.article-row');
                    json.response.forEach(ShowArticles);
                } else {
                    removeItems('.article-row');
                }
=======
function CheckSearch(name, str, model, callback, limit){
    //if search bar is empty, we load default list
    if (str.length === 0) {
        LoadContent(false, model, callback, 1,50);
        return;
    }
    //if not to search in DB items by inserted string
    $.ajax({url: '/' + model + '/search?limit=' + limit, type: 'POST', data: {value: str, field: name}}).then(
        function(json){
            if (json.response !== '') {
                removeItems('.'+model+'-row');
                json.response.forEach(callback);
            } else {
                removeItems('.'+model+'-row');
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
            }
        }
    );
}
<<<<<<< HEAD
=======

>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
//clear all items from left-table
function removeItems(selector) {
    $(selector).remove();
}
//function to paint checked row
function paintRow(id, type) {
    status = true;
<<<<<<< HEAD
    var default_class = type + "-row";
    //ceck if any another row has checked
    $("tr." + default_class).each(function () {
=======
    var selector = type + "-row";
    var row = $("." + selector );
    //ceck if any another row has checked
    row.each(function () {
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
        if ($(this).css("background-color") === selectedColor) {
            status = false;
        }
    });
    //if not, we paint selected row
    if (status === "true") {
        $("#" + id).css("background-color", selectedColor).addClass("selected").css("color", selectedTextColor);
    }
    //if yes, we paint in white all another rows before paint current row
    else if (status === "false") {
<<<<<<< HEAD
        $("tr." + default_class).each(function () {
            $(this).css("background-color", "white").css("color", 'black').removeClass('selected').addClass(default_class);
=======
        row.each(function () {
            $(this).css("background-color", "white").css("color", 'black').removeClass('selected').addClass(selector);
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
        });

        $("#" + id).css("background-color", selectedColor).addClass("selected").css("color", selectedTextColor);
    }
}

//fuction to ceck row
function checkRow(data, type) {
    var
        categoryParentId = $(".route-points").last().attr('id'),
        childId = data,
        url = "",
        dataGiven = "",
        service = "";
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
        $.ajax({url: url + categoryParentId}).then(function (json) {
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
                dataGiven.forEach(function (data) {
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
function button_true(type) {
    $("#" + type + "-link").removeClass("link-false").removeClass("link-none").addClass("link-true");
}
function button_false(type) {
    $("#" + type + "-link").removeClass("link-true").removeClass("link-none").addClass("link-false");
}
function button_none(type) {
    $("#" + type + "-link").removeClass("link-true").removeClass("link-false").addClass("link-none");
}

//function ceck link between current category and selected item
<<<<<<< HEAD
function Link(service, type) {
    if ($("#" + type + "-link").attr("class") !== "link-true")
        return;
    var parentId = $(".route-points").last().attr('id');
    var childId = $(".selected." + type + "-row td").first().text();
    if (parentId === childId && type === "category") {
=======
function Link(service) {
    if ($("#" + service + "-link").attr("class") !== "link-true")
        return;
    var parentId = $(".route-points").last().attr('id');
    var childId = $(".selected ." + service + "-values#id").text();
    if (parentId === childId && service === "category") {
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
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
    }).then(function (json) {
        checkResponse(json.status, json.category, "add");
    });
}
//function to make decisions after get response message
function checkResponse(status, id, type) {
    if (status === 200) {
        if (type === "set") {
            setCategory(id);
        } else if (type === "add") {
            openCategory(id);
        }
    }
}
//function that set in route the selected category and show all items of this
function setCategory(id) {
    button_none('category');
    button_none('article');
    if (id === '0') {
        removeItems('.route-points');
        $("#route-row").append(rootPoint);
    } else {
        $.ajax({type: "GET", url: "/category/" + id}).then(function (json) {
            str = '<td id="' + json.item.id + '" class="route-points" >' + json.item.title + '</td>';
            var status = true;
            //check if that category is already in path
            $("tr#route-row td").each(function () {
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
function ListCategory(categoryId) {
    removeItems('.current-items');
    if (categoryId === '0')return;
    var categories = $.ajax({url: "/category/Category_Relation/" + categoryId}).then(function (json) {
        json.children.forEach(function (data) {
            showCurrentItems(data, 'category');
        });

    });
    var articles = $.ajax({url: "/category/Article_Relation/" + categoryId}).then(function (json) {
        json.articles.forEach(function (data) {
            showCurrentItems(data, 'article');
        });
    });
}
//function that will permite open category from list
function openCategory(id) {
    setCategory(id);
}
//fucntion to show categories
function showCurrentItems(response, service) {
    var setIcon;
    if (service === 'category') {
        setIcon = setCategoryIcon();
    } else {
        setIcon = setArticleIcon();
    }
    str = '<tr id="' + service + '-' + response.id + '" class="current-items current-' + service + '">' +
        '<td class="' + service + '" id="icon">' + setIcon + '</td>' +
        '<td class="' + service + '" id="id">' + response.id + '</td>' +
        '<td class="' + service + '" id="title">' + response.title + '</td>' +
        '<td class="' + service + '" id="actions">' + setActions(service, response.id) + '</td>' +
        '</tr>';
    $("#content-container").append(str);
}
//function to redirect to clicked category in root bar
function routeRedirect(id) {
    setCategory(id);
<<<<<<< HEAD
=======
}


















////////////////////////navbar
function LoadNavigationBar(model, callback){
    var special_model ='';
    if($('#number-'+model).val() !== undefined)
        special_model='-'+model;
    var data = $('#number'+special_model).val();
    var endpoint = parseInt(parseInt(data) / 50) + 1;
    
    getMaxPages(1, endpoint,special_model);
    
    $(document).on('click', '.current-page'+special_model+' .nav-button'+special_model, function(){
        LoadContent(false, model, callback, $(this).val(),50);
        getMaxPages($(this).val(), endpoint,special_model);
    });
    $(document).on('click', '.nav-button'+special_model+'#prev', function(){
        var skip = parseInt($('.current-page'+special_model+' .selected-page').val());
        --skip;
        LoadContent(false, model, callback, skip,50);
        getMaxPages(skip,endpoint,special_model);
    });
    $(document).on('click', '.nav-button'+special_model+'#next', function(){
        var skip = parseInt($('.current-page'+special_model+' .selected-page').val());
        ++skip;
        LoadContent(false, model, callback, skip,50);
        getMaxPages(skip, endpoint,special_model);
    });
    $(document).on('click', '.nav-button'+special_model+'#first', function(){
        LoadContent(false, model, callback, 1,50);
        getMaxPages(1,endpoint,special_model);
    });
   
    
    $(document).on('click', '.nav-button'+special_model+'#last', function(){
        LoadContent(false, model, callback, endpoint,50);
        getMaxPages(endpoint,endpoint,special_model);
    });
}
//////////////////////////////////    | |    ///////////////////////////
//////////////////////////////////   _| |_   ///////////////////////////
//////////////////////////////////   \   /   ///////////////////////////
//////////////////////////////////    \ /    ///////////////////////////
//////////////////////////////////     V     ///////////////////////////
function getMaxPages(current,endpoint,special_model){
    $(".orfan").prop('checked', false);
    
    if (parseInt(current) === endpoint) {
        $('.nav-button'+special_model+'#next').prop('disabled', true).addClass('inactive-page');
        $('.nav-button'+special_model+'#last').prop('disabled', true).addClass('inactive-page');
    }
    else {
        $('.nav-button'+special_model+'#next').prop('disabled', false).removeClass('inactive-page');
        $('.nav-button'+special_model+'#last').prop('disabled', false).removeClass('inactive-page');
    }
    if (parseInt(current) === 1) {
        $('.nav-button'+special_model+'#first').prop('disabled', true).addClass('inactive-page');
        $('.nav-button'+special_model+'#prev').prop('disabled', true).addClass('inactive-page');
    } else {
        $('.nav-button'+special_model+'#first').prop('disabled', false).removeClass('inactive-page');
        $('.nav-button'+special_model+'#prev').prop('disabled', false).removeClass('inactive-page');
    }
    getPages(current, endpoint,special_model);
}
//////////////////////////////////    | |    ///////////////////////////
//////////////////////////////////   _| |_   ///////////////////////////
//////////////////////////////////   \   /   ///////////////////////////
//////////////////////////////////    \ /    ///////////////////////////
//////////////////////////////////     V     ///////////////////////////
function getPages(current, endpoint,special_model){
    var start = 1,
        stop = endpoint;
    if (endpoint < 6) {
        $('.space_buttons'+'.nav-button'+special_model).css('display', 'none');
        removeItems('.current-page'+special_model);
        start = 1;
        stop = endpoint;
    } else if (endpoint >= 6) {
        //calculte first-button-page
        start = current - 2;
        if (start > 1) $('#space_prev'+'.nav-button'+special_model).css('display', 'inline');
        else if (start <= 1) {
            $('#space_prev'+'.nav-button'+special_model).css('display', 'none');
            start = 1;
        }
        //calculte last-button-page
        stop = start + 4;
        if (stop >= endpoint) {
            $('#space_next'+'.nav-button'+special_model).css('display', 'none');
            stop = endpoint;
            start = stop - 5;
        } else if (stop < endpoint) $('#space_next'+'.nav-button'+special_model).css('display', 'inline');
        removeItems('.current-page'+special_model);
    }
    setPages(current, start, stop,special_model);
}
//////////////////////////////////    | |    ///////////////////////////
//////////////////////////////////   _| |_   ///////////////////////////
//////////////////////////////////   \   /   ///////////////////////////
//////////////////////////////////    \ /    ///////////////////////////
//////////////////////////////////     V     ///////////////////////////
function setPages(current, start, stop,special_model){
    var string = '';
    while (start <= stop) {
        string += '<div class="quark-presence-column  current-page'+special_model+'">' +
            '<button type="submit" class="nav-button '+'nav-button'+special_model +'" value="' + start + '" id="' + start + '">' + start + '</button>' +
            '</div>';
        ++start;
    }
    $('.current-pages'+special_model).append(string);
    $('.nav-button'+'.nav-button'+special_model).removeClass('selected-page');
    $('.nav-button'+special_model+'.nav-button#' + current).addClass('selected-page');
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
}