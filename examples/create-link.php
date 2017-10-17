<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use CollectionJson\Entity\Link;
use CollectionJson\Type;

$link = (new Link('https://example.co', Type\Relation::ITEM))
    ->withName('link name')
    ->withPrompt('prompt value')
    ->withRender(Type\Render::IMAGE); // default Render::LINK

echo json_encode($link, JSON_PRETTY_PRINT);
