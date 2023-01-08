<?php
namespace Nopel\Validation;


trait RulesResolver
{
    // use RulesMapper;
    public static function resolveRules(Array|String $rules)
    {

        $rules = (array) (is_string($rules) && str_contains($rules, '|') ? explode('|', $rules) : $rules);

        // if(is_string($rules))
        // {
        //     return Static::getRuleFromString($rules);
        // }

        return array_map(function($rule)
        {
            if(is_string($rule))
            {
                return Static::getRuleFromString($rule);
            }
            return $rule;
        }, $rules);

    }

    public static function getRuleFromString( $rule)
    {
        return RulesMapper::resolve(($exp = explode(':', $rule))[0], explode(',', end($exp)));
    }
}