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
 * Class Collection
 * @package JsonCollection
 * @link http://amundsen.com/media-types/collection/format/
 * @link http://code.ge/media-types/collection-next-json/
 */
class Collection extends BaseEntity implements LinkAware
{

    use LinkContainer;

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
     * @link http://amundsen.com/media-types/collection/format/#arrays-items
     */
    protected $items = [];

    /**
     * @var array
     * @link http://amundsen.com/media-types/collection/format/#arrays-queries
     */
    protected $queries = [];

    /**
     * @var \JsonCollection\Error
     * @link http://amundsen.com/media-types/collection/format/#objects-error
     */
    protected $error;

    /**
     * @var \JsonCollection\Status
     * @link http://code.ge/media-types/collection-next-json/#object-status
     */
    protected $status;

    /**
     * @var \JsonCollection\Template
     * @link http://amundsen.com/media-types/collection/format/#ojects-template
     */
    protected $template;

    /**
     * @param string $href
     * @return \JsonCollection\Collection
     */
    public function setHref($href)
    {
        if (is_string($href)) {
            $this->href = $href;
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * @param \JsonCollection\Item $item
     * @return \JsonCollection\Collection
     */
    public function addItem(Item $item)
    {
        array_push($this->items, $item);
        return $this;
    }

    /**
     * @param \JsonCollection\Query $query
     * @return \JsonCollection\Collection
     */
    public function addQuery(Query $query)
    {
        array_push($this->queries, $query);
        return $this;
    }

    /**
     * @param \JsonCollection\Error $error
     * @return \JsonCollection\Collection
     */
    public function setError(Error $error)
    {
        $this->error = $error;
        return $this;
    }

    /**
     * @return \JsonCollection\Error|null
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param \JsonCollection\Status $status
     * @return \JsonCollection\Collection
     */
    public function setStatus(Status $status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return \JsonCollection\Status|null
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param \JsonCollection\Template $template
     * @return \JsonCollection\Collection
     */
    public function setTemplate(Template $template)
    {
        $this->template = $template;
        return $this;
    }

    /**
     * @return \JsonCollection\Template|null
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
        $this->setEnvelope('collection');

        $data = [
            'version' => self::VERSION
        ];
        $data = array_merge($data, $this->getSortedObjectVars());
        $data = $this->filterEmptyArrays($data);
        $data = $this->filterNullValues($data);

        return $data;
    }
}
