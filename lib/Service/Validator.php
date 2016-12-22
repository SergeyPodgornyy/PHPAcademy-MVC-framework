<?php

namespace Service;

use Validator\LIVR;

class Validator
{
    /**
     * @param   array       $data   Data to validate
     * @param   array       $livr   LIVR rules
     * @return  array|bool
     * @throws X
     */
    public static function validate(array $data, array $livr)
    {
        LIVR::registerDefaultRules([
            'latin_string' => function () {
                return function ($value) {
                    if (!isset($value) || $value === '') {
                        return;
                    }
                    if (!is_string($value)) {
                        return 'FORMAT_ERROR';
                    }

                    $validStringReg = '/^[a-zA-Z0-9\-\_\+\#№"\']+$/';
                    if (!preg_match($validStringReg, $value)) {
                        return 'WRONG_STRING';
                    }

                    return;
                };
            },
            'list_objects' => function () {
                return function ($value) {
                    if (!isset($value) || !$value) {
                        return;
                    }
                    if (!is_array($value) || !\Validator\LIVR\Util::isAssocArray($value)) {
                        return 'FORMAT_ERROR';
                    }

                    foreach ($value as $object) {
                        if (!is_array($value) || !\Validator\LIVR\Util::isAssocArray($object)) {
                            return 'FORMAT_ERROR';
                        }
                    }

                    return;
                };
            }
        ]);

        $validator = new LIVR($livr);

        $validated = $validator->validate($data);
        $errors    = $validator->getErrors();

        if ($errors) {
            throw new X([
                'Type'      => 'FORMAT_ERROR',
                'Fields'    => $errors,
            ]);
        }

        return $validated;
    }
}
