<?php

/*
 * This file is part of JsonCollection, a php implementation
 * of the Collection+JSON Media Type
 *
 * (c) Mickaël Vieira <contact@mickael-vieira.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JsonCollection;

use JsonCollection\Entity\Data;

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
     * @param \JsonCollection\Entity\Data|array $data
     * @return mixed
     */
    public function addData($data)
    {
        if (is_array($data)) {
            $data = new Data($data);
        }
        if ($data instanceof Data) {
            array_push($this->data, $data);
        }
        return $this;
    }

    /**
     * @param array $set
     * @return mixed
     */
    public function addDataSet(array $set)
    {
        foreach ($set as $data) {
            $this->addData($data);
        }
        return $this;
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
     * @return \JsonCollection\Entity\Data|null
     */
    public function getDataByName($name)
    {
        $entity = null;
        foreach ($this->getDataSet() as $data) {
            /** @var \JsonCollection\Entity\Data $data */
            if ($data->getName() === $name) {
                $entity = $data;
                break;
            }
        }
        return $entity;
    }
}
