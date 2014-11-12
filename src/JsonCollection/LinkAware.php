<?php

namespace JsonCollection;

/**
 * Class LinkAware
 * @package JsonCollection
 */
interface LinkAware
{
    /**
     * @param Link|array $link
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

    /**
     * @return int
     */
    public function countLinks();
}
