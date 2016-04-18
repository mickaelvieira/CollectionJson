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

use BadMethodCallException;
use CollectionJson\BaseEntity;
use CollectionJson\LinkAware;
use CollectionJson\LinkContainer;
use CollectionJson\Validator\Uri;

/**
 * Class Collection
 * @package CollectionJson\Entity
 * @link http://amundsen.com/media-types/collection/format/
 * @link http://amundsen.com/media-types/collection/format/#objects-collection
 */
class Collection extends BaseEntity implements LinkAware
{
    /**
     * @see \CollectionJson\LinkContainer
     */
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
     * {@inheritdoc}
     */
    protected $wrapper = 'collection';


    /**
     * @param string $href
     * @return \CollectionJson\Entity\Collection
     * @throws \BadMethodCallException
     */
    public function setHref($href)
    {
        if (!Uri::isValid($href)) {
            throw new BadMethodCallException(sprintf("Field href must be a valid URL, %s given", $href));
        }
        $this->href = $href;

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
            $item = Item::fromArray($item);
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
     * @return Item|null
     */
    public function getFirstItem()
    {
        return (!empty($this->items)) ? reset($this->items) : null;
    }

    /**
     * @return Item|null
     */
    public function getLastItem()
    {
        return (end($this->items)) ?: null;
    }

    /**
     * @param \CollectionJson\Entity\Query|array $query
     * @return \CollectionJson\Entity\Collection
     */
    public function addQuery($query)
    {
        if (is_array($query)) {
            $query = Query::fromArray($query);
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
     * @return Query|null
     */
    public function getFirstQuery()
    {
        return (!empty($this->queries)) ? reset($this->queries) : null;
    }

    /**
     * @return Query|null
     */
    public function getLastQuery()
    {
        return (end($this->queries)) ?: null;
    }
    
    /**
     * @param \CollectionJson\Entity\Error|array $error
     * @return \CollectionJson\Entity\Collection
     */
    public function setError($error)
    {
        if (is_array($error)) {
            $error = Error::fromArray($error);
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
            $template = Template::fromArray($template);
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
        $data = [
            'version'  => self::VERSION,
            'error'    => $this->error,
            'href'     => $this->href,
            'items'    => $this->items,
            'links'    => $this->getLinksSet(),
            'queries'  => $this->queries,
            'template' => $this->template,
        ];

        $data = $this->filterEmptyArrays($data);
        $data = $this->filterNullValues($data);

        return $data;
    }
}
