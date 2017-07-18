<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use CollectionJson\Entity\Template;
use CollectionJson\Entity\Data;

$template = (new Template())
    ->withData(Data::fromArray(['name' => 'empty string', 'value' => '']))
    ->withData(Data::fromArray(['name' => 'null value']))
    ->withData(Data::fromArray(['name' => 'default value', 'value' => 0]))
    ->wrap();

echo json_encode($template, JSON_PRETTY_PRINT);
