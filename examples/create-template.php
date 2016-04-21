<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use CollectionJson\Entity\Template;
use CollectionJson\Entity\Data;

$template = (new Template())
    ->addData(Data::fromArray(['name' => 'empty string', 'value' => '']))
    ->addData(Data::fromArray(['name' => 'null value']))
    ->addData(Data::fromArray(['name' => 'default value', 'value' => 0]))
    ->wrap('template');

echo json_encode($template, JSON_PRETTY_PRINT);
