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
use CollectionJson\Exception\WrongParameter;

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
     *
     * @return Error
     *
     * @throws \DomainException
     */
    public function setCode(string $code): Error
    {
        $this->code = (string)$code;

        return $this;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $message
     *
     * @return Error
     *
     * @throws \DomainException
     */
    public function setMessage(string $message): Error
    {
        $this->message = (string)$message;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $title
     *
     * @return Error
     *
     * @throws \DomainException
     */
    public function setTitle(string $title): Error
    {
        $this->title = (string)$title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * {@inheritdoc}
     */
    protected function getObjectData(): array
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
