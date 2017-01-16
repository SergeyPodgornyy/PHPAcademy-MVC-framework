<?php

define('ROOT_PATH', dirname(__FILE__) . '/..');

// update lib files
Translator::createInstance(ROOT_PATH . '/lib', 'php')->update();
Translator::createInstance(ROOT_PATH . '/public/static', 'php')->update();

Translator::createInstance(ROOT_PATH . '/public/static', 'js')->update();
Translator::createInstance(ROOT_PATH . '/client/src', 'js')->update();

prepareJson();
removeComments();

function prepareJson() {
    $po2json = __DIR__ . "/po2json.pl";

    foreach (Translator::getLocales() as $lang => $code) {
        $jsFile     = ROOT_PATH . "/public/static/js/lang/${lang}.js";
        $poFile     = ROOT_PATH . "/locales/$code/LC_MESSAGES/library_js.po";
        $jsVariable = strtoupper("main_locale_$lang");

        $wrongHeader = "nplurals=INTEGER; plural=EXPRESSION;";
        $correctHeader = "nplurals=1; plural=0;";

        shell_exec("sed -i 's/$wrongHeader/$correctHeader/g' $poFile");

        echo "Updating $jsFile \n";

        $res = system("echo 'var $jsVariable = ' > $jsFile");
        ($res == 0) or die("Cannot update json language files $res");

        $res = system("$po2json -p $poFile >> $jsFile");
        ($res == 0) or die("Cannot update json language files $res");

        $res = system("echo ';' >> $jsFile");
        ($res == 0) or die("Cannot update  json language files $res");
    }
}

function removeComments() {
    $path = realpath(ROOT_PATH . '/locales');

    $iter = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
    $Regex = new RegexIterator($iter, '/^.+\.po$/i', RecursiveRegexIterator::GET_MATCH);

    foreach($Regex as $name => $object) {
        shell_exec("sed -i '/\#\:\s/d ; /\#\,\s/d' $name");
    }
}

class Translator
{
    private static $locales = [
        'en'    => 'en_GB',
        'de'    => 'de_DE',
        'ru'    => 'ru_RU',
        'ua'    => 'ru_UA',
    ];

    private $path;
    private $type;
    private $entryPathes = [];

    private function __construct($path, $type)
    {
        $this->path = $path;
        $this->type = $type;
    }

    public static function createInstance($path, $type)
    {
        return new static($path, $type);
    }

    public function update()
    {
        $this->findFiles($this->path);
        $this->translate();
    }

    private function findFiles($path)
    {
        $path = rtrim(str_replace("\\", "/", $path), '/') . '/';
        $entries = array();

        $dir = dir($path);
        while (false !== ($entry = $dir->read())) {
            $entries[] = $entry;
        }
        $dir->close();

        $pattern = $this->getPattern();

        foreach ($entries as $entry) {
            $filePath = $path . $entry;
            if ($entry != '.' && $entry != '..' && is_dir($filePath)) {
                $this->findFiles($filePath);
            } elseif (is_file($filePath) && preg_match($pattern, $entry)) {
                $this->entryPathes[] = $filePath;
            }
        }
    }

    private function translate()
    {
        foreach ($this->entryPathes as $filePath) {
            foreach (self::$locales as $locale) {
                system($this->makeXgettextCmd($filePath, $locale));
            }
        }
    }

    private function getPattern() {
        $patterns = [
            'php'   => '/\.php$/',
            'js'    => '/[a-zA-Z]\.js$/',
        ];

        return isset($patterns[$this->type]) ? $patterns[$this->type] : '';
    }

    private function makeXgettextCmd($fileName, $locale) {
        $type = $this->type;

        $cmd = '';
        if ($type == 'php') {
            $cmd = "xgettext -c -LPHP -j --no-wrap --from-code=UTF-8 -o '"
                . ROOT_PATH . "/locales/{$locale}/LC_MESSAGES/library.po' '$fileName'";
        } elseif ($type == 'js') {
            $cmd = "xgettext -c -LPython -j --no-wrap --from-code=UTF-8 -o '"
                . ROOT_PATH . "/locales/{$locale}/LC_MESSAGES/library_js.po' '$fileName'";
        } else {
            die("Wrong type");
        }

        return $cmd;
    }

    public static function getLocales()
    {
        return self::$locales;
    }
}
