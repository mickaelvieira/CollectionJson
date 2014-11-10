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
     * @return array
     */
    protected function getObjectData()
    {
        return $this->getSortedObjectVars();
    }
}
