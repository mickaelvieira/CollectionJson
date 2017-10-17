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

namespace CollectionJson\Exception;

/**
 * Class MissingProperty
 * @package CollectionJson\Exception
 */
final class MissingProperty extends \DomainException
{
    const TEMPLATE = 'Property [%s] of entity [%s] is required';

    /**
     * @param string $entity
     * @param string $property
     *
     * @return MissingProperty
     */
    public static function fromTemplate(string $entity, string $property): MissingProperty
    {
        $message = sprintf(self::TEMPLATE, $property, $entity);
        return new self($message);
    }
}
