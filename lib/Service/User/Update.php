<?php

namespace Service\User;

use Model\User;
use Model\Role;
use Model\Utils\Transaction;
use Service\Base;
use Service\Validator;
use Service\X;

class Update extends Base
{
    public function validate($params)
    {
        $roleIds = array_map(function ($role) {
            return $role['id'];
        }, Role::index());

        $rules = [
            'Id'                => ['required', 'positive_integer'],
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
        $user = User::findById($params['Id']);
        if (!$user) {
            throw new X([
                'Type'    => 'FORMAT_ERROR',
                'Fields'  => ['Id' => 'WRONG'],
                'Message' => 'User does not exists',
            ]);
        }

        if (User::findByEmail($params['Email']) && $params['Email'] !== $user['email']) {
            throw new X([
                'Type'    => 'FORMAT_ERROR',
                'Fields'  => ['Email' => 'WRONG'],
                'Message' => 'User with this email already exists',
            ]);
        }

        try {
            Transaction::beginTransaction();

            // ============= Update User data ==========================
            $updatedUser = array_merge(
                User::toCamelCase($user),
                $params
            );
            User::update($params['Id'], $updatedUser);
            // =========== End Update User data ========================

            Transaction::commitTransaction();
        } catch (\Exception $e) {
            Transaction::rollbackTransaction();
            throw $e;
        }

        return [
            'Status'    => 1,
            'User'      => User::findByEmail($params['Email']),
        ];
    }
}
