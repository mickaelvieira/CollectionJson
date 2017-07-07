<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use CollectionJson\Entity\Link;
use CollectionJson\Type;

$link = (new Link())
    ->setName('link name')
    ->setHref('http://www.example.com')
    ->setPrompt('prompt value')
    ->setRel(Type\Relation::ITEM)
    ->setRender(Type\Render::IMAGE); // default Render::LINK

echo json_encode($link, JSON_PRETTY_PRINT);
