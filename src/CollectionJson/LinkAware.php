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
 * Class LinkAware
 * @package CollectionJson
 */
interface LinkAware
{
    /**
     * @param \CollectionJson\Entity\Link|array $link
     * @return mixed
     */
    public function addLink($link);

    /**
     * @param array $set
     * @return mixed
     */
    public function addLinksSet(array $set);

    /**
     * @return array
     */
    public function getLinksSet();

    /**
     * @param string $relation
     * @return \CollectionJson\Entity\Link|null
     */
    public function findLinkByRelation($relation);

    /**
     * @return \CollectionJson\Entity\Link|null
     */
    public function getFirstLink();

    /**
     * @return \CollectionJson\Entity\Link|null
     */
    public function getLastLink();
}
