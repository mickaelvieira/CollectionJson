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

/**
 * Class LinkAware
 * @package JsonCollection
 */
interface LinkAware
{
    /**
     * @param \JsonCollection\Entity\Link|array $link
     */
    public function addLink($link);

    /**
     * @param array $set
     * @return mixed
     */
    public function addLinkSet(array $set);

    /**
     * @return array
     */
    public function getLinkSet();
}
