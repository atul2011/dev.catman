var creating = false;
var actioning = false;

function GetChildes(parent_id) {
    var links_container = $('#category-links-container');
    links_container.find('.page-category-item-container').remove();

    $.ajax({url: '/admin/category/childes/' + parent_id, 'type': 'GET'}).then(function (data) {
        if (data.status === 200) {
            $.each(data.articles, function (key, item) {
                if (item.grouped === 'true') return true;

                var item_title = (item.title.length > 0 ? item.title : ('NO_TITLE (ID=' + item.id + ')'));
                links_container.append(ItemBuilder(category_group_item_article, item.id, item_title));
            });
            $.each(data.categories, function (key, item) {
                if (item.grouped === 'true') return true;

                var item_title = (item.title.length > 0 ? item.title : ('NO_TITLE (ID=' + item.id + ')'));
                links_container.append(ItemBuilder(category_group_item_category, item.id, item_title));
            });
        }
    });
}

function GetGroups(parent_id) {
    var groups_container = $('#category-groups-container');
    groups_container.find('.group-container').remove();

    $.ajax({url: '/admin/category/group/list/' + parent_id, 'type': 'GET'}).then(function (data) {
        if (data.status === 200) {
            $.each(data.groups, function (key, item) {
                groups_container.append(GroupBuilder(item.id, item.title, item.priority, item.items));
            });
        }
    });
}

function GroupBuilder(id, title, priority, items) {
    var items_html = '';

    $.each(items, function (key, item) {
        var title = (item.title.length > 0 ? item.title : ('NO_TITLE (ID=' + item.target + ')'));
        items_html += ItemBuilder(item.type, item.target, title);
    });

    var group =
        '<div class="group-content-container">' +
            '<div class="group-container" group-id="' + id + '" group-priority="' + priority + '">' +
                '<div class="group-title"><span class="group-priority">' + priority + '</span><span class="group-title-value"> ' + title + '</span><span class="group-delete fa fa-remove"></span></div>' +
                '<input type="hidden" class="group-title-editable" value="' + title + '" autofocus>' +
                '<div class="group-items-container" data-draggable="target" data-draggable-type="drop">' + items_html + '</div>' +
            '</div>' +
        '</div>';

    return group;
}

function ItemBuilder (type, id, title) {
    var fa = (type == category_group_item_category ? 'fa-folder-open' : 'fa-file-o');
    var item =
            '<div class="page-category-item-container" draggable="true" data-draggable="item" app-list-item-id="' + id + '">' +
                '<div class="fa ' + fa + ' page-category-item" item-type="' + type + '" item-id="' + id + '">' +
                    title +
                '</div>' +
            '</div>';

    return item;
}

function GroupItemLink (group, item_type, item_id, callback) {
    $.ajax({url:'/admin/category/group/item/create/', type:"POST", data:{group:group, type:item_type, target:item_id}}).then(function (data) {
        if (data.status === 200) {
            callback();
        }
        else {
            return false;
        }
    });
}

function GroupItemUnlink (group, item_type, item_id, callback) {
    console.log(group, item_type, item_id);
    $.ajax({url:'/admin/category/group/item/delete/', type:"POST", data:{group:group, type:item_type, target:item_id}}).then(function (data) {
        if (data.status === 200) {
            callback();
        }
        else {
            return false;
        }
    });
}

function GetListItemsCurrentPostion() {
    var items = $('.list-item');

    var positions = new Array(items.length);

    $.each(items, function (key, item) {
        positions[key] = $(item).attr('app-list-item-id');
    });

    return positions;
}

$(document).ready(function () {//Load Category groups and childs
    var parent_id = $('#current_category_id').val();
    GetChildes(parent_id);
    GetGroups(parent_id);
});

//Form new grouphandling multiple button click
$(document).on('click', '#category-group-add', function () {
    if (creating === true) return;
    if (creating === false) creating = true;

    var parent_id = $('#current_category_id').val();
    var group_container = $('#category-groups-container');

    $.ajax({url: '/admin/category/group/create/' + parent_id, type: 'POST'}).then(function (data) {
        creating = false;

        if (data.status === 200) {
            group_container.append(GroupBuilder(data.group.id, data.group.title, data.group.priority, []));
        }
    });
});

//Edit Group Details
$(document).on('dblclick', '.group-container .group-title-value', function () {
    var title = $(this).parent();
    title.hide();
    title.parent().find('.group-title-editable').attr('type', 'text');
});

$(document).on('keydown', '.group-container .group-title-editable', function (e) {
    if (e.keyCode == 13) {
        //handling multiple button click
        if (actioning === true) return;
        if (actioning === false) actioning = true;

        var input = $(this);
        var parent = input.parent();

        $.ajax({url:"/admin/category/group/update/" + parent.attr('group-id'), type:"POST", data:{title:input.val()}}).then(function (data) {
            actioning = false;

            if (data.status === 200) {
                parent.find('.group-title').show();
                parent.find('.group-title').find('.group-title-value').html(input.val());
                input.attr('type', 'hidden');
            }
        });

    }
});

