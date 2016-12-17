<?php

namespace Service\Movie;

class Update extends \Service\Base
{
    public function validate(array $params)
    {
        $rules = [
            'Id'        => ['required', 'positive_integer'],
            'Title'     => ['not_empty', 'latin_string'],
            'Year'      => ['not_empty', 'positive_integer'],
            'Formar'    => ['not_empty', ['one_of' => ['DVD', 'Blu-Ray', 'VHS']]],
        ];

        return \Service\Validator::validate($params, $rules);
    }

    public function execute(array $params)
    {
        return $params;
    }
}
