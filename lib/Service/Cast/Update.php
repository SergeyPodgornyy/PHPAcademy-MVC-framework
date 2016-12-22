<?php

namespace Service\Cast;

use Model\Cast;
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
        $cast = Cast::findById($params['Id']);
        if (!$cast) {
            throw new X([
                'Type'    => 'FORMAT_ERROR',
                'Fields'  => ['Id' => 'WRONG'],
                'Message' => 'Cast does not exists'
            ]);
        }

        try {
            Transaction::beginTransaction();

            // ============= Update Cast data ==========================
            $updatedCast = array_merge(
                Cast::toCamelCase($cast),
                $params
            );
            Cast::update($params['Id'], $updatedCast);
            // =========== End Update Cast data ========================

            Transaction::commitTransaction();
        } catch (\Exception $e) {
            Transaction::rollbackTransaction();
            throw $e;
        }

        return [
            'Status'    => 1,
            'Cast'      => $updatedCast,
        ];
    }
}
