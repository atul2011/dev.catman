//NAVBAR SETTINGS
function SetSearchParams () {
    $('#cm-search-page').val(parseInt($('#cm-list-current-page').val()));
    $('#cm-search-orphan').val($('#cm-list-orphan-switch').attr('quark-enabled'));
}

$(document).on('click', '.navbar-page', function (e) {
    $('#cm-list-current-page').val(parseInt($(this).find('.cm-list-page').val()));
    $('#cm-list-search-form').submit();
});

$(document).on('submit', '#cm-list-search-form', function (e) {
    SetSearchParams();
});
//---------------------------------------------------------------------------------------------------------------------

function ResizeContent () {
    $('#cm-content-container').css('max-width', $(window).width() - parseInt($('#presence-menu-side-parent').width()) - 100);
}

$(document).ready(function () {
    ResizeContent();
});

$(window).on('resize', function () {
    ResizeContent();
});

$(function(){
    var remove = new Quark.Controls.Dialog('.cm-item-remove-dialog', {
        success: function(trigger, dialog){
            trigger.parents('.list-item').remove();

            var redirect = trigger.attr('cm-redirect');

            if (redirect)
                setTimeout(function(){window.location.href = redirect}, 1000);
        }
    });
});//item-remove dialog

$(function(){
    var action = new Quark.Controls.Dialog('.cm-decision-dialog', {
        success: function(trigger, dialog){
            var redirect = trigger.attr('cm-redirect');

            if (redirect)
                setTimeout(function(){window.location.href = redirect}, 1000);
        }
    });
});//item-action dialog

function SerializeForm (form) {//function that create form on form -> json object which i can use in ajax requests
    var config = {};

    form.serializeArray().map(function (item) {
        if (config[item.name]) {
            if (typeof(config[item.name]) === "string")
                config[item.name] = [config[item.name]];

            config[item.name].push(item.value);
        }
        else
            config[item.name] = item.value;

    });

    return config;
}