<?php

namespace Service\Author;

use Model\Author;
use Service\Base;
use Service\Validator;

class Create extends Base
{
    public function validate($params)
    {
        $rules = [
            'Name'      => ['required', ['max_length' => 255]],
            'Surname'   => ['required', ['max_length' => 255]],
        ];

        return Validator::validate($params, $rules);
    }

    public function execute($params)
    {
        $params += [
            'Name'      => '',
            'Surname'   => '',
        ];

        $authorId = Author::create($params);

        return [
            'Status'    => 1,
            'AuthorId'  => $authorId,
        ];
    }
}
