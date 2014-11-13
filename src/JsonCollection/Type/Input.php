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
 * Class Input
 * @package JsonCollection\Type
 */
final class Input
{
    /**
     *
     */
    private function __construct()
    {
    }

    const NUMBER   = "number";
    const EMAIL    = "email";
    const URL      = "url";
    const DATE     = "date";
    const DATETIME = "datetime";
    const MONTH    = "month";
    const TEL      = "tel";

    const INTEGER  = 'integer';
    const BOOLEAN  = 'boolean';
}
