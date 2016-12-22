<?php

namespace Framework;

class Router
{
    /**
     * @var array Lookup hash of all route objects
     */
    protected $routes;

    /**
     * @var array Array of route objects that match the request URI (lazy-loaded)
     */
    protected $matchedRoutes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->routes = array();
    }

    /**
     * Return route objects that match the given HTTP method and URI
     * @param  string               $httpMethod   The HTTP method to match against
     * @param  string               $resourceUri  The resource URI to match against
     * @return array[\Framework\Route]
     */
    public function getMatchedRoutes($httpMethod, $resourceUri)
    {
        if (is_null($this->matchedRoutes)) {
            $this->matchedRoutes = array();
            foreach ($this->routes as $route) {
                if (!$route->supportsHttpMethod($httpMethod)) {
                    continue;
                }

                if ($route->matches($resourceUri)) {
                    $this->matchedRoutes[] = $route;
                }
            }
        }

        return $this->matchedRoutes;
    }

    /**
     * Add a route object to the router
     * @param  \Framework\Route     $route      The Framework Route
     */
    public function map(Route $route)
    {
        $route->setPattern($route->getPattern());
        $this->routes[] = $route;
    }
}
