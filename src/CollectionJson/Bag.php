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

use CollectionJson\Exception\InvalidType;

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
     * @param mixed $itemOrData
     *
     * @return Bag
     *
     * @throws InvalidType
     */
    public function with($itemOrData): Bag
    {
        $item = is_array($itemOrData)
            ? call_user_func($this->className . '::fromArray', $itemOrData)
            : $itemOrData;

        if (!($item instanceof $this->className)) {
            throw InvalidType::fromTemplate($this->getPropertyName(), $this->className);
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
     *
     * @return Bag
     *
     * @throws InvalidType
     */
    public function withSet(array $set): Bag
    {
        return array_reduce($set, function (Bag $bag, $item) {
            return $bag->with($item);
        }, $this);
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
    public function first()
    {
        return reset($this->bag) ?: null;
    }

    /**
     * @return mixed|null
     */
    public function last()
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
