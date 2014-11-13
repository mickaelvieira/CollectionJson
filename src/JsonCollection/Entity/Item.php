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
use JsonCollection\LinkAware;
use JsonCollection\DataAware;
use JsonCollection\LinkContainer;
use JsonCollection\DataContainer;

/**
 * Class Item
 * @package JsonCollection\Entity
 * @link http://amundsen.com/media-types/collection/format/
 * @link http://code.ge/media-types/collection-next-json/
 * @link http://amundsen.com/media-types/collection/format/#arrays-items
 */
class Item extends BaseEntity implements LinkAware, DataAware
{

    use LinkContainer;

    use DataContainer;

    /**
     * @var string
     * @link http://amundsen.com/media-types/collection/format/#property-href
     */
    protected $href;

    /**
     * @param string $href
     * @return \JsonCollection\Entity\Item
     */
    public function setHref($href)
    {
        if (is_string($href)) {
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
