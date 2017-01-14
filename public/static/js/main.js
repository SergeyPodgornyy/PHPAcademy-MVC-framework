$(document).ready(function() {
    var template = $('#content').data('page');
    var action = $('#content').data('action');
    switch (template) {
        case 'movies':
            var templateCtrl = new Movie();
            break;
        case 'books':
            var templateCtrl = new Book();
            break;
        case 'music':
            var templateCtrl = new Music();
            break;
        default:
            var templateCtrl = new Dashboard();
            break;
    }

    switch (action) {
        case 'index':
            templateCtrl.index();
            break;
        case 'show':
            templateCtrl.show();
            break;
        case 'create':
            templateCtrl.create();
            break;
        case 'update':
            templateCtrl.update();
            break;
        default:
            templateCtrl.init();
            break;
    }

    $('.lang button').on('click', function(e) {
        e.preventDefault();
        $('.lang button').addClass('disabled').attr('disabled', true);
        var params = {
            Lang: $(e.target).attr('data-value')
        };

        $.postJSON('/lang', params, function (res) {
            if (res.Status == 1) {
                window.location.reload();
            } else {
                $('.lang button').removeClass('disabled').attr('disabled', false);
                console.log(res.Message);
            }
        });
    });
});
