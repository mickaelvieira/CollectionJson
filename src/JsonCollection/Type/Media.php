<?php

/*
 * This file is part of JsonCollection, a php implementation
 * of the Collection.next+JSON Media Type
 *
 * (c) Mickaël Vieira <contact@mickael-vieira.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JsonCollection\Type;

/**
 * Class Media
 * @package JsonCollection\Type
 */
final class Media
{
    /**
     *
     */
    private function __construct()
    {
    }

    const HTML                 = "text/html";
    const TIFF                 = "image/tiff";
    const JPEG                 = "image/jpeg";
    const COLLECTION_JSON      = "application/vnd.collection+json";
    const COLLECTION_NEXT_JSON = "application/vnd.collection.next+json";
}
