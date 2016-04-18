<?php

/*
 * This file is part of CollectionJson, a php implementation
 * of the Collection+JSON Media Type
 *
 * (c) Mickaël Vieira <contact@mickael-vieira.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CollectionJson;

/**
 * Class Bag
 * @package CollectionJson
 */
final class Bag implements \Countable, \IteratorAggregate
{
    /**
     * @var string
     */
    private $className;

    /**
     * @var array
     */
    private $bag = [];

    /**
     * Bag constructor.
     * @param $className
     */
    public function __construct($className)
    {
        $this->className = $className;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->bag);
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->bag);
    }

    /**
     * @return \ArrayIterator]
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->bag);
    }

    /**
     * @param $item
     * @return Bag
     */
    public function add($item)
    {
        $method = new \ReflectionMethod($this->className, 'fromArray');
        if (is_array($item)) {
            $item = $method->invoke(null, $item);
        }
        if ($item instanceof $this->className) {
            array_push($this->bag, $item);
        }
        return $this;
    }

    /**
     * @param array $set
     * @return Bag
     */
    public function addSet(array $set)
    {
        foreach ($set as $item) {
            $this->add($item);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getSet()
    {
        return $this->bag;
    }

    /**
     * @return mixed|null
     */
    public function getFirst()
    {
        return (reset($this->bag)) ?: null;
    }

    /**
     * @return mixed|null
     */
    public function getLast()
    {
        return (end($this->bag)) ?: null;
    }
}
