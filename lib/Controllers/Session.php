<?php

namespace Controller;

class Session extends Base
{
    public function create()
    {
        $params = $this->app->params();

        return $this->run(function () use ($params) {
            $result = $this->action("Service\Sessions\Create")->run($params);

            if ($result && isset($result['User'])) {
                $_SESSION['UserId'] = $result['User']['id'];
                $_SESSION['UserRole'] = $result['User']['role'];
                $_SESSION['UserName'] = $result['User']['name'];
                $_SESSION['UserEmail'] = $result['User']['email'];
                return ['Status' => 1];
            }
        });
    }

    public function delete()
    {
        unset($_SESSION['UserId']);
        unset($_SESSION['UserRole']);
        unset($_SESSION['UserName']);
        unset($_SESSION['UserEmail']);

        $this->renderJSON(['Status' => 1]);
    }

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

    public function checkAdminOrSuper()
    {
        if ($this->check() === true &&
            ($_SESSION['UserRole'] == 'admin' || $_SESSION['UserRole'] == 'superadmin')) {
            return true;
        } else {
            $this->renderJSON([
                'Error' => ['Type' => 'ACCESS_DENIED'],
            ]);
        }
    }

    public function checkSuper()
    {
        if ($this->check() === true && $_SESSION['UserRole'] == 'superadmin') {
            return true;
        } else {
            $this->renderJSON([
                'Error' => ['Type' => 'ACCESS_DENIED'],
            ]);
        }
    }

    public function checkAuthOrReferer()
    {
        $config = $this->config();
        $refererConf = array_merge(
            array_keys($config['refererWhitelist']),
            $this->getHostAddress()
        );
        $isAllow = false;

        foreach ($refererConf as $domen) {
            if (isset($_SERVER['HTTP_ORIGIN']) && strpos($_SERVER['HTTP_ORIGIN'], $domen) !== false) {
                $isAllow = true;
                break;
            }
        }

        if ((isset($_SESSION['UserId']) && $_SESSION['UserId']) || $isAllow) {
            return true;
        } else {
            $this->renderJSON([
                'Error' => ['Type' => 'ACCESS_DENIED']
            ]);
        }
    }

    private function getHostAddress()
    {
        if (isset($_SERVER['SERVER_NAME'])) {
            return [
                'http://' . $_SERVER['SERVER_NAME'],
                'https://' . $_SERVER['SERVER_NAME'],
            ];
        }
        return [];
    }
}
