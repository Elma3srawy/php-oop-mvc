<?php 

namespace Illuminate\Support\Config;

use Illuminate\Support\Array\Arr;



class Config implements \ArrayAccess
{
    protected array $items = [];

    public function __construct($items)
    {
        foreach($items as $key => $value)
        {
            $this->items[$key] = $value;
        }
    }

    function offsetExists(mixed $offset): bool
    {
        return $this->exists($offset);
    }
    function offsetGet(mixed $offset): mixed
    {
        return $this->get($offset);
    }
    function offsetSet(mixed $offset, mixed $value): void
    {
        $this->set($offset , $value);
    }
    function offsetUnset(mixed $offset): void
    {
        $this->unset($offset);
    }

    public function exists($offset): bool
    {
        return Arr::has($this->items , $offset);
    }
    public function get($offset , $default = null): mixed
    {
        if(is_array($offset))
        {
            return Arr::getMany($this->items , $offset , $default);
        }

        return Arr::get($this->items , $offset , $default);
    }

    public function set($offset , $value = null): void
    {
        $keys = is_array($offset) ? $offset : [$offset => $value];
        foreach ($keys as $key => $value)
        {
            Arr::set($this->items , $key , $value);
        }
    }
    public function unset($offset)
    {
        unset($this->items[$offset]);
    }

    public function push($key , $value)
    {
        $array = $this->get($key , $value);
        $array[] = $value;
        $this->set($key , $value);
    }

    public function all()
    {
        return $this->items;
    }

}
