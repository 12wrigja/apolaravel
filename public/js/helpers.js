function minimizeToIDs(collection) {
    var result = [];
    if ($.isArray(collection)) {
        for (var i = 0; i < collection.length; i++) {
            result.push(collection[i].id);
        }
    }
    return result;
}

function cleanupErrors(formID) {
    var formGroups = $('#' + formID + " .form-group.has-error");
    $.each(formGroups, function (index, group) {
        $(group).removeClass('has-error');
        $(group).children(".help-block").text('');
    });
}

function renderErrors(formID, jsonErrors) {
    $.each(jsonErrors, function (fieldName, error) {
        var field = $('#' + formID + ' [name="' + fieldName + '"]')[0];
        var parent = $(field).parent('.form-group')[0];
        $(parent).addClass('has-error');
        var errorBlock = $(parent).children(".help-block");
        $(errorBlock).text(error[0]);
    });
}

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json'
        }
    });

});

function collapseSwap(obj1, obj2) {
    var obj1 = $(obj1);
    var obj2 = $(obj2);
    obj1.collapse('show');
    obj2.collapse('hide');
}