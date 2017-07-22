<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use CollectionJson\Entity\Collection;
use CollectionJson\Entity\Item;
use CollectionJson\Entity\Query;
use CollectionJson\Entity\Data;
use CollectionJson\Entity\Error;
use CollectionJson\Entity\Template;
use CollectionJson\Entity\Link;
use CollectionJson\Type\Relation;

$collection = (new Collection('https://example.co/search'))
    ->withItem(
        new Item('https://example.co/item/1')
    )
    ->withLinksSet([
        new Link('https://example.co/search/next', Relation::NEXT),
        new Link('https://example.co/search/prev', Relation::PREV)
    ])
    ->withQuery(
        new Query('https://example.co/search', Relation::SEARCH)
    )
    ->withError(
        new Error('Error Code', 'Error Message', 'Error Title')
    )
    ->withTemplate(
        (new Template())
            ->withData(new Data('terms', ''))
    );

echo json_encode($collection, JSON_PRETTY_PRINT);
