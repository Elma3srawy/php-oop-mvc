<?php 
namespace App\Models;

use Illuminate\Support\Str\Str;


abstract class Model
{

    protected static $class;
    protected static $table;

    public static function raw(string $query, array $values = []): array
    {
        self::$class = static::class;
        return app()->db->query($query, $values);
    }

    public static function create(array $data): bool
    {
        self::$class = static::class;
        return app()->db->create($data);
    }

    public static function update(int $id, array $data): bool
    {
        self::$class = static::class;
        return app()->db->update($id, $data);
    }

    public static function delete(?int $id = null): bool
    {
        self::$class = static::class;
        return app()->db->delete($id);
    }

    public static function all(): array
    {
        self::$class = static::class;
        return app()->db->all();
    }

    public static function get(array $columns): array
    {
        self::$class = static::class;
        return app()->db->get($columns);
    }

    public static function getModel()
    {
       return self::$class;
    }
    
    public static function getTableName()
    {
        return Str::lower(Str::plural(class_baseName(self::$class)));
    }
}