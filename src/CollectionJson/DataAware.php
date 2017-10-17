<?php
declare(strict_types = 1);

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
     * @param Entity\Data|array $data
     *
     * @return mixed
     */
    public function withData($data);

    /**
     * @param array $set
     *
     * @return mixed
     */
    public function withDataSet(array $set);

    /**
     * @return Entity\Data[]
     */
    public function getDataSet(): array;

    /**
     * @param string $name
     *
     * @return Entity\Data|null
     */
    public function getDataByName($name);

    /**
     * @return Entity\Data
     */
    public function getFirstData(): Entity\Data;

    /**
     * @return Entity\Data
     */
    public function getLastData(): Entity\Data;

    /**
     * @return bool
     */
    public function hasData(): bool;
}
