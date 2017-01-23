<?php

namespace Service\User;

use Model\User;
use Model\Role;
use Service\Base;
use Service\Validator;

class Create extends Base
{
    public function validate($params)
    {
        $roleIds = array_map(function ($role) {
            return $role['id'];
        }, Role::index());

        $rules = [
            'Name'              => ['max_length' => 255],
            'Email'             => ['required', 'email', ['max_length' => 255]],
            'Password'          => ['required', ['min_length' => 8]],
            'PasswordRepeat'    => ['required', ['equal_to_field' => 'Password']],
            'Role'              => ['not_empty', ['one_of' => $roleIds]],
        ];

        return Validator::validate($params, $rules);
    }

    public function execute($params)
    {
        $defaultRole = Role::findByName('user');

        $params += [
            'Name'  => '',
            'Role'  => $defaultRole !== null ? $defaultRole['id'] : 0,
        ];

        $userId = User::create($params);

        return [
            'Status'   => 1,
            'UserId'   => $userId,
        ];
    }
}
