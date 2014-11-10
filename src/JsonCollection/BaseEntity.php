<?php

namespace JsonCollection;

/**
 * Class BaseEntity
 * @package JsonCollection
 */
class BaseEntity extends DataExtraction implements DataInjectable
{

    use DataInjection;

    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->inject($data);
    }

    /**
     * @return array
     */
    protected function getSortedObjectVars()
    {
        $data = get_object_vars($this);
        ksort($data);
        return $data;
    }

    /**
     * @param array $data
     * @return array
     */
    protected function filterEmptyArrays(array $data)
    {
        return array_filter(
            $data,
            function ($value) {
                return !(is_array($value) && empty($value));
            }
        );
    }

    /**
     * @param array $data
     * @return array
     */
    protected function filterNullValues(array $data)
    {
        return array_filter(
            $data,
            function ($value) {
                return !is_null($value);
            }
        );
    }

    /**
     * @return array
     */
    protected function getObjectData()
    {
        return $this->getSortedObjectVars();
    }
}
