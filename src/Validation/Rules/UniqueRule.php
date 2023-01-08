<?php
namespace Nopel\Validation\Rules;

use Nopel\Validation\Rules\Contract\Rule;

class UniqueRule implements Rule
{
    protected $table;
    protected $column;
    public function __construct($table, $column)
    {
        $this->table = $table;
        $this->column = $column;
    }
    public function apply($field, $value, $data)
    {
        // 
    }

    public function __toString()
    {
        return 'this %s is already taken';
    }
}