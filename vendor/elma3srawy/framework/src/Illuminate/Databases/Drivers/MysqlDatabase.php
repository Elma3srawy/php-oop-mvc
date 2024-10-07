<?php 

namespace Illuminate\Databases\Drivers;

use App\Models\Model;
use Illuminate\Databases\Grammars\MySQLGrammar;
use Illuminate\Databases\Drivers\Contract\DatabaseManger;




class MysqlDatabase implements DatabaseManger
{

    protected static $instance;

    public function connect():\PDO
    {
        if(!self::$instance)
        {
            $dns = 'mysql:host=' . env('DB_HOST') . ';port=' . env('DB_PORT') . ';dbname=' . env('DB_DATABASE');
            self::$instance = new \PDO($dns, env('DB_USERNAME'), env('DB_PASSWORD'));
        }
        return self::$instance;
    }

    public function query(string $query, array $values = []): array
    {
        $stmt = self::$instance->prepare($query);
        $this->bindValues($stmt, $values);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function read($columns = '*', array $filter = null): array
    {
        $query = MySQLGrammar::buildSelectQuery($columns, $filter);
        $stmt = self::$instance->prepare($query);

        if ($filter) {
            $stmt->bindValue(1, $filter[2]);  // Bind the filter value if available
        }

        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, Model::getModel());
    }

    public function delete(int $id): bool
    {
        $query = MySQLGrammar::buildDeleteQuery();
        $stmt = self::$instance->prepare($query);
        $stmt->bindValue(1, $id);
        return $stmt->execute();
    }

    public function update(int $id, array $attributes): bool
    {
        $query = MySQLGrammar::buildUpdateQuery(array_keys($attributes));
        $stmt = self::$instance->prepare($query);

        // Bind the values
        $this->bindValues($stmt, array_values($attributes));

        // Bind the ID for the WHERE clause
        $stmt->bindValue(count($attributes) + 1, $id);

        return $stmt->execute();
    }
    public function create(array $data): bool
    {
        $query = MySQLGrammar::buildInsertQuery(array_keys($data));
        $stmt = self::$instance->prepare($query);
        $this->bindValues($stmt, array_values($data));
        return $stmt->execute();
    }

    private function bindValues(\PDOStatement $stmt, array $values): void
    {
        foreach ($values as $i => $value) {
            $stmt->bindValue($i + 1, $value);
        }
    }

}
