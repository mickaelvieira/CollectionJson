<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use CollectionJson\Entity\Item;
use CollectionJson\Entity\Data;
use CollectionJson\Entity\Link;
use CollectionJson\Type\Relation;

$item = (new Item())
    ->withHref('http://www.example.com/item/1')
    ->withLink(
        Link::fromArray(['href' => 'http://www.example.com/item/1', 'rel' => Relation::ITEM])
    )
    ->addDataSet([
        Data::fromArray(['name' => 'data 1']),
        Data::fromArray(['name' => 'data 2', 'value' => 'value 2'])
    ]);

echo json_encode($item, JSON_PRETTY_PRINT);
