<?php

namespace Controller;

class Book extends Base
{
    // API goes here

    public function index()
    {
        $data = $this->app->params();

        $this->run(function () use ($data) {
            return $this->action('Service\Book\Index')->run($data);
        });
    }

    public function show($id)
    {
        $data = $this->app->params();
        $data['Id'] = $id;

        $this->run(function () use ($data) {
            return $this->action('Service\Book\Show')->run($data);
        });
    }

    public function create()
    {
        $data = $this->app->params();

        $this->run(function () use ($data) {
            return $this->action('Service\Book\Create')->run($data);
        });
    }

    public function update($id)
    {
        $data = $this->app->params();
        $data['Id'] = $id;

        $this->run(function () use ($data) {
            return $this->action('Service\Book\Update')->run($data);
        });
    }

    public function delete($id)
    {
        $data['Id'] = $id;

        $this->run(function () use ($data) {
            return $this->action('Service\Book\Delete')->run($data);
        });
    }

    // Static pages goes here

    public function getIndex()
    {
        $data = $this->app->params();

        $res = $this->run(function () use ($data) {
            return $this->action('Service\Book\Index')->run($data);
        }, true);

        $this->app->render('catalog.php', [
            'page'  => 'books',
            'title' => gettext('Books'),
            'items' => $res['Status'] == 1 ? $res['Books'] : [],
        ]);
    }

    public function getShow($id)
    {
        $data = $this->app->params();
        $data['Id'] = $id;

        $res = $this->run(function () use ($data) {
            return $this->action('Service\Book\Show')->run($data);
        }, true);

        $this->app->render('details.php', [
            'page'      => 'books',
            'action'    => 'show',
            'title'     => $res['Status'] == 1 ? $res['Book']['title'] : '',
            'item'      => $res['Status'] == 1 ? $res['Book'] : [],
        ]);
    }

    public function getCreate()
    {
        $authors = $this->run(function () {
            return $this->action('Service\Author\Index')->run([]);
        }, true);

        $genres = $this->run(function () {
            return $this->action('Service\Genre\Index')->run(['Type' => 'book']);
        }, true);

        $publishers = $this->run(function () {
            return $this->action('Service\Publisher\Index')->run([]);
        }, true);

        $this->app->render('book.edit.php', [
            'page'      => 'books',
            'action'    => 'create',
            'title'     => gettext('Insert new book'),
            'genres'    => $genres['Status'] == 1 ? $genres['Genres'] : [],
            'authors'   => $authors['Status'] == 1 ? $authors['Authors'] : [],
            'publishers' => $publishers['Status'] == 1 ? $publishers['Publishers'] : [],
        ]);
    }

    public function getEdit($id)
    {
        $data['Id'] = $id;
        $item = $this->run(function () use ($data) {
            return $this->action('Service\Book\Show')->run($data);
        }, true);

        $authors = $this->run(function () {
            return $this->action('Service\Author\Index')->run([]);
        }, true);

        $genres = $this->run(function () {
            return $this->action('Service\Genre\Index')->run(['Type' => 'book']);
        }, true);

        $publishers = $this->run(function () {
            return $this->action('Service\Publisher\Index')->run([]);
        }, true);

        $this->app->render('book.edit.php', [
            'page'      => 'books',
            'action'    => 'update',
            'title'     => $item['Status'] == 1 ? $item['Book']['title'] : '',
            'item'      => $item['Status'] == 1 ? $item['Book'] : [],
            'genres'    => $genres['Status'] == 1 ? $genres['Genres'] : [],
            'authors'   => $authors['Status'] == 1 ? $authors['Authors'] : [],
            'publishers' => $publishers['Status'] == 1 ? $publishers['Publishers'] : [],
        ]);
    }
}
