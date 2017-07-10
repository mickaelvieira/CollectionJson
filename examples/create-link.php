<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use CollectionJson\Entity\Link;
use CollectionJson\Type;

$link = (new Link())
    ->withName('link name')
    ->withHref('http://www.example.com')
    ->withPrompt('prompt value')
    ->withRel(Type\Relation::ITEM)
    ->withRender(Type\Render::IMAGE); // default Render::LINK

echo json_encode($link, JSON_PRETTY_PRINT);
