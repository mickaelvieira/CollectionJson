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
use CollectionJson\Exception\CollectionJsonException;

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
     * Error constructor.
     *
     * @param string|null $code
     * @param string|null $message
     * @param string|null $title
     */
    public function __construct(string $code = null, string $message = null, string $title = null)
    {
        $this->code    = $code;
        $this->message = $message;
        $this->title   = $title;
    }

    /**
     * @param string $code
     *
     * @return Error
     *
     * @throws CollectionJsonException
     */
    public function withCode(string $code): Error
    {
        $copy = clone $this;
        $copy->code = $code;

        return $copy;
    }

    /**
     * @return string|null
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $message
     *
     * @return Error
     *
     * @throws CollectionJsonException
     */
    public function withMessage(string $message): Error
    {
        $copy = clone $this;
        $copy->message = $message;

        return $copy;
    }

    /**
     * @return string|null
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $title
     *
     * @return Error
     *
     * @throws CollectionJsonException
     */
    public function withTitle(string $title): Error
    {
        $copy = clone $this;
        $copy->title = $title;

        return $copy;
    }

    /**
     * @return string|null
     */
    public function getTitle()
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
