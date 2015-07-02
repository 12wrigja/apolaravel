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

function collapseSwap(obj1, obj2) {
    var obj1 = $('#'+obj1);
    var obj2 = $('#'+obj2);
    obj1.collapse('show');
    obj2.collapse('hide');
}

function createEntity(url, formData){
    return $.ajax({
        url:url,
        type:'post',
        data: formData
    });
}

function updateEntity(url, formData, formID){
    return $.ajax({
        url:url,
        type:'put',
        data:formData
    });
}

function setupDebug(){
    $('.debug-block').addClass('hide');
    $(document).keypress(function( event ) {
        if ( event.which == 126 && event.shiftKey == true) {
            event.preventDefault();
            $('.debug-block').collapse('toggle').removeClass('hidden');
        }
    });
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        'Accept': 'application/json'
    }
});

$(document).ready(function () {
    setupDebug();
});
