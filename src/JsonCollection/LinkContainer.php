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

use JsonCollection\Entity\Link;

/**
 * Class LinkContainer
 * @package JsonCollection
 */
trait LinkContainer
{
    /**
     * @var array
     * @link http://amundsen.com/media-types/collection/format/#arrays-links
     */
    protected $links = [];

    /**
     * @param \JsonCollection\Entity\Link|array $link
     * @return mixed
     */
    public function addLink($link)
    {
        if (is_array($link)) {
            $link = new Link($link);
        }
        if ($link instanceof Link) {
            array_push($this->links, $link);
        }
        return $this;
    }

    /**
     * @param array $set
     * @return mixed
     */
    public function addLinkSet(array $set)
    {
        foreach ($set as $link) {
            $this->addLink($link);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getLinkSet()
    {
        return $this->links;
    }

    /**
     * @return int
     */
    public function countLinks()
    {
        return count($this->links);
    }
}
