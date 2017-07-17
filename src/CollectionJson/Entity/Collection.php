<?php
declare(strict_types=1);

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
use CollectionJson\LinkAware;
use CollectionJson\LinkContainer;
use CollectionJson\Validator\Uri;
use CollectionJson\Exception\InvalidType;
use CollectionJson\Exception\InvalidParameter;

/**
 * Class Collection
 * @package CollectionJson\Entity
 * @link http://amundsen.com/media-types/collection/format/
 * @link http://amundsen.com/media-types/collection/format/#objects-collection
 */
class Collection extends BaseEntity implements LinkAware
{
    /**
     * @see LinkContainer
     */
    use LinkContainer;

    /**
     * @link http://amundsen.com/media-types/collection/format/#properties-version
     */
    const VERSION = '1.0';

    /**
     * @var string
     * @link http://amundsen.com/media-types/collection/format/#properties-href
     */
    protected $href;

    /**
     * @var Bag
     * @link http://amundsen.com/media-types/collection/format/#arrays-items
     */
    protected $items;

    /**
     * @var Bag
     * @link http://amundsen.com/media-types/collection/format/#arrays-queries
     */
    protected $queries;

    /**
     * @var Error
     * @link http://amundsen.com/media-types/collection/format/#objects-error
     */
    protected $error;

    /**
     * @var Template
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
     *
     * @return Collection
     *
     * @throws \DomainException
     */
    public function setHref($href): Collection
    {
        if (!Uri::isValid($href)) {
            throw InvalidParameter::fromTemplate(self::getObjectType(), 'href', Uri::allowed());
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
     * @param $item
     *
     * @return Collection
     */
    public function addItem($item): Collection
    {
        $this->items->add($item);
        return $this;
    }

    /**
     * @param array $items
     *
     * @return Collection
     */
    public function addItemsSet(array $items): Collection
    {
        $this->items->addSet($items);
        return $this;
    }

    /**
     * @return array
     */
    public function getItemsSet(): array
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
    public function hasItems(): bool
    {
        return !$this->items->isEmpty();
    }
    
    /**
     * @param Query|array $query
     *
     * @return Collection
     */
    public function addQuery($query): Collection
    {
        $this->queries->add($query);
        return $this;
    }

    /**
     * @param array $queries
     *
     * @return Collection
     */
    public function addQueriesSet(array $queries): Collection
    {
        $this->queries->addSet($queries);
        return $this;
    }

    /**
     * @return array
     */
    public function getQueriesSet(): array
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
    public function hasQueries(): bool
    {
        return !$this->queries->isEmpty();
    }
    
    /**
     * @param Error|array $error
     *
     * @return Collection
     *
     * @throws InvalidType
     */
    public function setError($error): Collection
    {
        if (is_array($error)) {
            /** @noinspection CallableParameterUseCaseInTypeContextInspection */
            $error = Error::fromArray($error);
        }
        if (!($error instanceof Error)) {
            throw InvalidType::fromTemplate('error', Error::class);
        }

        $this->error = $error;
        
        return $this;
    }

    /**
     * @return Error|null
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return bool
     */
    public function hasError(): bool
    {
        return ($this->error instanceof Error);
    }

    /**
     * @param Template|array $template
     *
     * @return Collection
     *
     * @throws InvalidType
     */
    public function setTemplate($template): Collection
    {
        if (is_array($template)) {
            /** @noinspection CallableParameterUseCaseInTypeContextInspection */
            $template = Template::fromArray($template);
        }

        if (!($template instanceof Template)) {
            throw InvalidType::fromTemplate('template', Template::class);
        }

        $this->template = $template;

        return $this;
    }

    /**
     * @return Template|null
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @return bool
     */
    public function hasTemplate(): bool
    {
        return ($this->template instanceof Template);
    }

    /**
     * {@inheritdoc}
     */
    protected function getObjectData(): array
    {
        $data = [
            'version'  => self::VERSION,
            'error'    => $this->error,
            'href'     => $this->href,
            'items'    => $this->items->getSet(),
            'links'    => $this->getLinks(),
            'queries'  => $this->queries->getSet(),
            'template' => $this->template,
        ];

        $data = $this->filterEmptyArrays($data);
        $data = $this->filterNullValues($data);

        return $data;
    }

    /**
     * @return void
     */
    public function __clone()
    {
        if ($this->error instanceof Error) {
            $this->error = clone $this->error;
        }

        if ($this->template instanceof Template) {
            $this->template = clone $this->template;
        }

        $this->items = clone $this->items;
        $this->links = clone $this->links;
        $this->queries = clone $this->queries;
    }
}
