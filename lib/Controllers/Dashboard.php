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

        // TODO: implement books and music
        // $books = [];
        // $music = [];

        $this->app->render('index.php', [
            'title'     => 'Home',
            'items'     => $items,
        ]);
    }
}
