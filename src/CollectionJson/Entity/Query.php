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
use CollectionJson\DataAware;
use CollectionJson\BaseEntity;
use CollectionJson\Validator\Uri;
use CollectionJson\DataContainer;
use CollectionJson\Exception\InvalidParameter;
use CollectionJson\Exception\MissingProperty;

/**
 * Class Query
 * @package CollectionJson\Entity
 * @link http://amundsen.com/media-types/collection/format/
 * @link http://amundsen.com/media-types/collection/format/#arrays-queries
 */
class Query extends BaseEntity implements DataAware
{
    /**
     * @see \CollectionJson\DataContainer
     */
    use DataContainer;

    /**
     * @var string
     * @link http://amundsen.com/media-types/collection/format/#properties-href
     */
    protected $href;

    /**
     * @var string
     * @link http://amundsen.com/media-types/collection/format/#properties-rel
     */
    protected $rel;

    /**
     * @var string
     * @link http://amundsen.com/media-types/collection/format/#properties-name
     */
    protected $name;

    /**
     * @var string
     * @link http://amundsen.com/media-types/collection/format/#properties-prompt
     */
    protected $prompt;

    /**
     * Query constructor.
     */
    public function __construct()
    {
        $this->data = new Bag(Data::class);
    }
    
    /**
     * @param string $href
     *
     * @return Query
     *
     * @throws InvalidParameter
     */
    public function setHref($href): Query
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
     * @param string $name
     *
     * @return Query
     *
     * @throws \DomainException
     */
    public function setName(string $name): Query
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $prompt
     *
     * @return Query
     *
     * @throws \DomainException
     */
    public function setPrompt(string $prompt): Query
    {
        $this->prompt = $prompt;

        return $this;
    }

    /**
     * @return string
     */
    public function getPrompt(): string
    {
        return $this->prompt;
    }

    /**
     * @param string $rel
     *
     * @return Query
     *
     * @throws \DomainException
     */
    public function setRel(string $rel): Query
    {
        $this->rel = $rel;

        return $this;
    }

    /**
     * @return string
     */
    public function getRel(): string
    {
        return $this->rel;
    }

    /**
     * {@inheritdoc}
     */
    protected function getObjectData(): array
    {
        foreach (['href', 'rel'] as $property) {
            if (is_null($this->$property)) {
                throw MissingProperty::fromTemplate(self::getObjectType(), $property);
            }
        }

        $data = [
            'data'   => $this->getDataSet(),
            'href'   => $this->href,
            'name'   => $this->name,
            'prompt' => $this->prompt,
            'rel'    => $this->rel,
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
        $this->data = clone $this->data;
    }
}
