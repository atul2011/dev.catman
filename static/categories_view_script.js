//function what will run at end of loading of page
var selectedColor = 'rgb(51,\ 122,\ 183)';
var selectedTextColor = 'rgb(255,\ 255,\ 255)';
var rootPoint = '<td id="0" class="route-points">></td>';
$(document).ready(function () {
    LoadContent(false, 'none');
    //add event listener on input in search bars
    $(document).on("input", '.search', function () {
        CheckSearch(this.value, this.id);
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
            LoadContent(false, 'none');
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
            LoadContent(false, 'none');
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
});
function noParents(orfan, model) {
    LoadContent(orfan, model);
}

//function to load content
function LoadContent(orfan, model) {
    if (model === null || model === undefined) model = 'none';
    //search in db all categories
    $.ajax({url: "/category/all", data: {orfan: orfan, model: model}}).then(function (json) {
        if (json.response !== null) {
            removeItems('.category-row');
            json.response.forEach(ShowCategories);
        }
        //resize the left-table
        getHeight();
        //this script will load after loading of all categories all articles which it contains
        $.ajax({url: "/article/all", data: {orfan: orfan, model: model}}).then(function (json) {
            if (json.response !== null) {
                removeItems('.article-row');
                json.response.forEach(ShowArticles);
            }
//resize the left-table
            getHeight();
        });
    });
}

//fucntion to show categories
function ShowCategories(response) {
    str = '<tr id="category-values-' + response.id + '" class="category-row">' +
        '<td class="category-values" id="id">' + response.id + '</td>' +
        '<td class="category-values" id="title">' + response.title.substr(0, 30)  + '</td>' +
        '<td class="category-values" id="type">' + response.sub + '</td>' +
        '<td class="category-values" id="content">' + '<textarea rows="3" cols="25" class="content quark-input" readonly>' + response.intro.substr(0, 200) + '</textarea>' + '</td>' +
        '<td class="category-values" id="actions">' + setActions('category', response.id) + '</td>' +
        '</tr>';
    $("#category-container").append(str);
}

//fucntion to show the articles
function ShowArticles(response) {
    str = '<tr id="article-values-' + response.id + '" class="article-row">' +
        '<td class="article-values" id="id">' + response.id + '</td>' +
        '<td class="article-values" id="title">' + response.title.substr(0, 30)  + '</td>' +
        '<td class="article-values" id="date">' + response.release_date + '</td>' +
        '<td class="article-values" id="content">' + '<textarea rows="3" cols="25" class="content quark-input" readonly>' + response.txtfield.substr(0, 200) + '</textarea>' + '</td>' +
        '<td class="article-values" id="actions">' + setActions('article', response.id) + '</td>' +
        '</tr>';
    $("#articles-container").append(str);
}

//fucntion to add to each item in actions column the anchors-icons for redirecting
function setActions(model, id) {
    //define edit and remove buttons for all rows
    return actions =
        '<a class="fa actions edit-button-' + model + ' fa-pencil actions-' + model + '" id="' + id + '" href="/' + model + '/edit/' + id + '""></a>' +
        '<a class="fa actions delete-button-' + model + ' fa-eraser actions-' + model + '" id="' + id + '" "></a>';
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
function CheckSearch(str, id) {
    //if search bar is empty, we load default list
    if (str.length === 0) {
        LoadContent(false, type);
        return;
    }
    var type = '';
    if (id === 'categories') type = 'category'; else type = 'article';
    //if not to search in DB items by inserted string
    $.ajax({url: "/" + type + "/search?title=" + str}).then(function (json) {
            if (id === 'categories') {
                if (json.response !== '') {
                    //renove all old search and put new
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
            }
        }
    );
}
//clear all items from left-table
function removeItems(selector) {
    $(selector).remove();
}
//function to paint checked row
function paintRow(id, type) {
    status = true;
    var default_class = type + "-row";
    //ceck if any another row has checked
    $("tr." + default_class).each(function () {
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
        $("tr." + default_class).each(function () {
            $(this).css("background-color", "white").css("color", 'black').removeClass('selected').addClass(default_class);
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
        url = "/category/list/";
    }
    else if (type === 'article') {
        url = "/category/articles/";
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
function Link(service, type) {
    if ($("#" + type + "-link").attr("class") !== "link-true")
        return;
    var parentId = $(".route-points").last().attr('id');
    var childId = $(".selected." + type + "-row td").first().text();
    if (parentId === childId && type === "category") {
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
    var categories = $.ajax({url: "/category/list/" + categoryId}).then(function (json) {
        json.children.forEach(function (data) {
            showCurrentItems(data, 'category');
        });

    });
    var articles = $.ajax({url: "/category/articles/" + categoryId}).then(function (json) {
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
}