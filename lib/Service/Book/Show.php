<?php

namespace Service\Book;

use Model\Book;
use Service\Base;
use Service\Validator;
use Service\X;

class Show extends Base
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
        $book = Book::selectOne(['Id' => $params['Id'], 'Locale' => $this->locale()]);

        if (!$book) {
            throw new X([
                'Type'    => 'FORMAT_ERROR',
                'Fields'  => ['Id' => 'WRONG'],
                'Message' => 'Book does not exists'
            ]);
        }

        $bookAuthors = Book::getBookAuthors($book['id']);
        $book['authors'] = array_map(function ($author) {
            return $author['name'] . ' ' . $author['surname'];
        }, $bookAuthors);
        $book['author_ids'] = array_map(function ($author) {
            return $author['id'];
        }, $bookAuthors);

        return [
            'Status'    => 1,
            'Book'      => $book,
        ];
    }
}
