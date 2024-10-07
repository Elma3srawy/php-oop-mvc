<?php 

namespace Illuminate\Databases\Grammars;

use App\Models\Model;

class MySQLGrammar
{

    public static function buildInsertQuery(array $keys): string
    {
        $columns = implode('`, `', $keys);
        $placeholders = rtrim(str_repeat('?, ', count($keys)), ', ');

        return sprintf(
            'INSERT INTO `%s` (`%s`) VALUES (%s)',
            Model::getTableName(),
            $columns,
            $placeholders
        );
    }


    public static function buildUpdateQuery(array $keys): string
    {
        $columns = implode(' = ?, ', $keys) . ' = ?';

        return sprintf(
            'UPDATE `%s` SET %s WHERE id = ?',
            Model::getTableName(),
            $columns
        );
    }


    public static function buildSelectQuery($columns = '*', array $filter = null): string
    {
        $columns = is_array($columns) ? implode(', ', $columns) : $columns;
        $query = sprintf('SELECT %s FROM `%s`', $columns, Model::getTableName());

        if ($filter) {
            $query .= sprintf(' WHERE `%s` %s ?', $filter[0], $filter[1]);
        }

        return $query;
    }

    public static function buildDeleteQuery(): string
    {
        return sprintf('DELETE FROM `%s` WHERE id = ?', Model::getTableName());
    }
}