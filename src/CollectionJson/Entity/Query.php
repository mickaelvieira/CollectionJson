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
use CollectionJson\DataAware;
use CollectionJson\BaseEntity;
use CollectionJson\Validator\Uri;
use CollectionJson\DataContainer;
use CollectionJson\Validator\StringLike;
use CollectionJson\Exception\WrongParameter;
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
     * @return \CollectionJson\Entity\Query
     * @throws \BadMethodCallException
     * @throws \DomainException
     */
    public function setHref($href)
    {
        if (!Uri::isValid($href)) {
            throw WrongParameter::fromTemplate(self::getObjectType(), 'href', Uri::allowed());
        }
        $this->href = $href;

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
     * @param string $name
     * @return \CollectionJson\Entity\Query
     * @throws \DomainException
     */
    public function setName($name)
    {
        if (!StringLike::isValid($name)) {
            throw WrongParameter::fromTemplate(self::getObjectType(), 'name', StringLike::allowed());
        }
        $this->name = (string)$name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $prompt
     * @return \CollectionJson\Entity\Query
     * @throws \DomainException
     */
    public function setPrompt($prompt)
    {
        if (!StringLike::isValid($prompt)) {
            throw WrongParameter::fromTemplate(self::getObjectType(), 'prompt', StringLike::allowed());
        }
        $this->prompt = (string)$prompt;

        return $this;
    }

    /**
     * @return string
     */
    public function getPrompt()
    {
        return $this->prompt;
    }

    /**
     * @param string $rel
     * @return \CollectionJson\Entity\Query
     * @throws \DomainException
     */
    public function setRel($rel)
    {
        if (!StringLike::isValid($rel)) {
            throw WrongParameter::fromTemplate(self::getObjectType(), 'rel', StringLike::allowed());
        }
        $this->rel = (string)$rel;

        return $this;
    }

    /**
     * @return string
     */
    public function getRel()
    {
        return $this->rel;
    }

    /**
     * {@inheritdoc}
     */
    protected function getObjectData()
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
}
