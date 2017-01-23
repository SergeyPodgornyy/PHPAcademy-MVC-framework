<?php

namespace Controller;

use Utils\MessageCode;
use Utils\Context;
use Exception;

final class Language extends Base
{
    private $availableLangs = [
        'en',
        'de',
        'ru',
        'ua',
    ];

    public function create()
    {
        $lang = isset($this->app->params()['Lang'])
            ? $this->app->params()['Lang']
            : null;

        try {
            $this->checkAvailableLangs($lang);
            Context::setLang($lang);
            $result = [
                'Status'    => 1,
                'Message'   => gettext('Language has been successfully changed'),
            ];
        } catch (X $e) {
            $result = $e->getError();
        } catch (Exception $e) {
            $result = $e->getMessage();
        }

        $this->renderJson($result);
    }

    private function checkAvailableLangs($lang)
    {
        if (!in_array($lang, $this->availableLangs)) {
            $errorMsg = new MessageCode('WrongLanguage');
            throw new X($errorMsg);
        }
    }
}
