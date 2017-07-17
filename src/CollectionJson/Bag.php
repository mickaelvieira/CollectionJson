<?php
declare(strict_types=1);

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
     * Bag constructor.
     *
     * @param string $className
     */
    public function __construct(string $className)
    {
        $this->className = $className;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->bag);
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->bag);
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->bag);
    }

    /**
     * @param $item
     *
     * @return Bag
     */
    public function add($item): Bag
    {
        if (is_array($item)) {
            $item = call_user_func($this->className . '::fromArray', $item);
        }

        if (!($item instanceof $this->className)) {
            throw WrongType::fromTemplate($this->getPropertyName(), $this->className);
        }

        $this->bag[] = $item;

        return $this;
    }

    /**
     * @param mixed $itemOrData
     *
     * @return Bag
     */
    public function with($itemOrData): Bag
    {
        $item = is_array($itemOrData)
            ? call_user_func($this->className . '::fromArray', $itemOrData)
            : $itemOrData;

        if (!($item instanceof $this->className)) {
            throw WrongType::fromTemplate($this->getPropertyName(), $this->className);
        }

        $copy = clone $this;

        $copy->bag[] = $item;

        return $copy;
    }

    /**
     * @param mixed $item
     *
     * @return Bag
     */
    public function without($item): Bag
    {
        $key = array_search($item, $this->bag, true);

        if ($key === false) {
            return $this;
        }

        $copy = clone $this;

        unset($copy->bag[$key]);

        return $copy;
    }

    /**
     * @param array $set
     * @return Bag
     */
    public function addSet(array $set): Bag
    {
        foreach ($set as $item) {
            $this->add($item);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getSet(): array
    {
        return $this->bag;
    }

    /**
     * @return mixed|null
     */
    public function getFirst()
    {
        return reset($this->bag) ?: null;
    }

    /**
     * @return mixed|null
     */
    public function getLast()
    {
        return end($this->bag) ?: null;
    }

    /**
     * @return string
     */
    private function getPropertyName(): string
    {
        $tree = explode("\\", $this->className);
        return strtolower(end($tree));
    }

    /**
     * @return void
     */
    public function __clone()
    {
        $clone = function ($item) {
            return clone $item;
        };

        $this->bag = array_map($clone, $this->bag);
    }
}
