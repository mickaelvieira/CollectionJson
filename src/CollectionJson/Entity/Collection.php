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

use CollectionJson\Bag;
use CollectionJson\BaseEntity;
use CollectionJson\Exception\WrongType;
use CollectionJson\LinkAware;
use CollectionJson\LinkContainer;
use CollectionJson\Validator\Uri;
use CollectionJson\Exception\WrongParameter;

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
     * @var \CollectionJson\Bag
     * @link http://amundsen.com/media-types/collection/format/#arrays-items
     */
    protected $items;

    /**
     * @var \CollectionJson\Bag
     * @link http://amundsen.com/media-types/collection/format/#arrays-queries
     */
    protected $queries;

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
     * Collection constructor.
     */
    public function __construct()
    {
        $this->wrapper = self::getObjectType();
        $this->items   = new Bag(Item::class);
        $this->queries = new Bag(Query::class);
        $this->links   = new Bag(Link::class);
    }

    /**
     * @param string $href
     * @return \CollectionJson\Entity\Collection
     * @throws \DomainException
     */
    public function setHref($href)
    {
        if (!Uri::isValid($href)) {
            throw WrongParameter::format(self::getObjectType(), 'href', Uri::allowed());
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
        $this->items->add($item);
        return $this;
    }

    /**
     * @param array $items
     * @return \CollectionJson\Entity\Collection
     */
    public function addItemsSet(array $items)
    {
        $this->items->addSet($items);
        return $this;
    }

    /**
     * @return array
     */
    public function getItemsSet()
    {
        return $this->items->getSet();
    }

    /**
     * @return Item|null
     */
    public function getFirstItem()
    {
        return $this->items->getFirst();
    }

    /**
     * @return Item|null
     */
    public function getLastItem()
    {
        return $this->items->getLast();
    }

    /**
     * @return bool
     */
    public function hasItems()
    {
        return !$this->items->isEmpty();
    }
    
    /**
     * @param \CollectionJson\Entity\Query|array $query
     * @return \CollectionJson\Entity\Collection
     */
    public function addQuery($query)
    {
        $this->queries->add($query);
        return $this;
    }

    /**
     * @param array $queries
     * @return \CollectionJson\Entity\Collection
     */
    public function addQueriesSet(array $queries)
    {
        $this->queries->addSet($queries);
        return $this;
    }

    /**
     * @return array
     */
    public function getQueriesSet()
    {
        return $this->queries->getSet();
    }

    /**
     * @return Query|null
     */
    public function getFirstQuery()
    {
        return $this->queries->getFirst();
    }

    /**
     * @return Query|null
     */
    public function getLastQuery()
    {
        return $this->queries->getLast();
    }

    /**
     * @return bool
     */
    public function hasQueries()
    {
        return !$this->queries->isEmpty();
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
        if (!($error instanceof Error)) {
            throw WrongType::format('error', Error::class);
        }

        $this->error = $error;
        
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
     * @return bool
     */
    public function hasError()
    {
        return ($this->error instanceof Error);
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
        if (!($template instanceof Template)) {
            throw WrongType::format('template', Template::class);
        }

        $this->template = $template;

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
     * @return bool
     */
    public function hasTemplate()
    {
        return ($this->template instanceof Template);
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
            'items'    => $this->items->getSet(),
            'links'    => $this->getLinksSet(),
            'queries'  => $this->queries->getSet(),
            'template' => $this->template,
        ];

        $data = $this->filterEmptyArrays($data);
        $data = $this->filterNullValues($data);

        return $data;
    }
}
