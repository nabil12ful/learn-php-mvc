<?php

namespace Nopel\Support;

class Config implements \ArrayAccess
{
    public array $items = [];

    public function __construct($items)
    {
        foreach($items as $key => $item)
        {
            $this->items[$key] = $item;
        }
    }

    public function get($key, $default = null)
    {
        if(is_array($key))
        {
            return $this->getMany($key);
        }

        return Arr::get($this->items, $key, $default);
    }

    public function getMany($keys)
    {
        $config = [];

        foreach($keys as $key => $default)
        {
            if(is_numeric($key))
            {
                [$key, $default] = [$default, null];
            }
            $config[$key] = Arr::get($this->items, $key, $default);
        }

        return $config;
    }

    public function set($key, $value = null)
    {
        $keys = is_array($key) ? $key : [$key => $value];
        foreach($keys as $key => $value)
        {
            Arr::set($this->items, $key, $value);
        }
    }

    public function push($key, $value)
    {
        $array = $this->get($key);
        $array[] = $value;
        $this->set($key, $value);
    }

    public function all()
    {
        return $this->items;
    }

    public function exists($key)
    {
        return Arr::exists($this->items, $key);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->get($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->set($offset, $value);
    }

    public function offsetExists(mixed $offset): bool
    {
        return $this->exists($offset);
    }

    public function offsetUnset(mixed $offset): void
    {
        $this->set($offset, null);
    }
}