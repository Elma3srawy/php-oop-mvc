<?php 

use Illuminate\Support\Collections\Collection;



if(!function_exists('collect'))
{
    function collect($items): Collection
    {
        return new Collection($items);
    }
}