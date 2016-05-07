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

use CollectionJson\Exception\WrongType;

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
     * @var \ReflectionMethod
     */
    private $fromArray;

    /**
     * Bag constructor.
     * @param $className
     */
    public function __construct($className)
    {
        $this->className = $className;
        $this->fromArray = new \ReflectionMethod($this->className, 'fromArray');
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
     * @return \ArrayIterator
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
        if (is_array($item)) {
            $item = $this->fromArray->invoke(null, $item);
        }
        if (!($item instanceof $this->className)) {
            throw WrongType::fromTemplate($this->getPropertyName(), $this->className);
        }

        array_push($this->bag, $item);

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

    /**
     * @return string
     */
    private function getPropertyName()
    {
        $tree = explode("\\", $this->className);
        return strtolower(end($tree));
    }
}
