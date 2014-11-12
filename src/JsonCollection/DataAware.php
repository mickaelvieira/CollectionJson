<?php

namespace JsonCollection;

/**
 * Interface DataAware
 * @package JsonCollection
 */
interface DataAware
{
    /**
     * @param \JsonCollection\Data|array $data
     */
    public function addData($data);

    /**
     * @param array $set
     */
    public function addDataSet(array $set);

    /**
     * @return array
     */
    public function getDataSet();

    /**
     * @return int
     */
    public function countData();
}
