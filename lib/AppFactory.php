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

        $lang = new \Controller\Language($app);
        $app->post('/lang', [$lang, 'create']);

        $movie = new \Controller\Movie($app);
        $app->get('/movies/', [$movie, 'getIndex']);
        $app->get('/movies/create/', [$movie, 'getCreate']);
        $app->get('/movies/:id', [$movie, 'getShow']);
        $app->get('/movies/:id/edit', [$movie, 'getEdit']);

        $book = new \Controller\Book($app);
        $app->get('/books/', [$book, 'getIndex']);
        $app->get('/books/create/', [$book, 'getCreate']);
        $app->get('/books/:id', [$book, 'getShow']);
        $app->get('/books/:id/edit', [$book, 'getEdit']);

        $music = new \Controller\Music($app);
        $app->get('/music/', [$music, 'getIndex']);
        $app->get('/music/create/', [$music, 'getCreate']);
        $app->get('/music/:id', [$music, 'getShow']);
        $app->get('/music/:id/edit', [$music, 'getEdit']);

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

        $app->get('/api/books/', [$book, 'index']);
        $app->get('/api/books/:id', [$book, 'show']);
        $app->post('/api/books/', [$book, 'create']);
        $app->post('/api/books/:id', [$book, 'update']);
        $app->delete('/api/books/:id', [$book, 'delete']);

        $app->get('/api/music/', [$music, 'index']);
        $app->get('/api/music/:id', [$music, 'show']);
        $app->post('/api/music/', [$music, 'create']);
        $app->post('/api/music/:id', [$music, 'update']);
        $app->delete('/api/music/:id', [$music, 'delete']);

        $cast = new \Controller\Cast($app);
        $app->get('/api/casts/', [$cast, 'index']);
        $app->get('/api/casts/:id', [$cast, 'show']);
        $app->post('/api/casts/', [$cast, 'create']);
        $app->post('/api/casts/:id', [$cast, 'update']);
        $app->delete('/api/casts/:id', [$cast, 'delete']);

        $author = new \Controller\Author($app);
        $app->get('/api/authors/', [$author, 'index']);
        $app->get('/api/authors/:id', [$author, 'show']);
        $app->post('/api/authors/', [$author, 'create']);
        $app->post('/api/authors/:id', [$author, 'update']);
        $app->delete('/api/authors/:id', [$author, 'delete']);

        // TODO: implement services+views to create/update genres, casts, directors...

        return self::$instance = $app;
    }
}
