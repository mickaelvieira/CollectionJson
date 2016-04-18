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
            throw new \DomainException(
                sprintf("Property name of object type %s cannot be converted to a string", $this->getObjectType())
            );
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
            throw new \DomainException(
                sprintf("Property prompt of object type %s cannot be converted to a string", $this->getObjectType())
            );
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
            throw new \DomainException(
                sprintf(
                    "Property value of object type %s may only have types string, number, boolean or null",
                    $this->getObjectType()
                )
            );
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
            throw new \DomainException(sprintf("Property name of object type %s is required", $this->getObjectType()));
        }

        $original = [
            'name'   => $this->name,
            'prompt' => $this->prompt,
            'value'  => $this->value,
        ];

        $data = [];
        array_walk($original, function ($value, $key) use (&$data) {
            if (!is_null($value) || $key === 'value') {
                $data[$key] = $value;
            }
        });

        return $data;
    }
}
