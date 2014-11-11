<?php

namespace JsonCollection;

/**
 * Class DataContainer
 * @package JsonCollection
 */
trait DataContainer
{
    /**
     * @var array
     * @link http://amundsen.com/media-types/collection/format/#arrays-data
     */
    protected $data = [];

    /**
     * @param Data $data
     */
    public function addData(Data $data)
    {
        array_push($this->data, $data);
    }

    /**
     * @param array $set
     */
    public function addDataSet(array $set)
    {
        foreach ($set as $data) {
            if ($data instanceof Data) {
                $this->addData($data);
            }
        }
    }

    /**
     * @return array
     */
    public function getDataSet()
    {
        return $this->data;
    }
}
