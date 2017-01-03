<?php

namespace Service\Book;

use Model\Book;
use Service\Base;
use Service\Validator;
use Service\X;

class Delete extends Base
{
    public function validate(array $params)
    {
        $rules = [
            'Id'    => ['required', 'positive_integer'],
        ];

        return Validator::validate($params, $rules);
    }

    public function execute(array $params)
    {
        $book = Book::findById($params['Id']);
        if (!$book) {
            throw new X([
                'Type'    => 'FORMAT_ERROR',
                'Fields'  => ['Id' => 'WRONG'],
                'Message' => 'Book does not exists'
            ]);
        }

        if (!Book::delete(['Id' => [$params['Id']]])) {
            throw new X([
                'Type'    => 'FORMAT_ERROR',
                'Fields'  => ['Id' => 'WRONG'],
                'Message' => 'Cannot delete a book'
            ]);
        }

        return [
            'Status'    => 1,
        ];
    }
}
