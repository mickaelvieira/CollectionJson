<?php

/*
 * This file is part of JsonCollection, a php implementation
 * of the Collection+JSON Media Type
 *
 * (c) Mickaël Vieira <contact@mickael-vieira.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JsonCollection\Entity;

use JsonCollection\BaseEntity;
use JsonCollection\LinkAware;
use JsonCollection\LinkContainer;

/**
 * Class Collection
 * @package JsonCollection\Entity
 * @link http://amundsen.com/media-types/collection/format/
 * @link http://amundsen.com/media-types/collection/format/#objects-collection
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
     * @var \JsonCollection\Entity\Error
     * @link http://amundsen.com/media-types/collection/format/#objects-error
     */
    protected $error;

    /**
     * @var \JsonCollection\Entity\Template
     * @link http://amundsen.com/media-types/collection/format/#ojects-template
     */
    protected $template;

    /**
     * @param string $href
     * @return \JsonCollection\Entity\Collection
     */
    public function setHref($href)
    {
        if (is_string($href) && filter_var($href, FILTER_VALIDATE_URL)) {
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
     * @param \JsonCollection\Entity\Item $item
     * @return \JsonCollection\Entity\Collection
     */
    public function addItem(Item $item)
    {
        array_push($this->items, $item);
        return $this;
    }

    /**
     * @param array $items
     * @return \JsonCollection\Entity\Collection
     */
    public function addItems(array $items)
    {
        foreach ($items as $item) {
            $this->addItem($item);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param \JsonCollection\Entity\Query $query
     * @return \JsonCollection\Entity\Collection
     */
    public function addQuery(Query $query)
    {
        array_push($this->queries, $query);
        return $this;
    }

    /**
     * @param array $queries
     * @return \JsonCollection\Entity\Collection
     */
    public function addQueries(array $queries)
    {
        foreach ($queries as $query) {
            $this->addQuery($query);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getQueries()
    {
        return $this->queries;
    }

    /**
     * @param \JsonCollection\Entity\Error $error
     * @return \JsonCollection\Entity\Collection
     */
    public function setError(Error $error)
    {
        $this->error = $error;
        return $this;
    }

    /**
     * @return \JsonCollection\Entity\Error|null
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param \JsonCollection\Entity\Template $template
     * @return \JsonCollection\Entity\Collection
     */
    public function setTemplate(Template $template)
    {
        $this->template = $template;
        return $this;
    }

    /**
     * @return \JsonCollection\Entity\Template|null
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
