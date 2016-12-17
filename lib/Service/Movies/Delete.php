<?php

namespace Service\Movie;

class Delete extends \Service\Base
{
    public function validate(array $params)
    {
        $rules = [
            'Id'    => ['required', 'positive_integer'],
        ];

        return \Service\Validator::validate($params, $rules);
    }

    public function execute(array $params)
    {
        $movie = \Model\Movie::findById($params['Id']);
        if (!$movie) {
            throw new \Service\X([
                'Type'    => 'FORMAT_ERROR',
                'Fields'  => ['Id' => 'WRONG'],
                'Message' => 'Movie does not exists'
            ]);
        }

        if (!\Model\Movie::delete(['Id' => [$params['Id']]])) {
            throw new \Service\X([
                'Type'    => 'FORMAT_ERROR',
                'Fields'  => ['Id' => 'WRONG'],
                'Message' => 'Cannot delete a movie'
            ]);
        }

        return [
            'Status'    => 1,
        ];
    }
}
