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
use CollectionJson\Validator\DataValue;
use CollectionJson\Validator\StringLike;
use CollectionJson\Exception\WrongParameter;
use CollectionJson\Exception\MissingProperty;

/**
 * Class Data
 * @package CollectionJson\Entity
 * @link http://amundsen.com/media-types/collection/format/
 * @link http://amundsen.com/media-types/collection/format/#arrays-data
 */
class Data extends BaseEntity
{
    /**
     * @var string
     * @link http://amundsen.com/media-types/collection/format/#properties-prompt
     */
    protected $prompt;

    /**
     * @var string
     * @link http://amundsen.com/media-types/collection/format/#properties-name
     */
    protected $name;

    /**
     * @var string
     * @link http://amundsen.com/media-types/collection/format/#properties-value
     */
    protected $value;

    /**
     * @param string $name
     * @return \CollectionJson\Entity\Data
     * @throws \DomainException
     */
    public function setName($name)
    {
        if (!StringLike::isValid($name)) {
            throw WrongParameter::format($this->getObjectType(), 'name', StringLike::allowed());
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
     * @return \CollectionJson\Entity\Data
     * @throws \DomainException
     */
    public function setPrompt($prompt)
    {
        if (!StringLike::isValid($prompt)) {
            throw WrongParameter::format($this->getObjectType(), 'prompt', StringLike::allowed());
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
     * @param string $value
     * @return \CollectionJson\Entity\Data
     * @throws \DomainException
     */
    public function setValue($value)
    {
        if (!DataValue::isValid($value)) {
            throw WrongParameter::format($this->getObjectType(), 'value', DataValue::allowed());
        }
        $this->value = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    protected function getObjectData()
    {
        if (is_null($this->name)) {
            throw MissingProperty::format($this->getObjectType(), 'name');
        }

        $data = [
            'name'   => $this->name,
            'prompt' => $this->prompt,
            'value'  => $this->value,
        ];

        return $this->filterNullValues($data, ['value']);
    }
}