$(document).on('dblclick', '.group-container .group-priority', function () {
    $(this).attr('contenteditable', 'true');
});

$(document).on('keydown', '.group-container .group-priority', function (e) {
    if (e.keyCode == 13) {
        //handling multiple button click
        if (actioning === true) return;
        if (actioning === false) actioning = true;

        var input = $(this);
        var parent = input.parent().parent();

        $.ajax({url:"/admin/category/group/update/" + parent.attr('group-id'), type:"POST", data:{priority:input.html()}}).then(function (data) {
            actioning = false;

            if (data.status === 200) {
                input.removeAttr('contenteditable');
            }
        });

    }
});

$(document).on('click', '.group-delete', function () {
    var parent = $(this).parent().parent();
    var item = parent.parent();
    var parent_id = $('#current_category_id').val();

    $.ajax({url:"/admin/category/group/delete/" + parent.attr('group-id')}).then(function (data) {
        if (data.status === 200) {
            item.remove();
            GetChildes(parent_id);
        }
    });
});

//Dragable
(function(){
    //exclude older browsers by the features we need them to support
    //and legacy opera explicitly so we don't waste time on a dead browser
    if (!document.querySelectorAll || !('draggable' in document.createElement('span')) ||  window.opera) { return; }

    //get the collection of draggable items and add their draggable attribute
    for (var items = document.querySelectorAll('[data-draggable="item"]'), len = items.length, i = 0; i < len; i ++) {
        items[i].setAttribute('draggable', 'true');
    }

    //variable for storing the dragging item reference this will avoid the need to define any transfer data which means that the elements don't need to have IDs
    var item = null;
    var parent_dragged = null;
    var parent_dropped = null;

    //dragstart event to initiate mouse dragging
    document.addEventListener('dragstart', function(e) {//set the item reference to this element
        item = e.target;
        parent_dragged = FindDropableParent($(item));
    }, false);

    //dragover event to allow the drag by preventing its default ie. the default action of an element is not to allow dragging
    document.addEventListener('dragover', function(e) {
        if (item) {
            e.preventDefault();
        }
    }, false);

    //drop event to allow the element to be dropped into valid targets
    document.addEventListener('drop', function(e)  {
        //if this element is a drop target, move the item here then prevent default to allow the action (same as dragover)
        var item_to_swap = $(e.target);
        parent_dropped = FindDropableParent(item_to_swap);

        if (parent_dropped != null) {
            // if (parent_dropped.attr('data-draggable-type') === 'swap') {
            //     DropEvent(parent_dragged, parent_dropped);
            //     DragEndEvent(parent_dropped);
            // }
            // else
            if (parent_dropped.attr('data-draggable-type') === 'drop') {
                var group_id = $(e.target).parent().attr('group-id');
                var item_id = $(item).find('.page-category-item').attr('item-id');
                var item_type = $(item).find('.page-category-item').attr('item-type');
                var final_target = (e.target);
                var final_item = item;

                if ($(final_target).attr('action') === 'unlink') {
                    GroupItemUnlink(parent_dragged.parent().attr('group-id'), item_type, item_id, function () {
                        final_target.appendChild(final_item);
                    });

                    return;
                }

                GroupItemLink (group_id, item_type, item_id, function () {
                    final_target.appendChild(final_item);
                });
            }
        }

    }, false);

    //dragend event to clean-up after drop or abort which fires whether or not the drop target was valid
    document.addEventListener('dragend', function(e) {
        item = null;
    }, false);
})();
//On Drag Event
$(document).ready(function () {
    DragEndEvent = (function(_super) {
        return function() {
            // Extend it to log the value for example that is passed
            var category = $('#current_category_id');
            var group = arguments[0];

            var positions = GetListItemsCurrentPostion();

            $.each(positions, function (key, value) {
                $.ajax({url:'/admin/video/replace/' + value + '/' + playlist.val(), type:'POST', data:{position:key}}).then(function (data) {});
            });

            // Or override it by always subtracting 1 for example
            arguments[0] = arguments[0] - 1;
            return _super.apply(this, arguments);
        };

    })(parseFloat);

    DropEvent = (function(_super) {
        return function() {
            // Extend it to log the value for example that is passed

            var parent_dragged = arguments[0];
            var parent_dropped = arguments[1];

            var container  = parent_dragged.html();

            parent_dragged.html(parent_dropped.html());
            parent_dropped.html(container);

            // Or override it by always subtracting 1 for example
            arguments[0] = arguments[0] - 1;
            return _super.apply(this, arguments);
        };

    })(parseFloat);
});