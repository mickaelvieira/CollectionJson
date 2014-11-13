<?php

/*
 * This file is part of JsonCollection, a php implementation
 * of the Collection.next+JSON Media Type
 *
 * (c) Mickaël Vieira <contact@mickael-vieira.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JsonCollection;

/**
 * Interface DataAware
 * @package JsonCollection
 */
interface DataAware
{
    /**
     * @param \JsonCollection\Entity\Data|array $data
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
