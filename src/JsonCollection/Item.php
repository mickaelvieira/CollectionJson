<?php

namespace JsonCollection;

/**
 * Class Item
 * @package JsonCollection
 * @link http://amundsen.com/media-types/collection/format/
 * @link http://code.ge/media-types/collection-next-json/
 */
class Item extends BaseEntity implements LinkAware, DataAware
{

    use LinkContainer;

    use DataContainer;

    /**
     * @var string
     * @link http://amundsen.com/media-types/collection/format/#property-href
     */
    protected $href;

    /**
     * @param string $href
     * @return \JsonCollection\Item
     */
    public function setHref($href)
    {
        if (is_string($href)) {
            $this->href = $href;
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * {@inheritdoc}
     */
    protected function getObjectData()
    {
        $data = [];
        if (!is_null($this->href)) {
            $data = $this->getSortedObjectVars();
            $data = $this->filterEmptyArrays($data);
        }
        return $data;
    }
}
