<?php

namespace JsonCollection;

/**
 * Class LinkAware
 * @package JsonCollection
 */
interface LinkAware
{
    /**
     * @param Link $link
     */
    public function addLink(Link $link);

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
