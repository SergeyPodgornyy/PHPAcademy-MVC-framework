<?php

namespace Controller;

use Framework\App;

class Base
{
    protected $app;

    /**
     * Create object
     */
    public function __construct(App $app)
    {
        $this->app = $app;

        return $this;
    }

    /**
     *  void renderJson( $json )   - print JSON string
     *      @param      array       $data   - json structure
     *      @param      string      $type   - content-type header (default 'application/json')
     *      @return     void
     */
    public function renderJson($data, $type = 'application/json')
    {
        header('Content-Type:' . $type);
        echo json_encode($data);
        $this->app->stop();
    }

    public function renderFile($data = [])
    {
        $file = __DIR__.'/../../storage/files/'.$data['File'];
        $size = filesize($file);
        header("Content-Description: File Transfer");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename={$data['Filename']}");
        header("Content-Transfer-Encoding: binary");
        header("Pragma: public");
        header("Cache-Control: must-revalidate");
        header("Content-Length: {$size}");

        ob_clean();
        flush();
        readfile($file);
        $content = ob_get_clean();
        echo $content;
        $this->app->stop();
    }

    public function config()
    {
        return $this->app->config;
    }

    public function getUserId()
    {
        return isset($_SESSION['UserId']) ? $_SESSION['UserId'] : null;
    }

    /**
     * mix run( function $cb, bool $isSkipSuccessRender ) - action wrapper
     */
    final public function run($cb, $isSkipSuccessRender = null, $file = false)
    {
        try {
            $result = call_user_func($cb);

            if ($isSkipSuccessRender) {
                return $result;
            } elseif ($file) {
                $this->renderFile($result);
            } else {
                $this->renderJSON($result);
            }
        } catch (\Service\X $e) {
            if ($isSkipSuccessRender) {
                return $e->getError();
            } else {
                $this->renderJson($e->getError());
            }
        }
    }

    /**
     * mix action( string $class ) - create service object
     */
    public function action($class)
    {
        return new $class([
            'UserId' => $this->getUserId(),
            'config' => $this->config(),
        ]);
    }
}
