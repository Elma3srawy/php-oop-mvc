<?php 

namespace Illuminate\Validation\Rules;

use Illuminate\Http\Request\Request;
use Illuminate\Validation\Rules\Contract\Rule;



class EmailRule implements Rule
{

    public function apply($field , Request $request)
    {
       return preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $request->all($field));
    }
    public function __toString()
    {
        return 'your address is not a valid email address';
    }
}