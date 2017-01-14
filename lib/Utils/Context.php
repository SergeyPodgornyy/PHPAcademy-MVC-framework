<?php

namespace Utils;

use Exception;

class Context
{
    private static $lang;

    private static $locales = [
        'en'    => 'en_US',
        'ru'    => 'ru_RU',
        'ua'    => 'ru_UA',
    ];

    private static $localesFolder = __DIR__ . '/../../locales';

    public static function getLang() {
        return self::$lang;
    }

    public static function setLang($lang) {
        $locale = isset(self::$locales[$lang]) ? self::$locales[$lang] : null;

        if (!$locale) {
            $errorMsg = new MessageCode('WrongLanguage');
            throw new Exception($errorMsg->getMessage());
        }

        // Set language
        putenv("LC_ALL=$locale.UTF-8");
        putenv("LANGUAGE=$locale");
        setlocale(LC_ALL, "$locale.UTF-8");

        // Specify the location of the translation tables
        bindtextdomain('library', self::$localesFolder);
        bind_textdomain_codeset('library', 'UTF-8');

        // Choose domain
        textdomain('library');

        self::$lang = $lang;
        $_SESSION['Lang'] = $lang;
    }
}
