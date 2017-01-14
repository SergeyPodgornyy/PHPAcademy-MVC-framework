<?php

namespace Controller;

class Movie extends Base
{
    // API goes here

    public function index()
    {
        $data = $this->app->params();

        $this->run(function () use ($data) {
            return $this->action('Service\Movie\Index')->run($data);
        });
    }

    public function show($id)
    {
        $data = $this->app->params();
        $data['Id'] = $id;

        $this->run(function () use ($data) {
            return $this->action('Service\Movie\Show')->run($data);
        });
    }

    public function create()
    {
        $data = $this->app->params();

        $this->run(function () use ($data) {
            return $this->action('Service\Movie\Create')->run($data);
        });
    }

    public function update($id)
    {
        $data = $this->app->params();
        $data['Id'] = $id;

        $this->run(function () use ($data) {
            return $this->action('Service\Movie\Update')->run($data);
        });
    }

    public function delete($id)
    {
        $data['Id'] = $id;

        $this->run(function () use ($data) {
            return $this->action('Service\Movie\Delete')->run($data);
        });
    }

    // Static pages goes here

    public function getIndex()
    {
        $data = $this->app->params();

        $res = $this->run(function () use ($data) {
            return $this->action('Service\Movie\Index')->run($data);
        }, true);

        $this->app->render('catalog.php', [
            'page'  => 'movies',
            'title' => gettext('Movies'),
            'items' => $res['Status'] == 1 ? $res['Movies'] : [],
        ]);
    }

    public function getShow($id)
    {
        $data = $this->app->params();
        $data['Id'] = $id;

        $res = $this->run(function () use ($data) {
            return $this->action('Service\Movie\Show')->run($data);
        }, true);

        $this->app->render('details.php', [
            'page'      => 'movies',
            'action'    => 'show',
            'title'     => $res['Status'] == 1 ? $res['Movie']['title'] : '',
            'item'      => $res['Status'] == 1 ? $res['Movie'] : [],
        ]);
    }

    public function getCreate()
    {
        $casts = $this->run(function () {
            return $this->action('Service\Cast\Index')->run([]);
        }, true);

        $genres = $this->run(function () {
            return $this->action('Service\Genre\Index')->run(['Type' => 'movie']);
        }, true);

        $directors = $this->run(function () {
            return $this->action('Service\Director\Index')->run([]);
        }, true);

        $this->app->render('movie.edit.php', [
            'page'      => 'movies',
            'action'    => 'create',
            'title'     => gettext('Insert new movie'),
            'genres'    => $genres['Status'] == 1 ? $genres['Genres'] : [],
            'stars'     => $casts['Status'] == 1 ? $casts['Casts'] : [],
            'directors' => $directors['Status'] == 1 ? $directors['Directors'] : [],
        ]);
    }

    public function getEdit($id)
    {
        $data['Id'] = $id;
        $item = $this->run(function () use ($data) {
            return $this->action('Service\Movie\Show')->run($data);
        }, true);

        $casts = $this->run(function () {
            return $this->action('Service\Cast\Index')->run([]);
        }, true);

        $genres = $this->run(function () {
            return $this->action('Service\Genre\Index')->run(['Type' => 'movie']);
        }, true);

        $directors = $this->run(function () {
            return $this->action('Service\Director\Index')->run([]);
        }, true);

        $this->app->render('movie.edit.php', [
            'page'      => 'movies',
            'action'    => 'update',
            'title'     => $item['Status'] == 1 ? $item['Movie']['title'] : '',
            'item'      => $item['Status'] == 1 ? $item['Movie'] : [],
            'genres'    => $genres['Status'] == 1 ? $genres['Genres'] : [],
            'stars'     => $casts['Status'] == 1 ? $casts['Casts'] : [],
            'directors' => $directors['Status'] == 1 ? $directors['Directors'] : [],
        ]);
    }
}
