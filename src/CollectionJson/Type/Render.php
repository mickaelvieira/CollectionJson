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

namespace CollectionJson\Type;

/**
 * Class Render
 * @package CollectionJson\Type
 */
final class Render
{
    /**
     *
     */
    private function __construct()
    {
    }

    const LINK  = 'link';
    const IMAGE = 'image';
}
