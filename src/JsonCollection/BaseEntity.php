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
 * Class BaseEntity
 * @package JsonCollection
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
     */
    protected function getObjectData()
    {
        return $this->getSortedObjectVars();
    }
}
