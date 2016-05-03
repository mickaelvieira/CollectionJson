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

namespace CollectionJson\Exception;

/**
 * Class WrongType
 * @package CollectionJson\Exception
 */
final class WrongType extends \BadMethodCallException
{
    const TEMPLATE = "Property [%s] must be of type [%s]";

    /**
     * @param string $property
     * @param string $type
     * @return \CollectionJson\Exception\WrongType
     */
    public static function format($property, $type)
    {
        $message = sprintf(self::TEMPLATE, $property, $type);
        return new self($message);
    }
}
