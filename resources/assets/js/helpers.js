function minimizeToIDs(collection) {
    var result = [];
    if ($.isArray(collection)) {
        for (var i = 0; i < collection.length; i++) {
            result.push(collection[i].id);
        }
    }
    return result;
}