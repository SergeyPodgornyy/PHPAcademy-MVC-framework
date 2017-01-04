<?php

namespace Service\Book;

use Model\Author;
use Model\Publisher;
use Model\Genre;
use Model\Book;
use Model\Utils\Transaction;
use Service\Base;
use Service\Validator;

class Create extends Base
{
    public function validate(array $params)
    {
        $genreIds = array_map(function ($genre) {
            return $genre['id'];
        }, Genre::index(['Type' => 'book']));
        $publisherIds = array_map(function ($publisher) {
            return $publisher['id'];
        }, Publisher::index([]));
        $authorIds = array_map(function ($author) {
            return $author['id'];
        }, Author::index([]));

        $rules = [
            'Title'     => ['required', ['max_length' => 100]],
            'ISBN'      => ['required', ['max_length' => 100]],
            'Year'      => ['required', 'positive_integer'],
            'Genre'     => ['required', ['one_of' => $genreIds]],
            'Publisher' => ['not_empty', ['one_of' => $publisherIds]],
            'Format'    => ['not_empty', ['one_of' => ['Paperback', 'Ebook', 'Hardcover', 'Audio']]],
            'Authors'   => ['required', ['list_of' => ['one_of' => $authorIds]]],
            // TODO: upload images for books via AJAX
        ];

        return Validator::validate($params, $rules);
    }

    public function execute(array $params)
    {
        $params += [
            'Title'     => '',
            'ISBN'      => '',
            'Year'      => null,
            'Format'    => '',
            'Genre'     => null,
            'Publisher' => null,
            'Authors'     => [],
        ];

        try {
            Transaction::beginTransaction();

            // ============= Create Book data ==========================
            $bookId = Book::create($params);
            Book::addAuthors($bookId, $params['Authors']);
            // =========== End Create Book data ========================

            Transaction::commitTransaction();
        } catch (\Exception $e) {
            Transaction::rollbackTransaction();
            throw $e;
        }

        return [
            'Status'    => 1,
            'BookId'    => $bookId,
        ];
    }
}
