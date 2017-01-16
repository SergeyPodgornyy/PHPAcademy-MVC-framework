<?php

namespace Model;

use Model\Driver\Engine;

class Music implements ModelInterface
{

    use Traits\BaseFunctions;

    const CONNECTION_NAME = 'framework';
    const TABLE_NAME = 'music';

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
     * Insert new music item
     *
     * @param   array $data
     * @return  bool
     */
    public static function create($data = array())
    {
        $connection = self::getConnection();

        $title = isset($data['Title']) ? $data['Title'] : '';
        $year = isset($data['Year']) ? $data['Year'] : null;
        $format = isset($data['Format']) ? $data['Format'] : '';
        $genre = isset($data['Genre']) ? $data['Genre'] : null;
        $artist = isset($data['Artist']) ? $data['Artist'] : null;

        $statement = $connection->prepare(
            " INSERT INTO ".self::TABLE_NAME."(
                title,
                year,
                format,
                genre_id,
                artist_id
            ) VALUES (
                :title,
                :year,
                :format,
                :genre_id,
                :artist_id
            )"
        );

        $statement->bindValue(':title', $title);
        $statement->bindValue(':year', $year);
        $statement->bindValue(':format', $format);
        $statement->bindValue(':genre_id', $genre);
        $statement->bindValue(':artist_id', $artist);

        $inserted = $statement->execute();

        if ($inserted) {
            return $connection->lastInsertId(self::TABLE_NAME);
        }

        return false;
    }

    /**
     * Update music by Id
     *
     * @param   int     $id
     * @param   array   $data
     * @return  mixed
     */
    public static function update($id, array $data)
    {
        $connection = self::getConnection();

        $title = isset($data['Title']) ? $data['Title'] : '';
        $year = isset($data['Year']) ? $data['Year'] : null;
        $format = isset($data['Format']) ? $data['Format'] : '';
        $genre = isset($data['Genre']) ? $data['Genre'] : null;
        $artist = isset($data['Artist']) ? $data['Artist'] : null;

        $statement = $connection->prepare(
            "UPDATE ".self::TABLE_NAME."
             SET
                title = :title,
                year = :year,
                format = :format,
                genre_id = :genre_id,
                artist_id = :artist_id
             WHERE id = :id"
        );

        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':year', $year);
        $statement->bindValue(':format', $format);
        $statement->bindValue(':genre_id', $genre);
        $statement->bindValue(':artist_id', $artist);

        return $statement->execute();
    }

    /**
     * Return list of music
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
     * Search music by title
     *
     * @param   array   $params
     * @return  bool
     */
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

    /**
     * Count all music items
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

    /**
     * Delete music item
     *
     * @param   array   $data
     * @return  bool
     */
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

    /**
     * Select one music item by Id with genres and artists
     *
     * @param   array   $data
     * @return  mixed
     */
    public static function selectOne($data = array())
    {
        $connection = self::getConnection();

        $id = isset($data['Id']) ? $data['Id'] : '';

        $localeWhere = isset($data['Locale']) ? " AND gt.locale = '$data[Locale]' " : "";
        $genreName = isset($data['Locale']) ? " gt.name as genre " : " g.name as genre ";

        $statement = $connection->prepare(
            "SELECT ".self::TABLE_NAME.".*, $genreName, CONCAT(a.name, ' ', a.surname) as artist
                FROM ".self::TABLE_NAME."
            LEFT JOIN artists AS a
                ON ".self::TABLE_NAME.".artist_id = a.id
            LEFT JOIN genres AS g
                ON ".self::TABLE_NAME.".genre_id = g.id
            LEFT JOIN genre_translations AS gt
                ON gt.genre_id = g.id
            WHERE ".self::TABLE_NAME.".id = :id $localeWhere
            GROUP BY gt.genre_id"
        );

        $statement->bindValue(':id', $id);

        $statement->execute();

        $row = $statement->fetch();

        return $row;
    }

    /**
     * Transform database columns to Camel Case
     *
     * @param   array   $music
     * @return  array
     */
    public static function toCamelCase($music)
    {
        return [
            'Id'        => $music['id'],
            'Title'     => $music['title'],
            'Year'      => $music['year'],
            'Format'    => $music['format'],
            'Genre'     => $music['genre_id'],
            'Artist'    => $music['artist_id'],
        ];
    }
}
