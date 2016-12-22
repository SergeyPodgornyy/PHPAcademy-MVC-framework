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
        $year = isset($data['Year']) ? $data['Year'] : null;
        $format = isset($data['Format']) ? $data['Format'] : '';
        $genre = isset($data['Genre']) ? $data['Genre'] : null;
        $director = isset($data['Director']) ? $data['Director'] : null;

        $statement = $connection->prepare(
            " INSERT INTO ".self::TABLE_NAME."(
                title,
                year,
                format,
                genre_id,
                director_id
            ) VALUES (
                :title,
                :year,
                :format,
                :genre_id,
                :director_id
            )"
        );

        $statement->bindValue(':title', $title);
        $statement->bindValue(':year', $year);
        $statement->bindValue(':format', $format);
        $statement->bindValue(':genre_id', $genre);
        $statement->bindValue(':director_id', $director);

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
        $year = isset($data['Year']) ? $data['Year'] : null;
        $format = isset($data['Format']) ? $data['Format'] : '';
        $genre = isset($data['Genre']) ? $data['Genre'] : null;
        $director = isset($data['Director']) ? $data['Director'] : null;

        $statement = $connection->prepare(
            "UPDATE ".self::TABLE_NAME."
             SET
                title = :title,
                year = :year,
                format = :format,
                genre_id = :genre_id,
                director_id = :director_id
             WHERE id = :id"
        );

        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':year', $year);
        $statement->bindValue(':format', $format);
        $statement->bindValue(':genre_id', $genre);
        $statement->bindValue(':director_id', $director);

        return $statement->execute();
    }

    public static function addStar($movieId, $starId)
    {
        $connection = self::getConnection();

        $statement = $connection->prepare(
            " INSERT INTO movie_casts(
                movie_id,
                cast_id
            ) VALUES (
                :movie_id,
                :cast_id
            )"
        );

        $statement->bindValue(':movie_id', $movieId);
        $statement->bindValue(':cast_id', $starId);

        $inserted = $statement->execute();

        if ($inserted) {
            return $connection->lastInsertId(self::TABLE_NAME);
        }

        return false;
    }

    public static function removeStars($movieId)
    {
        $connection = self::getConnection();

        $statement = $connection->prepare(
            "DELETE FROM movie_casts WHERE movie_id = :movie_id"
        );

        $statement->bindValue(':movie_id', $movieId);

        return $statement->execute();
    }

    public static function getMoviesCasts($movieId = 0)
    {
        $connection = self::getConnection();

        $query = "SELECT * FROM casts
            LEFT JOIN movie_casts AS mv
                ON casts.id = mv.cast_id
            WHERE mv.movie_id = :movie_id";

        $statement = $connection->prepare($query);
        $statement->bindValue(':movie_id', $movieId, \PDO::PARAM_INT);

        $success = $statement->execute();

        if ($success) {
            return $statement->fetchAll();
        }

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
            "SELECT ".self::TABLE_NAME.".*, g.name as genre, CONCAT(d.name, ' ', d.surname) as director
                FROM ".self::TABLE_NAME."
            LEFT JOIN directors AS d
                ON ".self::TABLE_NAME.".director_id = d.id
            LEFT JOIN genres AS g
                ON ".self::TABLE_NAME.".genre_id = g.id
            WHERE ".self::TABLE_NAME.".id = :id"
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
            'Genre'     => $movie['genre_id'],
            'Director'  => $movie['director_id'],
        ];
    }
}
