<?php

namespace Model;

use Model\Driver\Engine;
use Utils\Cache;

class Genre implements ModelInterface
{
    use Traits\BaseFunctions;

    const CONNECTION_NAME = 'framework';
    const TABLE_NAME = 'genres';
    const TRANSLATION_TABLE_NAME = 'genre_translations';

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
     * Return list of genres
     *
     * @param   array   $params
     * @return  bool
     */
    public static function index($params = array())
    {
        $cache = new Cache();
        $cacheKey = implode('_', [
            'Genre',
            'Index',
            md5(json_encode($params))
        ]);

        $data = $cache->get($cacheKey);

        if ($data !== false) {
            return $data;
        }

        $connection = self::getConnection();

        $whereArray = [];

        if (isset($params['Type'])) {
            $whereArray[] = " type=:type ";
        }
        if (isset($params['Locale'])) {
            $whereArray[] = " locale=:locale ";
        }

        $limit = isset($params['Limit']) ? " LIMIT $params[Limit] " : '';
        $offset = isset($params['Offset']) ? " OFFSET $params[Offset] " : '';
        $order = isset($params['SortField']) && isset($params['SortOrder']) ?
            " ORDER BY $params[SortField] $params[SortOrder] " : '';

        $query = "SELECT " . self::TABLE_NAME . ".*, " . self::TRANSLATION_TABLE_NAME . ".name as translated_name "
            . " FROM " . self::TABLE_NAME
            . " LEFT JOIN " . self::TRANSLATION_TABLE_NAME
                . " ON " . self::TABLE_NAME . '.id = ' . self::TRANSLATION_TABLE_NAME . '.genre_id '
            . ($whereArray ? ' WHERE ' . implode(' AND ', $whereArray) : '')
            . " GROUP BY " . self::TRANSLATION_TABLE_NAME . '.genre_id '
            . $order . $limit . $offset;

        $statement = $connection->prepare($query);

        if (isset($params['Type'])) {
            $statement->bindValue(':type', $params['Type'], \PDO::PARAM_STR);
        }
        if (isset($params['Locale'])) {
            $statement->bindValue(':locale', $params['Locale'], \PDO::PARAM_STR);
        }

        $success = $statement->execute();

        if ($success) {
            $result = $statement->fetchAll();
            $cache->set($cacheKey, $result);
            return $result;
        }

        return false;
    }

    /**
     * Search genres by name
     *
     * @param   array   $params
     * @return  bool
     */
    public static function search($params = array())
    {
        $cache = new Cache();
        $cacheKey = implode('_', [
            'Genre',
            'Search',
            md5(json_encode($params))
        ]);

        $data = $cache->get($cacheKey);

        if ($data !== false) {
            return $data;
        }

        $connection = self::getConnection();

        $whereArray = [];

        if (isset($params['Search']) && $params['Search']) {
            $whereArray[] = self::TABLE_NAME.'.name LIKE "%:name%" ';
        }
        if (isset($params['Type']) && $params['Type']) {
            $whereArray[] = self::TABLE_NAME.'.type=:type ';
        }
        if (isset($params['Locale'])) {
            $whereArray[] = " locale=:locale ";
        }

        $limit = isset($params['Limit']) ? " LIMIT $params[Limit] " : '';
        $offset = isset($params['Offset']) ? " OFFSET $params[Offset] " : '';
        $order = isset($params['SortField']) && isset($params['SortOrder']) ?
            " ORDER BY $params[SortField] $params[SortOrder] " : '';

        $query = "SELECT " . self::TABLE_NAME . ".*, " . self::TRANSLATION_TABLE_NAME . ".name as translated_name "
            . " FROM " . self::TABLE_NAME
            . " LEFT JOIN " . self::TRANSLATION_TABLE_NAME
                . " ON " . self::TABLE_NAME . '.id = ' . self::TRANSLATION_TABLE_NAME . '.genre_id '
            . ($whereArray ? ' WHERE ' . implode(' AND ', $whereArray) : '')
            . " GROUP BY " . self::TRANSLATION_TABLE_NAME . '.genre_id '
            . $order . $limit . $offset;

        $statement = $connection->prepare($query);

        if (isset($params['Search']) && $params['Search']) {
            $statement->bindValue(':name', $params['Search'], \PDO::PARAM_STR);
        }
        if (isset($params['Type']) && $params['Type']) {
            $statement->bindValue(':type', $params['Type'], \PDO::PARAM_STR);
        }
        if (isset($params['Locale'])) {
            $statement->bindValue(':locale', $params['Locale'], \PDO::PARAM_STR);
        }

        $success = $statement->execute();

        if ($success) {
            $result = $statement->fetchAll();
            $cache->set($cacheKey, $result);
            return $result;
        }

        return false;
    }

    /**
     * Count all directors
     *
     * @return bool
     */
    public static function count($type = null)
    {
        $connection = self::getConnection();

        $where = $type ? " WHERE type='$type' " : '';
        $query = "SELECT count(*) as sum FROM ".self::TABLE_NAME.$where;

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

        $whereName = isset($params['Search']) && $params['Search']
            ? $params['Search']
            : null;
        $whereType = isset($params['Type']) && $params['Type']
            ? $params['Type']
            : null;
        $where = $whereName
            ? ' WHERE '.self::TABLE_NAME.'.name LIKE "%:name%" '
                . ($whereType ? " AND type='$type' " : '')
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

    /**
     * Transform database columns to Camel Case
     *
     * @param   array $genre
     * @return  array
     */
    public static function toCamelCase($genre)
    {
        return [
            'Id'    => $genre['id'],
            'Name'  => $genre['name'],
            'Type'  => $genre['type'],
        ];
    }
}
