<?php

namespace JsonCollection;

/**
 * Class Item
 * @package JsonCollection
 * @link http://amundsen.com/media-types/collection/format/
 * @link http://code.ge/media-types/collection-next-json/
 */
class Item extends BaseEntity
{
    /**
     * @var string
     * @link http://amundsen.com/media-types/collection/format/#property-href
     */
    protected $href;

    /**
     * @var array
     * @link http://amundsen.com/media-types/collection/format/#arrays-data
     */
    protected $data = [];

    /**
     * @var array
     * @link http://amundsen.com/media-types/collection/format/#arrays-links
     */
    protected $links = [];

    /**
     * @param string $href
     */
    public function setHref($href)
    {
        if (is_string($href)) {
            $this->href = $href;
        }
    }

    /**
     * @return string
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * @param Data $data
     */
    public function addData(Data $data)
    {
        array_push($this->data, $data);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param Link $link
     */
    public function addLink(Link $link)
    {
        array_push($this->links, $link);
    }

    /**
     * {@inheritdoc}
     */
    protected function getObjectData()
    {
        $data = array();
        if (!is_null($this->href)) {
            $data = array_filter(
                $this->getSortedObjectVars(),
                function ($value) {
                    if (is_array($value)) {
                        return !empty($value);
                    }
                    return $value;
                }
            );
        }
        return $data;
    }
}
