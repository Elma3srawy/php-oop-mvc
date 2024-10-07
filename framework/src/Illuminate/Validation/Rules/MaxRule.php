<?php 
namespace Illuminate\Validation\Rules;

use Illuminate\Http\Request\Request;
use Illuminate\Validation\Rules\Contract\Rule;



class MaxRule implements Rule
{

    public function __construct(private int $max)
    {

    }
    public function apply($field , Request $request)
    {
        if(strlen($request->all($field)) >= $this->max)
        {
            return false;
        }
        return true;
    }
    public function __toString()
    {
        return '%s must be less than ' . $this->max;
    }
}