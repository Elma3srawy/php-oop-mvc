<?php 

namespace Illuminate\Databases\Drivers\Contract;



interface DatabaseManger
{
    public function connect(): \PDO;

    public function query(string $query, array $values = []): array;

    public function create(array $data): bool;

    public function read($columns = '*', array $filter = null): array;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;
}