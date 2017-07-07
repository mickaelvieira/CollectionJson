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

/**
 * Class LinkAware
 * @package CollectionJson
 */
interface LinkAware
{
    /**
     * @param Entity\Link|array $link
     *
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
    public function getLinksSet(): array;

    /**
     * @param string $relation
     *
     * @return Entity\Link|null
     */
    public function findLinkByRelation(string $relation);

    /**
     * @return Entity\Link|null
     */
    public function getFirstLink();

    /**
     * @return Entity\Link|null
     */
    public function getLastLink();
    
    /**
     * @return bool
     */
    public function hasLinks(): bool;
}
