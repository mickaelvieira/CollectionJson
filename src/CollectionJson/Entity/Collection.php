<?php

/*
 * This file is part of CollectionJson, a php implementation
 * of the Collection+JSON Media Type
 *
 * (c) Mickaël Vieira <contact@mickael-vieira.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CollectionJson\Entity;

use CollectionJson\BaseEntity;
use CollectionJson\LinkAware;
use CollectionJson\LinkContainer;

/**
 * Class Collection
 * @package CollectionJson\Entity
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
     * @var \CollectionJson\Entity\Error
     * @link http://amundsen.com/media-types/collection/format/#objects-error
     */
    protected $error;

    /**
     * @var \CollectionJson\Entity\Template
     * @link http://amundsen.com/media-types/collection/format/#ojects-template
     */
    protected $template;

    /**
     * @param string $href
     * @return \CollectionJson\Entity\Collection
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
     * @param \CollectionJson\Entity\Item|array $item
     * @return \CollectionJson\Entity\Collection
     */
    public function addItem($item)
    {
        if (is_array($item)) {
            $item = new Item($item);
        }
        if ($item instanceof Item) {
            array_push($this->items, $item);
        }
        return $this;
    }

    /**
     * @param array $items
     * @return \CollectionJson\Entity\Collection
     */
    public function addItemsSet(array $items)
    {
        foreach ($items as $item) {
            $this->addItem($item);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getItemsSet()
    {
        return $this->items;
    }

    /**
     * @param \CollectionJson\Entity\Query|array $query
     * @return \CollectionJson\Entity\Collection
     */
    public function addQuery($query)
    {
        if (is_array($query)) {
            $query = new Query($query);
        }
        if ($query instanceof Query) {
            array_push($this->queries, $query);
        }
        return $this;
    }

    /**
     * @param array $queries
     * @return \CollectionJson\Entity\Collection
     */
    public function addQueriesSet(array $queries)
    {
        foreach ($queries as $query) {
            $this->addQuery($query);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getQueriesSet()
    {
        return $this->queries;
    }

    /**
     * @param \CollectionJson\Entity\Error|array $error
     * @return \CollectionJson\Entity\Collection
     */
    public function setError($error)
    {
        if (is_array($error)) {
            $error = new Error($error);
        }
        if ($error instanceof Error) {
            $this->error = $error;
        }
        return $this;
    }

    /**
     * @return \CollectionJson\Entity\Error|null
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param \CollectionJson\Entity\Template|array $template
     * @return \CollectionJson\Entity\Collection
     */
    public function setTemplate($template)
    {
        if (is_array($template)) {
            $template = new Template($template);
        }
        if ($template instanceof Template) {
            $this->template = $template;
        }
        return $this;
    }

    /**
     * @return \CollectionJson\Entity\Template|null
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
