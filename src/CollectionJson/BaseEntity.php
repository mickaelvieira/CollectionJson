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

use JsonSerializable;

/**
 * Class BaseEntity
 * @package CollectionJson
 */
abstract class BaseEntity implements JsonSerializable, ArrayConvertible
{
    /**
     * @var string
     */
    protected $wrapper;

    /**
     * @param array $data
     * @return static
     */
    public static function fromArray(array $data)
    {
        $object = new static();

        foreach ($data as $key => $value) {

            $setter = sprintf("set%s", ucfirst(strtolower($key)));
            $adder  = sprintf("add%sSet", ucfirst(strtolower($key)));

            if (method_exists($object, $setter)) {
                $object->$setter($value);
            } elseif (method_exists($object, $adder)) {
                $object->$adder($value);
            }
        }
        return $object;
    }

    /**
     * @param string $json
     * @return static
     */
    public static function fromJson($json)
    {
        $data = json_decode($json, true);
        $type = static::getObjectType();
        // unwrap the data if it is
        if (array_key_exists($type, $data)) {
            $data = $data[$type];
        }
        return self::fromArray($data);
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $data = $this->getObjectData();
        $data = $this->addWrapper($data);

        return $data;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = $this->getObjectData();
        $data = $this->recursiveToArray($data);
        $data = $this->addWrapper($data);

        return $data;
    }

    /**
     * @return static
     */
    final public function wrap()
    {
        $this->wrapper = static::getObjectType();
        return $this;
    }

    /**
     * @param array $data
     * @return array
     */
    final protected function filterEmptyArrays(array $data)
    {
        return array_filter($data, function ($value) {
            return !(is_array($value) && empty($value));
        });
    }

    /**
     * @param array $data
     * @param array $whiteList
     * @return array
     */
    final protected function filterNullValues(array $data, array $whiteList = [])
    {
        $filtered = [];
        foreach ($data as $key => $value) {
            if (!is_null($value) || in_array($key, $whiteList)) {
                $filtered[$key] = $value;
            }
        }
        return $filtered;
    }

    /**
     * @return string
     */
    final public static function getObjectType()
    {
        $tree = explode("\\", static::class);
        return strtolower(end($tree));
    }

    /**
     * Avoiding having dynamic properties set up
     *
     * @param string $name
     * @param mixed $value
     * @throws \LogicException
     */
    final public function __set($name, $value)
    {
        throw new \LogicException("Dynamic properties are not allowed");
    }

    /**
     * @return array
     */
    abstract protected function getObjectData();

    /**
     * @param array $data
     * @return array
     */
    private function recursiveToArray(array $data)
    {
        foreach ($data as &$value) {
            if (is_object($value) && $value instanceof ArrayConvertible) {
                $value = $value->toArray();
            } elseif (is_array($value)) {
                $value = $this->recursiveToArray($value);
            }
        }
        unset($value);

        return $data;
    }

    /**
     * @param array $data
     * @return array
     */
    private function addWrapper(array $data)
    {
        if (is_string($this->wrapper)) {
            $data = [
                $this->wrapper => $data
            ];
        }
        return $data;
    }
}
