<?php

namespace Model;

use Model\Driver\Engine;

class Book implements ModelInterface
{

    use Traits\BaseFunctions;

    const CONNECTION_NAME = 'framework';
    const TABLE_NAME = 'books';

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
     * Insert new book
     *
     * @param   array $data
     * @return  bool
     */
    public static function create($data = array())
    {
        $connection = self::getConnection();

        $title = isset($data['Title']) ? $data['Title'] : '';
        $isbn = isset($data['ISBN']) ? $data['ISBN'] : '';
        $year = isset($data['Year']) ? $data['Year'] : null;
        $format = isset($data['Format']) ? $data['Format'] : '';
        $genre = isset($data['Genre']) ? $data['Genre'] : null;
        $publisher = isset($data['Publisher']) ? $data['Publisher'] : null;

        $statement = $connection->prepare(
            " INSERT INTO ".self::TABLE_NAME."(
                title,
                isbn,
                year,
                format,
                genre_id,
                publisher_id
            ) VALUES (
                :title,
                :isbn,
                :year,
                :format,
                :genre_id,
                :publisher_id
            )"
        );

        $statement->bindValue(':title', $title);
        $statement->bindValue(':isbn', $isbn);
        $statement->bindValue(':year', $year);
        $statement->bindValue(':format', $format);
        $statement->bindValue(':genre_id', $genre);
        $statement->bindValue(':publisher_id', $publisher);

        $inserted = $statement->execute();

        if ($inserted) {
            return $connection->lastInsertId(self::TABLE_NAME);
        }

        return false;
    }

    /**
     * Update book by Id
     *
     * @param   int     $id
     * @param   array   $data
     * @return  mixed
     */
    public static function update($id, array $data)
    {
        $connection = self::getConnection();

        $title = isset($data['Title']) ? $data['Title'] : '';
        $isbn = isset($data['ISBN']) ? $data['ISBN'] : '';
        $year = isset($data['Year']) ? $data['Year'] : null;
        $format = isset($data['Format']) ? $data['Format'] : '';
        $genre = isset($data['Genre']) ? $data['Genre'] : null;
        $publisher = isset($data['Publisher']) ? $data['Publisher'] : null;

        $statement = $connection->prepare(
            "UPDATE ".self::TABLE_NAME."
             SET
                title = :title,
                isbn = :isbn,
                year = :year,
                format = :format,
                genre_id = :genre_id,
                publisher_id = :publisher_id
             WHERE id = :id"
        );

        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':isbn', $isbn);
        $statement->bindValue(':year', $year);
        $statement->bindValue(':format', $format);
        $statement->bindValue(':genre_id', $genre);
        $statement->bindValue(':publisher_id', $publisher);

        return $statement->execute();
    }

    /**
     * Add book authors
     *
     * @param   int         $bookId
     * @param   array       $starIds
     * @return  bool|int
     */
    public static function addAuthors($bookId, array $authorIds)
    {
        $connection = self::getConnection();

        $values = '';
        foreach ($authorIds as $n => $id) {
            $values .= $n ? ',' : '';
            $values .= "(:book_id, :author_id_$n)";
        }

        $statement = $connection->prepare("INSERT INTO book_authors(book_id, author_id) VALUES $values");

        $statement->bindValue(':book_id', $bookId);
        foreach ($authorIds as $n => $id) {
            $statement->bindValue(":author_id_$n", $id);
        }

        $inserted = $statement->execute();

        if ($inserted) {
            return $connection->lastInsertId(self::TABLE_NAME);
        }

        return false;
    }

    /**
     * Remove info about book authors
     *
     * @param   int     $bookId
     * @return  mixed
     */
    public static function removeAuthors($bookId)
    {
        $connection = self::getConnection();

        $statement = $connection->prepare(
            "DELETE FROM book_authors WHERE book_id = :book_id"
        );

        $statement->bindValue(':book_id', $bookId);

        return $statement->execute();
    }

    /**
     * Return book authors by book_id
     *
     * @param   int         $movieId
     * @return  bool|array
     */
    public static function getBookAuthors($bookId = 0)
    {
        $connection = self::getConnection();

        $query = "SELECT * FROM authors
            LEFT JOIN book_authors AS ba
                ON authors.id = ba.author_id
            WHERE ba.book_id = :book_id";

        $statement = $connection->prepare($query);
        $statement->bindValue(':book_id', $bookId, \PDO::PARAM_INT);

        $success = $statement->execute();

        if ($success) {
            return $statement->fetchAll();
        }

        return false;
    }

    /**
     * Return list of books
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
     * Search books by title
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
     * Count all books
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
     * Delete book
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
     * Select one book by Id with genres and publisher
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
            "SELECT ".self::TABLE_NAME.".*, $genreName, p.name as publisher
                FROM ".self::TABLE_NAME."
            LEFT JOIN publishers AS p
                ON ".self::TABLE_NAME.".publisher_id = p.id
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
     * @param   array   $movie
     * @return  array
     */
    public static function toCamelCase($movie)
    {
        return [
            'Id'        => $movie['id'],
            'Title'     => $movie['title'],
            'ISBN'      => $movie['isbn'],
            'Year'      => $movie['year'],
            'Format'    => $movie['format'],
            'Genre'     => $movie['genre_id'],
            'Publisher' => $movie['publisher_id'],
        ];
    }
}
