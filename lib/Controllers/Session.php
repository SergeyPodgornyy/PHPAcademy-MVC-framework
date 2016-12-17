<?php

namespace Controller;

class Session extends Base
{
    public function check()
    {
        if (isset($_SESSION['UserId']) && $_SESSION['UserId']) {
            return true;
        } else {
            $this->renderJSON([
                'Error' => ['Type' => 'ACCESS_DENIED'],
            ]);
        }
    }
}
