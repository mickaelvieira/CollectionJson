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

namespace CollectionJson\Validator;

/**
 * Class DataValue
 * @package CollectionJson\Validator
 */
final class DataValue
{
    /**
     * @param $value
     * @return bool
     */
    public static function isValid($value)
    {
        return (is_scalar($value) || is_null($value));
    }

    /**
     * @return array
     */
    public static function allowed()
    {
        return ['scalar', 'NULL'];
    }
}
