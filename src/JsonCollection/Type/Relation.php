<?php

namespace JsonCollection\Type;

/**
 * Class Relation
 * @package JsonCollection\Type
 */
final class Relation
{
    /**
     *
     */
    private function __construct()
    {
    }

    const COLLECTION = 'collection';
    const TEMPLATE   = 'template';
    const QUERIES    = 'queries';
    const FORM       = 'form';
    const ITEM       = 'item';

    const INDEX      = 'index';
    const FIRST      = 'first';
    const PREV       = 'prev';
    const NEXT       = 'next';
    const LAST       = 'last';
}
