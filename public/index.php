<?php 

use App\Models\User;
use Illuminate\Support\Session\Session;




ob_start();

require_once __DIR__.'/../vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable(base_path());
$dotenv->load();


require_once base_path('routes/web.php');

app()->run();


// $session = new Session;

// $session->put('key' , 'fad');

// var_dump($session->get());
// User::all([]);
// var_dump(User::getTableName());
ob_end_flush();





