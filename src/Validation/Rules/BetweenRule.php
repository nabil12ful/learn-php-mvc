<?php
namespace Nopel\Validation\Rules;

use Nopel\Validation\Rules\Contract\Rule;

class BetweenRule implements Rule
{
    protected int $min;
    protected int $max;

    public function __construct(int $min, int $max)
    {
        $this->min = $min;
        $this->max = $max;
    }
    public function apply($field, $value, $data)
    {
        // if(strlen($value) < $this->min && strlen($value) > $this->max)
        // {
        //     return false;
        // }
        return strlen($value) < $this->min || strlen($value) > $this->max ? false : true;
    }

    public function __toString()
    {
        return "%s must be between {$this->min} and {$this->max} charactars";
    }
}