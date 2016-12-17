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

$('.show-movies').on('click', function() {
    $.getJSON('/api/movies', [], function(data) {
        if (data.Status === 1) {
            var listItems = data.Movies.reduce(function(res, current) {
              return res
                + '<li>'
                +   '<b>' + current.title + '</b>'
                +   ' (' + current.year + ') - '
                +   current.format
                + '</li>';
            }, '');
            $('ul.catalog').html(listItems);
        } else {
            $('ul.catalog').text('Something went wrong');
        }
    });
});
