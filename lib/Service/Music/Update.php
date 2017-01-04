<?php

namespace Service\Music;

use Model\Artist;
use Model\Genre;
use Model\Music;
use Service\Base;
use Service\Validator;
use Service\X;

class Update extends Base
{
    public function validate(array $params)
    {
        $genreIds = array_map(function ($genre) {
            return $genre['id'];
        }, Genre::index(['Type' => 'music']));
        $artistIds = array_map(function ($director) {
            return $director['id'];
        }, Artist::index([]));

        $rules = [
            'Id'        => ['required', 'positive_integer'],
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

        $music = Music::findById($params['Id']);
        if (!$music) {
            throw new X([
                'Type'    => 'FORMAT_ERROR',
                'Fields'  => ['Id' => 'WRONG'],
                'Message' => 'Music does not exists'
            ]);
        }

        $updatedMusic = array_merge(
            Music::toCamelCase($music),
            $params
        );
        Music::update($params['Id'], $updatedMusic);

        return [
            'Status'    => 1,
            'Music'     => $updatedMusic,
        ];
    }
}
