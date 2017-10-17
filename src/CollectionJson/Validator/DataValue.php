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

namespace CollectionJson\Validator;

/**
 * Class DataValue
 * @package CollectionJson\Validator
 */
final class DataValue
{
    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isValid($value): bool
    {
        return (is_scalar($value) || is_null($value));
    }

    /**
     * @return array
     */
    public static function allowed(): array
    {
        return ['scalar', 'NULL'];
    }
}
