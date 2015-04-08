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

use CollectionJson\Type\Render as RenderType;

/**
 * Class Render
 * @package CollectionJson\Validator
 */
class Render
{
    /**
     * @param $type
     * @return bool
     */
    public static function isValid($type)
    {
        return ($type === RenderType::LINK || $type === RenderType::IMAGE);
    }
}
