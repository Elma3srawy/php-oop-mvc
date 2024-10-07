<?php 

namespace Illuminate\Validation\Rules;

use Illuminate\Http\Request\Request;
use Illuminate\Validation\Rules\Contract\Rule;



class ConfirmedRule implements Rule
{
    public function apply($field , Request $request)
    {
        return $request->all($field) === $request->all($field . '_confirmation');
    }

    public function __toString()
    {
        return '%s does not match %s confirmation';
    }
}