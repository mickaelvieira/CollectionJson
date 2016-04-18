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

        $underscoreToCamelCase = function ($key) {
            return implode("", array_map("ucfirst", preg_split("/_/", strtolower($key))));
        };

        foreach ($data as $key => $value) {

            $setter = sprintf("set%s", $underscoreToCamelCase($key));
            $adder  = sprintf("add%sSet", ucfirst($key));

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
     * @return \CollectionJson\Entity\Collection
     */
    public static function fromJson($json)
    {
        $data = json_decode($json, true);
        if (array_key_exists('collection', $data)) {
            $data = $data['collection'];
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
     * @param string $wrapper
     */
    final public function wrap($wrapper)
    {
        $this->wrapper = $wrapper;
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
     * @return array
     */
    final protected function filterNullValues(array $data)
    {
        return array_filter($data, function ($value) {
            return !is_null($value);
        });
    }

    /**
     * @return string
     */
    final public function getObjectType()
    {
        $tree = explode("\\", get_class($this));
        return strtolower(end($tree));
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
        array_walk(
            $data,
            function (&$value) {
                if (is_object($value) && $value instanceof ArrayConvertible) {
                    $value = $value->toArray();
                } elseif (is_array($value)) {
                    $value = $this->recursiveToArray($value);
                }
            }
        );

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
