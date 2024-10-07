<?php 

namespace Illuminate\Support\Collections;

use ArrayIterator;


class Collection implements \IteratorAggregate , \ArrayAccess
{

    protected  $items;

    public function __construct($items = [])
    {
        !is_array($items)?: $this->items = $items; 
    }


    public function all()
    {
        return $this->items;
    }
    public function add($item)
    {
        $this->items[] = $item;

        return $this;
    }
    public function merge($items)
    {
        return new static( array_merge($this->items  ,!is_array($items) ?: $items));
    }

    public function put($key , $value)
    {
        $this->items[$key] = $value;
        return $this;
    }
    public function except($key)
    {
        $this->offsetUnset($key);
        return new static($this->items);
    }
    public function forget($keys)
    {
        if(!is_null($keys) && is_array($keys))
        {
            foreach($keys as $key)
            {
               $this->offsetUnset($key);
            }
            return $this;
        }
    }
    public function filter(callable $callback = null)
    {
        if($callback){
            return new static(array_filter($this->items , $callback));
        }
        return new static(array_filter($this->items));
    }
    public function flip()
    {
        return new static(array_flip($this->items));
    }
    public function count()
    {
        return count($this->items);
    }

    public function map(callable $callback): static
    {
        return new static(array_map( $callback ,$this->items ));
    }

    public function keys($keys)
    {
        $result = [];
        foreach($keys as $key)
        {
            if ($this->offsetExists($key))
            {
                $result[$key] = $this->items[$key];
            }
        }
        
    }
    function getIterator(): \Traversable
    {
        return new ArrayIterator($this->items);
    }
    function offsetExists(mixed $offset): bool
    {
        return isset($this->items[$offset]);
    }
    function offsetGet(mixed $offset): mixed
    {
        return $this->items[$offset];
    }
    function offsetSet(mixed $offset, mixed $value): void
    {
        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }
    function offsetUnset(mixed $offset): void
    {
        unset($this->items[$offset]);
    }

}