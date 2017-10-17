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

use Psr\Link\LinkProviderInterface;
use Psr\Link\EvolvableLinkProviderInterface;

/**
 * Class LinkAware
 * @package CollectionJson
 */
interface LinkAware extends LinkProviderInterface, EvolvableLinkProviderInterface
{
    /**
     * @param array $set
     * @return mixed
     */
    public function withLinksSet(array $set);

    /**
     * @return Entity\Link
     */
    public function getFirstLink(): Entity\Link;

    /**
     * @return Entity\Link
     */
    public function getLastLink(): Entity\Link;
    
    /**
     * @return bool
     */
    public function hasLinks(): bool;
}
