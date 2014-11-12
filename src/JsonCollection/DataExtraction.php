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
     * @var string
     */
    private $envelope;

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $data = $this->getObjectData();
        $data = $this->addEnvelope($data);
        return $data;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = $this->getObjectData();
        $data = $this->recursiveToArray($data);
        $data = $this->addEnvelope($data);
//        var_dump($data);
        return $data;
    }

    /**
     * @param string $envelope
     */
    public function setEnvelope($envelope)
    {
        $this->envelope = $envelope;
    }

    /**
     * @param array $data
     * @return array
     */
    private function addEnvelope(array $data)
    {
        if (is_string($this->envelope)) {
            $data = [
                $this->envelope => $data
            ];
        }
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
