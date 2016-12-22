<?php

namespace Model;

use Model\Driver\Engine;

class Cast implements ModelInterface
{
    use Traits\BaseFunctions;

    const CONNECTION_NAME = 'framework';
    const TABLE_NAME = 'casts';

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
     * Insert new cast
     *
     * @param   array $data
     * @return  bool
     */
    public static function create($data = array())
    {
        $connection = self::getConnection();

        $name = isset($data['Name']) ? $data['Name'] : '';
        $surname = isset($data['Surname']) ? $data['Surname'] : '';

        $statement = $connection->prepare(
            " INSERT INTO ".self::TABLE_NAME."(
                name,
                surname
            ) VALUES (
                :name,
                :surname
            )"
        );

        $statement->bindValue(':name', $name);
        $statement->bindValue(':surname', $surname);

        $inserted = $statement->execute();

        if ($inserted) {
            return $connection->lastInsertId(self::TABLE_NAME);
        }

        return false;
    }

    /**
     * Update cast by Id
     *
     * @param   int     $id
     * @param   array   $data
     * @return  mixed
     */
    public static function update($id, array $data)
    {
        $connection = self::getConnection();

        $name = isset($data['Name']) ? $data['Name'] : '';
        $surname = isset($data['Surname']) ? $data['Surname'] : '';

        $statement = $connection->prepare(
            "UPDATE ".self::TABLE_NAME."
             SET
                name = :name,
                surname = :surname
             WHERE id = :id"
        );

        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':surname', $surname);

        return $statement->execute();
    }

    /**
     * Return list of casts
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
     * Search casts by surname
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
     * Count all casts
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
    public static function countFiltered(array $params)
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
     * Delete cast
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
     * Transform database columns to Camel Case
     *
     * @param   array   $cast
     * @return  array
     */
    public static function toCamelCase(array $cast)
    {
        return [
            'Id'        => $cast['id'],
            'Name'      => $cast['name'],
            'Surname'   => $cast['surname'],
        ];
    }
}
