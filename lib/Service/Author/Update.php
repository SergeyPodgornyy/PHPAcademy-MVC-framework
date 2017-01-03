<?php

namespace Service\Author;

use Model\Author;
use Model\Utils\Transaction;
use Service\Base;
use Service\Validator;
use Service\X;

class Update extends Base
{
    public function validate($params)
    {
        $rules = [
            'Id'        => ['required', 'positive_integer'],
            'Name'      => ['required', ['max_length' => 255]],
            'Surname'   => ['required', ['max_length' => 255]],
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

        try {
            Transaction::beginTransaction();

            // ============= Update Author data ==========================
            $updatedAuthor = array_merge(
                Author::toCamelCase($author),
                $params
            );
            Author::update($params['Id'], $updatedAuthor);
            // =========== End Update Author data ========================

            Transaction::commitTransaction();
        } catch (\Exception $e) {
            Transaction::rollbackTransaction();
            throw $e;
        }

        return [
            'Status'    => 1,
            'Author'    => $updatedAuthor,
        ];
    }
}
