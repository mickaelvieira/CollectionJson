<?php

/*
 * This file is part of CollectionJson, a php implementation
 * of the Collection+JSON Media Type
 *
 * (c) Mickaël Vieira <contact@mickael-vieira.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CollectionJson;

/**
 * Interface DataAware
 * @package CollectionJson
 */
interface DataAware
{
    /**
     * @param \CollectionJson\Entity\Data|array $data
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
}
