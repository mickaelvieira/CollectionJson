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

namespace CollectionJson\Validator;

use CollectionJson\Type\Render as RenderType;

/**
 * Class Render
 * @package CollectionJson\Validator
 */
final class Render
{
    /**
     * @param string $type
     *
     * @return bool
     */
    public static function isValid(string $type): bool
    {
        return ($type === RenderType::LINK || $type === RenderType::IMAGE);
    }

    /**
     * @return array
     */
    public static function allowed(): array
    {
        return [RenderType::LINK, RenderType::IMAGE];
    }
}
