<?php

namespace Model;

use Model\Driver\Engine;

class User implements ModelInterface
{
    use Traits\BaseFunctions;

    const CONNECTION_NAME = 'framework';
    const TABLE_NAME = 'users';
    const ROLES_TABLE_NAME = 'roles';

    /**
     * Create connection
     *
     * @return bool|mixed
     */
    public static function getConnection()
    {
        return Engine::getConnection(self::CONNECTION_NAME);
    }

    /**
     * Insert new user
     *
     * @param   array $data
     * @return  bool
     */
    public static function create($data = array())
    {
        $connection = self::getConnection();

        $name = isset($data['Name']) ? $data['Name'] : '';
        $roleId = isset($data['Role']) ? $data['Role'] : 1;
        $email = isset($data['Email']) ? $data['Email'] : '';
        $password = isset($data['Password'])
            ? password_hash($data['Password'], PASSWORD_BCRYPT)
            : '';

        $statement = $connection->prepare(
            " INSERT INTO ".self::TABLE_NAME."(
                role_id,
                name,
                email,
                password
            ) VALUES (
                :roleId,
                :name,
                :email,
                :password
            )"
        );

        $statement->bindValue(':roleId', $roleId);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $password);

        $inserted = $statement->execute();

        if ($inserted) {
            return $connection->lastInsertId(self::TABLE_NAME);
        }

        return false;
    }

    /**
     * Update user by Id
     *
     * @param   int     $id
     * @param   array   $data
     * @return  mixed
     */
    public static function update($id, array $data)
    {
        $connection = self::getConnection();

        $name = isset($data['Name']) ? $data['Name'] : '';
        $roleId = isset($data['Role']) ? $data['Role'] : 1;
        $email = isset($data['Email']) ? $data['Email'] : '';
        $password = isset($data['Password'])
            ? password_hash($data['Password'], PASSWORD_BCRYPT)
            : '';

        $statement = $connection->prepare(
            "UPDATE ".self::TABLE_NAME."
             SET
                name = :name,
                role_id = :roleId,
                email = :email,
                password = :password
             WHERE id = :id"
        );

        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->bindValue(':roleId', $roleId);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $password);

        return $statement->execute();
    }

    public static function findByEmail($email)
    {
        $connection = static::getConnection();

        $statement = $connection->prepare(
            " SELECT ".static::TABLE_NAME.".*, ".static::ROLES_TABLE_NAME.".name as role ".
            " FROM ".static::TABLE_NAME.
            " LEFT JOIN ".static::ROLES_TABLE_NAME.
            "     ON ".static::TABLE_NAME.".role_id = ".static::ROLES_TABLE_NAME.".id ".
            " WHERE email = :email"
        );

        $statement->bindValue(':email', $email);

        $statement->execute();

        $row = $statement->fetch();

        return $row;
    }

    /**
     * Transform database columns to Camel Case
     *
     * @param   array   $user
     * @return  array
     */
    public static function toCamelCase(array $user)
    {
        return [
            'Id'        => $user['id'],
            'Name'      => $user['name'],
            'Email'     => $user['email'],
            'Role'      => $user['role_id'],
            'Password'  => $user['password'],
        ];
    }
}
