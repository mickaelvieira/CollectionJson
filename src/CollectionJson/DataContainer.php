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

use CollectionJson\Entity\Data;

/**
 * Class DataContainer
 * @package CollectionJson
 */
trait DataContainer
{
    /**
     * @var Bag
     * @link http://amundsen.com/media-types/collection/format/#arrays-data
     */
    protected $data;

    /**
     * @param Data|array $data
     *
     * @return mixed
     */
    public function withData($data)
    {
        $copy = clone $this;
        $copy->data = $this->data->with($data);

        return $copy;
    }

    /**
     * @param Data $data
     *
     * @return mixed
     */
    public function withoutData(Data $data)
    {
        $copy = clone $this;
        $copy->data = $this->data->without($data);

        return $copy;
    }

    /**
     * @param array $set
     *
     * @return mixed
     */
    public function withDataSet(array $set)
    {
        $copy = clone $this;
        $copy->data = $this->data->withSet($set);

        return $copy;
    }

    /**
     * @return Data[]
     */
    public function getDataSet(): array
    {
        return $this->data->getSet();
    }

    /**
     * @param string $name
     *
     * @return Data|null
     */
    public function getDataByName($name)
    {
        $data = array_filter($this->data->getSet(), function (Data $d) use ($name) {
            return ($d->getName() === $name);
        });

        return current($data) ?: null;
    }

    /**
     * @return Data
     */
    public function getFirstData(): Data
    {
        return $this->data->first();
    }

    /**
     * @return Data
     */
    public function getLastData(): Data
    {
        return $this->data->last();
    }

    /**
     * @return bool
     */
    public function hasData(): bool
    {
        return !$this->data->isEmpty();
    }
}
