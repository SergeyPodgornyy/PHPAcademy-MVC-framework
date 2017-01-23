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

function getCookie(name) {
    var matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
};

function initGettext() {
    var locale = getGettextLocaleVar(getCookie('LANG')),
        domain = 'library_js';

    if (!Object.keys(locale['library_js']).length) return false;

    var params = {
        domain : domain,
        locale_data : locale
    };
    var gt = new Gettext(params);

    // Localize helper
    window.gettext = function (msgid) { return getCookie('LANG') ? gt.gettext(msgid) : msgid; }
};

function getGettextLocaleVar(lang) {
    switch(lang) {
        case 'en':
            return MAIN_LOCALE_EN;
        case 'de':
            return MAIN_LOCALE_DE;
        case 'ru':
            return MAIN_LOCALE_RU;
        case 'ua':
            return MAIN_LOCALE_UA;
        default:
            return MAIN_LOCALE_EN;
    }
}

function mixin(dst, src) {
    // tobj - вспомогательный объект для фильтрации свойств,
    // которые есть у объекта Object и его прототипа
    var tobj = {}
    for (var x in src) {
        // копируем в dst свойства src, кроме тех, которые унаследованы от Object
        if ((typeof tobj[x] == "undefined") || (tobj[x] != src[x])) {
            dst[x] = src[x];
        }
    }
    // В IE пользовательский метод toString отсутствует в for..in
    if (document.all && !document.isOpera) {
        var p = src.toString;
        if (typeof p == "function" && p != dst.toString && p != tobj.toString &&
                p != "\nfunction toString() {\n    [native code]\n}\n") {
            dst.toString = src.toString;
        }
    }
}
