<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use CollectionJson\Entity\Query;
use CollectionJson\Entity\Data;
use CollectionJson\Type\Relation;

$query = (new Query('https://example.co', Relation::SEARCH))
    ->withName('value')
    ->withPrompt('value')
    ->withData(new Data('data 1', true))
    ->withData(new Data('data 2', 'value 2'));

echo json_encode($query, JSON_PRETTY_PRINT);
