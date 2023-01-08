<?php
namespace Nopel\Validation\Rules;

use Nopel\Validation\Rules\Contract\Rule;

class MaxRule implements Rule
{
    /** 
     * @var int $max
     */
    protected int $max;

    public function __construct(int $max)
    {
        $this->max = $max;
    }
    public function apply($field, $value, $data)
    {
        return !(strlen($value) > $this->max);
    }

    public function __toString()
    {
        return "%s must be less than {$this->max}";
    }
}