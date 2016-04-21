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
 * Class WrongParameter
 * @package CollectionJson\Exception
 */
final class WrongParameter extends \DomainException
{
    const TEMPLATE = "Property [%s] of entity [%s] can only have one of the following values [%s]";

    /**
     * @param string $entity
     * @param string $property
     * @param array  $allowed
     * @return \CollectionJson\Exception\WrongParameter
     */
    public static function format($entity, $property, array $allowed)
    {
        $message = sprintf(self::TEMPLATE, $property, $entity, implode(',', $allowed));
        return new self($message);
    }
}
