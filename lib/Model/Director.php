<?php

namespace Model;

use Model\Driver\Engine;

class Director implements ModelInterface
{

    use Traits\BaseFunctions;

    const CONNECTION_NAME = 'framework';
    const TABLE_NAME = 'directors';

    /**
     * Create connection
     *
     * @return bool|mixed
     */
    public static function getConnection()
    {
        return Engine::getConnection(self::CONNECTION_NAME);
    }

    public static function create($data = array())
    {
        return false;
    }

    /**
     * Return list of directors
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

    /**
     * Search directors by surname
     *
     * @param   array   $params
     * @return  bool
     */
    public static function search($params = array())
    {
        $connection = self::getConnection();

        $whereSurname = isset($params['Search']) && $params['Search']
            ? $params['Search']
            : null;

        $limit = isset($params['Limit']) ? " LIMIT $params[Limit] " : '';
        $offset = isset($params['Offset']) ? " OFFSET $params[Offset] " : '';
        $order = isset($params['SortField']) && isset($params['SortOrder']) ?
            " ORDER BY $params[SortField] $params[SortOrder] " : '';

        $where = $whereSurname
            ? ' WHERE '.self::TABLE_NAME.'.surname LIKE "%:surname%" '
            : '';

        $query = "SELECT ".self::TABLE_NAME.".* FROM ".self::TABLE_NAME.$where.$order.$limit.$offset;

        $statement = $connection->prepare($query);

        $statement->bindValue(':surname', $whereSurname, \PDO::PARAM_STR);

        $success = $statement->execute();

        if ($success) {
            return $statement->fetchAll();
        }

        return false;
    }

    /**
     * Count all directors
     *
     * @return bool
     */
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

    /**
     * Count filtered rows
     *
     * @param   array   $params
     * @return  bool
     */
    public static function countFiltered($params)
    {
        $connection = self::getConnection();

        $whereSurname = isset($params['Search']) && $params['Search']
            ? $params['Search']
            : null;
        $where = $whereSurname
            ? ' WHERE '.self::TABLE_NAME.'.surname LIKE "%:surname%" '
            : '';

        $query = "SELECT count(*) as sum FROM ".self::TABLE_NAME.$where;

        $statement = $connection->prepare($query);

        $statement->bindValue(':surname', $whereSurname, \PDO::PARAM_STR);

        $success = $statement->execute();

        if ($success) {
            return $statement->fetch()['sum'];
        }

        return false;
    }

    /**
     * Transform database columns to Camel Case
     *
     * @param   array $director
     * @return  array
     */
    public static function toCamelCase($director)
    {
        return [
            'Id'        => $director['id'],
            'Name'      => $director['name'],
            'Surname'   => $director['surname'],
        ];
    }
}
