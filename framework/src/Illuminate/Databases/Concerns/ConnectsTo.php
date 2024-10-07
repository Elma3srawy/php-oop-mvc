<?php 


namespace Illuminate\Databases\Concerns;

use Illuminate\Databases\Drivers\Contract\DatabaseManger;


trait ConnectsTo
{
    public static function connect(DatabaseManger $dataBaseManger): \PDO 
    {
        return $dataBaseManger->connect();
    }
}