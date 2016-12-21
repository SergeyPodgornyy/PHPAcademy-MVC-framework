<?php

namespace Model;

class Genre implements \Model\ModelInterface
{

    use Traits\BaseFunctions;

    const CONNECTION_NAME = 'framework';
    const TABLE_NAME = 'genres';

    public static function getConnection()
    {
        return \Model\Driver\Engine::getConnection(self::CONNECTION_NAME);
    }

    public static function create($data = array())
    {
        return false;
    }

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

    public static function search($params = array())
    {
        $connection = self::getConnection();

        $whereName = isset($params['Search']) && $params['Search']
            ? $params['Search']
            : null;

        $limit = isset($params['Limit']) ? " LIMIT $params[Limit] " : '';
        $offset = isset($params['Offset']) ? " OFFSET $params[Offset] " : '';
        $order = isset($params['SortField']) && isset($params['SortOrder']) ?
            " ORDER BY $params[SortField] $params[SortOrder] " : '';

        $where = $whereName
            ? ' WHERE '.self::TABLE_NAME.'.name LIKE "%:name%" '
            : '';

        $query = "SELECT ".self::TABLE_NAME.".* FROM ".self::TABLE_NAME.$where.$order.$limit.$offset;

        $statement = $connection->prepare($query);

        $statement->bindValue(':name', $whereName, \PDO::PARAM_STR);

        $success = $statement->execute();

        if ($success) {
            return $statement->fetchAll();
        }

        return false;
    }

    public static function count()
    {
        $connection = self::getConnection();

        $query = "SELECT count(*) as sum FROM ".self::TABLE_NAME;

        $statement = $connection->prepare($query);

        $success = $statement->execute();

        if ($success) {
            return $statement->fetch()['sum'];
        }

        return false;
    }

    public static function countFiltered($params)
    {
        $connection = self::getConnection();

        $whereName = isset($params['Search']) && $params['Search']
            ? $params['Search']
            : null;
        $where = $whereName
            ? ' WHERE '.self::TABLE_NAME.'.name LIKE "%:name%" '
            : '';

        $query = "SELECT count(*) as sum FROM ".self::TABLE_NAME.$where;

        $statement = $connection->prepare($query);

        $statement->bindValue(':name', $whereName, \PDO::PARAM_STR);

        $success = $statement->execute();

        if ($success) {
            return $statement->fetch()['sum'];
        }

        return false;
    }

    public static function toCamelCase($genre)
    {
        return [
            'Id'        => $genre['id'],
            'Name'      => $genre['name'],
        ];
    }
}
