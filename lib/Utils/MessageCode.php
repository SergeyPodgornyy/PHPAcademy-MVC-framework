<?php

namespace Utils;

class MessageCode
{
    private $messagesList = [];

    private $message = '';

    public function __construct($messageKey = '')
    {
        $this->setDefaultMessages();
        $this->chooseMessage($messageKey);
    }

    private function setDefaultMessages()
    {
        $this->messagesList = [
            'UnknownErrorOccurred'              => gettext('Unknown Error Occurred. Please contact administrator'),
            'ErrorOccurredContactAdministrator' => gettext('Some Error Occurred. Please contact administrator'),
            'WrongLanguage'                     => gettext('Wrong language has been defined'),
        ];
    }

    public function getMessage()
    {
        return $this->message;
    }

    private function chooseMessage($messageKey)
    {
        $this->message = isset($this->messagesList[$messageKey])
            ? $this->messagesList[$messageKey]
            : $this->messagesList['UnknownErrorOccurred'];
    }
}
