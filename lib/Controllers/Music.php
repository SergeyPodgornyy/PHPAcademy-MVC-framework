<?php

namespace Controller;

class Music extends Base
{
    // API goes here

    public function index()
    {
        $data = $this->app->params();

        $this->run(function () use ($data) {
            return $this->action('Service\Music\Index')->run($data);
        });
    }

    public function show($id)
    {
        $data = $this->app->params();
        $data['Id'] = $id;

        $this->run(function () use ($data) {
            return $this->action('Service\Music\Show')->run($data);
        });
    }

    public function create()
    {
        $data = $this->app->params();

        $this->run(function () use ($data) {
            return $this->action('Service\Music\Create')->run($data);
        });
    }

    public function update($id)
    {
        $data = $this->app->params();
        $data['Id'] = $id;

        $this->run(function () use ($data) {
            return $this->action('Service\Music\Update')->run($data);
        });
    }

    public function delete($id)
    {
        $data['Id'] = $id;

        $this->run(function () use ($data) {
            return $this->action('Service\Music\Delete')->run($data);
        });
    }

    // Static pages goes here

    public function getIndex()
    {
        $data = $this->app->params();

        $res = $this->run(function () use ($data) {
            return $this->action('Service\Music\Index')->run($data);
        }, true);

        $this->app->render('catalog.php', [
            'page'  => 'music',
            'title' => gettext('Music'),
            'items' => $res['Status'] == 1 ? $res['Music'] : [],
        ]);
    }

    public function getShow($id)
    {
        $data = $this->app->params();
        $data['Id'] = $id;

        $res = $this->run(function () use ($data) {
            return $this->action('Service\Music\Show')->run($data);
        }, true);

        $this->app->render('details.php', [
            'page'      => 'music',
            'action'    => 'show',
            'title'     => $res['Status'] == 1 ? $res['Music']['title'] : '',
            'item'      => $res['Status'] == 1 ? $res['Music'] : [],
        ]);
    }

    public function getCreate()
    {
        $genres = $this->run(function () {
            return $this->action('Service\Genre\Index')->run(['Type' => 'music']);
        }, true);

        $artists = $this->run(function () {
            return $this->action('Service\Artist\Index')->run([]);
        }, true);

        $this->app->render('music.edit.php', [
            'page'      => 'music',
            'action'    => 'create',
            'title'     => gettext('Insert new music'),
            'genres'    => $genres['Status'] == 1 ? $genres['Genres'] : [],
            'artists'   => $artists['Status'] == 1 ? $artists['Artists'] : [],
        ]);
    }

    public function getEdit($id)
    {
        $data['Id'] = $id;
        $item = $this->run(function () use ($data) {
            return $this->action('Service\Music\Show')->run($data);
        }, true);

        $genres = $this->run(function () {
            return $this->action('Service\Genre\Index')->run(['Type' => 'music']);
        }, true);

        $artists = $this->run(function () {
            return $this->action('Service\Artist\Index')->run([]);
        }, true);

        $this->app->render('music.edit.php', [
            'page'      => 'music',
            'action'    => 'update',
            'title'     => $item['Status'] == 1 ? $item['Music']['title'] : '',
            'item'      => $item['Status'] == 1 ? $item['Music'] : [],
            'genres'    => $genres['Status'] == 1 ? $genres['Genres'] : [],
            'artists'   => $artists['Status'] == 1 ? $artists['Artists'] : [],
        ]);
    }
}
