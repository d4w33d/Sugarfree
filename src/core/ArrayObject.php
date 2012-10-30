<?php

namespace Core;

use ArrayAccess,
    Countable,
    IteratorAggregate, 
    ArrayIterator,
    Closure;

class ArrayObject implements ArrayAccess, Countable, IteratorAggregate
{

    protected $data;

    public function __construct(array $data = array())
    {
        $this->data = $data;
    }

    public function set($key, $value)
    {
        ArrayUtils::set($this->data, $key, $value);
        return $value;
    }

    public function push($value)
    {
        $this->data[] = $value;
    }

    public function unshift($value)
    {
        array_unshift($this->data, $value);
    }

    public function get($key, $default = null)
    {
        return ArrayUtils::get($this->data, $key, $default);
    }

    public function pop()
    {
        return array_pop($this->data);
    }

    public function shift()
    {
        return array_shift($this->data);
    }

    public function delete($key)
    {
        return ArrayUtils::delete($this->data, $key);
    }

    public function has($key)
    {
        return ArrayUtils::has($this->data, $key);
    }

    public function contains($value)
    {
        return in_array($value, $this->data);
    }

    public function merge(array $data)
    {
        $this->data = array_merge($this->data, $data);
    }

    public function clear()
    {
        $this->data = array();
    }

    public function map($mapper)
    {
        return ArrayUtils::map($this->data, $mapper);
    }

    public function toArray()
    {
        return $this->data;
    }

    public function replaceArray(array $array)
    {
        $this->data = $array;
    }

    public function getset($key, $value)
    {
        if (!$this->has($key))
        {
            if ($value instanceof Closure)
            {
                $value = $value();
            }
            $this->set($key, $value);
            return $value;
        }
        return $this->get($key);
    }

    public function __invoke($key, $default = null)
    {
        return $this->get($key, $default);
    }

    /**
     * IteratorAggregate implementation
     */

    public function getIterator()
    {
        return new ArrayIterator($this->data);
    }

    public function count()
    {
        return count($this->data);
    }

    public function offsetGet($key)
    {
        return $this->get($key);
    }

    public function offsetSet($key, $value)
    {
        if ($key === null)
        {
            $this->data[] = $value;
        }
        else
        {
            $this->set($key, $value);
        }
    }

    public function offsetExists($key)
    {
        return $this->has($key);
    }

    public function offsetUnset($key)
    {
        $this->delete($key);
    }

}
