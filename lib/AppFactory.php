<?php

class AppFactory
{
    public static $instance;

    public static function create($config)
    {
        // Prepare app
        \Framework\App::$templatesPath = __DIR__ . '/../public/static/';
        $app = new \Framework\App;
        $app->config = $config;

        // Prepare middleware
        $sessions = new \Controller\Session($app);
        $isAuth = [$sessions, 'check'];
        $token = new \Controller\Token($app);
        $hasPermission = [$token, 'check'];

        // Define routes
        $app->get('/library', function () use ($app) {
            $app->render('index.php');
        });
        $app->get('/welcome/', function () use ($app) {
            $app->render('test.php');
        });
        $app->get('/welcome/:user', function ($name) use ($app) {
            $app->render('test.php', ['name' => $name]);
        });

        // Define API routes
        $dashboard = new \Controller\Dashboard($app);
        $app->get('/api/dashboard/', [$dashboard, 'index']);
        $app->get('/api/dashboard/:id', [$dashboard, 'show']);
        $app->post('/api/dashboard/', [$dashboard, 'create']);
        $app->post('/api/dashboard/:id', [$dashboard, 'update']);
        $app->delete('/api/dashboard/:id', [$dashboard, 'delete']);

        $movie = new \Controller\Movie($app);
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

        return self::$instance = $app;
    }
}
