<?php

namespace Service\Cast;

class Update extends \Service\Base
{
    public function validate($params)
    {
        $rules = [
            'Id'        => ['required', 'positive_integer'],
            'Name'      => ['required', ['max_length' => 255]],
            'Surname'   => ['required', ['max_length' => 255]],
        ];

        return \Service\Validator::validate($params, $rules);
    }

    public function execute($params)
    {
        $cast = \Model\Cast::findById($params['Id']);
        if (!$cast) {
            throw new \Service\X([
                'Type'    => 'FORMAT_ERROR',
                'Fields'  => ['Id' => 'WRONG'],
                'Message' => 'Cast does not exists'
            ]);
        }

        try {
            \Model\Utils\Transaction::beginTransaction();

            // ============= Update Cast data ==========================
            $updatedCast = array_merge(
                \Model\Cast::toCamelCase($cast),
                $params
            );
            \Model\Cast::update($params['Id'], $updatedCast);
            // =========== End Update Cast data ========================

            \Model\Utils\Transaction::commitTransaction();
        } catch (\Exception $e) {
            \Model\Utils\Transaction::rollbackTransaction();
            throw $e;
        }

        return [
            'Status'    => 1,
            'Cast'      => $updatedCast,
        ];
    }
}
