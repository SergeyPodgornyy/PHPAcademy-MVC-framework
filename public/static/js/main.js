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
        case 'user':
            var templateCtrl = new User();
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
        case 'login':
            templateCtrl = new Dashboard();
            templateCtrl.login();
            break;
        case 'register':
            templateCtrl = new Dashboard();
            templateCtrl.register();
            break;
        default:
            templateCtrl.init();
            break;
    }

    initGettext();
    $('.lang button').on('click', function(e) {
        e.preventDefault();
        $('.lang button').addClass('disabled').attr('disabled', true);
        var langCode = $(e.target).attr('data-value');

        $.postJSON('/lang', {Lang: langCode}, function (res) {
            if (res.Status == 1) {
                document.cookie = "LANG=" + langCode;
                window.location.reload();
            } else {
                $('.lang button').removeClass('disabled').attr('disabled', false);
                console.log(res.Message);
            }
        });
    });

    $('#logout').on('click', function(e) {
        e.preventDefault();

        $.deleteJSON('/api/session', [], function(res) {
            if (res.Status == 1) {
                window.location.href = '/login';
            }
        });
    });
});
