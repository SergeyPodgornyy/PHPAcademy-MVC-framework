<?php

namespace Service\Sessions;

use Model\User;

class Create extends \Service\Base
{
    public function validate(array $params)
    {
        $rules = [
            'Email'     => ['required', 'email', 'to_lc'],
            'Password'  => ['required', ['min_length' => 6]],
        ];

        return \Service\Validator::validate($params, $rules);
    }

    public function execute(array $params)
    {
        $user = User::findByEmail($params['Email']);

        if (!$user) {
            throw new \Service\X\WrongAuthorization(['Type' => 'WRONG_EMAIL']);
        }


        // error_log(print_r($us))

        if (!($user &&  password_verify($params['Password'], $user['password']))) {
            throw new \Service\X\WrongAuthorization(['Type' => 'WRONG_PASSWORD']);
        }

        unset($user['Password']);

        return [
            'Status'    => 1,
            'User'      => $user,
        ];
    }
}
