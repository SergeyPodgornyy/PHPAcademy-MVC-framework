<?php

namespace Service\Movie;

class Create extends \Service\Base
{
    public function validate(array $params)
    {
        $rules = [
            'Title'     => ['required', ['max_length' => 255]],
            'Year'      => ['required', 'positive_integer'],
            'Format'    => ['not_empty', ['one_of' => ['DVD', 'Blu-Ray', 'VHS']]],
        ];

        return \Service\Validator::validate($params, $rules);
    }

    public function execute(array $params)
    {
        $params += [
            'Title'     => '',
            'Year'      => '',
            'Format'    => '',
        ];

        $movieId = \Model\Movie::create($params);

        return [
            'Status'    => 1,
            'MovieId'   => $movieId,
        ];
    }
}
