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

namespace CollectionJson\Entity;

use CollectionJson\BaseEntity;
use CollectionJson\LinkAware;
use CollectionJson\DataAware;
use CollectionJson\LinkContainer;
use CollectionJson\DataContainer;

/**
 * Class Item
 * @package CollectionJson\Entity
 * @link http://amundsen.com/media-types/collection/format/
 * @link http://amundsen.com/media-types/collection/format/#arrays-items
 */
class Item extends BaseEntity implements LinkAware, DataAware
{

    /**
     * @see \CollectionJson\LinkContainer
     */
    use LinkContainer;

    /**
     * @see \CollectionJson\DataContainer
     */
    use DataContainer;

    /**
     * @var string
     * @link http://amundsen.com/media-types/collection/format/#property-href
     */
    protected $href;

    /**
     * @param string $href
     * @return \CollectionJson\Entity\Item
     */
    public function setHref($href)
    {
        if (is_string($href) && filter_var($href, FILTER_VALIDATE_URL)) {
            $this->href = $href;
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * {@inheritdoc}
     */
    protected function getObjectData()
    {
        $data = [];
        if (!is_null($this->href)) {
            $data = $this->getSortedObjectVars();
            $data = $this->filterEmptyArrays($data);
        }
        return $data;
    }
}
