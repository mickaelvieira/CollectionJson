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
use CollectionJson\DataAware;
use CollectionJson\LinkContainer;
use CollectionJson\DataContainer;
use CollectionJson\Validator\Uri;
use CollectionJson\Exception\InvalidParameter;
use CollectionJson\Exception\MissingProperty;

/**
 * Class Item
 * @package CollectionJson\Entity
 * @link http://amundsen.com/media-types/collection/format/
 * @link http://amundsen.com/media-types/collection/format/#arrays-items
 */
class Item extends BaseEntity implements LinkAware, DataAware
{
    /**
     * @see LinkContainer
     */
    use LinkContainer;

    /**
     * @see DataContainer
     */
    use DataContainer;

    /**
     * @var string
     * @link http://amundsen.com/media-types/collection/format/#property-href
     */
    protected $href;

    /**
     * Item constructor.
     */
    public function __construct()
    {
        $this->links = new Bag(Link::class);
        $this->data  = new Bag(Data::class);
    }
    
    /**
     * @param string $href
     *
     * @return Item
     *
     * @throws \DomainException
     */
    public function setHref($href): Item
    {
        if (!Uri::isValid($href)) {
            throw InvalidParameter::fromTemplate(self::getObjectType(), 'href', Uri::allowed());
        }

        $this->href = $href;

        return $this;
    }

    /**
     * @return string
     */
    public function getHref(): string
    {
        return $this->href;
    }

    /**
     * {@inheritdoc}
     */
    protected function getObjectData(): array
    {
        if (is_null($this->href)) {
            throw MissingProperty::fromTemplate(self::getObjectType(), 'href');
        }

        $data = [
            'data'  => $this->getDataSet(),
            'href'  => $this->href,
            'links' => $this->getLinks(),
        ];

        return $this->filterEmptyArrays($data);
    }

    /**
     * @return void
     */
    public function __clone()
    {
        $this->data = clone $this->data;
        $this->links = clone $this->links;
    }
}
