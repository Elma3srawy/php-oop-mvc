<?php 

namespace Illuminate\Validation\Rules\Contract;

use Illuminate\Http\Request\Request;



interface Rule
{
    public function apply($field, Request $request);
    public function __toString();
}