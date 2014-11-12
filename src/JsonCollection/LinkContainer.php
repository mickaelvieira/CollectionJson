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
     * @param \JsonCollection\Link|array $link
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
