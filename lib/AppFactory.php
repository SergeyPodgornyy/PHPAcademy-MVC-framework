<?php

class AppFactory
{
    public static $instance;

    public static function create($config)
    {
        // Prepare app
        $app = new \Framework\App($config['frameworkOptions']);
        $app->config = $config;

        // Prepare middleware
        // TODO: implement some middleware, when registration will be implemented
        // $sessions = new \Controller\Session($app);
        // $isAuth = [$sessions, 'check'];
        // $token = new \Controller\Token($app);
        // $hasPermission = [$token, 'check'];
        // end TODO

        // Define routes
        $dashboard = new \Controller\Dashboard($app);
        $app->get('/', [$dashboard, 'getIndex']);

        $movie = new \Controller\Movie($app);
        $app->get('/movies/', [$movie, 'getIndex']);
        $app->get('/movies/create/', [$movie, 'getCreate']);
        $app->get('/movies/:id', [$movie, 'getShow']);
        $app->get('/movies/:id/edit', [$movie, 'getEdit']);

        // TODO `books` and `music` ============================================
        $app->get('/books/', function () use ($app) {
            $app->render('catalog.php', [
                'page'  => 'books',
                'title' => 'Books',
                'items' => [],
            ]);
        });
        $app->get('/music/', function () use ($app) {
            $app->render('catalog.php', [
                'page'  => 'music',
                'title' => 'Music',
                'items' => [],
            ]);
        });
        // end TODO ============================================================

        // Test routes
        $app->get('/welcome/', function () use ($app) {
            $app->render('test.php');
        });
        $app->get('/welcome/:user', function ($name) use ($app) {
            $app->render('test.php', ['name' => $name]);
        });

        // Define API routes
        $app->get('/api/movies/', [$movie, 'index']);
        $app->get('/api/movies/:id', [$movie, 'show']);
        $app->post('/api/movies/', [$movie, 'create']);
        $app->post('/api/movies/:id', [$movie, 'update']);
        $app->delete('/api/movies/:id', [$movie, 'delete']);

        $cast = new \Controller\Cast($app);
        $app->get('/api/casts/', [$cast, 'index']);
        $app->get('/api/casts/:id', [$cast, 'show']);
        $app->post('/api/casts/', [$cast, 'create']);
        $app->post('/api/casts/:id', [$cast, 'update']);
        $app->delete('/api/casts/:id', [$cast, 'delete']);

        // TODO: implement services+views to create/update genres, casts, directors...

        return self::$instance = $app;
    }
}
