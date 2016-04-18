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

use CollectionJson\Entity\Link;

/**
 * Class LinkContainer
 * @package CollectionJson
 */
trait LinkContainer
{
    /**
     * @var \CollectionJson\Entity\Link[]
     * @link http://amundsen.com/media-types/collection/format/#arrays-links
     */
    protected $links = [];

    /**
     * @param \CollectionJson\Entity\Link|array $link
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
    public function addLinksSet(array $set)
    {
        foreach ($set as $link) {
            $this->addLink($link);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getLinksSet()
    {
        return $this->links;
    }

    /**
     * @param string $relation
     * @return \CollectionJson\Entity\Link|null
     */
    public function findLinkByRelation($relation)
    {
        $links = array_filter($this->links, function (Link $link) use ($relation) {
            return ($link->getRel() === $relation);
        });

        return (current($links)) ?: null;
    }

    /**
     * @return \CollectionJson\Entity\Link|null
     */
    public function getFirstLink()
    {
        return (!empty($this->links)) ? reset($this->links) : null;
    }

    /**
     * @return \CollectionJson\Entity\Link|null
     */
    public function getLastLink()
    {
        return (!empty($this->links)) ? end($this->links) : null;
    }

}
