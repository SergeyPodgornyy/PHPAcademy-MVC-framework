<?php

namespace Framework;

use Framework\Exception\Pass;
use Framework\Exception\Stop;

class App
{
    private $router;
    private $view;

    private $defaultOptions = array(
        'templatesPath' => '../templates',
    );

    /**
     * @var mixed Callable to be invoked if no matching routes are found
     */
    protected $notFound;

    public function __construct(array $options = array())
    {
        $this->router = new Router;
        $this->view = new View;

        $templatesPath = isset($options['templatesPath'])
            ? $options['templatesPath']
            : $this->defaultOptions['templatesPath'];
        $this->view->setTemplatesDirectory($templatesPath);
    }

    /********************************************************************************
    * Routing
    *******************************************************************************/

    /**
     * Add GET|POST|PUT|PATCH|DELETE route
     *
     * ARGUMENTS:
     *
     * First:       string  The URL pattern (REQUIRED)
     * In-Between:  mixed   Anything that returns TRUE for `is_callable` (OPTIONAL)
     * Last:        mixed   Anything that returns TRUE for `is_callable` (REQUIRED)
     *
     * USAGE:
     *
     * App::get('/foo'[, middleware, middleware, ...], callable);
     *
     * @param   array (See notes above)
     * @return  \Framework\Route
     */
    protected function mapRoute($args)
    {
        $pattern = array_shift($args);
        $callable = array_pop($args);
        $caseSensitive = true;
        $route = new Route($pattern, $callable, $caseSensitive);
        $this->router->map($route);
        if (count($args) > 0) {
            $route->setMiddleware($args);
        }

        return $route;
    }

    /**
     * Add GET route
     * @see    mapRoute()
     * @return \Framework\Route
     */
    public function get()
    {
        $args = func_get_args();

        return $this->mapRoute($args)->via("GET", "HEAD");
    }

    /**
     * Add POST route
     * @see    mapRoute()
     * @return \Framework\Route
     */
    public function post()
    {
        $args = func_get_args();

        return $this->mapRoute($args)->via("POST");
    }

    /**
     * Add PUT route
     * @see    mapRoute()
     * @return \Framework\Route
     */
    public function put()
    {
        $args = func_get_args();

        return $this->mapRoute($args)->via("PUT");
    }

    /**
     * Add PATCH route
     * @see    mapRoute()
     * @return \Framework\Route
     */
    public function patch()
    {
        $args = func_get_args();

        return $this->mapRoute($args)->via("PATCH");
    }

    /**
     * Add DELETE route
     * @see    mapRoute()
     * @return \Framework\Route
     */
    public function delete()
    {
        $args = func_get_args();

        return $this->mapRoute($args)->via("DELETE");
    }

    /**
     * Fetch GET and POST data
     *
     * This method returns a union of GET and POST data as a key-value array, or the value
     * of the array key if requested; if the array key does not exist, NULL is returned,
     * unless there is a default value specified.
     *
     * @param  string           $key
     * @param  mixed            $default
     * @return array|mixed|null
     */
    public function params($key = null, $default = null)
    {
        $get = isset($_GET) ? $_GET : [];
        $post = isset($_POST) ? $_POST : [];
        $union = array_merge($get, $post);

        if ($key) {
            return isset($union[$key]) ? $union[$key] : $default;
        }

        return $union;
    }

    /**
     * Stop
     *
     * The thrown exception will be caught in application's `call()` method
     * and the response will be sent as is to the HTTP client.
     *
     * @throws \Framework\Exception\Stop
     */
    public function stop()
    {
        throw new Stop();
    }

    /**
     * Call
     *
     * This method finds and iterates all route objects that match the current request URI.
     */
    public function run()
    {
        $method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
        $pathInfo = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';

        try {
            ob_start();
            $dispatched = false;
            $matchedRoutes = $this->router->getMatchedRoutes($method, $pathInfo);
            foreach ($matchedRoutes as $route) {
                try {
                    $dispatched = $route->dispatch();
                    if ($dispatched) {
                        break;
                    }
                } catch (Pass $e) {
                    continue;
                }
            }
            if (!$dispatched) {
                $this->notFound();
            }
        } catch (Stop $e) {
            echo ob_get_clean();
        } catch (\Exception $e) {
            // Handle somehow an exception
            throw $e;
        }
    }

    /********************************************************************************
    * Rendering
    *******************************************************************************/

    /**
     * Render a template
     *
     * Call this method within a GET, POST, PUT, PATCH, DELETE, NOT FOUND, or ERROR
     * callable to render a template whose output is appended to the
     * current HTTP response body. How the template is rendered is
     * delegated to the current View.
     *
     * @param  string $template The name of the template passed into the view's render() method
     * @param  array  $data     Associative array of data made available to the view
     * @param  int    $status   The HTTP response status code to use (optional)
     */
    public function render($template, $data = array(), $status = null)
    {
        if (!is_null($status)) {
            http_response_code((int) $status);
        }
        $this->view->appendData($data);
        $this->view->display($template);
    }

    /**
     * Not Found Handler
     *
     * @param  mixed $callable Anything that returns true for is_callable()
     */
    public function notFound($callable = null)
    {
        if (is_callable($this->notFound)) {
            call_user_func($this->notFound);
        } else {
            call_user_func(array($this, 'defaultNotFound'));
        }
        $this->stop();
    }

    /**
     * Generate diagnostic template markup
     *
     * This method accepts a title and body content to generate an HTML document layout.
     *
     * @param  string   $title  The title of the HTML template
     * @param  string   $body   The body content of the HTML template
     * @return string
     */
    protected static function generateTemplateMarkup($title, $body)
    {
        return sprintf("
            <html>
                <head>
                    <title>%s</title>
                    <style>
                        body{
                            margin:0;padding:30px;
                            font:16px/1.5 Helvetica,Arial,Verdana,sans-serif;
                            text-align:center;color:#333;background-color:#eee;
                        }
                        h1{margin:0;font-size:48px;line-height:48px;}
                        strong{display:inline-block;width:65px;}
                        a,a:link,a:hover,a:active,a:visited{color:#5a5a5a;}
                    </style>
                </head>
                <body>
                    <h1>%s</h1>
                    %s
                </body>
            </html>
        ", $title, $title, $body);
    }

    /**
     * Default Not Found handler
     */
    protected function defaultNotFound()
    {
        echo static::generateTemplateMarkup(
            '404 Page Not Found',
            '<p>The page you are looking for could not be found. ' .
            'Check the address bar to ensure your URL is spelled correctly. ' .
            'If all else fails, you can visit our home page at the link below.</p>' .
            '<a href="/">Visit the Home Page</a>'
        );
    }
}
