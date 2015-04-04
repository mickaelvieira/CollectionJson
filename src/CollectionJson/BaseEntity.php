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
 * Class BaseEntity
 * @package CollectionJson
 */
class BaseEntity extends Extraction implements ArrayInjectable
{

    use Injection;

    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->inject($data);
    }

    /**
     * @return string
     */
    public function getObjectType()
    {
        return strtolower(end(explode("\\", get_class($this))));
    }

    /**
     * @return array
     */
    protected function getSortedObjectVars()
    {
        $data = get_object_vars($this);
        ksort($data);
        return $data;
    }

    /**
     * @param array $data
     * @return array
     */
    protected function filterEmptyArrays(array $data)
    {
        return array_filter(
            $data,
            function ($value) {
                return !(is_array($value) && empty($value));
            }
        );
    }

    /**
     * @param array $data
     * @return array
     */
    protected function filterNullValues(array $data)
    {
        return array_filter(
            $data,
            function ($value) {
                return !is_null($value);
            }
        );
    }

    /**
     * @return array
     * @throws \BadMethodCallException
     */
    protected function getObjectData()
    {
        return $this->getSortedObjectVars();
    }
}
