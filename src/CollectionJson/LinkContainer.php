<?php
declare(strict_types=1);

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
     * @var Bag
     * @link http://amundsen.com/media-types/collection/format/#arrays-links
     */
    protected $links;

    /**
     * @param Link|array $link
     *
     * @return mixed
     */
    public function addLink($link)
    {
        $this->links->add($link);
        return $this;
    }

    /**
     * @param array $set
     *
     * @return mixed
     */
    public function addLinksSet(array $set)
    {
        $this->links->addSet($set);
        return $this;
    }

    /**
     * @return array
     */
    public function getLinksSet(): array
    {
        return $this->links->getSet();
    }

    /**
     * @param string $relation
     *
     * @return Link|null
     */
    public function findLinkByRelation(string $relation)
    {
        $links = array_filter($this->links->getSet(), function (Link $link) use ($relation) {
            return ($link->getRel() === $relation);
        });

        return current($links) ?: null;
    }

    /**
     * @return Link|null
     */
    public function getFirstLink()
    {
        return $this->links->getFirst();
    }

    /**
     * @return Link|null
     */
    public function getLastLink()
    {
        return $this->links->getLast();
    }

    /**
     * @return bool
     */
    public function hasLinks(): bool
    {
        return !$this->links->isEmpty();
    }
}
