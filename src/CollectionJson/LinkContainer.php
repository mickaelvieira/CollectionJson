<?php
declare(strict_types = 1);

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
use Psr\Link\LinkInterface;

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
     * {@inheritdoc}
     */
    public function withLink(LinkInterface $link)
    {
        $copy = clone $this;
        $copy->links = $this->links->with($link);

        return $copy;
    }

    /**
     * {@inheritdoc}
     */
    public function withoutLink(LinkInterface $link)
    {
        $copy = clone $this;
        $copy->links = $this->links->without($link);

        return $copy;
    }

    /**
     * @param array $set
     *
     * @return mixed
     */
    public function withLinksSet(array $set)
    {
        $copy = clone $this;
        $copy->links = $this->links->withSet($set);

        return $copy;
    }

    /**
     * {@inheritdoc}
     */
    public function getLinks(): array
    {
        return $this->links->getSet();
    }

    /**
     * {@inheritdoc}
     */
    public function getLinksByRel($rel): array
    {
        return array_values(array_filter($this->links->getSet(), function (Link $link) use ($rel) {
            return $link->hasRel($rel);
        }));
    }

    /**
     * @return Entity\Link
     */
    public function getFirstLink(): Entity\Link
    {
        return $this->links->first();
    }

    /**
     * @return Entity\Link
     */
    public function getLastLink(): Entity\Link
    {
        return $this->links->last();
    }

    /**
     * @return bool
     */
    public function hasLinks(): bool
    {
        return !$this->links->isEmpty();
    }
}
