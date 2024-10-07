<?php 

use Illuminate\Views\View;



if (!function_exists("view")) {
    function view($view  , array $param = null)
    {
        return new View($view , $param);
    }
}
