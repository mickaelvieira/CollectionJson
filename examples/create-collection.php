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

$collection = (new Collection())
    ->withHref('http://www.example.com/search')
    ->addItem((new Item())->withHref('http://www.example.com/item/1'))
    ->addLinksSet([
        Link::fromArray(['href' => 'http://www.example.com/search/next', 'rel' => Relation::NEXT]),
        Link::fromArray(['href' => 'http://www.example.com/search/prev', 'rel' => Relation::PREV])
    ])
    ->addQuery(Query::fromArray(['href' => 'http://www.example.com/search', 'rel' => Relation::SEARCH]))
    ->withError(Error::fromArray([
        'title'   => 'Error Title',
        'code'    => 'Error Code',
        'message' => 'Error Message'
    ]))
    ->withTemplate(
        (new Template())->addData(Data::fromArray(['name' => 'terms', 'value' => '']))
    );

echo json_encode($collection, JSON_PRETTY_PRINT);
