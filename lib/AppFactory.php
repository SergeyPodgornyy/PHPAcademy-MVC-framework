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
        $app->get('/welcome', function () use ($app) {
            $app->render('test.php');
        });
        $app->get('/welcome/:user', function ($name) use ($app) {
            $app->render('test.php', ['name' => $name]);
        });

        // Define API routes
        $dashboard = new \Controller\Dashboard($app);
        $app->get('/dashboard/', [$dashboard, 'index']);
        $app->get('/dashboard/:id', $isAuth, [$dashboard, 'show']);
        $app->post('/dashboard/', $hasPermission, [$dashboard, 'create']);
        $app->post('/dashboard/:id', [$dashboard, 'update']);
        $app->delete('/dashboard/:id', [$dashboard, 'delete']);

        return self::$instance = $app;
    }
}
