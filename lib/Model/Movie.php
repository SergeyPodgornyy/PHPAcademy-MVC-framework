<?php

namespace Model;

class Movie implements \Model\ModelInterface
{

    use Traits\BaseFunctions;

    const CONNECTION_NAME = 'framework';
    const TABLE_NAME = 'movies';

    public static function getConnection()
    {
        return \Model\Driver\Engine::getConnection(self::CONNECTION_NAME);
    }

    public static function create($data = array())
    {
        $connection = self::getConnection();

        $title = isset($data['Title']) ? $data['Title'] : '';
        $year = isset($data['Year']) ? $data['Year'] : '';
        $format = isset($data['Formar']) ? $data['Formar'] : '';

        $statement = $connection->prepare(
            " INSERT INTO ".self::TABLE_NAME."(
                title,
                year,
                format
            ) VALUES (
                :title,
                :year,
                :format
            )"
        );

        $statement->bindValue(':title', $title);
        $statement->bindValue(':year', $year);
        $statement->bindValue(':format', $format);

        $inserted = $statement->execute();

        if ($inserted) {
            return $connection->lastInsertId(self::TABLE_NAME);
        }

        return false;
    }

    public static function update($id, $data)
    {
        $connection = self::getConnection();

        $title = isset($data['Title']) ? $data['Title'] : '';
        $year = isset($data['Year']) ? $data['Year'] : '';
        $format = isset($data['Format']) ? $data['Format'] : '';

        $statement = $connection->prepare(
            "UPDATE ".self::TABLE_NAME."
             SET
                title = :title,
                year = :year,
                format = :format
             WHERE id = :id"
        );

        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':year', $year);
        $statement->bindValue(':format', $format);

        return $statement->execute();
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

        $whereTitle = isset($params['Search']) && $params['Search']
            ? $params['Search']
            : null;

        $limit = isset($params['Limit']) ? " LIMIT $params[Limit] " : '';
        $offset = isset($params['Offset']) ? " OFFSET $params[Offset] " : '';
        $order = isset($params['SortField']) && isset($params['SortOrder']) ?
            " ORDER BY $params[SortField] $params[SortOrder] " : '';

        $where = $whereTitle
            ? ' WHERE '.self::TABLE_NAME.'.title LIKE "%:title%" '
            : '';

        $query = "SELECT ".self::TABLE_NAME.".* FROM ".self::TABLE_NAME.$where.$order.$limit.$offset;

        $statement = $connection->prepare($query);

        $statement->bindValue(':title', $whereTitle, \PDO::PARAM_STR);

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

        $whereTitle = isset($params['Search']) && $params['Search']
            ? $params['Search']
            : null;
        $where = $whereTitle
            ? ' WHERE '.self::TABLE_NAME.'.title LIKE "%:title%" '
            : '';

        $query = "SELECT count(*) as sum FROM ".self::TABLE_NAME.$where;

        $statement = $connection->prepare($query);

        $statement->bindValue(':title', $whereTitle, \PDO::PARAM_STR);

        $success = $statement->execute();

        if ($success) {
            return $statement->fetch()['sum'];
        }

        return false;
    }

    public static function delete($data = array())
    {
        $connection = self::getConnection();

        $ids = isset($data['Id']) && is_array($data['Id'])
            ? $data['Id']
            : [];

        $whereInds = '';
        foreach ($ids as $n => $id) {
            $whereInds .= $n ? ',' : '';
            $whereInds .= ":id_$n";
        }

        $whereInds = $whereInds ? " id IN ($whereInds) " : '';

        if (!$whereInds) {
            return false;
        }

        $statement = $connection->prepare(
            "DELETE FROM ".self::TABLE_NAME." WHERE $whereInds"
        );

        foreach ($ids as $n => $id) {
            $statement->bindValue(":id_$n", $id);
        }

        return $statement->execute();
    }

    public static function selectOne($data = array())
    {
        $connection = self::getConnection();

        $id = isset($data['Id']) ? $data['Id'] : '';

        $statement = $connection->prepare(
            " SELECT * FROM ".self::TABLE_NAME.
            " WHERE id = :id"
        );

        $statement->bindValue(':id', $id);

        $statement->execute();

        $row = $statement->fetch();

        return $row;
    }

    public static function toCamelCase($movie)
    {
        return [
            'Id'        => $movie['id'],
            'Title'     => $movie['title'],
            'Year'      => $movie['year'],
            'Format'    => $movie['format'],
        ];
    }
}
