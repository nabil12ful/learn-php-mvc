<?php
namespace Nopel\Validation;

use Nopel\Validation\Rules\RequiredRule;
use Nopel\Validation\Rules\AlphaNumericalRule;
use Nopel\Validation\Rules\MaxRule;
use Nopel\Validation\Rules\BetweenRule;
use Nopel\Validation\Rules\ConfirmedRule;
use Nopel\Validation\Rules\EmailRule;

class RulesMapper 
{
    protected static array $map = [
        'required' => RequiredRule::class,
        'alnum' => AlphaNumericalRule::class,
        'max' => MaxRule::class,
        'between' => BetweenRule::class,
        'email' => EmailRule::class,
        'confirmed' => ConfirmedRule::class,
    ];

    public static function resolve(string $rule, $options)
    {
        return new Static::$map[$rule](...$options);
    }
}