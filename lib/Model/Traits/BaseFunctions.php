<?php

namespace Model\Traits;

trait BaseFunctions
{

    public static function selectOneOrCreate($data = array())
    {
        $object = static::selectOne($data);

        if ($object && is_array($object)) {
            return $object;
        }

        $id = static::create($data);

        return static::findById($id);
    }

    public static function selectOneOrUpdate($id, $data = array())
    {
        $object = static::selectOne($data);

        if ($object && is_array($object)) {
            return $object;
        }

        $id = static::update($id, $data);

        return static::findById($id);
    }

    public static function findById($id)
    {
        $connection = static::getConnection();

        $statement = $connection->prepare(
            " SELECT * FROM ".static::TABLE_NAME.
            " WHERE id = :id"
        );

        $statement->bindValue(':id', $id);

        $statement->execute();

        $row = $statement->fetch();

        return $row;
    }

    private static function buildWhere($conditions = array(), $logicOperation = 'AND')
    {
        $where = '';
        foreach ($conditions as $column => $value) {
            $where .= $where ? " $logicOperation " : '';
            $where .= " $column = :$column ";
        }
        return $where ? "($where)" : '';
    }

    public static function toAssocArray($ids = array(), $array = array())
    {
        return array_combine($ids, $array);
    }
}
