<?php

namespace JsonCollection;

use JsonSerializable;

/**
 * Class DataExtraction
 * @package JsonCollection
 */
abstract class DataExtraction implements JsonSerializable, ArrayConvertible
{
    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->getObjectData();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = $this->getObjectData();
        $data = $this->recursiveToArray($data);
//        var_dump($data);
        return $data;
    }

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
     * @return array
     */
    abstract protected function getObjectData();
}
