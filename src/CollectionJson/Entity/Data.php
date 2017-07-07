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

use CollectionJson\BaseEntity;
use CollectionJson\Validator\DataValue;
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
     *
     * @return Data
     *
     * @throws \DomainException
     */
    public function setName(string $name): Data
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
     * @return Data
     *
     * @throws \DomainException
     */
    public function setPrompt(string $prompt): Data
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
     * @param mixed $value
     *
     * @return Data
     *
     * @throws \DomainException
     */
    public function setValue($value): Data
    {
        if (!DataValue::isValid($value)) {
            throw WrongParameter::fromTemplate(self::getObjectType(), 'value', DataValue::allowed());
        }

        $this->value = $value;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    protected function getObjectData(): array
    {
        if (is_null($this->name)) {
            throw MissingProperty::fromTemplate(self::getObjectType(), 'name');
        }

        $data = [
            'name'   => $this->name,
            'prompt' => $this->prompt,
            'value'  => $this->value,
        ];

        return $this->filterNullValues($data, ['value']);
    }
}
