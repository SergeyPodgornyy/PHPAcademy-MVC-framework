<?php

namespace Controller;

class Dashboard extends Base
{
    public function getIndex()
    {
        // Get last 4 created movies, books, music items
        $data = [
            'Limit'     => 4,
            'SortField' => 'id',
            'SortOrder' => 'desc',
        ];
        $items = [];

        // ************ Get movies ************
        $movies = $this->run(function () use ($data) {
            return $this->action('Service\Movie\Index')->run($data);
        }, true);

        if ($movies['Status'] == 1) {
            // Add movies to all items list
            $items = array_merge($items, array_map(function ($movie) {
                // Add `category` key to each movie
                return array_merge($movie, ['category' => 'movies']);
            }, $movies['Movies']));
        }

        // ************ Get books ************
        $books = $this->run(function () use ($data) {
            return $this->action('Service\Book\Index')->run($data);
        }, true);

        if ($books['Status'] == 1) {
            // Add books to all items list
            $items = array_merge($items, array_map(function ($book) {
                // Add `category` key to each book
                return array_merge($book, ['category' => 'books']);
            }, $books['Books']));
        }

        // ************ Get music ************
        $music = $this->run(function () use ($data) {
            return $this->action('Service\Music\Index')->run($data);
        }, true);

        if ($music['Status'] == 1) {
            // Add music to all items list
            $items = array_merge($items, array_map(function ($music) {
                // Add `category` key to each music item
                return array_merge($music, ['category' => 'music']);
            }, $music['Music']));
        }

        // shuffle($items);
        $this->app->render('index.php', [
            'title'     => gettext('Home'),
            'items'     => $items,
        ]);
    }
}
