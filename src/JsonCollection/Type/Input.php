<?php

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
