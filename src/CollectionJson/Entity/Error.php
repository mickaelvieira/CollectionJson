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
use CollectionJson\Validator\StringLike;

/**
 * Class Error
 * @package CollectionJson\Entity
 * @link http://amundsen.com/media-types/collection/format/
 * @link http://amundsen.com/media-types/collection/format/#objects-error
 */
class Error extends BaseEntity
{
    /**
     * @var string
     * @link http://amundsen.com/media-types/collection/format/#properties-title
     */
    protected $title;

    /**
     * @var string
     * @link http://amundsen.com/media-types/collection/format/#property-code
     */
    protected $code;

    /**
     * @var string
     * @link http://amundsen.com/media-types/collection/format/#property-message
     */
    protected $message;

    /**
     * @param string $code
     * @return \CollectionJson\Entity\Error
     * @throws \BadMethodCallException
     */
    public function setCode($code)
    {
        if (!StringLike::isValid($code)) {
            throw new BadMethodCallException(
                sprintf("Property code of object type %s cannot be converted to a string", $this->getObjectType())
            );
        }
        $this->code = (string)$code;

        return $this;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $message
     * @return \CollectionJson\Entity\Error
     * @throws \BadMethodCallException
     */
    public function setMessage($message)
    {
        if (!StringLike::isValid($message)) {
            throw new BadMethodCallException(
                sprintf("Property message of object type %s cannot be converted to a string", $this->getObjectType())
            );
        }
        $this->message = (string)$message;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $title
     * @return \CollectionJson\Entity\Error
     * @throws \BadMethodCallException
     */
    public function setTitle($title)
    {
        if (!StringLike::isValid($title)) {
            throw new BadMethodCallException(
                sprintf("Property title of object type %s cannot be converted to a string", $this->getObjectType())
            );
        }
        $this->title = (string)$title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * {@inheritdoc}
     */
    protected function getObjectData()
    {
        $data = [
            'code'    => $this->code,
            'message' => $this->message,
            'title'   => $this->title,
        ];

        $data = $this->filterEmptyArrays($data);
        $data = $this->filterNullValues($data);

        return $data;
    }
}
