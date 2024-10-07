<?php

namespace Illuminate\Validation;

use Illuminate\Validation\Rules\MaxRule;
use Illuminate\Validation\Rules\EmailRule;
use Illuminate\Validation\Rules\RequiredRule;
use Illuminate\Validation\Rules\ConfirmedRule;



trait RulesMapper
{
    protected static array $map = [
        'required' => RequiredRule::class,
        'max' => MaxRule::class,
        'email' => EmailRule::class,
        'confirmed' => ConfirmedRule::class,
    ];

    public static function resolve(string $rule, $options)
    {
        return new static::$map[$rule](...$options);
    }
}
