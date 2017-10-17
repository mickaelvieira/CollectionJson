<?php
declare(strict_types = 1);

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
use CollectionJson\Exception\InvalidParameter;
use CollectionJson\Exception\CollectionJsonException;

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
     * Data constructor.
     *
     * @param string|null                $name
     * @param string|int|float|bool|null $value
     * @param string|null                $prompt
     */
    public function __construct(string $name, $value = null, string $prompt = null)
    {
        if (!is_null($value) && !DataValue::isValid($value)) {
            throw InvalidParameter::fromTemplate(self::getObjectType(), 'value', DataValue::allowed());
        }

        $this->name   = $name;
        $this->value  = $value;
        $this->prompt = $prompt;
    }

    /**
     * @param string $name
     *
     * @return Data
     *
     * @throws CollectionJsonException
     */
    public function withName(string $name): Data
    {
        $copy = clone $this;
        $copy->name = $name;

        return $copy;
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $prompt
     *
     * @return Data
     *
     * @throws CollectionJsonException
     */
    public function withPrompt(string $prompt): Data
    {
        $copy = clone $this;
        $copy->prompt = $prompt;

        return $copy;
    }

    /**
     * @return string|null
     */
    public function getPrompt()
    {
        return $this->prompt;
    }

    /**
     * @param mixed $value
     *
     * @return Data
     *
     * @throws CollectionJsonException
     */
    public function withValue($value): Data
    {
        if (!DataValue::isValid($value)) {
            throw InvalidParameter::fromTemplate(self::getObjectType(), 'value', DataValue::allowed());
        }

        $copy = clone $this;
        $copy->value = $value;

        return $copy;
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
        $data = [
            'name'   => $this->name,
            'prompt' => $this->prompt,
            'value'  => $this->value,
        ];

        return $this->filterNullValues($data, ['value']);
    }
}
