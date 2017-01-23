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
        $sessions = new \Controller\Session($app);
        $isAuth = [$sessions, 'check'];
        $isAdminOrSuper = [$sessions, 'checkAdminOrSuper'];
        $isSuper = [$sessions, 'checkSuper'];
        $isAuthOrReferer = [$sessions, 'checkAuthOrReferer'];
        $token = new \Controller\Token($app);
        $hasPermission = [$token, 'check'];

        // Define routes
        $dashboard = new \Controller\Dashboard($app);
        $app->get('/', [$dashboard, 'getIndex']);
        $app->get('/login', function () use ($app) {
            $app->render('login.php', ['title' => gettext('Login')]);
        });
        $app->get('/register', function () use ($app) {
            $app->render('register.php', ['title' => gettext('Register')]);
        });
        // TODO: edit another users for admins
        $app->get('/user/:id/edit', $isAuth, function ($id) use ($app) {
            $app->render('user.edit.php', ['title' => gettext('Edit user data'), 'userId' => $id]);
        });

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

        // Define API routes
        $app->get('/api/movies/', $isAuth, [$movie, 'index']);
        $app->get('/api/movies/:id', $isAuth, [$movie, 'show']);
        $app->post('/api/movies/', $isSuper, [$movie, 'create']);
        $app->post('/api/movies/:id', $isSuper, [$movie, 'update']);
        $app->delete('/api/movies/:id', $isAdminOrSuper, [$movie, 'delete']);

        $app->get('/api/books/', $isAuth, [$book, 'index']);
        $app->get('/api/books/:id', $isAuth, [$book, 'show']);
        $app->post('/api/books/', $isSuper, [$book, 'create']);
        $app->post('/api/books/:id', $isSuper, [$book, 'update']);
        $app->delete('/api/books/:id', $isAdminOrSuper, [$book, 'delete']);

        $app->get('/api/music/', $isAuth, [$music, 'index']);
        $app->get('/api/music/:id', $isAuth, [$music, 'show']);
        $app->post('/api/music/', $isSuper, [$music, 'create']);
        $app->post('/api/music/:id', $isSuper, [$music, 'update']);
        $app->delete('/api/music/:id', $isAdminOrSuper, [$music, 'delete']);

        $cast = new \Controller\Cast($app);
        $app->get('/api/casts/', $isAuth, [$cast, 'index']);
        $app->get('/api/casts/:id', $isAuth, [$cast, 'show']);
        $app->post('/api/casts/', $isSuper, [$cast, 'create']);
        $app->post('/api/casts/:id', $isSuper, [$cast, 'update']);
        $app->delete('/api/casts/:id', $isAdminOrSuper, [$cast, 'delete']);

        $author = new \Controller\Author($app);
        $app->get('/api/authors/', $isAuth, [$author, 'index']);
        $app->get('/api/authors/:id', $isAuth, [$author, 'show']);
        $app->post('/api/authors/', $isSuper, [$author, 'create']);
        $app->post('/api/authors/:id', $isSuper, [$author, 'update']);
        $app->delete('/api/authors/:id', $isAdminOrSuper, [$author, 'delete']);

        $user = new \Controller\User($app);
        $app->post('/api/users', $isAuthOrReferer, [$user, 'create']);
        $app->post('/api/users/:id', $isAuth, [$user, 'update']);

        $app->post('/api/session', [$sessions, 'create']);
        $app->delete('/api/session', $isAuth, [$sessions, 'delete']);

        // TODO: implement services+views to create/update genres, casts, directors...

        return self::$instance = $app;
    }
}
