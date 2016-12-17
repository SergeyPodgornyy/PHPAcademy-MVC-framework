<?php

namespace Controller;

class Token extends Base
{
    public function check()
    {
        $tokenConf = $this->config()['headerAccessToken'];

        if (isset(getallheaders()[$tokenConf['name']])
            && in_array(getallheaders()[$tokenConf['name']], $tokenConf['values'])) {
            return true;
        } else {
            $this->renderJSON([
                'Error' => ['Type' => 'ACCESS_DENIED'],
            ]);
        }
    }
}
