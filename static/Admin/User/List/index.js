$(document).ready(function(){
    var model_select =
        '<option value="id">ID</option>' +
        '<option value="login">Login</option>' +
        '<option value="name">Name</option>' +
        '<option value="email">Email</option>' +
        '<option value="rights">Rights</option>';
    $('#user-select').append(model_select);
    
    resizeList(120,60);
    LoadContent(false, 'user', ShowUsers,1,50);

    $(document).on("keydown", '.search', function(e){// add event listener on input in search bars
        if (e.keyCode === 13) {
            removeItems('.content-row');
            $('#loading-circle').css('display','block');
            CheckSearch($('#user-select').val(), this.value, 'user', ShowUsers,50);
        }
    });
    
    $(document).on('click', '.content-row', function(){
        paintRow($(this).attr("id"));
    });
    ////////////////////////////navigation bar//////////////////////////////////////////
    LoadNavigationBar('author',ShowUsers);
});
//function to show categories
function ShowUsers(response) {
    str = '<div class="quark-presence-container presence-block content-row" id="user-values-' + response.id + '">' +
        '<div class="content-values quark-presence-column ids">' + response.id + '</div>' +
        '<div class="content-values quark-presence-column logins">' + response.login + '</div>' +
        '<div class="content-values quark-presence-column names">' + response.name + '</div>' +
        '<div class="content-values quark-presence-column emails">' + response.email + '</div>' +
        '<div class="content-values quark-presence-column rights">' + response.rights + '</div>' +
        '<div class="content-values quark-presence-column actions">' + setActions(response.id,'user') + '</div>' +
        '</div>';
    $("#list-content").append(str);
    $('#loading-circle').css('display','none');
}