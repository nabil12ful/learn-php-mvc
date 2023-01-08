<?php
namespace Nopel\Validation\Rules\Contract;

interface Rule 
{
    public function apply($field, $value, $data);

    public function __toString();
}