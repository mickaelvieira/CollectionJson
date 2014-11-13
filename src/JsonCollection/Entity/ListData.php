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

namespace JsonCollection\Entity;

use JsonCollection\BaseEntity;
use JsonCollection\OptionAware;
use JsonCollection\OptionContainer;

/**
 * Class ListData
 * @package JsonCollection
 * @link http://amundsen.com/media-types/collection/format/
 * @link http://code.ge/media-types/collection-next-json/
 */
class ListData extends BaseEntity implements OptionAware
{

    use OptionContainer;

    /**
     * @var bool
     * @link http://code.ge/media-types/collection-next-json/#property-multiple
     */
    protected $multiple;

    /**
     * @var string
     * @link http://code.ge/media-types/collection-next-json/#property-default
     */
    protected $default;

    /**
     * @param boolean $multiple
     * @return \JsonCollection\Entity\ListData
     */
    public function setMultiple($multiple)
    {
        if (is_bool($multiple)) {
            $this->multiple = $multiple;
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function isMultiple()
    {
        return $this->multiple;
    }

    /**
     * @param string $default
     * @return \JsonCollection\Entity\ListData
     */
    public function setDefault($default)
    {
        if (is_string($default)) {
            $this->default = $default;
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * {@inheritdoc}
     */
    protected function getObjectData()
    {
        $data = [];
        if (!empty($this->options)) {
            $data = $this->getSortedObjectVars();
            $data = $this->filterNullValues($data);
        }
        return $data;
    }
}
