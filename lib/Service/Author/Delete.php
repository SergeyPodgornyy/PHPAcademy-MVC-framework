<?php

namespace Service\Author;

use Model\Author;
use Service\Base;
use Service\Validator;
use Service\X;

class Delete extends Base
{
    public function validate($params)
    {
        $rules = [
            'Id'    => ['required', 'positive_integer'],
        ];

        return Validator::validate($params, $rules);
    }

    public function execute($params)
    {
        $author = Author::findById($params['Id']);
        if (!$author) {
            throw new X([
                'Type'    => 'FORMAT_ERROR',
                'Fields'  => ['Id' => 'WRONG'],
                'Message' => 'Author does not exists'
            ]);
        }

        if (!Author::delete(['Id' => [$params['Id']]])) {
            throw new X([
                'Type'    => 'FORMAT_ERROR',
                'Fields'  => ['Id' => 'WRONG'],
                'Message' => 'Cannot delete a author'
            ]);
        }

        return [
            'Status'    => 1,
        ];
    }
}
