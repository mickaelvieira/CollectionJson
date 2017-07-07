<?php
declare(strict_types=1);

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
    public function addData($data)
    {
        $this->data->add($data);
        return $this;
    }

    /**
     * @param array $set
     * @return mixed
     */
    public function addDataSet(array $set)
    {
        $this->data->addSet($set);
        return $this;
    }

    /**
     * @return array
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
    public function findDataByName($name)
    {
        $data = array_filter($this->data->getSet(), function (Data $d) use ($name) {
            return ($d->getName() === $name);
        });

        return current($data) ?: null;
    }

    /**
     * @return Data|null
     */
    public function getFirstData()
    {
        return $this->data->getFirst();
    }

    /**
     * @return Data|null
     */
    public function getLastData()
    {
        return $this->data->getLast();
    }

    /**
     * @return bool
     */
    public function hasData(): bool
    {
        return !$this->data->isEmpty();
    }
}
