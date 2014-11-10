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
        array_walk(
            $data,
            function (&$value) {
                if (is_object($value) && $value instanceof ArrayConvertible) {
                    $value = $value->toArray();
                }
            }
        );
        return $data;
    }

    /**
     * @return mixed
     */
    abstract protected function getObjectData();
}
