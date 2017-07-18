<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use CollectionJson\Entity\Query;
use CollectionJson\Entity\Data;
use CollectionJson\Type\Relation;

$query = (new Query())
    ->withHref('http://www.example.com')
    ->withRel(Relation::SEARCH)
    ->withName('value')
    ->withPrompt('value')
    ->withData(Data::fromArray(['name' => 'data 1', 'value' => true]))
    ->withData(Data::fromArray(['name' => 'data 2', 'value' => 'value 2']));

echo json_encode($query, JSON_PRETTY_PRINT);
