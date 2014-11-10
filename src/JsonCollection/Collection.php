<?php

namespace JsonCollection;

/**
 * Class Collection
 * @package JsonCollection
 * @link http://amundsen.com/media-types/collection/format/
 * @link http://code.ge/media-types/collection-next-json/
 */
class Collection extends BaseEntity
{
    /**
     * @link http://amundsen.com/media-types/collection/format/#properties-version
     */
    const VERSION = "1.0";

    /**
     * @var string
     * @link http://amundsen.com/media-types/collection/format/#properties-href
     */
    protected $href;

    /**
     * @var array
     * @link http://amundsen.com/media-types/collection/format/#arrays-links
     */
    protected $links = [];

    /**
     * @var array
     * @link http://amundsen.com/media-types/collection/format/#arrays-items
     */
    protected $items = [];

    /**
     * @var array
     * @link http://amundsen.com/media-types/collection/format/#arrays-queries
     */
    protected $queries = [];

    /**
     * @var Error
     * @link http://amundsen.com/media-types/collection/format/#objects-error
     */
    protected $error;

    /**
     * @var Status
     * @link http://code.ge/media-types/collection-next-json/#object-status
     */
    protected $status;

    /**
     * @var Template
     * @link http://amundsen.com/media-types/collection/format/#ojects-template
     */
    protected $template;

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
     * @param Link $link
     */
    public function addLink(Link $link)
    {
        array_push($this->links, $link);
    }

    /**
     * @param Item $item
     */
    public function addItem(Item $item)
    {
        array_push($this->items, $item);
    }

    /**
     * @param Query $query
     */
    public function addQuery(Query $query)
    {
        array_push($this->queries, $query);
    }

    /**
     * @param Error $error
     */
    public function setError(Error $error)
    {
        $this->error = $error;
    }

    /**
     * @return Error
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param Status $status
     */
    public function setStatus(Status $status)
    {
        $this->status = $status;
    }

    /**
     * @return Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param Template $template
     */
    public function setTemplate(Template $template)
    {
        $this->template = $template;
    }

    /**
     * @return Template
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * {@inheritdoc}
     */
    protected function getObjectData()
    {
        $data = [
            'version' => self::VERSION
        ];
        $data = array_merge($data, $this->getSortedObjectVars());
        $data = $this->filterEmptyArrays($data);
        $data = $this->filterNullValues($data);

        return [
            'collection' => $data
        ];
    }
}
