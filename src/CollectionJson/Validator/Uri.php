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
 * Class Uri
 * @package CollectionJson\Validator
 */
class Uri
{
    /**
     * @param $uri
     * @return bool
     */
    public static function isValid($uri)
    {
        return (filter_var($uri, FILTER_VALIDATE_URL) !== false);
    }
}
