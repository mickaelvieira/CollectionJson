<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use CollectionJson\Entity\Item;
use CollectionJson\Entity\Data;
use CollectionJson\Entity\Link;
use CollectionJson\Type\Relation;

$item = (new Item('https://example.co/item/1'))
    ->withDataSet([
        new Data('data 1'),
        new Data('data 2', 'value 2')
    ])
    ->withLink(
        new Link('https://example.co/item/1', Relation::ITEM)
    );

echo json_encode($item, JSON_PRETTY_PRINT);
