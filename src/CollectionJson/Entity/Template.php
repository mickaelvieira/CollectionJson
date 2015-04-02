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
use CollectionJson\DataAware;
use CollectionJson\DataContainer;

/**
 * Class Template
 * @package CollectionJson\Entity
 * @link http://amundsen.com/media-types/collection/format/
 * @link http://amundsen.com/media-types/collection/format/#objects-template
 */
class Template extends BaseEntity implements DataAware
{
    /**
     * @see \CollectionJson\DataContainer
     */
    use DataContainer;

    /**
     * {@inheritdoc}
     */
    protected function getObjectData()
    {
        $data = $this->getSortedObjectVars();
        $data = $this->filterEmptyArrays($data);
        $data = $this->filterNullValues($data);

        return $data;
    }
}
