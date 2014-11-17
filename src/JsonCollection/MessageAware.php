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

/**
 * Interface MessageAware
 * @package JsonCollection
 */
interface MessageAware
{
    /**
     * @param \JsonCollection\Entity\Message|array $message
     */
    public function addMessage($message);

    /**
     * @param array $set
     */
    public function addMessageSet(array $set);

    /**
     * @return array
     */
    public function getMessageSet();
}
