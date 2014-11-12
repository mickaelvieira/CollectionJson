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
     * @param \JsonCollection\Data $data
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

    /**
     * @param string $name
     * @return null|\JsonCollection\Data
     */
    public function getDataByName($name)
    {
        $entity = null;
        foreach ($this->getDataSet() as $data) {
            /** @var \JsonCollection\Data $data */
            if ($data->getName() === $name) {
                $entity = $data;
                break;
            }
        }
        return $entity;
    }

    /**
     * @return int
     */
    public function countData()
    {
        return count($this->data);
    }
}
