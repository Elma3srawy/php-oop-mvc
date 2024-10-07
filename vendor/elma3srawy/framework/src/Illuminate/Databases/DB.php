<?php

namespace Illuminate\Databases;

use Illuminate\Databases\Concerns\ConnectsTo;
use Illuminate\Databases\Drivers\Contract\DatabaseManger;

class DB
{
    protected DatabaseManger $manager;

    public function __construct(DatabaseManger $manager)
    {
        $this->manager = $manager;
    }

    public function init():\PDO
    {
        return ConnectsTo::connect($this->manager);
    }

    public function raw(string $query, array $values = []): array
    {
        return $this->manager->query($query, $values);
    }

    public function create(array $data): bool
    {
        return $this->manager->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->manager->update($id, $data);
    }

    public function delete(?int $id = null): bool
    {
        return $this->manager->delete($id);
    }
    public function all(): array
    {
        return $this->manager->read();
    }
    public function get(array $columns): array
    {
        return $this->manager->read($columns);
    }

}