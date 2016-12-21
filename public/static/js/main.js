$.postJSON = function(url, data, callback) {
    return jQuery.ajax({
        'type' : 'POST',
        'url': url,
        'data': data,
        'dataType' : 'json',
        'success' : callback
    });
};

$.deleteJSON = function(url, data, callback) {
    return jQuery.ajax({
        'type' : 'DELETE',
        'url': url,
        'data': data,
        'dataType' : 'json',
        'success' : callback
    });
};
