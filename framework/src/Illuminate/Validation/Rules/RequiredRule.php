<?php 
namespace Illuminate\Validation\Rules;

use Illuminate\Http\Request\Request;
use Illuminate\Validation\Rules\Contract\Rule;



class RequiredRule implements Rule
{

    public function apply($field, Request $request)
    {
       return empty($request->all($field))? false : true;
    }

    public function __toString()
    {
        return '%s must be require';
    }
}