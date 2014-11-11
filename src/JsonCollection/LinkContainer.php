<?php

namespace JsonCollection;

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
     * @param Link $link
     */
    public function addLink(Link $link)
    {
        array_push($this->links, $link);
    }

    /**
     * @param array $set
     * @return mixed
     */
    public function addLinkSet(array $set)
    {
        foreach ($set as $link) {
            if ($link instanceof Link) {
                $this->addLink($link);
            }
        }
    }

    /**
     * @return array
     */
    public function getLinkSet()
    {
        return $this->links;
    }
}
