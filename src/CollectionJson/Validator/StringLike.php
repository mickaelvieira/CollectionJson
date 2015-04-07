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
 * Class StringLike
 * @package CollectionJson\Validator
 */
final class StringLike
{
    /**
     * @param mixed $value
     * @return bool
     */
    public static function isValid($value)
    {
        if (is_scalar($value) || is_object($value) && method_exists($value, '__toString')) {
            return true;
        } else {
            return false;
        }
    }
}
