<?php

namespace Model;

use Model\Driver\Engine;

class Role implements ModelInterface
{
    use Traits\BaseFunctions;

    const CONNECTION_NAME = 'framework';
    const TABLE_NAME = 'roles';

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
     * Insert new role
     *
     * @param   array $data
     * @return  bool
     */
    public static function create($data = array())
    {
        return false;
    }

    /**
     * Return list of roles
     *
     * @param   array   $params
     * @return  bool
     */
    public static function index($params = array())
    {
        $connection = self::getConnection();

        $limit = isset($params['Limit']) ? " LIMIT $params[Limit] " : '';
        $offset = isset($params['Offset']) ? " OFFSET $params[Offset] " : '';
        $order = isset($params['SortField']) && isset($params['SortOrder']) ?
            " ORDER BY $params[SortField] $params[SortOrder] " : '';

        $query = "SELECT * FROM ".self::TABLE_NAME.$order.$limit.$offset;

        $statement = $connection->prepare($query);

        $success = $statement->execute();

        if ($success) {
            return $statement->fetchAll();
        }

        return false;
    }

    public static function findByName($name)
    {
        $connection = static::getConnection();

        $statement = $connection->prepare(
            " SELECT * FROM ".static::TABLE_NAME.
            " WHERE name = :name"
        );

        $statement->bindValue(':name', $name);

        $statement->execute();

        $row = $statement->fetch();

        return $row;
    }
}
