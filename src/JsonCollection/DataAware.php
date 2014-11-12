<?php

namespace JsonCollection;

/**
 * Interface DataAware
 * @package JsonCollection
 */
interface DataAware
{
    /**
     * @param Data $data
     */
    public function addData(Data $data);

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
