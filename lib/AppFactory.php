<?php

class AppFactory
{
    public static $instance;

    public static function create($config)
    {
        // Prepare app
        $app = new \Framework\App;
        $app->config = $config;

        // Prepare middleware
        $sessions = new \Controller\Session($app);
        $isAuth = [$sessions, 'check'];
        $token = new \Controller\Token($app);
        $hasPermission = [$token, 'check'];

        // Define routes
        $app->get('/welcome/', function () use ($app) {
            $app->render('test.php');
        });
        $app->get('/welcome/:user', function ($name) use ($app) {
            $app->render('test.php', ['name' => $name]);
        });

        // Define API routes
        $dashboard = new \Controller\Dashboard($app);
        $app->get('/dashboard/', [$dashboard, 'index']);
        $app->get('/dashboard/:id', [$dashboard, 'show']);
        $app->post('/dashboard/', [$dashboard, 'create']);
        $app->post('/dashboard/:id', [$dashboard, 'update']);
        $app->delete('/dashboard/:id', [$dashboard, 'delete']);

        $movie = new \Controller\Movie($app);
        $app->get('/movies/', [$movie, 'index']);
        $app->get('/movies/:id', [$movie, 'show']);
        $app->post('/movies/', [$movie, 'create']);
        $app->post('/movies/:id', [$movie, 'update']);
        $app->delete('/movies/:id', [$movie, 'delete']);

        $cast = new \Controller\Cast($app);
        $app->get('/casts/', [$cast, 'index']);
        $app->get('/casts/:id', [$cast, 'show']);
        $app->post('/casts/', [$cast, 'create']);
        $app->post('/casts/:id', [$cast, 'update']);
        $app->delete('/casts/:id', [$cast, 'delete']);

        return self::$instance = $app;
    }
}
