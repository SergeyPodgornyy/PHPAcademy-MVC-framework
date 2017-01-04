<?php

namespace Service\Music;

use Model\Artist;
use Model\Genre;
use Model\Music;
use Service\Base;
use Service\Validator;

class Create extends Base
{
    public function validate(array $params)
    {
        $genreIds = array_map(function ($genre) {
            return $genre['id'];
        }, Genre::index(['Type' => 'music']));
        $artistIds = array_map(function ($artist) {
            return $artist['id'];
        }, Artist::index([]));

        $rules = [
            'Title'     => ['required', ['max_length' => 100]],
            'Year'      => ['required', 'positive_integer'],
            'Genre'     => ['required', ['one_of' => $genreIds]],
            'Artist'    => ['required', ['one_of' => $artistIds]],
            'Format'    => ['not_empty', ['one_of' => ['Cassette', 'CD', 'MP3', 'Vinyl']]],
            // TODO: upload images for music via AJAX
        ];

        return Validator::validate($params, $rules);
    }

    public function execute(array $params)
    {
        $params += [
            'Title'     => '',
            'Year'      => null,
            'Format'    => '',
            'Genre'     => null,
            'Artist'    => null,
        ];

        $musicId = Music::create($params);

        return [
            'Status'    => 1,
            'MusicId'   => $musicId,
        ];
    }
}
